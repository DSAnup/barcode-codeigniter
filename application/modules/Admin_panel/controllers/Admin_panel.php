<?php

class Admin_panel extends MX_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Rest_model');
		$this->load->library('session');
		$this->load->helper('text');
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function login(){
		$data=$this->input->post();
		$data['password'] = md5($this->input->post('password'));
		$d=$this->Rest_model->SelectData_1('wsxq_admin','*',$data);
		// $dd = $d->status;
		// echo "<pre>";	
		// print_r($dd);
		if (!empty($d) && $d->status==1) {
			$userID =$this->session->set_userdata('userID',$d->id);
			redirect(base_url().'Admin_panel/dashboard','refresh');
		}else{
			redirect(base_url().'Admin_panel','refresh');
		}
	}
	public function user(){
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		$data['adm'] = $this->Rest_model->SelectData('wsxq_admin', '*', '');
		$this->load->view('Admin_panel/user', $data);
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function delete_user($id){
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		$this->Rest_model->DeleteData('wsxq_admin', array('id'=>$id));
		redirect(base_url().'Admin_panel/user', 'refresh');
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function add_user(){
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		$data= $this->input->post();
		$data['password'] = md5($this->input->post('password'));
		$this->Rest_model->SaveData('wsxq_admin', $data);
		redirect(base_url().'Admin_panel/user');
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function edit_user($id){
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		$data['adm'] =$this->Rest_model->SelectData_1('wsxq_admin','*',array('id'=>$id));
		$this->load->view('Admin_panel/edit_user', $data);
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function update_user(){
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		$id = $this->input->post('id');
		$data = $this->input->post();
		$data['password'] = md5($this->input->post('password'));
		// print_r($data['password']);
		$this->Rest_model->UpdateData('wsxq_admin', $data, array('id'=>$id));
		redirect(base_url().'Admin_panel/user', 'refresh');
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function dashboard()
	{
		$userID = $this->session->userdata('userID');
		if (isset($userID)) {
		
        $session['menu']='home';
        $this->session->set_userdata($session);
		$this->load->view('dashboard');
		}else{
			redirect(base_url().'Admin_panel', 'refresh');
		}
	}
	public function signout(){
		session_destroy();
		redirect(base_url().'Admin_panel','refresh');
	}

}
?>