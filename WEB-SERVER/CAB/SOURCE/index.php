<?php

// настройка уведомлений об ошибках
ini_set('html_errors', 0);
ini_set('display_errors', 0);
ini_set("log_errors", 1);
ini_set("error_log", "error.log");
ini_set('error_reporting', -1);

// загрузка файла настроек
require_once ('config.php');

// начальная загрузка
require_once ('application/bootstrap.php');
