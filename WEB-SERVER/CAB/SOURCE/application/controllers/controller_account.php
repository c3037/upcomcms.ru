<?php

class Controller_Account extends Controller
{
    
    function action_index()
	{
        Route::Page("/account/overview");
	}
    
    function action_login()
	{
        $this->use_model("Account");
        
        if(!isset($_POST['account']) or empty($_POST['account'])) Route::Page("/main/index?status=error");
        if(!isset($_POST['password']) or empty($_POST['password'])) Route::Page("/main/index?status=error");
        if(!isset($_POST['uk']) or empty($_POST['uk'])) Route::Page("/main/index?status=error");
        
        $status = $this->model->login($_POST['account'], $_POST['password'], $_POST['uk']);
        
        if($status) Route::Page("/account/overview");
        else Route::Page("/main/index?status=error");
	}
    
    function action_logout()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $this->model->logout();
        Route::Page("/main/index");
	}
    
    function action_overview()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "index";
        $data["page_title"] = "Общая информация";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        $data = array_merge($data, $this->model->get_user_data());
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_overview', 'template_account', $data);
	}
    
    function action_counters()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "counters";
        $data["page_title"] = "Счётчики";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        $data["counters"] = $this->model->get_counters_list();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_counters', 'template_account', $data);
	}
    
    function action_history()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "history";
        $data["page_title"] = "История показаний";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_GET['counter']) and !empty($_GET['counter']))
        {
            if(isset($_GET['deleteValue']) and !empty($_GET['deleteValue']))
                $this->model->delete_value_of_counter($_GET['counter'],$_GET['deleteValue']);
            else
                $data["counter"] = $this->model->get_counter_history($_GET['counter'], 6);
        }
        else
            $data["counter"] = array();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_history', 'template_account', $data);
	}
    
    function action_submit()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "submit";
        $data["page_title"] = "Текущие показания";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        $data["counters"] = $this->model->get_counters_for_submit();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_submit', 'template_account', $data);
	}
    
    function action_submit_check()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "submit_check";
        $data["page_title"] = "Текущие показания";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_POST['counter']) and is_array($_POST['counter']) and count($_POST['counter']) > 0)
            $data["counter_values"] = $this->model->check_counters_values_for_submit($_POST['counter']);
        else
            Route::Page("/account/submit");
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_submit_check', 'template_account', $data);
	}
    
    function action_submit_send()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "submit_send";
        $data["page_title"] = "Текущие показания";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_POST['counter']) and is_array($_POST['counter']) and count($_POST['counter']) > 0)
            $this->model->send_counters_values($_POST['counter']);
        else
            Route::Page("/account/submit");
        
		$this->model->set_analytics_event("svl");
		
        $this->view->generate('view_submit_send', 'template_account', $data);
    }
    
    function action_finances()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "finances";
        $data["page_title"] = "Начисления и оплаты";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_GET['year']) and !empty($_GET['year']) and $_GET['year'] > 1900 and $_GET['year'] < 2100)
            $data["current_year"] = intval($_GET['year']);
        else
            $data["current_year"] = (int) date("Y", time());
        
        $data["last_year"] = $data["current_year"]-1;
        $data["next_year"] = $data["current_year"]+1;
        
        $data["finances"] = $this->model->get_finances($data["current_year"]);
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_finances', 'template_account', $data);
    }
    
    function action_houses_counters()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "houses_counters";
        $data["page_title"] = "Домовые счётчики";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        $data["counters"] = $this->model->get_houses_counters_list();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_houses_counters', 'template_account', $data);
	}
    
    function action_houses_counters_history()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "houses_counters_history";
        $data["page_title"] = "История показаний";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_GET['counter']) and !empty($_GET['counter']))
            $data["counter"] = $this->model->get_houses_counter_history($_GET['counter'], 6);
        else
            $data["counter"] = array();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_houses_counters_history', 'template_account', $data);
	}
    
    function action_odns()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "odns";
        $data["page_title"] = "Расчёт ОДН";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(isset($_GET['year']) and !empty($_GET['year']) and $_GET['year'] > 1900 and $_GET['year'] < 2100)
            $data["current_year"] = intval($_GET['year']);
        else
            $data["current_year"] = (int) date("Y", time());
        
        $data["last_year"] = $data["current_year"]-1;
        $data["next_year"] = $data["current_year"]+1;
        
        $data["odns"] = $this->model->get_odns($data["current_year"]);
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_odns', 'template_account', $data);
    }
    
    function action_files()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = "";
        
        if(isset($_GET['receipt']) and !empty($_GET['receipt']))
            $data = $this->model->get_receipt($_GET['receipt']);
        elseif(isset($_GET['upload']) and !empty($_GET['upload']))
            $data = $this->model->get_upload($_GET['upload']);
        
		$this->model->set_analytics_event("dfl");
		
        if($data != "")
            { echo $data; exit; }
        else
            Route::Page("/main/index");
    }
    
    function action_pay()
	{
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "pay";
        $data["page_title"] = "Онлайн оплата";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        if(Config::$use_pay){
            $data["saldo"] = $this->model->get_current_saldo();
            $data["sum"] = $this->model->format_sum($data["saldo"]);
            $data["sum_and_fee"] = $this->model->format_sum_and_fee($data["saldo"]);
            $data["saldo"] = $this->model->format_saldo($data["saldo"]);
            $data["commission"] = $this->model->format_commission();
            $data["min_commission"] = $this->model->format_min_commission();
        }
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_pay', 'template_account', $data);
	}
    
    function action_to_payment()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        if(Config::$use_pay and isset($_GET['sum2']) and !empty($_GET['sum2']))
        {
            $sum = str_replace(",", ".", $_GET['sum2']);
            if($sum > 0)
            {
                $this->model->set_analytics_event("pay");
                $this->model->payOnlineLink($sum);
            }
            else
                Route::Page("/account/pay");
        }
        else
            Route::Page("/account/pay");
    }
    
    function action_feedback()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "feedback";
        $data["page_title"] = "Обратная связь";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        $max_file_size = $this->model->get_max_allowed_packet();
        $data["max_file_size"] = ($max_file_size > (2*1024*1024+262144) ) ? 2*1024*1024 : $max_file_size-262144;
        $data["max_file_size"] = number_format($data["max_file_size"]/(1024*1024), 2, ',', ' ');
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_feedback', 'template_account', $data);
    }
    
    function action_feedback_send()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "feedback_send";
        $data["page_title"] = "Обратная связь";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        
        $max_file_size = $this->model->get_max_allowed_packet();
        $max_file_size = ($max_file_size > (2*1024*1024+262144) ) ? 2*1024*1024 : $max_file_size-262144;
        
        if(isset($_POST['message']) and !empty($_POST['message']))
        {
            $file = null;
            if(
                isset($_FILES['file']['size']) and 
                !empty($_FILES['file']['size']) and 
                $_FILES['file']['size'] > 0 and
                $_FILES['file']['size'] <= $max_file_size and
                $_FILES['file']['error'] == ""
            )
                $file = $_FILES['file'];
            
            switch($this->model->send_message($_POST['message'], $file))
            {
                case 100:
                    Route::Page("/account/feedback");
                break;
                case 101:
                    Route::Page("/account/feedback?error=bad_message_length");
                break;
                case 102:
                    Route::Page("/account/feedback?error=bad_query_size");
                break;
                default:
                break;
            }
        }
        else
            Route::Page("/account/feedback?error=does_not_exist_message");
        
		$this->model->set_analytics_event("fbk");
		
        $this->view->generate('view_feedback_send', 'template_account', $data);
    }
    
    function action_messages()
    {
        $this->use_model("Account");
        if($this->model->check_auth() === false) Route::Page("/main/index");
        
        $data = array();
        $data["current_page"] = "messages";
        $data["page_title"] = "История отправленных сообщений";
        $data["uk_name"] = $this->model->get_uk_name();
        $data["user_name"] = $this->model->get_user_name();
        $data["user_id"] = $this->model->get_user_id();
        $data["messages"] = $this->model->get_messages();
        
		$this->model->set_analytics_event("hit");
		
        $this->view->generate('view_messages', 'template_account', $data);
    }
}