<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MTicket extends CI_Model {

    var $table = 'ticket';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_tickets() {
        $this->db->select('*, usr.username AS marketing')
                ->from('ticket AS tc')
                ->join('user AS usr', 'usr.user_id = tc.createdby');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_tickets_by_user($user_id) {
        $query = $this->db->where('createdby', $user_id)
                ->get('ticket');
        return $query->result();
    }

    public function get_ticket_by_id($id) {
        $this->db->from($this->table)
                ->where('ticket_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function ticket_add($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function ticket_update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($ticket_id) {
        $this->db->where('ticket_id', $ticket_id);
        $this->db->delete($this->table);
    }

    public function ticket() {
        $query = $this->db->query("SELECT COUNT(*) as count_rows FROM $this->table");
        return $query->row_array();
    }

}
