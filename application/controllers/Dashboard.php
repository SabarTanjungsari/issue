<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role_id') != '1') {
            redirect('Login');
        }
        $this->load->model('MUser');
        $this->load->model('MTicket');
    }

    public function index() {
        $data['usercount'] = $this->MUser->get_count_user();
        $data['ticketcount'] = $this->MTicket->ticket();
        
        $this->load->view('/admin/header');
        $this->load->view('/admin/topnav');
        $this->load->view('/admin/leftnav');
        $this->load->view('/admin/dashboard', $data);
        $this->load->view('/admin/footer');
    }

}
