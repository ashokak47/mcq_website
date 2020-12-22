<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {
	

	public function ModelHelper($success,$error,$error_msg = '',$data_arr = array()){
        if($success == true && $error == false){
            $data = array(
                'success' => 'true',
                'error'   => 'false',
                'message' => $error_msg,
                'res_arr' => $data_arr 
            );
            
            return $data;
        }
        elseif ($success == false && $error == true) {
            $data = array(
                'success' => 'false',
                'error'   => 'true',
                'message' => $error_msg
            );
            
            return $data;
        }
    }
	 //Testing Function
	 private function PrintArray($data){
		print("<pre>".print_r($data,true)."</pre>");
		die;
	}
    //public function for logging in the admin to dashboard    
    public function AdminLogin($data) {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('admin_email',$data['admin_email']);
        $this->db->limit(1);
        
        $query = $this->db->get();

        if ($query->num_rows() == 1){
            return $this->ModelHelper(true,false);
        }
        else{
            return $this->ModelHelper(false,true,'No such business admin exists!');
        }
    }
    

    public function AdminByEmail($email) {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('admin_email',$email);
        $this->db->limit(1);
        
        //execute the query
        $query = $this->db->get();

        if ($query->num_rows() == 1){
            return $this->ModelHelper(true,false,'',$query->row_array());
        } 
        else{
            return $this->ModelHelper(false,true,"Duplicate emails are there!");
        }
    }

    //Generic function
    public function Insert($data,$table_name){
			$result=$this->db->insert($table_name,$data);
        if($result){
            $data = array('insert_id' => $this->db->insert_id());
            return $this->ModelHelper(true,false,'',$data);
        }
        else{
            return $this->ModelHelper(false,true,"Check your inserted query!",$data);
        }
    }

    public function GetUserScore(){
		$query="SELECT
		guest.guest_name,
		guest.contact,
		guest.guest_email,
		guest_score.guest_score,
		guest_score.test_date
	FROM
		guest,
		guest_score
	WHERE
		guest.guest_id= guest_score.guest_id
		GROUP BY guest.guest_id
		HAVING  MAX(guest_score.test_date) ";
        
        //execute the query
        $res = $this->db->query($query);

        if($res){
            return $this->ModelHelper(true,false,'',$res->result_array());
        }
        else{
            return $this->ModelHelper(false,true,"DB error!");   
        }
	}
}
