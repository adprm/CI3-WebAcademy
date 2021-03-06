<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class Contacts extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        // load model dan libarry
        $this->load->model('contact_model');
        $this->load->library('form_validation');
        $this->load->model("user_model");
        if ($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
    }

    // get data dari model dengan method getAll
    public function index(){
        $data['contact'] = $this->contact_model->getAll();
        $this->load->view('admin/contact/list', $data);
    }

    public function add(){
        $contact = $this->contact_model;
        $validation = $this->form_validation;
        $validation->set_rules($contact->rules());

        if ($validation->run()) {
            $contact->save();
            $this->session->set_flashdata('success', 'Saved successfully');
        }

        $this->load->view('admin/contact/new_form');
    }

    public function edit($id = null){
        if (!isset($id)) redirect('admin/contacts');

        $contact = $this->contact_model;
        $validation = $this->form_validation;
        $validation->set_rules($contact->rules());

        if ($validation->run()) {
            $contact->update();
            $this->session->set_flashdata('success', 'Saved successfully');
        }

        $data['contact'] = $contact->getById($id);
        if (!$data['contact']) show_404();

        $this->load->view('admin/contact/edit_form', $data);
    }

    public function delete($id = null){
        if (!isset($id)) show_404();

        if ($this->contact_model->delete($id)) {
            redirect(site_url('admin/contacts'));
        }
    }
}