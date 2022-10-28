<!DOCTYPE html>
<html lang="en">


<?php $this->load->view("admin/header"); ?>

<body>

  <?php $this->load->view("admin/side_topbar"); ?>

  <div id="wrapper">
    <div class="main-content">
      <div class="row small-spacing">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">List Penduduk</h4>

            <div class="card-content">

              <!-- create button for 'Tambah Penduduk' -->
              <button type="button" class="btn btn-primary btn-xs" onclick="proses_bantuan()">
                <i class="fa fa-book"></i> Proses Bantuan Sosial
              </button>
              <br><br>
              <div style="overflow-x: auto">
                <table id="table_list_penduduk" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Nama</th>
                      <th>Status Bantuan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>
      <!-- /.row -->

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Matriks Keputusan</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_matriks_keputusan" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Kriteria Umur</th>
                      <th>Kriteria Pekerjaan</th>
                      <th>Kriteria Penghasilan</th>
                      <th>Kriteria Jumlah Tanggungan</th>
                      <th>Kriteria Status Rumah</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Matriks Normalisasi</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_matriks_normalisasi" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Kriteria Umur</th>
                      <th>Kriteria Pekerjaan</th>
                      <th>Kriteria Penghasilan</th>
                      <th>Kriteria Jumlah Tanggungan</th>
                      <th>Kriteria Status Rumah</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Normalisasi Terbobot</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_normalisasi_terbobot" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Kriteria Umur</th>
                      <th>Kriteria Pekerjaan</th>
                      <th>Kriteria Penghasilan</th>
                      <th>Kriteria Jumlah Tanggungan</th>
                      <th>Kriteria Status Rumah</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Ideal Positif</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_ideal_positif" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Kriteria Umur</th>
                      <th>Kriteria Pekerjaan</th>
                      <th>Kriteria Penghasilan</th>
                      <th>Kriteria Jumlah Tanggungan</th>
                      <th>Kriteria Status Rumah</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Ideal Negatif</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_ideal_negatif" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Kriteria Umur</th>
                      <th>Kriteria Pekerjaan</th>
                      <th>Kriteria Penghasilan</th>
                      <th>Kriteria Jumlah Tanggungan</th>
                      <th>Kriteria Status Rumah</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <div class="row small-spacing tampilkan" style="display: none;">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">preverensi</h4>

            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_preverensi" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>NIK</th>
                      <th>Preverensi</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>

      <?php $this->load->view('admin/footer') ?>

    </div>
    <!-- /.main-content -->
  </div>

  <!-- create modal for 'Tambah Penduduk' -->
  <div class="modal fade" id="modal_add_penduduk" tabindex="-1" role="dialog" aria-labelledby="modal_add_penduduk" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal_add_penduduk"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form_add_penduduk" onsubmit="return tambah_edit_penduduk(event)">
          <div class="modal-body">

            <div class="form-group">
              <input type="hidden" id="status">
              <label for="nik">NIK</label>
              <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" onkeypress="return isNumberKey(event)" minlength="16" maxlength="16" required>
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
              <label for="umur">Tanggal Lahir</label>
              <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukkan Tanggal Lahir" required>
            </div>
            <div class="form-group">
              <label for="jenis_kelamin">Jenis Kelamin</label>
              <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" style="resize :none;" required></textarea>
            </div>
            <div class="form-group">
              <label for="no_hp">No HP</label>
              <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP" onkeypress="return isNumberKey(event)" minlength="9" maxlength="13" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-xs" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary btn-xs" id="btn_add_penduduk">Simpan</button>
            <button type="submit" class="btn btn-primary btn-xs" id="btn_update_penduduk">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <?php $this->load->view('admin/scripts') ?>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>


  <script>
    var data_lama;

    function datatables() {
      table = $('#table_list_penduduk').DataTable({
        // "searching": false,
        "lengthMenu": [
          [5, 10, 15, -1],
          [5, 10, 15, "All"]
        ],
        "pageLength": 10,
        "ordering": true,
        "processing": true,
        "serverSide": true,
        // "order": [[ 4, 'desc' ]], 

        "ajax": {
          "url": server_url + "admin/topsis",
          "type": "POST",
          data: {
            proses: 'table_penduduk'
          },

        },

        "columnDefs": [{
          "targets": [2, 3],
          "orderable": false,
        }, ],
      });
    }
    datatables()

    function status_bantuan(nik) {
      // console.log(nik)
      window.location.href = server_url + "admin/topsis/" + nik
    }

    function proses_bantuan() {
      // console.log("sini proses bantuan")
      ajax_proses = $.ajax({
        url: server_url_api + "bantuan",
        type: "get",

        dataType: "JSON",
        beforeSend: function() {
          block_ui("Menyimpan Data Penduduk");
        },
        success: function(data) {
          console.log(data)
          // show class tampilkan
          $('.tampilkan').removeAttr('style')

          const matriks_keputusan = data.matriks_keputusan
          const matriks_normalisasi = data.matriks_normalisasi
          const normalisasi_terbobot = data.normalisasi_terbobot
          const preverensi = data.preverensi
          // insert data matriks_keputusan to table table_matriks_keputusan body
          let html_matriks_keputusan = ''
          let html_matriks_normalisasi = ''
          let html_normalisasi_terbobot = ''
          let html_preverensi = ''

          for (let i = 0; i < matriks_keputusan.length; i++) {
            html_matriks_keputusan += '<tr>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].nik + '</td>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].kriteria_umur + '</td>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].kriteria_pekerjaan + '</td>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].kriteria_penghasilan + '</td>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].kriteria_jumlah_tanggungan + '</td>'
            html_matriks_keputusan += '<td>' + matriks_keputusan[i].kriteria_jenis_rumah + '</td>'
            html_matriks_keputusan += '</tr>'

            html_matriks_normalisasi += '<tr>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].nik + '</td>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].kriteria_umur + '</td>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].kriteria_pekerjaan + '</td>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].kriteria_penghasilan + '</td>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].kriteria_jumlah_tanggungan + '</td>'
            html_matriks_normalisasi += '<td>' + matriks_normalisasi[i].kriteria_jenis_rumah + '</td>'
            html_matriks_normalisasi += '</tr>'

            html_normalisasi_terbobot += '<tr>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].nik + '</td>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].kriteria_umur + '</td>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].kriteria_pekerjaan + '</td>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].kriteria_penghasilan + '</td>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].kriteria_jumlah_tanggungan + '</td>'
            html_normalisasi_terbobot += '<td>' + normalisasi_terbobot[i].kriteria_jenis_rumah + '</td>'
            html_normalisasi_terbobot += '</tr>'

            html_preverensi += '<tr>'
            html_preverensi += '<td>' + preverensi[i].nik + '</td>'
            html_preverensi += '<td>' + preverensi[i].preverensi + '</td>'
            html_preverensi += '</tr>'

          }

          $('#table_matriks_keputusan tbody').html(html_matriks_keputusan)
          $('#table_matriks_normalisasi tbody').html(html_matriks_normalisasi)
          $('#table_normalisasi_terbobot tbody').html(html_normalisasi_terbobot)
          $('#table_preverensi tbody').html(html_preverensi)

          // datatable matriks_keputusan
          $('#table_matriks_keputusan').DataTable();
          $('#table_matriks_normalisasi').DataTable();
          $('#table_normalisasi_terbobot').DataTable();
          $('#table_preverensi').DataTable();

          const ideal_positif = data.ideal_positif

          let html_ideal_positif = ''
          html_ideal_positif += '<tr>'
          html_ideal_positif += '<td>' + ideal_positif.kriteria_umur + '</td>'
          html_ideal_positif += '<td>' + ideal_positif.kriteria_pekerjaan + '</td>'
          html_ideal_positif += '<td>' + ideal_positif.kriteria_penghasilan + '</td>'
          html_ideal_positif += '<td>' + ideal_positif.kriteria_jumlah_tanggungan + '</td>'
          html_ideal_positif += '<td>' + ideal_positif.kriteria_jenis_rumah + '</td>'
          html_ideal_positif += '</tr>'
          $('#table_ideal_positif tbody').html(html_ideal_positif)
          $('#table_ideal_positif').DataTable();

          const ideal_negatif = data.ideal_negatif

          let html_ideal_negatif = ''
          html_ideal_negatif += '<tr>'
          html_ideal_negatif += '<td>' + ideal_negatif.kriteria_umur + '</td>'
          html_ideal_negatif += '<td>' + ideal_negatif.kriteria_pekerjaan + '</td>'
          html_ideal_negatif += '<td>' + ideal_negatif.kriteria_penghasilan + '</td>'
          html_ideal_negatif += '<td>' + ideal_negatif.kriteria_jumlah_tanggungan + '</td>'
          html_ideal_negatif += '<td>' + ideal_negatif.kriteria_jenis_rumah + '</td>'
          html_ideal_negatif += '</tr>'
          $('#table_ideal_negatif tbody').html(html_ideal_negatif)
          $('#table_ideal_negatif').DataTable();

          $('#table_list_penduduk').dataTable().fnDestroy();
          datatables();
          $.unblockUI();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          const statusCode = XMLHttpRequest.status;
          const responseJSON = XMLHttpRequest.responseJSON;
          console.log(statusCode);
          console.log(responseJSON)
          // if (statusCode != 500 || statusCode != 0) {
          //   toastr.error(responseJSON.message);
          // } else {
          //   toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
          // }
          // $.unblockUI();
        }
      })
    }
  </script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>