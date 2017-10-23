<?php

class MCustomer extends CI_Model {

    function lookup($keyword) {
        $this->db->select('*')->from('customer_v');
        $this->db->like('customer', $keyword, 'after');
        //$this->db->or_like('iso', $keyword, 'after');
        $query = $this->db->get();
        return $query->result();
    }
    
    

    function get_AllCustomers() {
        $this->db->select('*')->from('customer_v');
        //$this->db->or_like('iso', $keyword, 'after');
        $query = $this->db->get();
        return $query->result();
        
    }
}
