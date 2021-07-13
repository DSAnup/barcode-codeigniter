<?php
/**
* 
*/
class Dashboard_model extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function get_head_code(){
		$query=$this->db->get('account_head_main');
		return $query->result();
	}
	public function get_total($main_id){
		$q=$this->db->get('current_budget_year');
		$year=$q->row();
		$year_id=$year->budget_year_id;
		$this->db->select_sum('expense_amount');
		$this->db->where('account_main_head_id',$main_id);
		$this->db->where('budget_year_id',$year_id);
		$query=$this->db->get('general_expense');
		return $query->row();
	}
	public function get_total_budget($main_id){
		$q=$this->db->get('current_budget_year');
		$year=$q->row();
		$year_id=$year->budget_year_id;
		$this->db->select_sum('distributed_amount');
		$this->db->where('account_main_head_id',$main_id);
		$this->db->where('budget_year_id',$year_id);
		$query=$this->db->get('budget_distribution');
		return $query->row();
	}
	public function get_total_budget_monthly($main_id,$month){
		$q=$this->db->get('current_budget_year');
		$year=$q->row();
		$year_id=$year->budget_year_id;
		$this->db->select_sum('expense_amount');
		$this->db->where('account_main_head_id',$main_id);
		$this->db->where('budget_year_id',$year_id);
		$this->db->like('date', "$month", 'after'); 
		$query=$this->db->get('general_expense');
		return $query->row();
	}
	public function get_notification_num(){
		// $this->db->where('viewd','no');
		// $query=$this->db->count_all('notification');
		$this->db->select('*');
		$this->db->from('notification');
		$this->db->join('account_head_sub','account_head_sub.sub_head_id=notification.sub_head');
		$this->db->where('viewd','no');
		$query=$this->db->get();
		return count($query->result());
	}
	public function get_notified(){
		$this->db->select('*');
		$this->db->from('notification');
		$this->db->join('account_head_sub','account_head_sub.sub_head_id=notification.sub_head');
		$this->db->where('viewd','no');
		$query=$this->db->get();
		return $query->result();
	}
	public function clead_notification($data){
		$this->db->query("UPDATE notification SET viewd='yes'");
	}
	public function get_category($id){
		$this->db->where('category_type',$id);
		$query=$this->db->get('job_category');
		return $query->result();
	}
	public function get_jobs($limit,$id){
		$this->db->limit($limit);
		$this->db->where('job_category',$id);
		$query=$this->db->get('job');
		return $query->result();
	}
	public function record_count($id){
		$this->db->like('job_category', $id, 'both'); 
		$query=$this->db->get("job");
		return $query->num_rows();
	}
	public function get_all_jobs($limit, $start,$id) {
        $sql = "select * from job where job_category like '%".$id."%' order by job_id desc limit  ".$start." ,  ".$limit;
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_details($id){
    	$this->db->select('*');
    	$this->db->from('job');
    	$this->db->join('job_location','job_location.location_id=job.job_location');
    	$this->db->where('job_id',$id);
		$query=$this->db->get();
		return $query->row();
    }
    public function increment_visited($id){
    	$sql="UPDATE job SET visited = visited + 1 WHERE job_id=$id";
    	$this->db->query($sql);
    }
    public function get_details_photo($id){
    	$this->db->select('*');
    	$this->db->from('job');
    	$this->db->where('job_id',$id);
		$query=$this->db->get();
		return $query->row();
    }
    public function get_job_number($c_id){
    	$this->db->like('job_category', $c_id, 'both'); 
    	$query=$this->db->get('job');
    	$rows=$query->result();
    	return $query->num_rows();
    }
    public function get_govt_job($start,$end){
    	$query=$this->db->query("select * from job where job_category like '%69%' order by job_id desc limit $start,$end");
    	return $query->result();
    }
    public function get_related($category,$id,$start){
    	$query=$this->db->query("SELECT * FROM `job` as j join job_location as l on j.job_location=l.location_id WHERE `job_id`!=$id AND job_category=$category order by job_id desc LIMIT $start, 3");
    	return $query->result();
    }
    public function get_related_1($category,$id,$start){
    	$query=$this->db->query("SELECT * FROM `job` as j WHERE `job_id`!=$id AND job_category like '%".$category."%' order by job_id desc LIMIT ".$start.", 3");
    	return $query->result();
    }
    public function get_todays_topics($category){
    	$this->db->where('category',$category);
    	$this->db->order_by("id", "desc"); 
    	$this->db->limit(1);
    	$query=$this->db->get('todays_topics');
    	return $query->row();
    }
    public function get_related_blog($category){
    	$this->db->where('category',$category);
    	$this->db->limit(3);
    	$query=$this->db->get('todays_topics');
    	return $query->result();
    }
    public function get_latest_blog(){
    	$this->db->limit(8);
    	    	$this->db->order_by('id','desc');
    	$query=$this->db->get('todays_topics');
    	return $query->result();
    }
    public function get_blogs($category){
    	$this->db->where('category',$category);
    	$this->db->order_by("id", "desc"); 
    	$query=$this->db->get('todays_topics');
    	return $query->result();
    }
    public function get_top_employer(){
    	$this->db->order_by('id','desc');
        $query=$this->db->get('top_employer');
        return $query->result();
    }
}
?>