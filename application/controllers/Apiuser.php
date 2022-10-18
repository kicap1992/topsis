<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Apiuser extends RestController
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
    $this->response(['message' => 'Halo Bosku'], 200);
  }

  // -----------------------------------------------------------------------------------------------------------





  public function login_post() // login user
  {
    $nik = $this->post('nik');
    $password = $this->post('password');
    $device_id = $this->post('device_id');

    if ($nik == null || $nik == '' || $password == null || $password == '' || $device_id == null || $device_id == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $cek_data = $this->model->tampil_data_where('tb_login_user', ['username' => $nik, 'password' => md5($password)])->result();

    if (count($cek_data) == 0) return $this->response(['status' => false, 'message' => "Username Dan Password Salah"], 401);

    $data_user = $this->model->custom_query("SELECT * from tb_karyawan a join tb_dinas b on a.id_dinas = b.id_dinas where a.nik=$nik")->result()[0];

    if ($data_user->device_id == null || $data_user->device_id == '') {
      $cek_if_device_exist = $this->model->tampil_data_where('tb_karyawan', ['device_id' => $device_id])->result();
      if (count($cek_if_device_exist) > 0) return $this->response(['status' => false, 'message' => "Gagal Login Ke Perangkat Ini, Perangkat Ini Telah Terdaftar Ke Karayawan Lainnya, Sila Infokan Ke Admin Bersangkutan Jika Ingin Ganti Perangkat Anda"], 403);

      $this->model->update("tb_karyawan", ['nik' => $nik], ['device_id' => $device_id, "updated_at" => date("Y-m-d H:i:s")]);
      return $this->response(['status' => true, 'message' => "Selamat Login " . $data_user->nama, "data" => $data_user, "firstTime" => true], 200);
    } else {
      if ($device_id != $data_user->device_id) return $this->response(['status' => false, 'message' => "Gagal Login Ke Perangkat Ini,Login Ke Perangkat Yang Anda Gunakan Sebelumnya. Sila Infokan Ke Admin Bersangkutan Jika Ingin Ganti Perangkat Anda"], 403);
      $this->response(['status' => true, 'message' => "Selamat Login " . $data_user->nama, "data" => $data_user], 200);
    }
  }

  public function user_data_get() //get user data
  {
    $nik = $this->get('nik');
    if ($nik == null || $nik == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);


    $data_user = $this->model->custom_query("SELECT * from tb_karyawan a join tb_dinas b on a.id_dinas = b.id_dinas where a.nik=$nik")->result();
    if (count($data_user) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $this->response(['status' => true, 'message' => "Sukses mengambil data", "data" => $data_user[0]], 200);
  }

  public function jadwal_dinas_post() // ambil jadwal absesni instansi
  {
    $id_dinas = $this->post('id_dinas');
    if ($id_dinas == null || $id_dinas == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $check_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $id_dinas])->result();
    if (count($check_dinas) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $data_kerja_dinas = $this->model->tampil_data_where('tb_pengaturan_jam_kerja_harian', ['id_dinas' => $id_dinas])->result();



    $this->response(['status' => true, 'message' => "Sukses mengambil data jadawal kerja", "data" => $data_kerja_dinas], 200);
  }

  public function today_absensi_get() // ambil absensi ini hari berdasarkan kayawan
  {
    $nik = $this->get('nik');
    $date = $this->get('date');
    if ($nik == null || $nik == '' || $date == null || $date == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();
    if (count($check_karyawan) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $check_data_absensi = $this->model->tampil_data_where('tb_absensi_karyawan', ['nik' => $nik, 'tanggal' => $date])->result();

    if (count($check_data_absensi) > 0) {
      $this->response(['status' => true, 'message' => "Sukses mengambil data jadawal karyawan", "data" => $check_data_absensi[0]], 200);
    } else {
      $this->response(['status' => true, 'message' => "Sukses mengambil data jadawal karyawan", "data" => null], 200);
    }
  }

  public function today_absensi_post() // ambil absensi ini hari berdasarkan kayawan
  {
    $nik = $this->post('nik');
    $date = $this->post('date');
    $stat = $this->post('stat');
    if ($nik == null || $nik == '' || $date == null || $date == ''  || $stat == null || $stat == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();
    if (count($check_karyawan) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);
    $time = date('H:i:s');
    $check_data_absensi = $this->model->tampil_data_where('tb_absensi_karyawan', ['nik' => $nik, 'tanggal' => $date])->result();

    if (count($check_data_absensi) > 0) {
      if ($stat == 'jam_istirehat') {
        $this->model->update('tb_absensi_karyawan', ['nik' => $nik, 'tanggal' => $date], [
          'jam_istirehat' => $time
        ]);
      }
      if ($stat == 'jam_masuk_kembali') {
        $this->model->update('tb_absensi_karyawan', ['nik' => $nik, 'tanggal' => $date], [
          'jam_masuk_kembali' => $time
        ]);
      }
      if ($stat == 'jam_pulang') {
        $this->model->update('tb_absensi_karyawan', ['nik' => $nik, 'tanggal' => $date], [
          'jam_pulang' => $time
        ]);
      }
      $this->response(['status' => true, 'message' => "Sukses mengambil data jadawal karyawan", "data" => $check_data_absensi[0]], 200);
    } else {
      if ($stat != 'jam_masuk') return $this->response(['status' => false, 'message' => "Status Salah"], 401);
      $this->model->insert('tb_absensi_karyawan', ['nik' => $nik, "id_dinas" => $check_karyawan[0]->id_dinas, "tanggal" => $date, "jam_masuk" => $time]);
      $this->response(['status' => true, 'message' => "Sukses Mengabsen"], 200);
    }

    // $this->response(['status' => true, 'message' => "Sukses Mengabsen", "data" => $date], 200);

  }

  public function get_perjalanan_dinas_libur_get() // ambil absensi ini hari berdasarkan kayawan
  {
    $nik = $this->get('nik');
    $date = $this->get('date');
    if ($nik == null || $nik == '' || $date == null || $date == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();
    if (count($check_karyawan) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $check_perjalanan_dinas = $this->model->tampil_data_where("tb_informasi_perjalanan_dinas", ["nik" => $nik, 'tanggal' => $date])->result();

    if (count($check_perjalanan_dinas) > 0) {
      $check_perjalanan_dinas = $check_perjalanan_dinas[0];
      $check_perjalanan_dinas->stat = 'Perjalanan Dinas';
      $this->response(['status' => true, 'message' => "Ada Perjalanan Dinas Karyawan", "data" => $check_perjalanan_dinas], 200);
    }

    $check_libur = $this->model->tampil_data_where("tb_informasi_libur", ["nik" => $nik, 'tanggal' => $date])->result();

    if (count($check_libur) > 0) {
      $check_libur = $check_libur[0];
      $check_libur->stat = 'Libur';
      $this->response(['status' => true, 'message' => "Ada Libur Karyawan", "data" => $check_libur], 200);
    }


    $this->response(['status' => true, 'message' => "Tiada Libur Karyawan", "data" => null], 200);
  }

  public function laporan_post()
  {
    $ada_foto = $this->post('ada_foto');
    $nik = $this->post('nik');
    $device_id = $this->post('device_id');
    $id_dinas = $this->post('id_dinas');
    $nama_laporan = $this->post('nama_laporan');
    $ket_laporan = $this->post('ket_laporan');
    $image = ($ada_foto == 'true') ? $_FILES['image'] : null;

    if ($nik == null || $nik == '' || $ada_foto == null || $ada_foto == '' || $device_id == null || $device_id == '' || $id_dinas == null || $id_dinas == '' || $nama_laporan == null || $nama_laporan == '' || $ket_laporan == null || $ket_laporan == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    // cek user first
    $cek_user = $this->model->tampil_data_where('tb_karyawan', ["nik" => $nik, "device_id" => $device_id, "id_dinas" => $id_dinas])->result();

    if (count($cek_user) == 0) return $this->response(['status' => false, 'message' => "Karyawan, Device ID dan Dinas tidak cocok di sistem"], 401);


    $auto_increment_val = $this->model->cek_last_ai('tb_laporan_karyawan');


    $dir = "assets/images/karyawan/$auto_increment_val/";
    $image_path = null;

    if ($ada_foto == 'true') {
      if (is_dir($dir) === false) {
        mkdir($dir);
      }

      $path = $dir . $image['name'];
      move_uploaded_file($image['tmp_name'], $path);
      $image_path = $path;
    }

    // for ($i = 0; $i < 30; $i++) {
    $this->model->insert('tb_laporan_karyawan', ['nik' => $nik, 'image' => $image_path, 'nama_laporan' => $nama_laporan, 'ket_laporan' => $ket_laporan, 'created_at' => date("Y-m-d H:i:s")]);
    // }


    $this->response(['status' => true, 'message' => 'Laporan Berhasil Ditambah'], 200);
  }

  public function laporan_get()
  {
    $nik = $this->get('nik');
    $page = $this->get('page');
    $where = $this->get('where');

    

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();
    if (count($check_karyawan) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $page_search = ($page - 1) * 10;

    if ($where == '') {
      $get_all_data = $this->model->custom_query("SELECT * FROM tb_laporan_karyawan where nik=$nik order by no_laporan desc")->result();

      $cek_data = $this->model->custom_query("SELECT * FROM tb_laporan_karyawan where nik=$nik  order by no_laporan desc limit 10 OFFSET $page_search ")->result();
    } else {
      $get_all_data = $this->model->custom_query("SELECT * FROM tb_laporan_karyawan where nik=$nik and ket_laporan like '%$where%' or nama_laporan like '%$where%'   or created_at like '%$where%'  order by no_laporan desc")->result();
      $cek_data = $this->model->custom_query("SELECT * FROM tb_laporan_karyawan where nik=$nik and ket_laporan like '%$where%' or nama_laporan like '%$where%'   or created_at like '%$where%' order by no_laporan desc limit 10 OFFSET $page_search  ")->result();
    }


    $count_get_all_data = count($get_all_data);
    $all_page = ceil($count_get_all_data / 10);



    $data = ["count_all" => $count_get_all_data, "all_page" => $all_page, "data" => $cek_data];
    $this->response(['status' => true, 'message' => "Selamat Login ", "data" => $data], 200);
  }


  public function my_location_post()
  {
    $nik = $this->post('nik');
    $lat = $this->post('lat');
    $lng = $this->post('lng');
    if ($nik == null || $nik == '' || $lat == null || $lat == ''  || $lng == null || $lng == '') return $this->response(['status' => false, 'message' => "Isi Semua Form"], 403);

    $check_karyawan = $this->model->tampil_data_where('tb_karyawan', ['nik' => $nik])->result();
    if (count($check_karyawan) == 0) return $this->response(['status' => false, 'message' => "Tiada Data"], 401);

    $check_if_ada = $this->model->tampil_data_where('tb_kordinat_karyawan', ['nik' => $nik])->result();


    $time = date("Y-m-d H:i:s");
    if (count($check_if_ada) > 0) {
      $this->model->update('tb_kordinat_karyawan', ['nik' => $nik], ['lat' => $lat, 'lng' => $lng, 'updated_at' => $time]);
    } else {
      $this->model->insert('tb_kordinat_karyawan', ['nik' => $nik],['lat' => $lat, 'lng' => $lng, 'updated_at' => $time]);
    }

    $this->response(['status' => true, 'message' => "ini dia"], 200);
  }
}
