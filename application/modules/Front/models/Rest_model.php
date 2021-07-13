<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rest_model extends CI_Model {

    function __construct() {
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
    public function SelectDataOrder($table, $data, $where,$by,$type) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->select($data);
        $this->db->from($table);
        $this->db->order_by($by,$type);
        return $this->db->get()->result();
    }
    public function SelectDataOrder_1($table, $data, $where,$by,$type,$limit) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->select($data);
        $this->db->from($table);
        $this->db->order_by($by,$type);
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function SaveData($table, $data) {
        if ($this->db->insert($table, $data))
            return TRUE;

        return FALSE;
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
