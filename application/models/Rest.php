<?php
/**
* 
*/
class Rest extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
	}
	public function SelectData($table, $data, $where) {
		if ($where) {
			$this->db->where($where);
		}
		$this->db->select($data);
		$this->db->from($table);
		return $this->db->get()->result();
	}

	public function SelectData_1($table, $data, $where) {
		if ($where) {
			$this->db->where($where);
		}
		$this->db->select($data);
		$this->db->from($table);
		return $this->db->get()->row();
	}

	public function SaveData($table, $data) {
		if ($this->db->insert($table, $data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function DeleteData($table, $where) {
		if ($where) {
			$this->db->where($where);
		}
		if ($this->db->delete($table)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function UpdateData($table, $data, $where) {
		$this->db->where($where);
		if ($this->db->update($table, $data)) {
			return TRUE;
		} else
		return FALSE;
	}

}
?>