<?php
class Model_Main extends Model
{
    public function get_uk_list()
    {
        $data = array();
        
        if($this->conn == null) $this->db_connect();
        
        $rows = $this->conn->query("SELECT * FROM `companies` ORDER BY `program_company_id` ASC")->fetchAll(PDO::FETCH_ASSOC);
        if(count($rows) > 0)
        {
            foreach($rows as $row)
            {
				$row['program_company_id'] = intval($row['program_company_id']);
                $data[$row['program_company_id']] = htmlspecialchars($row['name'], ENT_QUOTES, "UTF-8");
            }
        }
        
        return $data;
    }
	
	public function get_last_uk()
	{
		if(
            !isset($_COOKIE['upko_last_uk']) or 
            empty($_COOKIE['upko_last_uk']) or 
            !preg_match("/^[0-9]+$/i", $_COOKIE['upko_last_uk'])
        ) return 0;
		
		return intval($_COOKIE['upko_last_uk']);
	}
}