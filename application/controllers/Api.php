<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('model');
    // $this->db->query("SET sql_mode = '' ");
    date_default_timezone_set("Asia/Kuala_Lumpur");
  }

  public function index_get()
  {
    if ($this->session->userdata('level') == 'Admin') {
      $this->response(['message' => 'Halo Bosku'], 200);
    } else {
      $this->response(['message' => 'Halo gagal'], 400);
    }

    // redirect(base_url());

  }

  // -----------------------------------------------------------------------------------------------------------





  public function login_admin_get() // login admin
  {
    $username = $this->get('username');
    $password = $this->get('password');

    $cek_data = $this->model->tampil_data_where('tb_login_admin', ['username' => $username, 'password' => md5($password)])->result();

    if (count($cek_data) > 0) {
      $cek_data_admin = $this->model->tampil_data_where('tb_admin', ['nik' => $cek_data[0]->nik])->result()[0];
      $cek_data_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $cek_data_admin->id_dinas])->result()[0];
      $this->session->set_userdata(['nik' => $cek_data_admin->nik, "level" => $cek_data_admin->level, 'id_dinas' => $cek_data_dinas->id_dinas]);
      $this->response(['message' => "Sukses Login", "status" => true], 200);
    } else {
      $this->session->unset_userdata(array('nik', "level"));
      $this->response(['message' => "Gagal Login, Username dan Password salah", "status" => false], 400);
    }

    // $this->response(['res' => $username,'url' => $password], 200);

  }

  public function pengaturan_lokasi_put() // pengaturan titik kordinat dinas
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $lat = $this->put('lat');
    $lng = $this->put('lng');
    $id = $this->put('id');

    if ($lat == null || $lat == '' || $lng == null || $lng == '' || $id == null || $id == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }


    $cek_data = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id])->result();

    if (count($cek_data) > 0) {
      $this->model->update('tb_dinas', ['id_dinas' => $id], ['lat' => $lat, 'lng' => $lng]);
      $this->session->set_flashdata('info', 'Titik Kordinat Berhasil Diubah');
      $this->response(['message' => 'Sukses Tukar Kordinat ' . $cek_data[0]->dinas], 200);
    } else {
      $this->response(['message' => 'Data Tiada', 'stat' => false], 403);
    }

    // $this->response(['res' => 'ok','url' => $id], 200);

  }

  public function pengaturan_radius_put() // pengaturan titik kordinat dinas
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $radius = $this->put('radius');
    $id = $this->put('id');

    if ($radius == null || $radius == '' || $id == null || $id == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }


    $cek_data = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id])->result();

    if (count($cek_data) > 0) {
      $this->model->update('tb_dinas', ['id_dinas' => $id], ['radius' => $radius]);
      $this->session->set_flashdata('info', 'Radius Berhasil Diubah');
      $this->response(['message' => 'Sukses Ubah Radius ' . $cek_data[0]->dinas], 200);
    } else {
      $this->response(['message' => 'Data Tiada', 'stat' => false], 403);
    }

    // $this->response(['res' => 'ok','url' => $id], 200);

  }

  public function karyawan_post() // penambahan_karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->post('id_dinas');
    // $foto = $_FILES['foto'];
    $foto = $this->post('foto') == 'tiada' ? null : $_FILES['foto'];
    $nik = $this->post('nik');
    $nama = $this->post('nama');
    $no_telpon = $this->post('no_telpon');
    $jabatan = $this->post('jabatan');
    $alamat = $this->post('alamat');
    $status_form = $this->post('status_form');
    $status = $this->post('status');
    $pangkat = $this->post('pangkat');
    $status = $this->post('status');
    $tanggal_lahir = $this->post('tanggal_lahir');

    if ($id_dinas == null || $id_dinas == '' || $nik == null || $nik == '' || $nama == null || $nama == '' || $no_telpon == null || $no_telpon == '' || $jabatan == null || $jabatan == '' || $alamat == null || $alamat == '' || $status_form == null || $status_form == '' || $pangkat == null || $pangkat == '' || $tanggal_lahir == null || $tanggal_lahir == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    if ($status_form == 'tambah') {
      $cek_data = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();

      if (count($cek_data) > 0) {
        $this->response(['message' => 'Karyawan Dengan NIK ' . $nik . " telah terdaftar di sistem", 'stat' => false], 403);
      } else {
        $dir = "assets/images/foto_karyawan/$nik/";

        if (is_dir($dir) === false) {
          mkdir($dir);
        }

        $path = $dir . $foto['name'];
        move_uploaded_file($foto['tmp_name'], $path);
        $image_path = $path;

        $this->model->insert("tb_karyawan", ['nik' => $nik, 'nama' => $nama, 'no_telpon' => $no_telpon, 'jabatan' => $jabatan, 'alamat' => $alamat, "id_dinas" => $id_dinas, "image" => $image_path, "status" => $status, "pangkat" => $pangkat, "tanggal_lahir" => $tanggal_lahir]);
        $this->model->insert("tb_login_user", ["username" => $nik, "password" => md5("12345678"), "nik" => $nik]);
        $this->response(['message' => 'Karyawan Dengan NIK ' . $nik . " berhasil didaftar di sistem\nUsername : " . $nik . "\nPassword : 12345678"], 201);
      }
    }

    if ($status_form == 'edit') {
      $cek_data = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik, "id_dinas" => $id_dinas])->result();


      if (count($cek_data) == 0) return $this->response(['message' => 'Karyawan Tidak Ditemukan', 'stat' => false], 401);

      if ($foto == null) {
        $this->model->update("tb_karyawan", ['nik' => $nik, "id_dinas" => $id_dinas], ["nama" => $nama, "no_telpon" => $no_telpon, "jabatan" => $jabatan, "alamat" => $alamat, "status" => $status, "pangkat" => $pangkat, "tanggal_lahir" => $tanggal_lahir]);
      } else {
        $dir = "assets/images/foto_karyawan/$nik/";
        if (is_dir($dir) === false) {
          mkdir($dir);
        }

        $files = glob($dir . '*'); // get all file names
        foreach ($files as $file) { // iterate files
          if (is_file($file)) {
            unlink($file); // delete file
          }
        }


        $path = $dir . $foto['name'];
        move_uploaded_file($foto['tmp_name'], $path);
        $image_path = $path;

        $this->model->update("tb_karyawan", ['nik' => $nik, "id_dinas" => $id_dinas], ["nama" => $nama, "no_telpon" => $no_telpon, "jabatan" => $jabatan, "alamat" => $alamat,  "image" => $image_path, "status" => $status, "pangkat" => $pangkat, "tanggal_lahir" => $tanggal_lahir]);
      }



      $this->response(['message' => 'Data Karyawan Berhasil Diubah'], 200);
    }



    // $this->response(['res' => 'ok', 'url' => $status], 200);
  }

  public function karyawanAll_get()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $check_data = $this->model->tampil_data_keseluruhan('tb_karyawan')->result();
    $this->response(['data' => $check_data], 200);
  }

  public function karyawan_get() // ambil data karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->get('id_dinas');
    $nik = $this->get('nik');


    if ($id_dinas == null || $id_dinas == '' || $nik == null || $nik == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    $cek_data = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();

    if (count($cek_data) == 0) return $this->response(['message' => 'Karyawan Tidak Ditemukan', 'stat' => false], 401);


    $this->response(['data' => $cek_data[0]], 200);
    // $this->response(['message' => 'Karyawan Tidak Ditemukan', 'stat' => false], 401);

  }

  public function karyawan_put() // edit data karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->put('id_dinas');
    $foto = $_FILES['foto'];
    $nik = $this->put('nik');
    $nama = $this->put('nama');
    $no_telpon = $this->put('no_telpon');
    $jabatan = $this->put('jabatan');
    $alamat = $this->put('alamat');

    // if ($id_dinas == null || $id_dinas == '' || $nik == null || $nik == '' || $nama == null || $nama == '' || $no_telpon == null || $no_telpon == '' || $jabatan == null || $jabatan == '' || $alamat == null || $alamat == '') {
    //   $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    // }

    // $cek_dinas = $this->model->tampil_data_where('tb_dinas',['id_dinas' => $id_dinas])->result();

    // if(count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    // $cek_data = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik, "id_dinas" => $id_dinas])->result();

    // if (count($cek_data) == 0) return $this->response(['message' => 'Karyawan Tidak Ditemukan', 'stat' => false], 401);

    // $this->model->update("tb_karyawan",['nik' => $nik, "id_dinas" => $id_dinas], ["nama" => $nama , "no_telpon" => $no_telpon , "jabatan" => $jabatan, "alamat" => $alamat]);

    // $this->response(['message' => '"Data Karyawan Berhasil Diubah'], 200);
    $this->response(['message' => $foto], 200);
  }

  public function karyawan_delete() // edit data karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->delete('id_dinas');
    $nik = $this->delete('nik');


    if ($id_dinas == null || $id_dinas == '' || $nik == null || $nik == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    $cek_data = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik, "id_dinas" => $id_dinas])->result();

    if (count($cek_data) == 0) return $this->response(['message' => 'Karyawan Tidak Ditemukan', 'stat' => false], 401);

    $this->model->delete("tb_karyawan", ['nik' => $nik, "id_dinas" => $id_dinas]);

    $this->response(['message' => "Data Karyawan Berhasil Dihapus"], 200);
  }

  public function jam_kerja_post() // edit data karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->post('id_dinas');
    $hari = $this->post('hari');
    $jam_masuk = $this->post('jam_masuk');
    $jam_istirehat = $this->post('jam_istirehat');
    $jam_masuk_kembali = $this->post('jam_masuk_kembali');
    $jam_pulang = $this->post('jam_pulang');


    if ($id_dinas == null || $id_dinas == '' || $hari == null || $hari == '' || $jam_masuk == null || $jam_masuk == '' || $jam_istirehat == null || $jam_istirehat == '' || $jam_masuk_kembali == null || $jam_masuk_kembali == '' || $jam_pulang == null || $jam_pulang == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    $cek_data = $this->model->tampil_data_where('tb_pengaturan_jam_kerja_harian', ['hari' => $hari, "id_dinas" => $id_dinas])->result();

    if (count($cek_data) == 0) {
      $this->model->insert("tb_pengaturan_jam_kerja_harian", ['hari' => $hari, "id_dinas" => $id_dinas, "jam_masuk" => $jam_masuk,  "jam_istirehat" => $jam_istirehat, "jam_masuk_kembali" => $jam_masuk_kembali, "jam_pulang" => $jam_pulang]);
    } else {
      $this->model->update("tb_pengaturan_jam_kerja_harian", ['hari' => $hari, "id_dinas" => $id_dinas], ["jam_masuk" => $jam_masuk,  "jam_istirehat" => $jam_istirehat, "jam_masuk_kembali" => $jam_masuk_kembali, "jam_pulang" => $jam_pulang]);
    }
    // $this->model->delete("tb_karyawan",['nik' => $nik, "id_dinas" => $id_dinas]);
    // $this->session->set_flashdata('info',"Jam Kerja Hari ".ucfirst($hari)." Berhasil Diubah");
    $this->response(['message' => "Jam Kerja Hari " . ucfirst($hari), " Berhasil Diubah"], 200);
  }

  public function jam_kerja_get() // edit data karyawan
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->get('id_dinas');


    if ($id_dinas == null || $id_dinas == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);


    $cek_data = $this->model->tampil_data_where('tb_pengaturan_jam_kerja_harian', ["id_dinas" => $id_dinas])->result();


    $this->response(['data' => $cek_data], 200);
  }


  public function libur_post()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->post('id_dinas');
    $list_karyawan = $this->post('list_karyawan');
    $start_tanggal = $this->post('start_tanggal');
    $end_tanggal = $this->post('end_tanggal');
    $ket = $this->post('ket');

    if ($id_dinas == null || $id_dinas == '' || $list_karyawan == null || $list_karyawan == '' || $start_tanggal == null || $start_tanggal == '' || $end_tanggal == null || $end_tanggal == '' || $ket == null || $ket == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);

    $period = new DatePeriod(
      new DateTime($start_tanggal),
      new DateInterval('P1D'),
      new DateTime($end_tanggal)
    );

    $cek_last_ai = $this->model->cek_last_ai('tb_libur');
    $this->model->insert('tb_libur', ['id_dinas' => $id_dinas, 'list_karyawan' => $list_karyawan, 'range_tanggal' => $start_tanggal . " - " . $end_tanggal, 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")", 'created_at' => date("Y-m-d H:i:s")]);
    $converted_list_karyawan = json_decode($list_karyawan);


    foreach ($converted_list_karyawan as $key1 => $value1) {
      foreach ($period as $key => $value) {
        $this->model->insert('tb_informasi_libur', ['id_libur' => $cek_last_ai, 'nik' => $value1, "tanggal" => $value->format('Y-m-d'), 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")"]);
      }
      $this->model->insert('tb_informasi_libur', ['id_libur' => $cek_last_ai, 'nik' => $value1, "tanggal" => $end_tanggal, 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")"]);
    }
    $this->response(['message' => "Data Libur Berhasil Dimasukkan"], 200);
  }

  public function libur_get()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->get('id_dinas');
    $id_libur = $this->get('id_libur');


    if ($id_dinas == null || $id_dinas == '' || $id_libur == null || $id_libur == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);

    $check_data = $this->model->tampil_data_where('tb_libur', ['id_libur' => $id_libur, "id_dinas" => $id_dinas])->result();

    if (count($check_data) == 0) return $this->response(['message' => 'Informasi Libur Tidak Ditemukan', 'stat' => false], 401);

    $data = array();

    $data['range_tanggal'] = $check_data[0]->range_tanggal;
    $data['ket'] = $check_data[0]->ket;
    $data['created_at'] = $check_data[0]->created_at;

    $data['list_karyawan'] = '';

    $list_karyawan = json_decode($check_data[0]->list_karyawan);

    foreach ($list_karyawan as $key => $value) {
      $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $value])->result();
      $data['list_karyawan']  .= " " . $check_karyawan[0]->nama . ' ,';
    }

    $data['list_karyawan']  = rtrim($data['list_karyawan'] ,",");



    $this->response(['data' => $data], 200);
  }

  public function perjalanan_dinas_post()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->post('id_dinas');
    $list_karyawan = $this->post('list_karyawan');
    $start_tanggal = $this->post('start_tanggal');
    $end_tanggal = $this->post('end_tanggal');
    $ket = $this->post('ket');

    if ($id_dinas == null || $id_dinas == '' || $list_karyawan == null || $list_karyawan == '' || $start_tanggal == null || $start_tanggal == '' || $end_tanggal == null || $end_tanggal == '' || $ket == null || $ket == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);

    $period = new DatePeriod(
      new DateTime($start_tanggal),
      new DateInterval('P1D'),
      new DateTime($end_tanggal)
    );

    $cek_last_ai = $this->model->cek_last_ai('tb_perjalanan_dinas');
    $this->model->insert('tb_perjalanan_dinas', ['id_dinas' => $id_dinas, 'list_karyawan' => $list_karyawan, 'range_tanggal' => $start_tanggal . " - " . $end_tanggal, 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")", 'created_at' => date("Y-m-d H:i:s")]);
    $converted_list_karyawan = json_decode($list_karyawan);


    foreach ($converted_list_karyawan as $key1 => $value1) {
      foreach ($period as $key => $value) {
        $this->model->insert('tb_informasi_perjalanan_dinas', ['id_perjalanan_dinas' => $cek_last_ai, 'nik' => $value1, "tanggal" => $value->format('Y-m-d'), 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")"]);
      }
      $this->model->insert('tb_informasi_perjalanan_dinas', ['id_perjalanan_dinas' => $cek_last_ai, 'nik' => $value1, "tanggal" => $end_tanggal, 'ket' => $ket . " (" . $start_tanggal . " - " . $end_tanggal . ")"]);
    }
    $this->response(['message' => "Data Libur Berhasil Dimasukkan"], 200);
  }

  public function perjalanan_dinas_get()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Failed', 'stat' => false], 401);
    $id_dinas = $this->get('id_dinas');
    $id_perjalanan_dinas = $this->get('id_perjalanan_dinas');


    if ($id_dinas == null || $id_dinas == '' || $id_perjalanan_dinas == null || $id_perjalanan_dinas == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);

    $check_data = $this->model->tampil_data_where('tb_perjalanan_dinas', ['id_perjalanan_dinas' => $id_perjalanan_dinas, "id_dinas" => $id_dinas])->result();

    if (count($check_data) == 0) return $this->response(['message' => 'Informasi Libur Tidak Ditemukan', 'stat' => false], 401);

    $data = array();

    $data['range_tanggal'] = $check_data[0]->range_tanggal;
    $data['ket'] = $check_data[0]->ket;
    $data['created_at'] = $check_data[0]->created_at;

    $data['list_karyawan'] = '';

    $list_karyawan = json_decode($check_data[0]->list_karyawan);

    foreach ($list_karyawan as $key => $value) {
      $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $value])->result();
      $data['list_karyawan']  .= " " . $check_karyawan[0]->nama . ' ,';
    }

    $data['list_karyawan']  = rtrim($data['list_karyawan'] ,",");



    $this->response(['data' => $data], 200);
  }

  public function get_today_absensi_get()
  {
    $id_dinas = $this->get('id_dinas');

    if ($id_dinas == null || $id_dinas == '') {
      $this->response(['message' => 'Isi Semua Form', 'stat' => false], 401);
    }

    $cek_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();

    if (count($cek_dinas) == 0) return $this->response(['message' => 'Dinas Tidak Ditemukan', 'stat' => false], 401);

    $today = date("Y-m-d");

    $check_data = $this->model->tampil_data_where('tb_absensi_karyawan', ['id_dinas' => $id_dinas, 'tanggal' => $today])->result();
    $datanya = array();
    if (count($check_data) > 0) {

      foreach ($check_data as $key => $value) {
        $check_data_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $value->nik])->result();
        $check_kordinat = $this->model->tampil_data_where('tb_kordinat_karyawan', ['nik' => $value->nik])->result();

        $status = "Sedang Bekerja";

        if ($check_data[$key]->jam_istirehat != null) {
          $status = "Sedang Istirehat";
        }
        if ($check_data[$key]->jam_masuk_kembali != null) {
          $status = "Sedang Bekerja";
        }
        if ($check_data[$key]->jam_pulang != null) {
          $status = "Pulang Kerja";
        }

        $datanya[$key]['nik'] = $value->nik;
        $datanya[$key]['nama'] = $check_data_karyawan[0]->nama;
        $datanya[$key]['lat'] = floatval($check_kordinat[0]->lat);
        $datanya[$key]['lng'] = floatval($check_kordinat[0]->lng);
        $datanya[$key]['last_updated'] = $check_kordinat[0]->updated_at;
        $datanya[$key]['status'] = $status;
      }
    }



    $this->response(['data' =>  $datanya], 200);
  }
}
