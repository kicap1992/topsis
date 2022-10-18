<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // $this->load->model('model');
  }

  function index()
  {
    $this->load->view('login/index');
  }

  function coba()
  {
    $this->session->set_userdata(['level' => 'Admin']);
    echo "ok";
  }

  function coba1()
  {
    if ($this->session->userdata('level') == 'Admin') {
      echo 200;
    } else {
      echo 400;
    }
  }

  function coba2()
  {
    $this->session->unset_userdata('level');
    echo "ok";
  }
}
