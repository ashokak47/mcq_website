<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller {
	//constructor of the  Controller
	public function __construct(){
	  parent::__construct();
	  $this->load->model('AdminModel');
	  $this->load->model('GuestModel');
  }

  public function ReturnJsonArray($success,$error,$message){
  	if($success == true && $error == false){
  		$data = array(
						'success' => 'true',
						'error'   => 'false',
						'message' =>  $message
					 );
			header("Content-type: application/json");
			print(json_encode($data, JSON_PRETTY_PRINT));
		}
		elseif ($success == false && $error == true) {
			$data = array(
						'success' => 'false',
						'error'   => 'true',
						'message' =>  $message
					 );
			header("Content-type: application/json");
			print(json_encode($data, JSON_PRETTY_PRINT));
		}
  }

  //Testing Function
  private function PrettyPrintArray($data){
  	print("<pre>".print_r($data,true)."</pre>");
  	die;
  }


	//function for login
	public function Login(){
        if(isset($_POST) && !empty($_POST)){			
            $this->form_validation->set_rules('admin_email', 'Email', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('admin_password', 'Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
            {
                $data = array(
                                'success' => 'false',
                                'error'   => 'true',
                                'message' =>  validation_errors()
                             );
                header("Content-type: application/json");
                print(json_encode($data, JSON_PRETTY_PRINT));
                die;
            }  
            else 
            {
                $data = array(
                    'admin_email'    => $this->input->post('admin_email'),
                    'password' => $this->input->post('admin_password')
                );
				$result = $this->AdminModel->AdminLogin($data);
                if ($result['success'] == 'true') 
                {
                    $result = $this->AdminModel->AdminByEmail($data['admin_email']);
                    
                    if($result['success'] == 'true'){
                        if($data['admin_email'] == $result['res_arr']['admin_email'] && password_verify($data['password'],$result['res_arr']['password'])){ 
                            $this->ReturnJsonArray(true,false,'Valid login!');
                            die;
                        }
                        else{                        
							$this->ReturnJsonArray(false,true,'Wrong email or password !');
							die;
                        }
                    }
                    elseif($result['error'] == 'true'){
                        $this->ReturnJsonArray(false,true,$result['message']);
                        die;
                    }
                }
                elseif($result['error'] == 'true'){
                    $this->ReturnJsonArray(false,true,$result['message']);
                    die;
                }
            }
        }
        else{
            $data['title'] = "Login";
            $this->load->view('admin/admin_login_view',$data);
        }
    }

	//Default Page for Admin
	public function index(){
			$data['title'] = "Login";
			$data['sidebar_collapsed'] = "true";		
			$this->load->view('admin/admin_login_view',$data);
	}

	//Dashboard Page for Admin
	public function Dashboard(){
		$data['title'] = "Dashboard";
		$data['sidebar_collapsed'] = "true";		
		$data['score']=$this->AdminModel->GetUserScore();
		$data['score']=$data['score']['res_arr'];
		$this->load->view('admin/admin_dashboard_view',$data);
}

}

