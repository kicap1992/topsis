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
      $cek_data = $this->model->tampil_data_where('tb_admin', array('nik' => $this->session->userdata('nik')))->result();

      if (count($cek_data) > 0) {
        # code...
        $this->main['level'] = $cek_data[0]->level;
        $this->main["nama"] = $cek_data[0]->nama;
        $cek_data_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $cek_data[0]->id_dinas])->result()[0];
        $this->main["id_dinas"] = $cek_data_dinas->id_dinas;
        $this->main["dinas"] = $cek_data_dinas->dinas;
        $this->main['lat'] = $cek_data_dinas->lat;
        $this->main['lng'] = $cek_data_dinas->lng;
        $this->main['radius'] = $cek_data_dinas->radius;
        $this->month = date("m");
        $this->year = date("Y");
      } else {
        $this->session->unset_userdata(array('nik',  'level'));
        redirect('/login');
      }
    }
  }



  function index()
  {
    $main = $this->main;
    $main["header"] = "Halaman Utama";
    $main['list_karyawan'] = $this->model->tampil_data_where('tb_karyawan', ['id_dinas' => $main['id_dinas']])->result();

    $array = $main['list_karyawan'];
    $today = date("Y-m-d");
    foreach ($array as $key => $value) {
      $main['list_karyawan'][$key]->status_kerja = '-';
      $check_libur = $this->model->tampil_data_where('tb_informasi_libur', ['nik' => $value->nik, 'tanggal' => $today])->result();

      if (count($check_libur) > 0) {
        $main['list_karyawan'][$key]->status_kerja = 'Libur';
      }

      $check_perjalanan_dinas = $this->model->tampil_data_where('tb_informasi_perjalanan_dinas', ['nik' => $value->nik, 'tanggal' => $today])->result();

      if (count($check_perjalanan_dinas) > 0) {
        $main['list_karyawan'][$key]->status_kerja = 'Perjalanan Dinas';
      }
    }

    // echo $this->level;
    $this->load->view('admin/menu/index', $main);
    // $this->load->view('admin/index');
    // echo "sini index admin";
  }

  function pengaturan()
  {
    $main = $this->main;
    $main["header"] = "Halaman Pengaturan Lokasi Dinas";

    // echo $this->level;
    $this->load->view('admin/menu/pengaturan', $main);
    // $this->load->view('admin/index');
    // echo "sini index admin";
  }

  function karyawan()
  {
    if ($this->input->post('proses') == "table_karyawan") {
      $list = $this->m_tabel_ss->get_datatables(array('nik', 'nama', 'no_telpon', 'jabatan', 'pangkat'), array(null, 'nik', 'nama', 'no_telpon', 'jabatan', 'pangkat', null), array('status' => 'desc'), "tb_karyawan", null, array("id_dinas" => $this->main['id_dinas']), "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        $stat = '';
        $title = 'Tukar ID Smartphone';
        if ($field->device_id == null || $field->device_id == '') {
          $stat = 'disabled';
          $title = 'Karyawan Belum Login Dari Smartphone';
        }

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $field->nik;
        $row[] = $field->nama;
        $row[] = $field->no_telpon;
        $row[] = $field->jabatan;
        $row[] = $field->pangkat;
        $row[] = "<center><button type='button' onclick='karyawan_edit(" . '"' . (string)$field->nik . '"' . ")' title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button> &nbsp <button type='button' onclick='tukar_id(" . '"' . (string)$field->nik . '"' . ")' title='" . $title . "' " . $stat . " class='btn btn-warning btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-smartphone-landscape-lock'></i></button> &nbsp <button type='button' onclick='hapus_karyawan(" . '"' . (string)$field->nik . '"' . ")' title='Hapus Karyawan' class='btn btn-danger btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-delete'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_karyawan", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('nik', 'nama', 'no_telpon', 'jabatan', 'pangkat'), array(null, 'nik', 'nama', 'no_telpon', 'jabatan', 'pangkat', null), array('status' => 'desc'), "tb_karyawan", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      $main = $this->main;
      $main["header"] = "Halaman Karyawan";

      $this->load->view('admin/menu/karyawan', $main);
    }
  }


  function jam_kerja()
  {
    $main = $this->main;
    $main["header"] = "Halaman Jam Kerja";

    // echo $this->level;
    $this->load->view('admin/menu/jam_kerja', $main);
  }

  function libur()
  {
    if ($this->input->post('proses') == "table_libur") {
      $list = $this->m_tabel_ss->get_datatables(array('range_tanggal', 'created_at'), array(null, 'range_tanggal', null, 'created_at',  null), array('id_libur' => 'desc'), "tb_libur", null, array("id_dinas" => $this->main['id_dinas']), "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        $list_karyawan = json_decode($field->list_karyawan);

        $value_karyawan = '';
        foreach ($list_karyawan as $key => $value) {
          $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $value])->result();
          $value_karyawan .= " " . $check_karyawan[0]->nama . ' ,';
        }

        $value_karyawan = rtrim($value_karyawan, ",");

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $field->range_tanggal;
        $row[] = $value_karyawan;
        $row[] = $field->created_at;
        $row[] = "<center><button type='button' onclick='check_info(" . '"' . (string)$field->id_libur . '"' . ")' title='Check Informasi Libur' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-info-outline'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_libur", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('range_tanggal', 'created_at'), array(null, 'range_tanggal', null,  'created_at',  null), array('id_libur' => 'desc'), "tb_libur", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      $main = $this->main;
      $main["header"] = "Halaman Pengaturan Libur";

      // echo $main["header"];

      $this->load->view('admin/menu/libur', $main);
    }
  }


  function perjalanan_dinas()
  {
    if ($this->input->post('proses') == "table_dinas") {
      $list = $this->m_tabel_ss->get_datatables(array('range_tanggal', 'created_at'), array(null, 'range_tanggal', null, 'created_at',  null), array('id_perjalanan_dinas' => 'desc'), "tb_perjalanan_dinas", null, array("id_dinas" => $this->main['id_dinas']), "*");
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $field) {

        $list_karyawan = json_decode($field->list_karyawan);

        $value_karyawan = '';
        foreach ($list_karyawan as $key => $value) {
          $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $value])->result();
          $value_karyawan .= " " . $check_karyawan[0]->nama . ' ,';
        }

        $value_karyawan = rtrim($value_karyawan, ",");

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $field->range_tanggal;
        $row[] = $value_karyawan;
        $row[] = $field->created_at;
        $row[] = "<center><button type='button' onclick='check_info(" . '"' . (string)$field->id_perjalanan_dinas . '"' . ")' title='Check Informasi Perjalanan Dinas' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-info-outline'></i></button></center>";
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_tabel_ss->count_all("tb_perjalanan_dinas", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "recordsFiltered" => $this->m_tabel_ss->count_filtered(array('range_tanggal', 'created_at'), array(null, 'range_tanggal', null,  'created_at',  null), array('id_perjalanan_dinas' => 'desc'), "tb_perjalanan_dinas", null, array("id_dinas" => $this->main['id_dinas']), "*"),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      $main = $this->main;
      $main["header"] = "Halaman Pengaturan Perjalanan Dinas";

      // echo $main["header"];

      $this->load->view('admin/menu/perjalanan_dinas', $main);
    }
  }


  function laporan($month = null, $year = null)
  {
    $main = $this->main;
    $main["header"] = "Halaman Laporan";

    $main["month"] = $month != null ? $month : date("m");
    $main["year"] = $year != null ? $year : date("Y");

    $main["first_date"] = ($main["month"] == "09" && $main["year"]  == 2022) ? 21 : 1;

    $main["last_date"] =  date("d");

    // echo $main["month"].;
    // echo $main["year"] . "ini year";
    // $i = 21;
    // $tanggal = strlen($i) == 1 ? "0" . $i : $i;
    // echo $tanggal;

    $main['list_karyawan'] = $this->model->tampil_data_where(('tb_karyawan'), ['id_dinas' => $this->main['id_dinas']])->result();

    // print_r($main['list_karyawan']);

    $this->load->view('admin/menu/laporan', $main);
  }

  function coba2($month = null, $year = null)
  {

    $month = $month != null ? $month : date("m");
    $year = $year != null ? $year : date("Y");
    // echo "sini tampilkan pdf";
    $this->load->library('Pdf');
    $pdf = new Pdf('P', 'mm', array(210, 297));
    $pdf->AddPage();
    $pdf->SetFont('times', '', 12);
    $html = '
      <br><br><br><br>
      <table width="100%">
        <tr>
          <td align="center" style="font-weight:bold">
            <u>Daftar Hadir Pegawai</u><br>
            Periode ' . $this->model->bulan($month)  . ' ' . $year . '
          </td>
        </tr>
      </table>

      <style>
        
        .ini {
          border-bottom: 1px dotted black;
        }


      </style>
    ';

    $first_date = ($month == "09" && $year == 2022) ? 21 : 1;
    $last_date =  date("d");

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['id_dinas' => $this->main['id_dinas']])->result();
    for ($i = $first_date; $i <=  $last_date; $i++) {
      $tanggal = strlen($i) == 1 ? "0" . $i : $i;
      $html .= '
      <br><br>
      <table width="100%">
          <tr>
            <td style="font-weight:bold">Tanggal '. $tanggal . '-' . $month . '-' . $year . '</td>
          </tr>
        </table>
      ';
      $html .= '
      <table width="100%" border="1" class="ini" cellpadding="2" style="font-size:10px">
          <tr style="font-weight:bold">
            <td>NIP</td>
            <td>Nama</td>           
            <td>Jabatan</td>           
            <td>Status</td>           
            <td>Jam Masuk</td>           
            <td>Jam Istirehat</td>           
            <td>Jam Masuk Kembali</td>           
            <td>Jam Pulang</td>           
          </tr>
        ';
      foreach ($check_karyawan as $key => $value) {
        $check_absensi = $this->model->tampil_data_where('tb_absensi_karyawan', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

        $status = '-';
        $jam_masuk = "-";
        $jam_istirehat = "-";
        $jam_masuk_kembali = "-";
        $jam_pulang = "-";

        if (count($check_absensi) > 0) {
          $status = 'Masuk Kerja';
          $jam_masuk = $check_absensi[0]->jam_masuk;
          $jam_istirehat = $check_absensi[0]->jam_istirehat ?? '-';
          $jam_masuk_kembali = $check_absensi[0]->jam_masuk_kembali ?? '-';
          $jam_pulang = $check_absensi[0]->jam_pulang ?? '-';
        }

        $check_libur = $this->model->tampil_data_where('tb_informasi_libur', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

        if (count($check_libur) > 0) {
          $status = "Libur";
          $idnya = $check_libur[0]->id_libur;
        }

        $check_perjalanan_dinas = $this->model->tampil_data_where('tb_informasi_perjalanan_dinas', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

        if (count($check_perjalanan_dinas) > 0) {
          $status = "Perjalanan Dinas";
          $idnya = $check_perjalanan_dinas[0]->id_perjalanan_dinas;
        }

        $html .= '
        <tr style="font-size:8px">
          <td>'.$value->nik.'</td>
          <td>'.$value->nama.'</td>           
          <td>'.$value->jabatan.'</td>           
          <td>'.$status.'</td>           
          <td>'.$jam_masuk.'</td>           
          <td>'.$jam_istirehat.'</td>           
          <td>'.$jam_masuk_kembali.'</td>           
          <td>'.$jam_pulang.'</td>           
        </tr>
        ';
      }
      $html .= '</table>';
    }

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output("laporan data pasien.pdf", 'I');
  }
}
