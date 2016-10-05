<?php

class Controller_404 extends Controller
{
    
    function action_index()
	{	
        $data = array();
        $data["page_title"] = "Страница не найдена";
        
        $this->view->generate('view_404', 'template_404', $data);
        
	}
    
}