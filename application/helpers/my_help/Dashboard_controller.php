<?php

class Dashboard extends CI_Controller{
	function __construct() {
		parent::__construct();
		$this->load->model('Dashboard_model');
		$this->load->library('pagination');
	}
	public function index(){
		$data['category_1']=$this->Dashboard_model->get_category(1);
    $data['category_2']=$this->Dashboard_model->get_category(2);
    $data['govt_1']=$this->Dashboard_model->get_govt_job(0,5);
    $data['govt_2']=$this->Dashboard_model->get_govt_job(6,5);
    $data['govt_3']=$this->Dashboard_model->get_govt_job(12,5);
    $data['edu']=$this->Dashboard_model->get_todays_topics('Education & Training');
    $data['tools']=$this->Dashboard_model->get_todays_topics('Career Tools');
    $data['tvet']=$this->Dashboard_model->get_todays_topics('TVET');
    $data['skill']=$this->Dashboard_model->get_todays_topics('Skills Competition');
    $data['sch']=$this->Dashboard_model->get_todays_topics('Scholarship');
    $data['topm']=$this->Dashboard_model->get_top_employer();
    $this->load->view('index',$data);
  }
  public function job($id){
    $session['category']=$id;
    $this->session->set_userdata($session);
    redirect(base_url().'Dashboard/jobs/');
  }
  public function jobs(){
    $id=$this->session->userdata('category');
    $this->load->helper('url');
    $this->load->database();
    $this->load->library('pagination');

    $config['base_url'] = site_url('Dashboard/jobs');
    $config['total_rows'] = $this->Dashboard_model->record_count($id);
    $config['per_page'] = "6";
    $config["uri_segment"] = 3;
    $choice = $config["total_rows"] / $config["per_page"];
    $config["num_links"] = floor($choice);

    $config['full_tag_open'] = '<ul class="pagination uk-pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = false;
    $config['last_link'] = false;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);
    $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $data['jobs'] = $this->Dashboard_model->get_all_jobs($config["per_page"], $data['page'],$id);

    $data['pagination'] = $this->pagination->create_links();
    $this->load->view('jobs', $data);
  }
  public function details($ids){
    $ddd=explode('_', $ids);
    $id=$ddd[0];
    $d=$this->Dashboard_model->get_details_photo($id);
    $this->Dashboard_model->increment_visited($id);
    if ($d->job_location==0) {
        redirect(base_url().'Dashboard/jobdetails_photo/'.$ids);
    }else{
       $data['details']=$this->Dashboard_model->get_details($id);
    $category= $ddd[1];
    $data['category']=$category;
    $photo= $data['details']->photo;
    
    $data['related_1']=$this->Dashboard_model->get_related($category,$id,0);
    $data['related_2']=$this->Dashboard_model->get_related($category,$id,3);
    $data['related_3']=$this->Dashboard_model->get_related($category,$id,6);
      $this->load->view('jobdetails', $data);
    }
  }
  public function jobdetails_photo($ids){
    $ddd=explode('_', $ids);
    $id=$ddd[0];
    $data['details']=$this->Dashboard_model->get_details_photo($id);
    $category= $ddd[1];
    $photo= $data['details']->photo;
    $data['category']=$category;
    $data['related_1']=$this->Dashboard_model->get_related_1($category,$id,0);
    $data['related_2']=$this->Dashboard_model->get_related_1($category,$id,3);
    $data['related_3']=$this->Dashboard_model->get_related_1($category,$id,6);
    
      // $data['details']=$this->Dashboard_model->get_details_photo($id);
      $this->load->view('jobdetails_photo', $data);
    // echo "SELECT * FROM `job` as j WHERE `job_id`!=$id AND job_category like '%".$category."%' order by job_id desc LIMIT 0, 3";
  }
  public function view_blog($id){
    $where=array('id'=>$id);
    $data['news']=$this->Rest->SelectData_1('todays_topics','*',$where);
    $category= $data['news']->category;
    $view= $data['news']->view;
    $data['related']=$this->Dashboard_model->get_related_blog($category);
    $data['latest']=$this->Dashboard_model->get_latest_blog();
    $dd['view']=$view+1;
    $this->Rest->UpdateData('todays_topics',$dd,$where);
    $this->load->view('blogs',$data);
  }
  public function blogs($category){
    switch ($category) {
      case 'e':
      $cat='Education & Training';
      break;
      case 'c':
      $cat='Career Tools';
      break;
      case 's':
      $cat='Skills Competition';
      break;
      case 't':
      $cat='TVET';
      break;
      case 'sc':
      $cat='Scholarship';
      break;
    }
    $data['cat']=$cat;
    $data['related']=$this->Dashboard_model->get_blogs($cat);
    $data['latest']=$this->Dashboard_model->get_latest_blog();
    $this->load->view('news',$data);
    // var_dump($cat);
  }
  public function about(){
    $data['latest']=$this->Dashboard_model->get_latest_blog();
    $this->load->view('about',$data);
  }
  public function signup(){
  	$this->load->view('registation');
  }
}
