<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role_id') == '') {
            redirect('Login');
        }
        $this->load->model('MRole');
    }

    public function index() {
        //$user_id = $this->session->userdata('user_id');
        //$data['roles'] = $this->MRole->get_roles_by_user($user_id);
        //$data['customers'] = $this->MCustomer->get_AllCustomers();
        ///$this->load->view('layout/header');
        //$this->load->view('layout/top_nav');
        //$this->load->view('role_v', $data);
        //$this->load->view('layout/footer');
    }

    public function add_role() {

        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $follow = $this->input->post('isfollow');
        if ($follow == FALSE) {
            $follow = '0';
        } else {
            $follow = '1';
        }

        $data = array(
            'daterole' => $this->input->post('daterole'),
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

        $insert = $this->MRole->role_add($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_get_role() {
        $data = $this->MRole->get_all_role();
        echo json_encode($data);
    }

    public function update_role() {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $follow = $this->input->post('isfollow');
        if ($follow == FALSE) {
            $follow = '0';
        } else {
            $follow = '1';
        }

        $data = array(
            'daterole' => $this->input->post('daterole'),
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

        $this->MRole->role_update(array('role_id' => $this->input->post('role_id')), $data);
        echo json_encode(array('status' => TRUE));
    }

    public function role_delete($role_id) {
        $this->MRole->delete_by_id($role_id);
        echo json_encode(array("status" => TRUE));
    }

    public function get_AllCustomer() {
        $this->MCustomer->get_AllCustomers();
        echo json_encode(array("status" => TRUE));
    }

}
