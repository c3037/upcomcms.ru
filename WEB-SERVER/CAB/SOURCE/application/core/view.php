<?php

class View
{
	
    /*
	$view_content - виды, отображающие контент страниц;
	$view_template - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы.
	*/
	function generate($view_content, $view_template, $data = null)
	{
        
        // подключаем вид, отображающий контент страницы
        ob_start();
            require_once('application/views/'.$view_content.'.php');
            $content = ob_get_contents();
        ob_get_clean();
        
        // подключаем аналитику
        $data_for_analytics = array();
            if(isset($data['user_id'])) $data_for_analytics['user_id'] = $data['user_id'];
        $analytics = $this->analytics($data_for_analytics);
        
        /*
		подключаем общий шаблон (вид),
		внутри которого будет встраиваться вид
		для отображения контента конкретной страницы.
		*/
        require_once ('application/views/templates/'.$view_template.'.php');
	}
    
    // подгружаем файл с кодом аналитики
    function analytics(array $data)
    {
        ob_start();
            require_once('analytics.php');
            $analytics = ob_get_contents();
        ob_get_clean();
        
        return $analytics;
    }
}
