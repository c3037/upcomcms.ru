<?php

class Model
{
    // соединение с бд
    protected $conn;
    
    // подключение к бд
    public function db_connect()
    {
        try
        {
            $this->conn = new PDO( "mysql:host=".Config::$db_host.";port=".Config::$db_port.";dbname=".Config::$db_base, Config::$db_user, Config::$db_password );
            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->conn->query( 'SET NAMES utf8' );
            
            $update = $this->conn->query("SELECT `value` FROM `sysconf` WHERE `key`='update'")->fetchColumn();
            if($update == 1) exit('В данный момент идёт синхронизация базы данных. Повторите запрос позднее.');
            
            $last_date_in_db = $this->conn->query("
            (SELECT `date` FROM `counters_values`) UNION 
            (SELECT `date` FROM `finances`) UNION 
            (SELECT `date` FROM `receipts`) UNION 
            (SELECT DATE(`date`) as `date` FROM `messages`) UNION 
            (SELECT `date` FROM `odns`) UNION 
            (SELECT `date` FROM `houses_counters_values`)
            ORDER BY `date` DESC LIMIT 1
            ")->fetchColumn();
            
            if(strtotime($last_date_in_db) > strtotime("now")) throw new Exception("Wrong time on server.");
        }
        catch(PDOException $e)
        {
            echo "Database connection error.";
            
            $message = "Exception: ".get_class($e)." with message: ".$e->getMessage()." on line ".$e->getLine();
			if(ini_get('display_errors') == 1) { echo "<br /><br />"; echo $message; }
            if(ini_get('log_errors') == 1) error_log($message);
            
            exit;
        }
        catch(Exception $e)
        {
            echo "Server error.";
            
            $message = "Exception: ".get_class($e)." with message: ".$e->getMessage()." on line ".$e->getLine();
			if(ini_get('display_errors') == 1) { echo "<br /><br />"; echo $message; }
            if(ini_get('log_errors') == 1) error_log($message);
            
            exit;
        }
    }
    
    // отключение от бд
    public function db_disconnect()
    {
        $this->conn = null;
    }
    
	// метод выборки данных
	public function get_data() {}
    
    // проверка аутентификации
    public function check_auth()
    {
        if(
            !isset($_COOKIE['upko_user_id']) or 
            empty($_COOKIE['upko_user_id']) or 
            !preg_match("/^[0-9]+$/i", $_COOKIE['upko_user_id'])
        ) return false;
        
        if(
            !isset($_COOKIE['upko_user_token']) or 
            empty($_COOKIE['upko_user_token']) or 
            !preg_match("/^[0-9abcdef]+$/i", $_COOKIE['upko_user_token'])
        ) return false;
        
        if(
            !isset($_COOKIE['upko_user_temp']) or 
            empty($_COOKIE['upko_user_temp']) or 
            !preg_match("#^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$#", $_COOKIE['upko_user_temp'])
        ) return false;
        
        $id = intval($_COOKIE['upko_user_id']);
        $token = sha1($_COOKIE['upko_user_token'].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $sha1_salt = sha1(Config::$salt);
        
        $sha1_pass = (string) $this->strcode(base64_decode($_COOKIE['upko_user_temp']), $sha1_salt.$token);
        $sha1_pass = addslashes($sha1_pass);
        
        if(!preg_match("/^[0-9abcdef]+$/i", $sha1_pass)) return false;
        
        $password=sha1($sha1_pass.$sha1_salt);
        
        if($this->conn == null) $this->db_connect();
        
        $nRows = $this->conn->query("
        SELECT COUNT(*) FROM `customers` WHERE `password`='$password' and `program_customer_id`=(
            SELECT `program_customer_id` FROM `bridge` WHERE `id`='$id' AND `token`='$token'
        )
        ")->fetchColumn();
        
        if($nRows == 1)
        {
            $aes_key = sha1($sha1_salt.$sha1_pass);
            $this->conn->query("SET @aes_key = '$aes_key'");
            return $id;
        }
        else return false;
    }
    
    // функция обратимого шифрования
    public function strcode($string, $secret="")
    {
       $salt = "Dn8*#2n!9j";
       $len = strlen($string);
       $gamma = '';
       $n = $len>100 ? 8 : 2;
       while( strlen($gamma)<$len )
       {
          $gamma .= substr(pack('H*', sha1($secret.$gamma.$salt)), 0, $n);
       }
       return $string^$gamma;
    }
    
    // получаем дату обновления БД
    public function get_upd_date()
    {
        if($this->conn == null) $this->db_connect();
        $upd_date = $this->conn->query("SELECT `value` FROM `sysconf` WHERE `key`='upd_date'")->fetchColumn();
        $upd_date = date("d-m-Y", strtotime($upd_date));
        return $upd_date;
    }
    
    // проверяем защищено ли соединение
    public function isSecureConnection()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
}