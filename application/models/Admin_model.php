<?php
/**
* 
*/
class Admin_model extends CI_Model
{
	
	function __construct() {
        parent::__construct();
    }
    
    public function get_category_name(){
    	$query=$this->db->query('SELECT para_gallery.id as id,para_gallery.image as image,para_category.name FROM `para_category` JOIN para_gallery ON para_gallery.catID=para_category.id ORDER BY para_gallery.id DESC');
    	return $query->result();
    }
    public function get_department_name(){
    	$query = $this->db->query('SELECT md_gallery.id , md_gallery.image , md_department.dept_name 
           FROM md_department JOIN md_gallery ON md_gallery.deptID = md_department.id 
           ORDER BY md_gallery.id DESC');
    	return $query->result();
    }
    public function get_icon(){
        $query = $this->db->query('SELECT md_service.* , md_icon.icon_name, md_icon.icon 
            FROM md_service LEFT JOIN md_icon ON md_service.iconID = md_icon.id 
            ORDER BY md_service.id ASC');
        return $query->result();
    }
    public function get_department_name_1(){
        $query = $this->db->query('SELECT md_gallery.id , md_gallery.image , md_department.dept_name 
            FROM md_department JOIN md_gallery ON md_gallery.deptID = md_department.id 
            ORDER BY md_gallery.id DESC LIMIT 4');
        return $query->result();
    }
    public function get_appointment(){

        $query = $this->db->query('SELECT md_appointment.* , md_department.dept_name, md_hospital.hos_name,md_doctor.doc_name
            FROM md_appointment LEFT JOIN md_department ON md_appointment.dpt_id=md_department.id LEFT JOIN md_hospital ON md_appointment.hospitalID=md_hospital.id LEFT JOIN md_doctor ON md_appointment.drID=md_doctor.id
            ORDER BY md_appointment.id ASC');
        return $query->result();
    }
    public function get_doctor(){

        $query = $this->db->query('SELECT md_doctor.* , md_department.dept_name
            FROM md_doctor LEFT JOIN md_department ON md_doctor.deptID=md_department.id
            ORDER BY md_doctor.id DESC');
        return $query->result();
    }
    public function get_doctor_ch(){
        $this->db->select('md_dr_chamber.id as ch_id,md_dr_chamber.time,md_dr_chamber.day, md_doctor.*,md_hospital.*,md_department.*');
        $this->db->from('md_dr_chamber'); 
        $this->db->join('md_doctor', 'md_dr_chamber.drID=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dr_chamber.hospitalID=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dr_chamber.dpt_id=md_department.id', 'left');
        $this->db->order_by('md_dr_chamber.id','asc');         
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_hospital(){
        $this->db->select('md_test_cost.*, md_hospital.hos_name');
        $this->db->from('md_test_cost');
        $this->db->join('md_hospital', 'md_test_cost.hospitalID=md_hospital.id', 'left');
        $query =$this->db->get();
        return $query->result();
    }
    public function get_hospital_1($id){
        $this->db->select('md_test_cost.*, md_hospital.hos_name');
        $this->db->from('md_test_cost');
        $this->db->join('md_hospital', 'md_test_cost.hospitalID=md_hospital.id', 'left');
        $this->db->where('md_test_cost.id',$id);
        $query =$this->db->get();
        return $query->row();
    }
    public function get_dpt($id){
        $this->db->select('md_department.*,md_dpt_allocation.dpt_id');
        $this->db->from('md_dpt_allocation');
        $this->db->join('md_department', 'md_department.id=md_dpt_allocation.dpt_id', 'left');
        $this->db->where('md_dpt_allocation.hos_id',$id);
        $this->db->group_by('md_dpt_allocation.dpt_id');
        $query =$this->db->get();
        return $query->result();
    }
    public function get_doc($id){
        $this->db->select('md_department.*');
        $this->db->from('md_doctor');
        $this->db->join('md_department', 'md_department.id=md_doctor.deptID', 'left');
        $this->db->where('md_doctor.id',$id);
        $query =$this->db->get();
        return $query->result();
    }
    public function get_chamber_1($id){
        $this->db->select('md_dr_chamber.*, md_hospital.hos_name, md_department.dept_name, md_doctor.doc_name');
        $this->db->from('md_dr_chamber');
        $this->db->join('md_hospital', 'md_dr_chamber.hospitalID=md_hospital.id');
        $this->db->join('md_doctor', 'md_dr_chamber.drID=md_doctor.id');
        $this->db->join('md_department', 'md_dr_chamber.dpt_id=md_department.id');
        $this->db->where('md_dr_chamber.id',$id);
        $query =$this->db->get();
        return $query->row();
    }
    public function get_dept_doc(){
        $this->db->select('md_dpt_allocation.id as d_id,md_dpt_allocation.*, md_doctor.*,md_hospital.*,md_department.*');
        $this->db->from('md_dpt_allocation'); 
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dpt_allocation.dpt_id=md_department.id', 'left');
        $this->db->order_by('md_dpt_allocation.id','asc');         
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_dept_doc_1($id){
        $this->db->select('md_dpt_allocation.id as d_id,md_dpt_allocation.*, md_doctor.*,md_hospital.*,md_department.*');
        $this->db->from('md_dpt_allocation'); 
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dpt_allocation.dpt_id=md_department.id', 'left');
        $this->db->where('md_dpt_allocation.id', $id);         
        $query = $this->db->get ();
        return $query->row ();
    }
    public function get_dept_doc_2($id){
        $this->db->select('md_dpt_allocation.id as d_id,md_dpt_allocation.*, md_doctor.*,md_hospital.*,md_department.*');
        $this->db->from('md_dpt_allocation'); 
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dpt_allocation.dpt_id=md_department.id', 'left');
        $this->db->where('md_dpt_allocation.id', $id);         
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_dpt_2($id){
        $query = $this->db->query('SELECT md_department.dept_name FROM md_dpt_allocation LEFT JOIN md_department ON md_dpt_allocation.dpt_id=md_department.id LEFT JOIN md_hospital ON md_dpt_allocation.hos_id=md_hospital.id WHERE md_dpt_allocation.hos_id = $id GROUP BY md_department.dept_name;');
        return $query->result();
    }
    public function get_dept_doc_3($id){
        $this->db->select('*');
        $this->db->from('md_dpt_allocation');
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dpt_allocation.dpt_id=md_department.id', 'left');
        $this->db->where('md_hospital.id', $id);
        $this->db->group_by('md_department.dept_name');         
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_dept_doc_4($id){
        $this->db->select('md_doctor.*,md_department.*');
        $this->db->from('md_dpt_allocation'); 
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left');
        $this->db->join('md_department', 'md_dpt_allocation.dpt_id=md_department.id', 'left');
        $this->db->where('md_hospital.id', $id);
        $this->db->group_by('md_department.dept_name');        
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_dr_dpt($dpt,$hos){
        $this->db->select('*');
        $this->db->from('md_dpt_allocation'); 
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->where('md_dpt_allocation.hos_id', $hos);
        $this->db->where('md_dpt_allocation.dpt_id', $dpt);
        $query = $this->db->get ();
        return $query->result ();
    }
    public function get_dr_dpt_1($dpt){
        $this->db->select('*');
        $this->db->from('md_department'); 
        $this->db->where('md_department.id', $dpt);
        $query = $this->db->get ();
        return $query->row ();
    }
    public function get_campaign(){
        $this->db->select('md_campaign.*, md_hospital.hos_name');
        $this->db->from('md_campaign'); 
        $this->db->join('md_hospital', 'md_campaign.hospitalID=md_hospital.id', 'left');
        $this->db->order_by('md_campaign.id', 'desc');
        $query = $this->db->get ();
        return $query->result ();

    }
    
    public function get_campaign_1($id){
        $query = $this->db->query('SELECT md_campaign.*, md_hospital.hos_name FROM md_hospital LEFT JOIN md_campaign ON md_campaign.hospitalID=md_hospital.id WHERE md_campaign.hospitalID = id;');
        return $query->result();
    }
    public function get_campaign_t($id){ 
        $this->db->select('md_campaign.*, md_hospital.hos_name');
        $this->db->from('md_campaign');
        $this->db->join('md_hospital', 'md_campaign.hospitalID=md_hospital.id', 'left');
        $this->db->where('hospitalID', $id);
        $this->db->order_by('md_campaign.id','desc');
        $query = $this->db->get (); 
        return $query->result ();

    }
    public function get_dr_dpt_2($id){
        $this->db->select('md_doctor.photo as doc_image, md_doctor.*, md_hospital.*');
        $this->db->from('md_dpt_allocation');
        $this->db->join('md_doctor', 'md_dpt_allocation.dr_id=md_doctor.id', 'left');
        $this->db->join('md_hospital', 'md_dpt_allocation.hos_id=md_hospital.id', 'left'); 
        $this->db->where('md_hospital.id', $id);
        $query = $this->db->get ();
        return $query->result ();
    }
    
}