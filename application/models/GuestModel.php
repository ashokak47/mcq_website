<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GuestModel extends CI_Model {

    public function ModelHelper($success,$error,$error_msg = '',$data_arr = array()){
        if($success == true && $error == false){
            $data = array(
                'success' => 'true',
                'error'   => 'false',
                'message' => $error_msg,
                'res_arr' => $data_arr 
            ) ;
            
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

       
    public function GuestLogin($data) {
        $this->db->select('*');
        $this->db->from('guest');
        $this->db->where('guest_email',$data['guest_email']);
        $this->db->limit(1);        
		$query = $this->db->get();
		
        if ($query->num_rows() == 1){
            
            return $this->ModelHelper(true,false);
        }
        else{
            return $this->ModelHelper(false,true,'No such User exists !');
        }
    }
    

    public function GuestByEmail($email) {
		$sql="SELECT 
			* 
		FROM 
			guest
		WHERE 
			guest_email = ".$this->db->escape($email)." ";
			
        $query = $this->db->query($sql);
        
        if($query && $query->num_rows() > 0){
            return $this->ModelHelper(true,false,'',$query->row_array());
        }
        else{
            return $this->ModelHelper(false,true,"No user found.");   
        }
    }
    //Generic function
    public function Insert($data,$table_name){
        if($this->db->insert($table_name,$data)){
            $data = array('insert_id' => $this->db->insert_id());
            return $this->ModelHelper(true,false,'',$data);
        }
        else{
            return $this->ModelHelper(false,true,"Check your inserted query!");
        }
    }    

}
