<?php
class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function register($data){
        $this->db->insert('admin',$data);
    }
    public function login($email,$password){
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query=$this->db->get('admin');
        return $query->row();
    }
    public function get_icon_welcome(){
        $this->db->select('welcome_area.*,  icon.name, icon.icon_code');
        $this->db->from('welcome_area');
        $this->db->join('icon', 'welcome_area.iconId = icon.id','left');
        $this->db->order_by('welcome_area.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_icon_ab_service(){
        $this->db->select('about_service.*,  icon.name, icon.icon_code');
        $this->db->from('about_service');
        $this->db->join('icon', 'about_service.iconId = icon.id','left');
        $this->db->order_by('about_service.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_market_chart(){
        $this->db->select('market_chart.*,  market_f_analysis.title, market_f_analysis.description, market_f_analysis.date');
        $this->db->from('market_chart');
        $this->db->join('market_f_analysis', 'market_f_analysis.id = market_chart.marId','left');
        $this->db->order_by('market_chart.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_chart_image(){
        $this->db->select('chart_image.*,  chart_analysis.title, chart_analysis.description, chart_analysis.date');
        $this->db->from('chart_image');
        $this->db->join('chart_analysis', 'chart_analysis.id = chart_image.chatId','left');
        $this->db->order_by('chart_image.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function read_msg($id){
        $status = 1;
        $this->db->set('status', $status, FALSE);
        $this->db->where('id', $id);
        $this->db->update('message');
    }
    public function get_person_name(){
        $query = $this->db->query("SELECT attendance.*, person.name FROM attendance LEFT JOIN person ON attendance.personID = person.id");
        return $query;
    }
    public function get_category(){
        $this->db->select('fd_item.*, fd_item.id as id, fd_category.name');
        $this->db->from('fd_item');
        $this->db->join('fd_category', 'fd_item.catID = fd_category.id','left');
        $query = $this->db->get();
        return $query->result();
    }
    public function count_msg(){
        $this->db->from('fd_msg');
        // $this->db->where('fd_msg.siteID', $siteID)
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_country(){
        $this->db->select('member.*,member.id as id, price.package_name, price.amount,  country.name as cname');
        $this->db->from('member');
        $this->db->join('country', 'country.id = member.countryId','left');
        $this->db->join('price', 'price.id = member.packageId','left');
        $this->db->order_by('member.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_country_1($id){
        $this->db->select('member.*,  country.name as cname');
        $this->db->from('member');
        $this->db->join('country', 'country.id = member.countryId','left');
        $this->db->where('member.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function member_status_up($id){
        $status = 1;
        $this->db->set('status', $status, FALSE);
        $this->db->where('id', $id);
        $this->db->update('member');
    }
    public function member_status_ac($id){
        $status = 0;
        $this->db->set('status', $status, FALSE);
        $this->db->where('id', $id);
        $this->db->update('member');
    }
    public function member_package($id){
        $packageId = 0;
        $this->db->set('packageId', $packageId, FALSE);
        $this->db->where('id', $id);
        $this->db->update('member');
    }
    
}
?>