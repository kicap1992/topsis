<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('model');
    $this->load->model('m_tabel_ss');
    // $this->load->library('pdf');
    date_default_timezone_set("Asia/Kuala_Lumpur");
    ini_set('memory_limit', '-1');
    if ($this->session->userdata('level') != 'Admin') {
      $this->session->unset_userdata(array('nik',  'level'));
      redirect('/login');
    } else {
      // $cek_data = $this->model->tampil_data_where('tb_admin', array('nik' => $this->session->userdata('nik')))->result();

      // if (count($cek_data) > 0) {
      //   # code...
      //   $this->main['level'] = $cek_data[0]->level;
      //   $this->main["nama"] = $cek_data[0]->nama;
      //   $cek_data_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $cek_data[0]->id_dinas])->result()[0];
      //   $this->main["id_dinas"] = $cek_data_dinas->id_dinas;
      //   $this->main["dinas"] = $cek_data_dinas->dinas;
      //   $this->main['lat'] = $cek_data_dinas->lat;
      //   $this->main['lng'] = $cek_data_dinas->lng;
      //   $this->main['radius'] = $cek_data_dinas->radius;
      //   $this->month = date("m");
      //   $this->year = date("Y");
      // } else {
      //   $this->session->unset_userdata(array('nik',  'level'));
      //   redirect('/login');
      // }
    }
  }



  function index()
  {

    if ($this->input->post('proses') == "table_penduduk") {
      $list = $this->m_tabel_ss->get_datatables(array('nik', 'nama', 'no_hp', 'jenis_kelamin'), array('nik', 'nama', null, 'jenis_kelamin', null), array('status' => 'desc'), "tb_penduduk", null, null, "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        // get umur
        $date1 = new DateTime($field->tgl_lahir);
        $date2 = new DateTime("now");
        $interval = $date1->diff($date2);
        $umur = $interval->y;

        $no++;
        $row = array();
        // $row[] = $no;
        $row[] = $field->nik;
        $row[] = $field->nama;
        $row[] = $umur;
        $row[] = $field->no_hp;
        $row[] = $field->jenis_kelamin;
        $row[] = "<center><button type='button' onclick='edit_penduduk(" . '"' . (string)$field->nik . '"' . ")' title='Edit Detail Penduduk' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button> &nbsp <button type='button' onclick='hapus_penduduk(" . '"' . (string)$field->nik . '"' . ")' title='Hapus Penduduk' class='btn btn-danger btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-delete'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_penduduk", null, null, "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nik', 'nama', 'no_hp', 'jenis_kelamin'), array('nik', 'nama', null, 'jenis_kelamin', null), array('status' => 'desc'), "tb_penduduk", null, null, "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      $main["header"] = "Halaman Utama";
      $this->load->view('admin/menu/index', $main);
    }
  }

  function topsis($nik = null)
  {
    if ($this->input->post('proses') == "table_penduduk") {
      $list = $this->m_tabel_ss->get_datatables(array('nik', 'nama'), array('nik', 'nama', null, null), array('status' => 'desc'), "tb_penduduk", null, null, "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        $cek_data_bantuan = $this->model->tampil_data_where('tb_detail', array('nik' => $field->nik))->result();

        if (count($cek_data_bantuan) > 0) {
          $status = $cek_data_bantuan[0]->status == '' ? 'Belum Diverifikasi' : $cek_data_bantuan[0]->status;
        } else {
          $status = "Data Belum Dimasukkan";
        }

        $no++;
        $row = array();
        // $row[] = $no;
        $row[] = $field->nik;
        $row[] = $field->nama;
        $row[] = $status;
        $row[] = "<center><button type='button' onclick='status_bantuan(" . '"' . (string)$field->nik . '"' . ")' title='Lihat Status Bantuan Sosial' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_penduduk", null, null, "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nik', 'nama'), array('nik', 'nama', null, null), array('status' => 'desc'), "tb_penduduk", null, null, "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } 
    elseif($nik != null){
      $cek_data = $this->model->tampil_data_where('tb_penduduk', array('nik' => $nik))->result();
      if(count($cek_data) > 0){
        // cek umur
        $date1 = new DateTime($cek_data[0]->tgl_lahir);
        $date2 = new DateTime("now");
        $interval = $date1->diff($date2);
        $main['umur'] = $interval->y;

        $main["header"] = "Halaman Topsis";
        $main["nik"] = $nik;
        $main['nama'] = $cek_data[0]->nama;
        $this->load->view('admin/menu/topsis_detail', $main);
      } else{
        redirect('/admin/topsis');
      }
    }
    else {
      $main["header"] = "Halaman Topsis";
      $main["nik"] = $nik;
      $this->load->view('admin/menu/topsis', $main);
    }
  }
}
