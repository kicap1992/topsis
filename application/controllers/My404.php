<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My404 extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function index()
  {
    // $this->session->sess_destroy();
    $this->load->view('404');
  }
}
