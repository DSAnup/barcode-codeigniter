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
        $this->db->limit('4');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_icon_ab_service(){
        $this->db->select('about_service.*,about_service.name as s_name,  icon.name, icon.icon_code');
        $this->db->from('about_service');
        $this->db->join('icon', 'about_service.iconId = icon.id','left');
        $this->db->order_by('about_service.id','desc');
        $this->db->limit('4');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_market_chart($id){
        $this->db->select('chart_image.*,  chart_analysis.title, chart_analysis.description, chart_analysis.date');
        $this->db->from('chart_image');
        $this->db->join('chart_analysis', 'chart_analysis.id = chart_image.chatId','left');
        $this->db->where('chart_analysis.id',$id);
        $this->db->order_by('chart_image.id','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_chart_image($id){
        $this->db->select('market_chart.*,  market_f_analysis.title, market_f_analysis.description, market_f_analysis.date');
        $this->db->from('market_chart');
        $this->db->join('market_f_analysis', 'market_f_analysis.id = market_chart.marId','left');
        $this->db->where('market_f_analysis.id',$id);
        $this->db->order_by('market_chart.id','desc');
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
    public function selectmember($email, $pass){

                $this->db->select('*');    
                $this->db->from('member');
                $this->db->where('member.email',$email);
                $this->db->where('member.password',$pass);
                $this->db->where('member.status',0);
                $this->db->where('member.packageId != ',0,FALSE);
                $query = $this->db->get()->row();
                return $query;
    }
    public function get_all_me_d($id){
        $this->db->select('member.*,member.id as id, price.package_name, price.amount,  country.name as cname');
        $this->db->from('member');
        $this->db->join('country', 'country.id = member.countryId','left');
        $this->db->join('price', 'price.id = member.packageId','left');
        $this->db->where('member.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function cou_live_s(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('live_s_signal');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function cou_last_c(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('last_c_trade');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function cou_month(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('monthly_pips');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function p_cou_live_s(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('p_live_s_signal');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function p_cou_last_c(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('p_last_c_trade');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    public function p_cou_month(){
        $date = date('Y-m-d');
        $this->db->select('*'); 
        $this->db->from('p_monthly_pips');
        $this->db->like('date', $date);
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>