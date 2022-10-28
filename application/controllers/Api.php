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

    // $cek_data = $this->model->tampil_data_where('tb_login_admin', ['username' => $username, 'password' => md5($password)])->result();

    if ($username == 'admin' && $password == 'admin') {
      // $cek_data_admin = $this->model->tampil_data_where('tb_admin', ['nik' => $cek_data[0]->nik])->result()[0];
      // $cek_data_dinas = $this->model->tampil_data_where('tb_dinas', ['id_dinas' => $cek_data_admin->id_dinas])->result()[0];
      $this->session->set_userdata(['nik' => 'Admin', "level" => 'Admin']);
      $this->response(['message' => "Sukses Login", "status" => true], 200);
    } else {
      $this->session->unset_userdata(array('nik', "level"));
      $this->response(['message' => "Gagal Login, Username dan Password salah", "status" => false], 400);
    }

    // $this->response(['res' => $username,'url' => $password], 200);

  }

  public function penduduk_get() // tampil data penduduk
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);
    $nik = $this->get('nik');
    $cek_data = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();
    if (count($cek_data) == 0) return $this->response(['message' => 'Data Tidak Ditemukan', 'data' => null], 400);

    $this->response(['message' => 'Data Ditemukan', 'data' => $cek_data[0]], 200);
  }

  public function penduduk_post() // tambah data penduduk
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);

    $nik = $this->post('nik');
    $nama = $this->post('nama');
    $tgl_lahir = $this->post('tgl_lahir');
    $jenis_kelamin = $this->post('jenis_kelamin');
    $alamat = $this->post('alamat');
    $no_hp = $this->post('no_hp');

    $cek_nik = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();

    if (count($cek_nik) > 0) return $this->response(['message' => 'NIK ' . $nik . ' sudah terdaftar'], 400);

    $data = [
      'nik' => $nik,
      'nama' => $nama,
      'tgl_lahir' => $tgl_lahir,
      'jenis_kelamin' => $jenis_kelamin,
      'alamat' => $alamat,
      'no_hp' => $no_hp,
    ];

    $this->model->insert('tb_penduduk', $data);


    $this->response(['message' => 'Data dengan NIK ' . $nik . ' berhasil ditambahkan'], 200);
  }

  public function penduduk_put() // edit data penduduk
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);

    $nik = $this->put('nik');
    $nama = $this->put('nama');
    $tgl_lahir = $this->put('tgl_lahir');
    $jenis_kelamin = $this->put('jenis_kelamin');
    $alamat = $this->put('alamat');
    $no_hp = $this->put('no_hp');

    $cek_nik = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();

    if (count($cek_nik) == 0) return $this->response(['message' => 'NIK ' . $nik . ' tidak terdaftar'], 400);

    $data = [
      'nama' => $nama,
      'tgl_lahir' => $tgl_lahir,
      'jenis_kelamin' => $jenis_kelamin,
      'alamat' => $alamat,
      'no_hp' => $no_hp,
    ];

    $this->model->update('tb_penduduk', ['nik' => $nik], $data);

    $this->response(['message' => 'Data dengan NIK ' . $nik . ' berhasil diubah'], 200);
  }


  public function penduduk_delete() // hapus data penduduk
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);

    $nik = $this->delete('nik');

    $cek_nik = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();

    if (count($cek_nik) == 0) return $this->response(['message' => 'NIK ' . $nik . ' tidak terdaftar'], 400);

    $this->model->delete('tb_penduduk', ['nik' => $nik]);

    $this->response(['message' => 'Data dengan NIK ' . $nik . ' berhasil dihapus'], 200);
    // $this -> response(['message' => $nik], 200);
  }

  public function topsis_get()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);

    $nik = $this->get('nik');
    $cek_nik = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();

    if (count($cek_nik) == 0) return $this->response(['message' => 'NIK ' . $nik . ' tidak terdaftar'], 400);

    $cek_data = $this->model->tampil_data_where('tb_detail', ['nik' => $nik])->result();
    if (count($cek_data) == 0) {
      $this->response(['message' => 'Data Tidak Ditemukan', 'data' => null], 200);
    } else {
      $this->response(['message' => 'Data Ditemukan', 'data' => $cek_data[0]], 200);
    }
  }

  public function topsis_post()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);
    $nik = $this->post('nik');
    $bobot_umur = $this->post('bobot_umur');
    $bobot_pekerjaan = $this->post('bobot_pekerjaan');
    $bobot_penghasilan = $this->post('bobot_penghasilan');
    $bobot_jumlah_tanggungan = $this->post('bobot_jumlah_tanggungan');
    $bobot_jenis_rumah = $this->post('bobot_jenis_rumah');

    $cek_nik = $this->model->tampil_data_where('tb_penduduk', ['nik' => $nik])->result();

    if (count($cek_nik) == 0) return $this->response(['message' => 'NIK ' . $nik . ' tidak terdaftar'], 400);

    $data = [
      'bobot_umur' => $bobot_umur,
      'bobot_pekerjaan' => $bobot_pekerjaan,
      'bobot_penghasilan' => $bobot_penghasilan,
      'bobot_jumlah_tanggungan' => $bobot_jumlah_tanggungan,
      'bobot_jenis_rumah' => $bobot_jenis_rumah,
    ];
    $cek_data = $this->model->tampil_data_where('tb_detail', ['nik' => $nik])->result();
    if (count($cek_data) == 0) {
      $data['nik'] = $nik;
      $this->model->insert('tb_detail', $data);
    } else {
      $this->model->update('tb_detail', ['nik' => $nik], $data);
    }



    $this->response(['message' => ""], 200);
  }

  public function bantuan_get()
  {
    if ($this->session->userdata('level') != 'Admin') return $this->response(['message' => 'Not Allowed'], 401);

    $cek_detail = $this->model->tampil_data_keseluruhan('tb_detail')->result();
    $bobotall = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        $value->bobot_umur,
        $value->bobot_pekerjaan,
        $value->bobot_penghasilan,
        $value->bobot_jumlah_tanggungan,
        $value->bobot_jenis_rumah,
      ];
      array_push($bobotall, $array);
    }

    $the_bobotall = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        'nik' => $value->nik,
        'kriteria_umur' => $value->bobot_umur,
        'kriteria_pekerjaan' => $value->bobot_pekerjaan,
        'kriteria_penghasilan' => $value->bobot_penghasilan,
        'kriteria_jumlah_tanggungan' => $value->bobot_jumlah_tanggungan,
        'kriteria_jenis_rumah' => $value->bobot_jenis_rumah,

      ];
      array_push($the_bobotall, $array);
    }

    $bobot = [4, 4, 4, 4, 4];

    $matriks_keputusan  = $this->MatrixKeputusan($bobotall);

    $the_matrix_keputusan = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        'nik' => $cek_detail[$key]->nik,
        'kriteria_umur' => $matriks_keputusan[$key][0],
        'kriteria_pekerjaan' => $matriks_keputusan[$key][1],
        'kriteria_penghasilan' => $matriks_keputusan[$key][2],
        'kriteria_jumlah_tanggungan' => $matriks_keputusan[$key][3],
        'kriteria_jenis_rumah' => $matriks_keputusan[$key][4],
      ];
      array_push($the_matrix_keputusan, $array);
    }

    $totalmatriks_keputusan  = $this->TotMatrixKeputusan($matriks_keputusan);
    $matriks_normalisasi = $this->MatrixTernormalisasi($bobotall, $totalmatriks_keputusan);
    $the_matrix_normalisasi = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        'nik' => $cek_detail[$key]->nik,
        'kriteria_umur' => $matriks_normalisasi[$key][0],
        'kriteria_pekerjaan' => $matriks_normalisasi[$key][1],
        'kriteria_penghasilan' => $matriks_normalisasi[$key][2],
        'kriteria_jumlah_tanggungan' => $matriks_normalisasi[$key][3],
        'kriteria_jenis_rumah' => $matriks_normalisasi[$key][4],
      ];
      array_push($the_matrix_normalisasi, $array);
    }

    $normalisasi_terbobot =  $this->TermTerbobot($matriks_normalisasi, $bobot);
    $the_normalisasi_terbobot = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        'nik' => $cek_detail[$key]->nik,
        'kriteria_umur' => $normalisasi_terbobot[$key][0],
        'kriteria_pekerjaan' => $normalisasi_terbobot[$key][1],
        'kriteria_penghasilan' => $normalisasi_terbobot[$key][2],
        'kriteria_jumlah_tanggungan' => $normalisasi_terbobot[$key][3],
        'kriteria_jenis_rumah' => $normalisasi_terbobot[$key][4],
      ];
      array_push($the_normalisasi_terbobot, $array);
      $this->model->update('tb_detail', ['nik' => $cek_detail[$key]->nik], ['normalisasi' => json_encode($normalisasi_terbobot[$key])]);
    }
    $ideal_positif = $this->SolusiIdealPositif($normalisasi_terbobot);
    $the_ideal_positif = [
      'kriteria_umur' => $ideal_positif[0],
      'kriteria_pekerjaan' => $ideal_positif[1],
      'kriteria_penghasilan' => $ideal_positif[2],
      'kriteria_jumlah_tanggungan' => $ideal_positif[3],
      'kriteria_jenis_rumah' => $ideal_positif[4],
    ];

    $ideal_negatif = $this->SolusiIdealNegatif($normalisasi_terbobot);

    $the_ideal_negatif = [
      'kriteria_umur' => $ideal_negatif[0],
      'kriteria_pekerjaan' => $ideal_negatif[1],
      'kriteria_penghasilan' => $ideal_negatif[2],
      'kriteria_jumlah_tanggungan' => $ideal_negatif[3],
      'kriteria_jenis_rumah' => $ideal_negatif[4],
    ];


    $solusiideal = array();
    $solusiideal[] = $ideal_positif;
    $solusiideal[] = $ideal_negatif;

    $jarak_solusi = $this->JarakSolusi($normalisasi_terbobot, $solusiideal);
    $preverensi = $this->Preverensi($jarak_solusi);
    $the_preverensi = [];
    foreach ($cek_detail as $key => $value) {
      $array = [
        'nik' => $cek_detail[$key]->nik,
        'preverensi' => $preverensi[$key],
      ];
      array_push($the_preverensi, $array);
      $this->model->update('tb_detail', ['nik' => $cek_detail[$key]->nik], ['preverensi' => json_encode($preverensi[$key])]);
      $status = ($preverensi[$key] >= 0.5) ? 'Layak' : 'Tidak Layak';
      $this->model->update('tb_detail', ['nik' => $cek_detail[$key]->nik], ['status' => $status]);
    }
    $this->response(["bobot" => $the_bobotall, 'matriks_keputusan' => $the_matrix_keputusan, "matriks_normalisasi" => $the_matrix_normalisasi, 'normalisasi_terbobot' => $the_normalisasi_terbobot, 'ideal_positif' => $the_ideal_positif, "ideal_negatif" => $the_ideal_negatif, 'preverensi' => $the_preverensi], 200);
  }


  function MatrixKeputusan($matrix)
  {
    $all = [];
    for ($i = 0; $i < count($matrix); $i++) {
      $bobot = [];
      for ($j = 0; $j < count($matrix[$i]); $j++) {
        $x = $matrix[$i][$j] ** 2;
        array_push($bobot, $x);
      }
      array_push($all, $bobot);
    }
    return $all;
  }

  function TotMatrixKeputusan($matrix)
  {
    $total = [];
    for ($i = 0; $i < count($matrix[0]); $i++) {
      $tot = 0;
      for ($j = 0; $j < count($matrix); $j++) {
        $tot += $matrix[$j][$i];
      }
      $total[] = $tot ** (1 / 2);
    }
    return $total;
  }

  function MatrixTernormalisasi($matrix1, $matrix2)
  {
    $total = $matrix2;
    $all = [];
    for ($i = 0; $i < count($matrix1); $i++) {
      $sub = [];
      $k = 0;
      for ($j = 0; $j < count($matrix1[$i]); $j++) {
        $x = $matrix1[$i][$j] / $total[$k];
        array_push($sub, $x);
        $k++;
      }
      array_push($all, $sub);
    }
    return $all;
  }

  function TermTerbobot($matrix, $bobot)
  {
    $all = array();
    for ($i = 0; $i < count($matrix); $i++) {
      $sub = array();
      $k = 0;
      for ($j = 0; $j < count($matrix[$i]); $j++) {
        $sub[] = $matrix[$i][$j] * $bobot[$k];
        $k++;
      }
      $all[] = $sub;
    }
    return $all;
  }

  function SolusiIdealPositif($matrix)
  {
    $all = array();
    for ($i = 0; $i < count($matrix[0]); $i++) {
      $sub = array();
      for ($j = 0; $j < count($matrix); $j++) {
        array_push($sub, $matrix[$j][$i]);
      }
      array_push($all, $sub);
    }
    $sub1 = array();
    for ($k = 0; $k < count($all); $k++) {
      if ($all[$k] == $all[0] || $all[$k] == $all[2]) {
        $val = min($all[$k]);
      } else {
        $val = max($all[$k]);
      }
      array_push($sub1, $val);
    }
    return $sub1;
  }

  function SolusiIdealNegatif($matrix)
  {
    $all = [];
    for ($i = 0; $i < count($matrix[0]); $i++) {
      $sub = [];
      for ($j = 0; $j < count($matrix); $j++) {
        $sub[] = $matrix[$j][$i];
      }
      $all[] = $sub;
    }
    $sub1 = [];
    for ($k = 0; $k < count($all); $k++) {
      if ($all[$k] == $all[0] || $all[$k] == $all[2]) {
        $val = max($all[$k]);
      } else {
        $val = min($all[$k]);
      }
      $sub1[] = $val;
    }
    return $sub1;
  }

  function JarakSolusi($matrix1, $matrix2)
  {
    $all = [];
    for ($n = 0; $n < 2; $n++) {
      $solution = [];
      for ($i = 0; $i < count($matrix1); $i++) {
        $sub = [];
        $k = 0;
        for ($j = 0; $j < count($matrix1[$i]); $j++) {
          $x = $matrix1[$i][$j] - $matrix2[$n][$k];
          $sub[] = $x ** 2;
          $k += 1;
        }
        $solution[] = array_sum($sub) ** (1 / 2);
      }
      $all[] = $solution;
    }
    return $all;
  }

  function Preverensi($matrix)
  {
    $all = array();
    for ($i = 0; $i < count($matrix[0]); $i++) {
      $all[] = $matrix[1][$i] / ($matrix[1][$i] + $matrix[0][$i]);
    }
    return $all;
  }
}
