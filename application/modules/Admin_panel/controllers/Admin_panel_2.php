<?php

class Admin_panel extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Rest_model');
    }
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function index(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $this->load->view('index');
    }
    public function signup(){
        if (!isset($_SESSION['adminID'])) {
            redirect(base_url() . 'Admin_panel');
        }
        $this->load->view('register');
    }
    public function register(){
        if (!isset($_SESSION['adminID'])) {
            redirect(base_url() . 'Admin_panel');
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 20; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $id=$randomString;
        $name=$this->input->post('name');
        $data['admin_id']=$id;
        $data['name']=$name;
        $data['email']=$this->input->post('email');
        $data['phone']=$this->input->post('phone');
        $data['password']=md5($this->input->post('password'));
        $this->Admin_model->register($data);
        $session['adminID']=$id;
        $session['admin_name']=$name;
        $this->session->set_userdata($session);
        redirect(base_url().'Admin_panel/dashboard');
    }
    public function dashboard(){

        $adminID=$this->session->userdata('adminID');
        if(isset($adminID)) {
            $query['jobs']=$this->Admin_model->job_number();
            $query['emp']=$this->Admin_model->emp_number();
            $this->load->view('dashboard',$query);
        }else{
            redirect(base_url().'Admin_panel');
        }
        $session['menu']='home';
        $this->session->set_userdata($session);
        var_dump($_SESSION);
        $session['menu']='home';
        $this->session->set_userdata($session);
        // $query['jobs']=$this->Admin_model->job_number();
        // $query['emp']=$this->Admin_model->emp_number();
        $this->load->view('dashboard');
    }
    
    public function login(){
        $email=$this->input->post('email');
        $password=md5($this->input->post('password'));
        $query=$this->Admin_model->login($email,$password);
        if(!empty($query)){
            $session['admin_name']=$query->name;
            $session['adminID']=$query->admin_id;
            $this->session->set_userdata($session);
            redirect(base_url().'Admin_panel/dashboard');
        }else{
            $this->session->set_flashdata('error','Wrong username or password');
            redirect(base_url().'Admin_panel');
        }
        $session['admin_name']=$query->name;
        $session['adminID']=$query->admin_id;
        $this->session->set_userdata($session);
        redirect(base_url().'Admin_panel/dashboard');

    }
    
    public function signout(){
        $this->session->unset_userdata('adminID');
        $this->session->unset_userdata('admin_name');
        redirect(base_url().'Admin_panel');
    }
    public function gallery(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['img'] = $this->Rest_model->SelectDataOrder('fd_gallery','*',array('siteID'=>$siteID),'id','desc');
        $this->load->view('gallery', $data);
    }
    public function add_gallery(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $config['upload_path'] = './uploads/gallery/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100000000;
        $config['max_width'] = 10240000;
        $config['max_height'] = 7680000;
        $this->load->library('upload', $config);


        $this->load->library('image_lib');
        $config_1['image_library'] = 'gd2';
        $config_1['create_thumb'] = FALSE;
        $config_1['maintain_ratio'] = FALSE;
        $config_1['width']         = 250;
        $config_1['height']       = 250;

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data2 = array('upload_data' => $this->upload->data());
            $data['image'] = $data2['upload_data']['file_name'];
            $config_1['source_image'] = 'uploads/gallery/'.$data2['upload_data']['file_name'];
            $this->image_lib->initialize($config_1); 
            $this->image_lib->resize();
        }
        $this->Rest_model->SaveData('fd_gallery', $data);
        redirect(base_url().'Admin_panel/gallery', 'refresh');
    }
    public function delete_gallery($id){
        $siteID = $this->session->userdata('siteID');
        $qq=$this->Rest_model->SelectData_1('fd_gallery','*',array('id'=>$id,'siteID'=>$siteID));
        unlink('uploads/gallery/'.$qq->image);
        $this->Rest_model->DeleteData('fd_gallery', array('id'=>$id));
        redirect(base_url().'Admin_panel/gallery', 'refresh'); 
    }
    public function category(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['cat'] = $this->Rest_model->SelectDataOrder('fd_category','*',array('siteID'=>$siteID), 'id','desc');
        $this->load->view('category', $data);
    }
    public function add_category(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->SaveData('fd_category', $data);
        redirect(base_url().'Admin_panel/category', 'refresh');
    }
    public function edit_category($id){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['c']= $this->Rest_model->SelectData_1('fd_category','*', array('id'=>$id, 'siteID'=>$siteID));
        $this->load->view('edit_category', $data);

    }
    public function update_category(){
        $id = $this->input->post('id');
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->UpdateData('fd_category', $data, array('id'=>$id));
        redirect(base_url().'Admin_panel/category', 'refresh');
    }
    public function delete_category($id){
        $this->Rest_model->DeleteData('fd_category',array('id'=>$id));
        redirect(base_url().'Admin_panel/category', 'refresh');     
    }
    public function item(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['cat'] = $this->Rest_model->SelectData('fd_category', '*',array('siteID'=>$siteID));
        $data['get_cat'] = $this->Admin_model->get_category();
        $this->load->view('item', $data);
    }
    public function add_item(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->SaveData('fd_item', $data);
        redirect(base_url().'Admin_panel/item', 'refresh');
    }
    public function edit_item($id){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $data['cat'] = $this->Rest_model->SelectData('fd_category', '*','');
        $data['i'] = $this->Rest_model->SelectData_1('fd_item','*',array('id'=>$id));
        $this->load->view('edit_item', $data);
    }
    public function update_item(){
        $id = $this->input->post('id');
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->UpdateData('fd_item', $data, array('id'=>$id));
        redirect(base_url().'Admin_panel/item', 'refresh'); 
    }
    public function delete_item($id){
        $this->Rest_model->DeleteData('fd_item', array('id'=>$id));
        redirect(base_url().'Admin_panel/item', 'refresh');
    }
    public function special_dishes(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['dish'] = $this->Rest_model->SelectDataOrder('fd_special_dishes', '*', array('siteID'=>$siteID),'id','desc');
        $this->load->view('special_dishes', $data);    
    }
    public function add_dish(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $config['upload_path'] = './uploads/dish/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100000000;
        $config['max_width'] = 10240000;
        $config['max_height'] = 7680000;
        $this->load->library('upload', $config);


        $this->load->library('image_lib');
        $config_1['image_library'] = 'gd2';
        $config_1['create_thumb'] = FALSE;
        $config_1['maintain_ratio'] = FALSE;
        $config_1['width']         = 100;
        $config_1['height']       = 100;

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data2 = array('upload_data' => $this->upload->data());
            $data['image'] = $data2['upload_data']['file_name'];
            $config_1['source_image'] = 'uploads/dish/'.$data2['upload_data']['file_name'];
            $this->image_lib->initialize($config_1); 
            $this->image_lib->resize();
        }
        $this->Rest_model->SaveData('fd_special_dishes', $data);
        redirect(base_url().'Admin_panel/special_dishes', 'refresh');    
    }
    public function delete_dish($id){
        $qq=$this->Rest_model->SelectData_1('fd_special_dishes','*',array('id'=>$id));
        unlink('uploads/dish/'.$qq->image);
        $this->Rest_model->DeleteData('fd_special_dishes', array('id'=>$id));
        redirect(base_url().'Admin_panel/special_dishes', 'refresh');
    }
    public function reservation(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['res'] = $this->Rest_model->SelectDataOrder('fd_reservation','*', array('siteID'=>$siteID),'id','desc');
        $this->load->view('reservation', $data);
    }
    public function delete_reservation($id){
        $this->Rest_model->DeleteData('fd_reservation',array('id'=>$id));
        redirect(base_url().'Admin_panel/reservation', 'refresh');    
    }
    public function team(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['team'] = $this->Rest_model->SelectDataOrder('fd_team','*', array('siteID'=>$siteID),'id','desc');
        $this->load->view('team', $data);  
    }
    public function add_team(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $config['upload_path'] = './uploads/teams/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100000000;
        $config['max_width'] = 10240000;
        $config['max_height'] = 7680000;
        $this->load->library('upload', $config);


        $this->load->library('image_lib');
        $config_1['image_library'] = 'gd2';
        $config_1['create_thumb'] = FALSE;
        $config_1['maintain_ratio'] = FALSE;
        $config_1['width']         = 370;
        $config_1['height']       = 500;

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data2 = array('upload_data' => $this->upload->data());
            $data['image'] = $data2['upload_data']['file_name'];
            $config_1['source_image'] = 'uploads/teams/'.$data2['upload_data']['file_name'];
            $this->image_lib->initialize($config_1); 
            $this->image_lib->resize();
        }
        $this->Rest_model->SaveData('fd_team', $data);
        redirect(base_url().'Admin_panel/team', 'refresh');   
    }
    public function edit_team($id){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $data['t'] = $this->Rest_model->SelectData_1('fd_team','*',array('id'=>$id));
        $this->load->view('edit_team', $data);  
    }
    public function update_team(){
        $id = $this->input->post('id');
        $data = $this->input->post();
        $siteID = $this->session->userdata('siteID');
        $config['upload_path'] = './uploads/teams/';
        $config['allowed_types'] = 'gif|jpg|png|mp4';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100000000;
        $config['max_width'] = 10240000;
        $config['max_height'] = 7680000;
        $this->load->library('upload', $config);


        $this->load->library('image_lib');
        $config_1['image_library'] = 'gd2';
        $config_1['create_thumb'] = FALSE;
        $config_1['maintain_ratio'] = FALSE;
        $config_1['width']         = 370;
        $config_1['height']       = 500;

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data2 = array('upload_data' => $this->upload->data());
            $data['image'] = $data2['upload_data']['file_name'];
            $config_1['source_image'] = 'uploads/teams/'.$data2['upload_data']['file_name'];
            $this->image_lib->initialize($config_1); 
            $this->image_lib->resize();
            $qq= $this->Rest_model->SelectData_1('fd_team', '*', array('id'=>$id, 'siteID'=>$siteID));
            unlink('uploads/teams/'. $qq->image);
        }
        $this->Rest_model->UpdateData('fd_team', $data, array('id'=>$id));
        redirect(base_url().'Admin_panel/team', 'refresh');
    }
    public function delete_team($id){
        $siteID = $this->session->userdata('siteID');
        $qq= $this->Rest_model->SelectData_1('fd_team', '*', array('id'=>$id, 'siteID'=>$siteID));
        unlink('uploads/teams/'. $qq->image);
        $this->Rest_model->DeleteData('fd_team',array('id'=>$id));
        redirect(base_url().'Admin_panel/team', 'refresh');
    }
    public function testimonial(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['testi'] = $this->Rest_model->SelectDataOrder('fd_testimonial','*',array('siteID'=>$siteID),'id','desc');
        $this->load->view('testimonial', $data);
    }
    public function add_testimonial(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $config['upload_path'] = './uploads/testimonial/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = 100000000;
        $config['max_width'] = 10240000;
        $config['max_height'] = 7680000;
        $this->load->library('upload', $config);


        $this->load->library('image_lib');
        $config_1['image_library'] = 'gd2';
        $config_1['create_thumb'] = FALSE;
        $config_1['maintain_ratio'] = FALSE;
        $config_1['width']         = 50;
        $config_1['height']       = 50;

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $data2 = array('upload_data' => $this->upload->data());
            $data['image'] = $data2['upload_data']['file_name'];
            $config_1['source_image'] = 'uploads/testimonial/'.$data2['upload_data']['file_name'];
            $this->image_lib->initialize($config_1); 
            $this->image_lib->resize();
        }
        $this->Rest_model->SaveData('fd_testimonial', $data);
        redirect(base_url().'Admin_panel/testimonial', 'refresh');
    }
    public function delete_testimonial($id){
        $siteID = $this->session->userdata('siteID');
        $qq= $this->Rest_model->SelectData_1('fd_testimonial', '*', array('id'=>$id, 'siteID'=>$siteID));
        unlink('uploads/testimonial/'. $qq->image);
        $this->Rest_model->DeleteData('fd_testimonial',array('id'=>$id));
        redirect(base_url().'Admin_panel/testimonial', 'refresh'); 
    }
    public function contact(){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $siteID = $this->session->userdata('siteID');
        $data['cont'] = $this->Rest_model->SelectDataOrder('fd_contact','*',array('siteID'=>$siteID),'id','desc');
        $this->load->view('contact', $data);  
    }
    public function add_contact(){
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->SaveData('fd_contact', $data);
        redirect(base_url().'Admin_panel/contact', 'refresh');
    }
    public function edit_contact($id){
        $session['menu']='home';
        $this->session->set_userdata($session);
        $data['c'] = $this->Rest_model->SelectData_1('fd_contact', '*', array('id'=>$id));
        $this->load->view('edit_contact', $data);
    }
    public function update_contact(){
        $id = $this->input->post('id');
        $data = $this->input->post();
        $data['siteID'] = $this->session->userdata('siteID');
        $this->Rest_model->UpdateData('fd_contact', $data, array('id'=>$id));
        redirect(base_url().'Admin_panel/contact', 'refresh');
    }
    public function delete_contact($id){
        $this->Rest_model->DeleteData('fd_contact', array('id'=>$id));
        redirect(base_url().'Admin_panel/contact', 'refresh');
    }
    public function head(){
        $siteID = $this->session->userdata('siteID');
        $data['c'] = $this->Admin_model->count_msg();
        $this->load->view('head', $data);
    }
}