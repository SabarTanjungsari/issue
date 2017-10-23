<?php

if (!defined('BASEPATH'))
    exit('no direct script access allowed');

class ResetPassword extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MUser');
    }

    public function index() {
    }

    public function reset_view() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->MUser->get_user_by_id($user_id);
        $this->load->view('layout/header');
        $this->load->view('layout/top_nav');
        $this->load->view('resetpassword_v', $data);
        $this->load->view('layout/footer');
    }
    public function ajax_reset($user_id) {
        $data = $this->MUser->get_user_by_id($user_id);
        echo json_encode($data);
    }

    public function reset() {
        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            //'email' => $this->input->post('email'),
            'lastupdated' => $now
        );

        $this->MUser->reset(array('user_id' => $this->input->post('user_id')), $data);
        echo json_encode(array('status' => TRUE));
    }
}
