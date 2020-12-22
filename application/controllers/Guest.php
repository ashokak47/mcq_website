<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guest extends CI_Controller {

	
	

	//constructor of the Alumni Controller
	public function __construct(){
		parent::__construct();
		$this->load->model('GuestModel');
		
  }		
	
  private function ReturnJsonArray($success,$error,$message){
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

  //  Testing Function
  private function PrintArray($data){
  	print("<pre>".print_r($data,true)."</pre>");
  	die;
  }

  //Default Page for cashier
	public function index(){			
		$data['title'] = "Login";
		$this->load->view('guest/guest_login_view',$data);
	}
	//function for login
    public function Login(){
        if(isset($_POST) && !empty($_POST)){
            $this->form_validation->set_rules('guest_email', 'Email', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('guest_password', 'Password', 'trim|required');
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
                    'guest_email'    => $this->input->post('guest_email'),
                    'guest_password' => $this->input->post('guest_password')
                );
                $result = $this->GuestModel->GuestLogin($data);
                if ($result['success'] == 'true') 
                {
                    $result = $this->GuestModel->GuestByEmail($data['guest_email']);
                    
                    if($result['success'] == 'true'){
                        if($data['guest_email'] == $result['res_arr']['guest_email'] && password_verify($data['guest_password'],$result['res_arr']['guest_password']))
                        { 
							$session_data = array(
                                'guest_id'      => $result['res_arr']['guest_id'],
                                'guest_email'   => $result['res_arr']['guest_email'],
                                'guest_name'    => $result['res_arr']['guest_name'],                                
                                'guest_number'   =>$result['res_arr']['contact'],
                                'user_type'        => 'guest'
                            );
                            $this->session->set_userdata('logged_user', $session_data);
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
            $this->load->view('guest/guest_login_view',$data);
        }
    }

	//Registration Page for guest
	public function Register(){		
		if(isset($_POST) && !empty($_POST)){
			$this->form_validation->set_rules('guest_name', 'Name', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('guest_number', 'Number', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('guest_email', 'Email', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('guest_password', 'Password', 'trim|required');
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
					'guest_name'    => $this->input->post('guest_name'),
					'contact'    => $this->input->post('guest_number'),
					'guest_email'    => $this->input->post('guest_email'),
                    'guest_password' => password_hash($this->input->post('guest_password'), PASSWORD_DEFAULT)
				);	
				$res=$this->GuestModel->Insert($data,'guest');
				if($res['res_arr']['success']='true'){
					$this->ReturnJsonArray(true,false,'Regsitration Successful!');
                    die;
				}else{
					$this->ReturnJsonArray(false,true,'Regsitration Failed!');
                    die;
				}
			}
		
		}else{
		$data['title'] = "Login";
		$this->load->view('guest/guest_registration',$data);
		}
	}

	public function Dashboard(){			
		$data['title'] = "dashboard";
		$data['sidebar_collapsed'] = "true";
		$data['questions']=$this->GetQuestions();
		$data['guest_name']=$this->session->userdata['logged_user']['guest_name'];
		$data['guest_id']=$this->session->userdata['logged_user']['guest_id'];
		$this->load->view('guest/guest_dashboard_view',$data);
	}


	public function GetQuestions(){
		// API 
		$url='https://opentdb.com/api.php?amount=10';
  		$ch = curl_init($url);
  		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		curl_setopt($ch,CURLOPT_POST,1);
  		curl_setopt($ch,CURLOPT_POSTFIELDS,"");
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER,2);  		
		$data = curl_exec($ch);
	  	return json_decode($data,true);				
	}

	//Add Score for guest
	public function AddGuestScore(){		
		if(isset($_POST) && !empty($_POST)){
			$this->form_validation->set_rules('guest_id', 'Id', 'trim|required|max_length[5]');
			$this->form_validation->set_rules('guest_score', 'Score', 'trim|required|max_length[3]');
			
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
					'guest_id'    => $this->input->post('guest_id'),
					'guest_score'    => $this->input->post('guest_score'),
                    'test_date' => date('Y-m-d')
				);	
				$res=$this->GuestModel->Insert($data,'guest_score');
				if($res['res_arr']['success']='true'){
					$this->ReturnJsonArray(true,false,'Submission Successful!');
                    die;
				}else{
					$this->ReturnJsonArray(false,true,'Submission Failed!');
                    die;
				}
			}
		
		}else{
			$data['sidebar_collapsed'] = "true";
		$data['title'] = "Dashboard";
		$this->load->view('guest/guest_dashboard_view',$data);
		}
	}


}
