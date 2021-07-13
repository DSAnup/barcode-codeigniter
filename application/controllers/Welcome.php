<?php
require APPPATH . 'libraries/REST_Controller.php';
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
	public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Rest_model');
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}

	 public function get()
    {
        $data = $this->db->get("barcode_info")->result();
        echo json_encode($data);
    }

    public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where("items", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("items")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('items',$input);
     	// echo "success";
     	// var_dump($input);
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 

    public function index_get_single($id)
    {
        $data = $this->Rest_model->SelectData_1('items','', array('id'=>$id));
        echo json_encode($data);
        // $this->response($data, REST_Controller::HTTP_OK);
    }
}
