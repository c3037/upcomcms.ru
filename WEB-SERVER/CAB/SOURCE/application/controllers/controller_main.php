<?php

class Controller_Main extends Controller
{
    
    function action_index()
	{	
        $this->use_model('Main');
        if($this->model->check_auth() !== false) Route::Page("/account");
        
        $data = array();
        $data["page_title"] = "Стартовая страница";
        $data["uk_list"] = $this->model->get_uk_list();
        $data["upd_date"] = $this->model->get_upd_date();
		$data["last_uk"] = $this->model->get_last_uk();
        
        $this->view->generate('view_main', 'template_main', $data);
        
	}
    
    function action_sp()
    {
        $data = array();
        $data["page_title"] = "Подтверждение платежа";
        $data["dateTime"] = (isset($_GET["DateTime"]) and !empty($_GET["DateTime"]) and preg_match("/^[ 0-9-:]{1,50}$/i", $_GET["DateTime"])) ? $_GET["DateTime"] : "---";
        $data["transactionID"] = (isset($_GET["TransactionID"]) and !empty($_GET["TransactionID"])) ? intval($_GET["TransactionID"]) : "---";
        $data["orderID"] = (isset($_GET["OrderId"]) and !empty($_GET["OrderId"]) and preg_match("/^[0-9-]{1,50}$/i", $_GET["OrderId"])) ? $_GET["OrderId"] : "---";
        $this->view->generate('view_sp', 'template_sp', $data);
    }
    
}