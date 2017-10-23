<?php

if (!defined('BASEPATH'))
    exit('no direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role_id') == '') {
            redirect('Login');
        }

        $this->load->model('MUser');
        $this->load->model('MRole');
    }

    public function index() {
        $data['users'] = $this->MUser->get_all_user();
        $data['roles'] = $this->MRole->get_all_role();
        $this->load->view('/admin/header');
        $this->load->view('/admin/topnav');
        $this->load->view('/admin/leftnav');
        $this->load->view('/admin/user_v', $data);
        $this->load->view('/admin/footer');
    }

    public function ajax_reset($user_id) {
        $data = $this->M_users->get_user_by_id($user_id);
        echo json_encode($data);
    }

    public function reset_password() {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            //'email' => $this->input->post('email'),
            'lastupdated' => $now
        );

        $this->M_users->reset_password(array('user_id' => $this->input->post('user_id')), $data);
        echo json_encode(array('status' => TRUE));
    }

    public function add_user() {

        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'role_id' => $this->input->post('role_id'),
            'createdby' => $this->session->userdata('user_id'),
            'created' => $now,
            'lastupdated' => $now
        );

        $insert = $this->MUser->add_user($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_user() {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'email' => $this->input->post('email'),
            'role_id' => $this->input->post('role_id'),
            'lastupdated' => $now
        );

        $this->MUser->user_update(array('user_id' => $this->input->post('user_id')), $data);
        echo json_encode(array('status' => TRUE));
    }

    public function get_all_user() {
        $query = $this->MUser->get_all_user();
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_edit($user_id) {
        $data = $this->MUser->get_user_by_id($user_id);
        echo json_encode($data);
    }

    public function user_delete($user_id) {
        $this->MUser->delete_by_id($user_id);
        echo json_encode(array("status" => TRUE));
    }

}
