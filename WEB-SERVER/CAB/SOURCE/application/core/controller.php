<?php

abstract class Controller {
	
	public $model;
	public $view;
	
	function __construct()
	{
        $this->view = new View();
	}
    
    // загрузка локальной модели
    function use_model($model_name)
	{
        $model_name = 'Model_'.$model_name;
        
        // подцепляем файл с классом модели
        $model_file = strtolower($model_name).'.php';
        $model_path = "application/models/".$model_file;
        require_once ($model_path);
        
        $this->model = new $model_name;
	}
	
	// действие (action), вызываемое по умолчанию
	abstract function action_index();
}
