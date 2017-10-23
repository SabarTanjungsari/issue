<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        if ($this->session->userdata('role_id') == '') {
            redirect('Login');
        }
    }

    public function index() {
        $this->load->view('test');
    }

    public function search() {
        // tangkap variabel keyword dari URL
        $keyword = $this->uri->segment(3);

        // cari di database
        $data = $this->db->from('customer_v')->like('name', $keyword)->get();

        // format keluaran di dalam array
        foreach ($data->result() as $row) {
            $arr['query'] = $keyword;
            $arr['suggestions'][] = array(
                'value' => $row->name//,
                //'nim' => $row->nim,
                //'jurusan' => $row->jurusan
            );
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    public function lookup() {
        // process posted form data  
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //Set default response  
        $query = $this->MCustomer->lookup($keyword); //Search DB  
        if (!empty($query)) {
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach ($query as $row) {
                $data['message'][] = array(
                    'value' => $row->customer,
                    ''
                );  //Add a row to array  
            }
        }
        if ('IS_AJAX') {
            echo json_encode($data); //echo json string if ajax request  
        } else {
            $this->load->view('show', $data); //Load html view of search results  
        }
    }

}
