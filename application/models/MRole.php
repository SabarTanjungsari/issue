<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MRole extends CI_Model {

    var $table = 'role';

    public function __construct() {
        parent::__construct();
    }

    public function get_all_role() {
        $this->db->select('role_id, name')
                ->from('role');
        $query = $this->db->get();
        return $query;
    }

}
