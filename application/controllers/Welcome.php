<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}
	public function index()
	{
		if(!empty($_POST)){
			$config = array(
				'upload_path' => 'uploads',
				'allowed_types' => 'gif|jpg|png|jpeg',
			);
			$this->load->library('upload', $config);
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[profile_data.email]');
			$this->form_validation->set_rules('phone_no', 'Phone #', 'required|min_length[10]|max_length[10]');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('register-form');
			}
			else
			{
				if (!$this->upload->do_upload('profile_pic')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata("error", $this->upload->display_errors());
					$this->load->view('register-form');
				} else {
					$fileName = $this->upload->data();
					$data = array();
					$fullname = $_POST['first_name']." ".$_POST['last_name'];
					$data['first_name'] = $_POST['first_name'];
					$data['last_name'] = $_POST['last_name'];
					$data['email'] = $_POST['email'];
					$data['phone_no'] = $_POST['phone_no'];
					$data['job_title'] = $_POST['job_title'];
					$data['profile_pic'] = $fileName['file_name'];
					$this->db->insert('profile_data',$data);
					$this->session->set_flashdata("success", "Your profile added to our database");
					$curl = curl_init();
					$time = date('h:i a');
					$date = date('d/m/y');
					$data = array('channel'=>'DP0EG0YJD','text'=>$fullname.' has created a profile on your app at '.$time.' on '.$date);
					$jsonString = json_encode($data);
					curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
					curl_setopt($curl,CURLOPT_POSTFIELDS,$jsonString);
					curl_setopt($curl,CURLOPT_CRLF,true);
					curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl,CURLOPT_URL,"https://slack.com/api/chat.postMessage");
					curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
					curl_setopt($curl,CURLOPT_HTTPHEADER,array(
						'Content-Type: application/json',
						'Content-Length: '.strlen($jsonString),
						'Authorization: Bearer xoxp-788931034208-790780708887-776339297410-cf6ff9bbfc17fcbbfd457504867348f5'
					));
					$result = curl_exec($curl);
					redirect("Welcome/users_list", "refresh");
				}
			}
		}
		else{
			$this->load->view('register-form');
		}
	}
	public function users_list(){
		$list = $this->db->get('profile_data')->result();
		$data['profile_list'] = $list;
		$this->load->view('users_list',$data);
	}
	public function edit_profile($id){
		if(!empty($_POST)){
			$config = array(
				'upload_path' => 'uploads',
				'allowed_types' => 'gif|jpg|png|jpeg',
			);
			$this->load->library('upload', $config);
			
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			$this->form_validation->set_rules('phone_no', 'Phone #', 'required|min_length[10]|max_length[10]');
			$data = array();
			if ($this->form_validation->run() == FALSE){}
			else{
				if($_FILES['profile_pic']['name'] != ''){
					if (!$this->upload->do_upload('profile_pic')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata("error", $this->upload->display_errors());
						$this->load->view('register-form');
					} else {
						$fileName = $this->upload->data();
						$data['profile_pic'] = $fileName['file_name'];
					}
				}
				$fullname = $_POST['first_name']." ".$_POST['last_name'];
				$data['first_name'] = $_POST['first_name'];
				$data['last_name'] = $_POST['last_name'];
				$data['phone_no'] = $_POST['phone_no'];
				$data['job_title'] = $_POST['job_title'];
				$this->db->update('profile_data',$data,array('ID'=>$id));
				$this->session->set_flashdata("success", "Your profile has been updated");
				$curl = curl_init();
				$time = date('h:i a');
				$date = date('d/m/y');
				$data = array('channel'=>'DP0EG0YJD','text'=>$fullname.' has updated the profile on your app at '.$time.' on '.$date);
				$jsonString = json_encode($data);
				curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
				curl_setopt($curl,CURLOPT_POSTFIELDS,$jsonString);
				curl_setopt($curl,CURLOPT_CRLF,true);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl,CURLOPT_URL,"https://slack.com/api/chat.postMessage");
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
				curl_setopt($curl,CURLOPT_HTTPHEADER,array(
					'Content-Type: application/json',
					'Content-Length: '.strlen($jsonString),
					'Authorization: Bearer xoxp-788931034208-790780708887-776339297410-cf6ff9bbfc17fcbbfd457504867348f5'
				));
				$result = curl_exec($curl);
				redirect("Welcome/users_list", "refresh");
			}
		}
		$userData = $this->db->from('profile_data')->where('ID',$id)->get()->row();
		$data['user_data'] = $userData;
		$this->load->view('edit_profile',$data);
	}
	public function delete_profile($id){
		$this->db->delete('profile_data',array('ID'=>$id));
		$this->session->set_flashdata("success", "Your profile delete successfully");
		redirect("Welcome/users_list", "refresh");
	}
}