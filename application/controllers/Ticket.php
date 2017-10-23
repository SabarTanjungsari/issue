<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role_id') == '') {
            redirect('Login');
        }
        $this->load->model('MTicket');
        $this->load->model("MUser");
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['tickets'] = $this->MTicket->get_tickets_by_user($user_id);
        $data['users'] = $this->MUser->get_all_user();
        $this->load->view('layout/header');
        $this->load->view('layout/top_nav');
        $this->load->view('ticket_v', $data);
        $this->load->view('layout/footer');
    }
    
    public function all_ticket() {
        $user_id = $this->session->userdata('user_id');
        $data['tickets'] = $this->MTicket->get_all_tickets();
        $this->load->view('layout/header');
        $this->load->view('layout/top_nav');
        $this->load->view('admin/ticket_v', $data);
        $this->load->view('layout/footer');
    }

    public function add_ticket() {

        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $follow = $this->input->post('isfollow');
        if ($follow == FALSE) {
            $follow = '0';
        } else {
            $follow = '1';
        }

        $data = array(
            'dateticket' => $this->input->post('dateticket'),
            'customer' => $this->input->post('customer'),
            'pic' => $this->input->post('pic'),
            'location' => $this->input->post('location'),
            'description' => $this->input->post('description'),
            'isfollow' => $follow,
            'note' => $this->input->post('note'),
            'datefollow' => $this->input->post('datefollow'),
            'createdby' => $this->session->userdata('user_id'),
            'created' => $now,
            'lastupdated' => $now
        );

        $insert = $this->MTicket->ticket_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($ticket_id) {
        $data = $this->MTicket->get_ticket_by_id($ticket_id);
        echo json_encode($data);
    }

    public function update_ticket() {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $follow = $this->input->post('isfollow');
        if ($follow == FALSE) {
            $follow = '0';
        } else {
            $follow = '1';
        }

        $data = array(
            'dateticket' => $this->input->post('dateticket'),
            'customer' => $this->input->post('customer'),
            'pic' => $this->input->post('pic'),
            'location' => $this->input->post('location'),
            'description' => $this->input->post('description'),
            'attachment' => $this->input->post('attachment'),
            'isfollow' => $follow,
            'note' => $this->input->post('note'),
            'datefollow' => $this->input->post('datefollow'),
            'lastupdated' => $now
        );

        $this->MTicket->ticket_update(array('ticket_id' => $this->input->post('ticket_id')), $data);
        echo json_encode(array('status' => TRUE));
    }

    public function ticket_delete($ticket_id) {
        $this->MTicket->delete_by_id($ticket_id);
        echo json_encode(array("status" => TRUE));
    }

    public function get_AllCustomer() {
        $this->MCustomer->get_AllCustomers();
        echo json_encode(array("status" => TRUE));
    }

}
