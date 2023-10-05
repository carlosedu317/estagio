<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcoes extends CI_Controller{

    public function login(){
        $this->load->helper('url');
        $this->load->view('login'); 
    }
    public function index(){
        $this->load->helper('url');
        $this->load->view('index');
    }

    public function cadastrar(){
        $this->load->helper('url');
        $this->load->view('cadastrar');
    }

    public function consultaAlu(){
        $this->load->helper('url');
        $this->load->view('consultaAlu');
    }
}