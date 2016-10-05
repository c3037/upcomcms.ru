<?php

/*
Класс-маршрутизатор для определения запрашиваемой страницы.
> цепляет классы контроллеров и моделей;
> создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
*/
class Route
{

	static function start()
	{
		// контроллер и действие по умолчанию
		$controller_name = 'Main';
		$action_name = 'index';
		
        $r = explode('?', $_SERVER['REQUEST_URI']);
		$routes = explode('/', $r[0]);
        
		// получаем имя контроллера
		if ( !empty($routes[1]) and preg_match("/^[_0-9a-z]+$/i", $routes[1]) )
		{	
			$controller_name = $routes[1];
		}
		
		// получаем имя экшена
		if ( !empty($routes[2]) and preg_match("/^[_0-9a-z]+$/i", $routes[2]) )
		{
			$action_name = $routes[2];
		}

		// добавляем префиксы
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			require_once ($controller_path);
		}
		else
		{
			header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            Route::Page("/404");
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			$controller->$action();
		}
		else
		{
            header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            Route::Page("/404");
		}
	
	}
    
    static function Page($page)
	{
		header("Location: $page");
        exit;
    }
    
}
