<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('form_login');
        } else {
            $this->load->model('MUser');
            $valid_user = $this->MUser->check_cridential();

            if ($valid_user == FALSE) {
                $this->session->set_flashdata('error', 'Wrong User or password !');
                redirect('login');
            } else {
                // if an email and password is match
                $this->session->set_userdata('user_id', $valid_user->user_id);
                $this->session->set_userdata('username', $valid_user->username);
                $this->session->set_userdata('role_id', $valid_user->role_id);
                $this->session->set_userdata('email', $valid_user->email);

                switch ($valid_user->role_id) {
                    case 1 : //Admin
                        redirect('Dashboard');
                        break;
                    case 2 : //user
                        redirect('Ticket');
                        break;
                    default : break;
                }
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

}
