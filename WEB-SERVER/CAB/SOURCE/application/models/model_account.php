<?php
class Model_Account extends Model
{
    protected $user_id;
    
    // проверяем аутентификацию
    function check_auth()
	{
        $this->user_id = parent::check_auth();
        return $this->user_id;
	}
    
    function get_user_id()
    {
        return $this->user_id;
    }
    
    // авторизация
    function login($account, $password, $uk)
    {
        if(
            !preg_match("/^[а-яёa-z0-9]+$/iu", $account) or 
            !preg_match("/^[0-9]+$/i", $uk)
        ) return false;
        
        usleep(100000); // 0.1 sec
        
        $account = htmlentities($account, ENT_QUOTES, "UTF-8");
        $account = addslashes($account);
        $uk = intval($uk);
        
        $sha1_pass = sha1($password);
        $sha1_salt = sha1(Config::$salt);
        
        $password = sha1($sha1_pass.$sha1_salt);
        
        if($this->conn == null) $this->db_connect();
        
        $result = $this->conn->query("
        SELECT `id` FROM `bridge` WHERE `program_customer_id`=(
            SELECT `program_customer_id` FROM `customers` WHERE `personal_account`='$account' AND `password`='$password' AND `program_house_id` IN (
                SELECT `program_house_id` FROM `houses` WHERE `program_company_id`=(
                    SELECT `program_company_id` FROM `companies` WHERE `program_company_id`='$uk'
                )
            )
        )
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return false;
        
        $id = intval($result[0]['id']);
        
        $token_cookie = md5(time().$sha1_salt.mt_rand(1000,9999));
        $token = sha1($token_cookie.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        
        $pass_cookie = base64_encode($this->strcode($sha1_pass, $sha1_salt.$token));
        
        $this->conn->query("UPDATE `bridge` SET `token`='$token' WHERE `id`='$id'");
        
        setcookie("upko_user_id", $id, time()+3600, '/', null, $this->isSecureConnection());
        setcookie("upko_user_token", $token_cookie, time()+3600, '/', null, $this->isSecureConnection());
        setcookie("upko_user_temp", $pass_cookie, time()+3600, '/', null, $this->isSecureConnection());
		setcookie("upko_last_uk", $uk, time()+3600*24*365, '/', null);
        
        return true;
    }
    
    // выход из ЛК
    function logout()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;
        
        $this->conn->query("UPDATE `bridge` SET `token`='' WHERE `id`='$this->user_id'");
        
        setcookie("upko_user_id", '', 0, '/');
        setcookie("upko_user_token", '', 0, '/');
        setcookie("upko_user_temp", '', 0, '/');
        
    }
    
    // получение названия УК
    function get_uk_name()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return 'Данных не найдено';
        
        $result = $this->conn->query("
        SELECT `name` FROM `companies` WHERE `program_company_id`=(
            SELECT `program_company_id` FROM `houses` WHERE `program_house_id`=(
                SELECT `program_house_id` FROM `customers` WHERE `program_customer_id`=(
                    SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id'
                )
            )
        )
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        return (count($result) == 0) ? 'Данных не найдено' : htmlspecialchars($result[0]['name'], ENT_QUOTES, "UTF-8");
    }
    
    // получение имени клиента
    function get_user_name()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return 'Данных не найдено';
        
        $result = $this->conn->query("
        SELECT AES_DECRYPT(`owner`, @aes_key) AS `owner` FROM `customers` WHERE `program_customer_id`=(
            SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id'
        )
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        return (count($result) == 0) ? 'Данных не найдено' : htmlspecialchars($result[0]['owner'], ENT_QUOTES, "UTF-8");
    }
    
    // получение данных клиента
    function get_user_data()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array( 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено' );
        
        $result = $this->conn->query("
        SELECT
            `personal_account`,
            `program_house_id`,
            AES_DECRYPT(`flat`, @aes_key) AS `flat`,
            AES_DECRYPT(`total_space`, @aes_key) AS `total_space`,
            AES_DECRYPT(`living_space`, @aes_key) AS `living_space`,
            AES_DECRYPT(`residents`, @aes_key) AS `residents`,
            AES_DECRYPT(`phone`, @aes_key) AS `phone`,
            AES_DECRYPT(`email`, @aes_key) AS `email`
        FROM `customers` WHERE `program_customer_id`=(
            SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id'
        )
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return array( 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено', 'Данных не найдено' );
        
        $data = array();
        
        $data['user_lc'] = htmlspecialchars($result[0]['personal_account'], ENT_QUOTES, "UTF-8");
        $result[0]['total_space'] = str_replace(",", ".", $result[0]['total_space']);
        if(!is_float($result[0]['total_space'])) $result[0]['total_space'] = (float) $result[0]['total_space'];
        $data['user_total_space'] = number_format($result[0]['total_space'], 2, ',', ' ');
		$result[0]['living_space'] = str_replace(",", ".", $result[0]['living_space']);
        if(!is_float($result[0]['living_space'])) $result[0]['living_space'] = (float) $result[0]['living_space'];
        $data['user_living_space'] = number_format($result[0]['living_space'], 2, ',', ' ');
        $data['user_residents'] = intval($result[0]['residents']);
        $data['user_phone'] = htmlspecialchars($result[0]['phone'], ENT_QUOTES, "UTF-8");
        $data['user_email'] = htmlspecialchars($result[0]['email'], ENT_QUOTES, "UTF-8");
        
        if(!isset($result[0]['program_house_id']))
        {
            $data['user_address'] = 'Данных не найдено';
        }
        else
        {
            if(isset($result[0]['flat']) and !empty($result[0]['flat']))
			{
				$flat = htmlspecialchars($result[0]['flat'], ENT_QUOTES, "UTF-8");
				if(preg_match("/^[0-9]+$/i", $flat)) $flat = 'кв. '.$flat;
				$flat = ", ".$flat;
			}
            else $flat = "";
			
            $result = $this->conn->query("SELECT `address` FROM `houses` WHERE `program_house_id`='{$result[0]['program_house_id']}'")->fetchAll(PDO::FETCH_ASSOC);
            if(count($result) == 0) $data['user_address'] = 'Данных не найдено';
            else
            {
                $data['user_address'] = htmlspecialchars($result[0]['address'], ENT_QUOTES, "UTF-8").$flat;
            }
        }
        
        return $data;
    }
    
    // получение списка счётчиков
    function get_counters_list()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        
        $result = $this->conn->query("
        SELECT
            C.`id`, C.`service`, C.`serial_number`, C.`number_of_tariffs`, C.`check_date`, C.`start_date`, CV.`date`, CV.`value`, CV.`value2`, CV.`mode`
        FROM
            `counters` AS C
        LEFT JOIN
            `counters_values` AS CV 
        ON
            CV.`id` = (
                SELECT
                    `id`
                FROM
                    `counters_values` AS S 
                WHERE
                    S.`counter` = C.`id`
                ORDER BY
                    `date` DESC, `id` DESC
                LIMIT
                    1
            )
        WHERE
            C.`customer` = '$this->user_id'
        ORDER BY
            C.`service` ASC, C.`id` ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        $data = array();
        
        if(count($result) > 0)
        {
            foreach($result AS $key => $row)
            {
                $data[$key]['id'] = intval($row['id']);
				$data[$key]['number_of_tariffs'] = intval($row['number_of_tariffs']);
                $data[$key]['service'] = htmlspecialchars($row['service'], ENT_QUOTES, "UTF-8");
                $data[$key]['serial_number'] = htmlspecialchars($row['serial_number'], ENT_QUOTES, "UTF-8");
				if(empty($data[$key]['serial_number'])) $data[$key]['serial_number'] = '--';
				$data[$key]['check_date'] = (strtotime($row['check_date']) > strtotime('2000-01-01')) ? date("d-m-Y" ,strtotime($row['check_date'])) : "--";
				$data[$key]['start_date'] = date("d-m-Y" ,strtotime($row['start_date']));
                if($row['date'] != '')
                    $data[$key]['last_report_date'] = date("d-m-Y" ,strtotime($row['date']));
                else
                    $data[$key]['last_report_date'] = 'Данных не найдено';
                $data[$key]['last_report_value'] = number_format($row['value'], 0, ',', ' ');
				if(!empty($row['value2']) and $data[$key]['number_of_tariffs'] > 1){
					$data[$key]['last_report_value'] .= ' <span class="redline">&equiv;</span> '.number_format($row['value2'], 0, ',', ' ');
				}
                $data[$key]['last_report_mode'] = htmlspecialchars($row['mode'], ENT_QUOTES, "UTF-8");
            }
        }
        return $data;
    }
    
    // получение истории счётчика
    function get_counter_history($counter_id, $row)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        if(!preg_match("/^[0-9]+$/i", $counter_id)) return array();
        if(!preg_match("/^[\,0-9]+$/i", $row)) return array();
        
        $counter_id = intval($counter_id);
        
        $result = $this->conn->query("SELECT `service`, `serial_number`, `number_of_tariffs` FROM `counters` WHERE `id`='$counter_id' and `customer`='$this->user_id'")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return array();
        
        $data = array();
        $data['ID'] = $counter_id;
        $data['service'] = htmlspecialchars($result[0]['service'], ENT_QUOTES, "UTF-8");
        $data['serial_number'] = htmlspecialchars($result[0]['serial_number'], ENT_QUOTES, "UTF-8");
		$number_of_tariffs = intval($result[0]['number_of_tariffs']);
        $data['values'] = array();
        
        $result = $this->conn->query("SELECT `id`, `date`, `value`, `value2`, `mode` FROM `counters_values` WHERE `counter`='$counter_id' ORDER BY `date` DESC, `id` DESC LIMIT $row")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) > 0)
        {
            foreach($result as $key => $row)
            {
                $data['values'][$key]['ID'] = intval($row['id']);
                $data['values'][$key]['date'] = date("d-m-Y" ,strtotime($row['date']));
                $data['values'][$key]['value'] = number_format($row['value'], 0, ',', ' ');
				
				if(!empty($row['value2']) and $number_of_tariffs > 1)
				$data['values'][$key]['value'] .= ' <span class="redline">&equiv;</span> '.number_format($row['value2'], 0, ',', ' ');
				
                $data['values'][$key]['mode'] = htmlspecialchars($row['mode'], ENT_QUOTES, "UTF-8");
            }
        }
        
        return $data;
    }
    
    // удаление значения переданного через сайт
    function delete_value_of_counter($counterID, $valueID)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;
        
        $counterID = intval($counterID);
        $valueID = intval($valueID);
        
        $this->conn->query("DELETE FROM `counters_values` WHERE `id`='{$valueID}' AND `counter`=(SELECT `id` FROM `counters` WHERE `id`='{$counterID}' AND `customer`='{$this->user_id}') AND `mode`='site'");
        Route::Page("/account/history?counter=".$counterID);
    }
    
    // список счётчиков для передачи показаний
    function get_counters_for_submit()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        
        $result = $this->conn->query("SELECT `id`, `service`, `serial_number`, `number_of_tariffs` FROM `counters` WHERE `customer`='$this->user_id' ORDER BY `service` ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return array();
        $data = array();
        
        foreach($result as $key => $row)
        {
            $data[$key]['id'] = intval($row['id']);
            $data[$key]['service'] = htmlspecialchars($row['service'], ENT_QUOTES, "UTF-8");
            $data[$key]['serial'] = htmlspecialchars($row['serial_number'], ENT_QUOTES, "UTF-8");
			$data[$key]['number_of_tariffs'] = intval($row['number_of_tariffs']);
        }
        
        return $data;
        
    }
    
    // проверка значений счётчиков
    function check_counters_values_for_submit(array $values)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        
        $data = array();

        foreach($values as $key => $value)
        {
            if(empty($key) or !preg_match("/^[0-9]+$/i", $key)) continue;
			$key = intval($key);
            
            $result = $this->conn->query("SELECT `service`, `serial_number`, `max_value`, `number_of_tariffs` FROM `counters` WHERE `id`='$key' and `customer`='$this->user_id'")
                ->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($result) == 0) continue;
			
            $number_of_tariffs = intval($result[0]['number_of_tariffs']);
			
			if($number_of_tariffs > 1)
			{
				if(empty($value[1]) or !preg_match("/^[0-9\.\,]+$/i", $value[1])) continue;
				$value[1] = intval($value[1]);
				if(empty($value[2]) or !preg_match("/^[0-9\.\,]+$/i", $value[2])) continue;
				$value[2] = intval($value[2]);
				
				$result[0]['max_value'] = intval($result[0]['max_value']);
				if($value[1] > $result[0]['max_value'] or $value[2] > $result[0]['max_value']) continue;
				
				$data[$key]['id'] = $key;
				$data[$key]['service'] = htmlspecialchars($result[0]['service'], ENT_QUOTES, "UTF-8");
				$data[$key]['serial'] = htmlspecialchars($result[0]['serial_number'], ENT_QUOTES, "UTF-8");
				$data[$key]['number_of_tariffs'] = $number_of_tariffs;
				$data[$key]['value1'] = $value[1];
				$data[$key]['value2'] = $value[2];
			}
			else
			{
				if(empty($value) or !preg_match("/^[0-9\.\,]+$/i", $value)) continue;
				$value = intval($value);
				
				$result[0]['max_value'] = intval($result[0]['max_value']);
				if($value > $result[0]['max_value']) continue;
				
				$data[$key]['id'] = $key;
				$data[$key]['service'] = htmlspecialchars($result[0]['service'], ENT_QUOTES, "UTF-8");
				$data[$key]['serial'] = htmlspecialchars($result[0]['serial_number'], ENT_QUOTES, "UTF-8");
				$data[$key]['number_of_tariffs'] = $number_of_tariffs;
				$data[$key]['value'] = $value;
			}
        }
        
        return $data;
    }
    
    function send_counters_values(array $values)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;

        foreach($values as $key => $value)
        {
            if(empty($key) or !preg_match("/^[0-9]+$/i", $key)) continue;
            $key = intval($key);
            
            $result = $this->conn->query("SELECT `max_value`, `number_of_tariffs` FROM `counters` WHERE `id`='$key' and `customer`='$this->user_id'")
                ->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($result) == 0) continue;
			
			$number_of_tariffs = intval($result[0]['number_of_tariffs']);
			
			if($number_of_tariffs > 1)
			{
				if(empty($value[1]) or !preg_match("/^[0-9\.\,]+$/i", $value[1])) continue;
				$value1 = intval($value[1]);
				if(empty($value[2]) or !preg_match("/^[0-9\.\,]+$/i", $value[2])) continue;
				$value2 = intval($value[2]);
				
				$result[0]['max_value'] = intval($result[0]['max_value']);
				if($value1> $result[0]['max_value'] or $value2 > $result[0]['max_value']) continue;
				
				$this->conn->query("INSERT INTO `counters_values` (`counter`,`date`,`value`,`value2`,`mode`) VALUES ('$key',NOW(),'$value1','$value2','site')");
			}
			else
			{
				if(empty($value) or !preg_match("/^[0-9]+$/i", $value)) continue;
				$value = intval($value);
				
				$result[0]['max_value'] = intval($result[0]['max_value']);
				if($value > $result[0]['max_value']) continue;
				
				$this->conn->query("INSERT INTO `counters_values` (`counter`,`date`,`value`,`mode`) VALUES ('$key',NOW(),'$value','site')");
			}
        }
    }
    
    function get_finances($year)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        if(!preg_match("/^[0-9]+$/i", $year) or $year < 1000 or $year > 3000) return array();
        
        $monthAr = array(
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10=> 'Октябрь',
            11=> 'Ноябрь',
            12=> 'Декабрь'
        );
        
        $data = array();
        
        for($i = 12; $i > 0; $i--)
        {
            if(strlen($i) == 1) $month = (string) "0".$i;
            else $month = (string) $i;
            
            $transactions = $this->conn->query("SELECT * FROM `finances` WHERE MONTH(`date`)='$month' AND YEAR(`date`)='$year' and `customer`='$this->user_id' ORDER BY `date` DESC, `id` DESC")
                ->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($transactions) == 0) continue;
            
            $receipts = $this->conn->query("SELECT `id` FROM `receipts` WHERE MONTH(`date`)='$month' AND YEAR(`date`)='$year' and `customer`='$this->user_id' ORDER BY `date` DESC, `id` DESC LIMIT 1")
                ->fetchAll(PDO::FETCH_ASSOC);
            
            $data[$i]['period'] = (string) $monthAr[$i]." ".$year;
            $data[$i]['receipt'] = (count($receipts) == 0) ? "" : intval($receipts[0]['id']);
            
            foreach($transactions as $key => $row)
            {
                $data[$i]['transactions'][$key]['date'] = date("d-m-Y" ,strtotime($row['date']));
                $data[$i]['transactions'][$key]['accrued'] = ($row['accrued'] == 0) ? "--" : number_format($row['accrued'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['penalty'] = ($row['penalty'] == 0) ? "--" : number_format($row['penalty'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['recalculation'] = ($row['recalculation'] == 0) ? "--" : number_format($row['recalculation'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['paid'] = ($row['paid'] == 0) ? "--" : number_format($row['paid'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['saldo'] = ($row['saldo'] == 0) ? "--" : number_format($row['saldo'], 2, ',', ' ');
            }
        }
        
        return $data;
    }
    
    // получение списка домовых счётчиков
    function get_houses_counters_list()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        
        $result = $this->conn->query("
        SELECT
            C.`id`, C.`service`, C.`model`, C.`start_date`, C.`transformation_coefficient`, C.`number_of_tariffs`, CV.`date`, CV.`value`, CV.`value2`
        FROM
            `houses_counters` AS C
        LEFT JOIN
            `houses_counters_values` AS CV 
        ON
            CV.`id` = (
                SELECT
                    `id`
                FROM
                    `houses_counters_values` AS S 
                WHERE
                    S.`counter` = C.`id`
                ORDER BY
                    `date` DESC, `id` DESC
                LIMIT
                    1
            )
        WHERE
            C.`house_id` = (
                SELECT `program_house_id` FROM `customers` WHERE `program_customer_id`=(
                    SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id'
                )
            )
        ORDER BY
            C.`service` ASC, C.`id` ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
        
        $data = array();
        
        if(count($result) > 0)
        {
            foreach($result AS $key => $row)
            {
                $data[$key]['id'] = intval($row['id']);
                $data[$key]['service'] = htmlspecialchars($row['service'], ENT_QUOTES, "UTF-8");
                $data[$key]['model'] = htmlspecialchars($row['model'], ENT_QUOTES, "UTF-8");
                if(empty($data[$key]['model'])) $data[$key]['model'] = '--';
                $data[$key]['start_date'] = (strtotime($row['start_date']) > strtotime('2000-01-01')) ? date("d-m-Y" ,strtotime($row['start_date'])) : "--";
                $data[$key]['transformation_coefficient'] = ($row['transformation_coefficient'] == 0) ? "--" : number_format($row['transformation_coefficient'], 2, ',', ' ');
				$data[$key]['number_of_tariffs'] = intval($row['number_of_tariffs']);
                
                if($row['date'] != '')
                    $data[$key]['last_report_date'] = date("d-m-Y" ,strtotime($row['date']));
                else
                    $data[$key]['last_report_date'] = 'Данных не найдено';
                $data[$key]['last_report_value'] = number_format($row['value'], 0, ',', ' ');
				if(!empty($row['value2']) and $data[$key]['number_of_tariffs'] > 1){
					$data[$key]['last_report_value'] .= ' <span class="redline">|</span> '.number_format($row['value2'], 0, ',', ' ');
				}
            }
        }
        return $data;
    }
    
    // получение истории домового счётчика
    function get_houses_counter_history($counter_id, $row)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        if(!preg_match("/^[0-9]+$/i", $counter_id)) return array();
        if(!preg_match("/^[\,0-9]+$/i", $row)) return array();
        
        $counter_id = intval($counter_id);
        
        $result = $this->conn->query("SELECT `service`, `model`, `number_of_tariffs` FROM `houses_counters` WHERE `id`='$counter_id' and `house_id` = (
                SELECT `program_house_id` FROM `customers` WHERE `program_customer_id`=(SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id')
            )")->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return array();
        
        $data = array();
        $data['service'] = htmlspecialchars($result[0]['service'], ENT_QUOTES, "UTF-8");
        $data['model'] = htmlspecialchars($result[0]['model'], ENT_QUOTES, "UTF-8");
		$number_of_tariffs = intval($result[0]['number_of_tariffs']);
        $data['values'] = array();
        
        $result = $this->conn->query("SELECT `date`, `value`, `value2` FROM `houses_counters_values` WHERE `counter`='$counter_id' ORDER BY `date` DESC, `id` DESC LIMIT $row")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) > 0)
        {
            foreach($result as $key => $row)
            {
                $data['values'][$key]['date'] = date("d-m-Y" ,strtotime($row['date']));
                $data['values'][$key]['value'] = number_format($row['value'], 0, ',', ' ');
				
				if(!empty($row['value2']) and $number_of_tariffs > 1)
				$data['values'][$key]['value'] .= ' <span class="redline">|</span> '.number_format($row['value2'], 0, ',', ' ');
            }
        }
        
        return $data;
    }
	
	function get_odns($year)
	{
		if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        if(!preg_match("/^[0-9]+$/i", $year) or $year < 1000 or $year > 3000) return array();
        
        $monthAr = array(
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10=> 'Октябрь',
            11=> 'Ноябрь',
            12=> 'Декабрь'
        );
        
        $data = array();
        
        for($i = 12; $i > 0; $i--)
        {
            if(strlen($i) == 1) $month = (string) "0".$i;
            else $month = (string) $i;
            
            $transactions = $this->conn->query("SELECT * FROM `odns` WHERE MONTH(`date`)='$month' AND YEAR(`date`)='$year' and `customer`='$this->user_id' ORDER BY `date` DESC, `id` DESC")
                ->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($transactions) == 0) continue;
            
            $data[$i]['period'] = (string) $monthAr[$i]." ".$year;
            foreach($transactions as $key => $row)
            {
                $data[$i]['transactions'][$key]['date'] = date("d-m-Y" ,strtotime($row['date']));
                $data[$i]['transactions'][$key]['type'] = htmlspecialchars($row['type'], ENT_QUOTES, "UTF-8");
                $data[$i]['transactions'][$key]['units'] = htmlspecialchars($row['units'], ENT_QUOTES, "UTF-8");
                $data[$i]['transactions'][$key]['real_overall_consumption'] = ($row['real_overall_consumption'] == 0) ? "--" : number_format($row['real_overall_consumption'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['estimated_overall_consumption'] = ($row['estimated_overall_consumption'] == 0) ? "--" : number_format($row['estimated_overall_consumption'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['counters_consumption'] = ($row['counters_consumption'] == 0) ? "--" : number_format($row['counters_consumption'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['norm_consumption'] = ($row['norm_consumption'] == 0) ? "--" : number_format($row['norm_consumption'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['sum_consumption'] = (($row['norm_consumption']+$row['counters_consumption']) == 0) ? "--" : number_format(($row['norm_consumption']+$row['counters_consumption']), 2, ',', ' ');
                $data[$i]['transactions'][$key]['diff'] = ($row['diff'] == 0) ? "--" : number_format($row['diff'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['total_square'] = ($row['total_square'] == 0) ? "--" : number_format($row['total_square'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['distribution_coefficient'] = ($row['distribution_coefficient'] == 0) ? "--" : number_format($row['distribution_coefficient'], 5, ',', ' ');
                $data[$i]['transactions'][$key]['flat_square'] = ($row['flat_square'] == 0) ? "--" : number_format($row['flat_square'], 2, ',', ' ');
                $data[$i]['transactions'][$key]['odn_value'] = ($row['odn_value'] == 0) ? "--" : number_format($row['odn_value'], 2, ',', ' ');
            }
        }
        
        return $data;
	}
    
    function get_receipt($id)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return "";
        if(!preg_match("/^[0-9]+$/i", $id) or $id <= 0) return "";
        
        $id = intval($id);
        
        $file = $this->conn->query("SELECT AES_DECRYPT(`file`, @aes_key) AS `file` FROM `receipts` WHERE `id`='$id' and `customer`='$this->user_id'")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=Квитанция-{$id}.pdf");
        
        if(count($file) == 0) return "";
        else return $file[0]['file'];
    }
    
    function get_upload($id)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return "";
        if(!preg_match("/^[0-9]+$/i", $id) or $id <= 0) return "";
        
        $id = intval($id);
        
        $file = $this->conn->query("SELECT `file`, `file_type`,`file_name` FROM `messages` WHERE `id`='$id' and `customer`='$this->user_id'")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        $file[0]['file_type'] = (string) $file[0]['file_type'];
        $file[0]['file_name'] = (string) $file[0]['file_name'];
        $file[0]['file_name'] = str_replace(' ', '_', $file[0]['file_name']);
        
        header("Content-Type: ". $file[0]['file_type']);
        header("Content-Disposition: attachment; filename=".$file[0]['file_name']);
        
        if(count($file) == 0) return "";
        else return $file[0]['file'];
    }
    
    function get_max_allowed_packet()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return -1;
        
        $max = $this->conn->query( 'SELECT @@global.max_allowed_packet' )->fetch();
        return $max[0];
    }
    
    function send_message($message, $file = null)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return 100;
        if(strlen($message) > 32000 or strlen($message) < 10) return 101;
        
        $message = htmlentities($message, ENT_QUOTES, "UTF-8");
        $message = addslashes($message);
        
        $fileContent = '';
        $fileType = '';
        $fileName = '';
        
        if($file !== null)
        {
            $fileName = (!empty($file['name'])) ? $file['name'] : "No_name.";
            $tmpName  = $file['tmp_name'];
            $fileType = (!empty($file['type'])) ? $file['type'] : "No_type.";

            $fp = fopen($tmpName, 'r');
            $fileContent = fread($fp, filesize($tmpName));
            $fileContent = addslashes($fileContent);
            fclose($fp);
            
            $fileName = htmlentities($fileName, ENT_QUOTES, "UTF-8");
            $fileName = addslashes($fileName);
            $fileType = addslashes($fileType);
        }
        
        $sql = "INSERT INTO `messages` (`customer`,`message`,`date`,`viewed`,`file`,`file_type`,`file_name`) 
                            VALUES ('$this->user_id','$message',NOW(),'no','$fileContent','$fileType','$fileName')";
        
        $max = $this->conn->query( 'SELECT @@global.max_allowed_packet' )->fetch();
        if(strlen($sql) > $max[0] ) return 102;
        
        $this->conn->query($sql);
    }
    
    function get_messages()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return array();
        
        $result = $this->conn->query("SELECT `id`,`date`,`message`,`viewed`,`file_name`, (CASE `file_type` WHEN '' THEN 'no' ELSE 'yes' END) AS `file` FROM `messages` WHERE `customer`='$this->user_id' ORDER BY `date` DESC, `id` DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($result) == 0) return array();
        
        $data = array();
        foreach($result as $key => $row)
        {
            $data[$key]['date'] = date("d-m-Y H:i" ,strtotime($row['date']));
            $row['message'] = html_entity_decode($row['message'], ENT_QUOTES, "UTF-8");
            $data[$key]['body'] = htmlentities($row['message'], ENT_QUOTES, "UTF-8");
            $data[$key]['include'] = ($row['file'] == "yes") ? intval($row['id']) : "";
            $row['file_name'] = html_entity_decode($row['file_name'], ENT_QUOTES, "UTF-8");
            $data[$key]['include_name'] = htmlentities($row['file_name'], ENT_QUOTES, "UTF-8");
            $data[$key]['viewed'] = htmlspecialchars($row['viewed'], ENT_QUOTES, "UTF-8");
        }
        return $data;
    }
	
	function set_analytics_event($type)
	{
		if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;
		
		$type = htmlentities($type, ENT_QUOTES, "UTF-8");
        $type = addslashes($type);
		
		try
		{
			$this->conn->query("INSERT INTO `analytics` SET `customer`='{$this->user_id}', `date`=NOW(), `type`='{$type}'");
			$this->conn->query("DELETE FROM `analytics` WHERE `date` < DATE_SUB(NOW() , INTERVAL 3 MONTH)");
		}
		catch(Exception $e) {}
	}
    
    function get_current_saldo()
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;
        
        $saldo = $this->conn->query("SELECT `saldo` FROM `finances` WHERE `customer`='$this->user_id' ORDER BY `date` DESC, `id` DESC LIMIT 1")->fetchColumn();
        $saldo = number_format($saldo, 2, '.', '');
        return $saldo;
    }
    
    function format_sum($saldo)
    {
        return ($saldo<=0) ? "0,00" : number_format($saldo, 2, ',', '');
    }
    
    function format_sum_and_fee($saldo)
    {
        if($saldo<=0) return "0,00";
        $comm = (1/(1-Config::$pay_online_commission_percent/100))-1;
        $fee = $saldo*$comm;
        if($fee<Config::$pay_online_min_commission) $fee = Config::$pay_online_min_commission;
        $fee = ceil($fee*100)/100;
        if($fee<0) $fee=0.00;
        $fee = number_format($fee, 2, '.', '');
        return number_format(($saldo+$fee), 2, ',', '');
    }
    
    function format_saldo($saldo)
    {
        return number_format($saldo, 2, ',', '');
    }
    
    function format_commission()
    {
        $comm = (1/(1-Config::$pay_online_commission_percent/100))-1;
        $comm = ceil($comm*10000)/100;
        return number_format($comm, 2, ',', '');
    }
    
    function format_min_commission()
    {
        return number_format(Config::$pay_online_min_commission, 2, ',', '');
    }
    
    function payOnlineLink($amount)
    {
        if($this->conn == null) $this->db_connect();
        if(!isset($this->user_id)) return;
        
        $PaymentUrl="https://secure.payonlinesystem.com/ru/payment/?";
	
        $SecurityKey = 'MerchantId='.(int)Config::$pay_online_merchant_id;
        $PaymentUrl .= 'MerchantId='.(int)Config::$pay_online_merchant_id;
        
        $result = $this->conn->query("
        SELECT `program_company_id`,`name` FROM `companies` WHERE `program_company_id`=(
            SELECT `program_company_id` FROM `houses` WHERE `program_house_id`=(
                SELECT `program_house_id` FROM `customers` WHERE `program_customer_id`=(
                    SELECT `program_customer_id` FROM `bridge` WHERE `id`='$this->user_id'
                )
            )
        )
        ")->fetchAll(PDO::FETCH_ASSOC);
        $resultID = (int)$result[0]["program_company_id"];
        $resultName = (string)$result[0]["name"];
        $resultRand = mt_rand(10,99);
        
        $SecurityKey .= '&OrderId='.mb_substr($resultID."-".$this->user_id."-".date("YmdHis")."-".$resultRand, 0, 50);
        $PaymentUrl .= '&OrderId='.urlencode(mb_substr($resultID."-".$this->user_id."-".date("YmdHis")."-".$resultRand, 0, 50));
        
        $SecurityKey .= '&Amount='.number_format((float)$amount, 2, '.', '');
        $PaymentUrl .= '&Amount='.number_format((float)$amount, 2, '.', '');

        $SecurityKey .= '&Currency=RUB';
        $PaymentUrl .= '&Currency=RUB';

        $SecurityKey .= '&OrderDescription='.(string)(htmlspecialchars($result[0]["name"], ENT_QUOTES, "UTF-8")." - Оплата коммунальных услуг");
        $PaymentUrl .= '&OrderDescription='.urlencode((string)(htmlspecialchars($result[0]["name"], ENT_QUOTES, "UTF-8")." - Оплата коммунальных услуг"));
        
        $site = (($this->isSecureConnection()) ? "https://" : "http://").$_SERVER['SERVER_NAME'];
        $PaymentUrl .= "&FailUrl=".urlencode((string)($site."/account/pay?status=fail"));

        $SecurityKey .= '&PrivateSecurityKey='.(string)Config::$pay_online_private_security_key;
        $PaymentUrl .= "&SecurityKey=".md5($SecurityKey);
        
        Route::Page($PaymentUrl);
    }
    
}