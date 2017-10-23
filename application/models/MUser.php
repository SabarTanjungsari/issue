<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MUser extends CI_Model {

    var $table = 'user';

    public function __construct() {
        parent::__construct();
    }

    public function check_cridential() {
        $username = set_value('username');
        $password = set_value('password');

        $result = $this->db->where('username', $username)
                ->where('password', $password)
                ->limit(1)
                ->get('user');

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return array();
        }
    }

    /*public function get_user_by_id($user_id) {
        $this->db->from($this->table)
                ->where('user_id', $user_id);
        $query = $this->db->get();

        return $query->row();
    }*/

    public function reset($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_count_user() {
        $query = $this->db->query("SELECT COUNT(*) as count_rows FROM $this->table");
        return $query->row_array();
    }

    public function get_all_user() {
        $this->db->select('usr.user_id, usr.username, usr.password, usr.email, rl.role_id, rl.name AS role')
                ->from('user AS usr')
                ->join('role AS rl', 'rl.role_id = usr.role_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function add_user($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function user_update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
        
    public function get_user_by_id($id) {
        $this->db->select('usr.user_id, usr.username, usr.password, usr.email, rl.role_id, rl.name AS role')
                ->from('user AS usr')
                ->join('role AS rl', 'rl.role_id = usr.role_id')
                ->where('user_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function delete_by_id($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->delete($this->table);
    }
}
