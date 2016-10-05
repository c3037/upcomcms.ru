<?php

// определяем глобальные константы
define("APP_VERSION", "1.04");
define("APP_ID", md5($_SERVER['SERVER_ADDR'].__FILE__.Config::$salt));

// запрет кэширования
header("Pragma: no-cache");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: " . date("r"));

// подключаем файлы ядра
require_once ('core/model.php');
require_once ('core/view.php');
require_once ('core/controller.php');

// проверяем лицензию
function license_check($show_license_information = false) {
    
    $license_salt = "12876c0b23c5fc70125874";
    $license_key = sha1( APP_ID.$license_salt.Config::$license_expiration );
    
    if(
        isset(Config::$license_key) and 
        !empty(Config::$license_key) and 
        isset(Config::$license_expiration) and 
        !empty(Config::$license_expiration) and 
        (Config::$license_key === $license_key) and 
        (strtotime(Config::$license_expiration) >= strtotime("now")) and
        $show_license_information == false
    ) return;
    
    echo "<strong>Приложение не активировано.</strong><br /><br />",
        "<strong>AppVersion:</strong> ",APP_VERSION,"<br />",
        "<strong>AppID:</strong> ",APP_ID,"<br />";
    exit;
}
license_check();

// запускаем маршрутизатор
require_once ('core/route.php');
Route::start();
