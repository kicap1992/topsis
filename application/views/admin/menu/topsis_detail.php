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
            <h4 class="box-title" id="header_absensi">Detail Kriteria Penduduk</h4>

            <div class="card-content">
              <!-- create input below like umur, pekerjaan, penghasilan , jumlah tanggungan dan jenis rumah -->
              <form class="form-horizontal" onsubmit="return cek_status_bantuan_sosial(event)">
                <div class="form-group">
                  <label class="col-sm-2 control-label">NIK</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nik" name="nik" value="<?= $nik ?>" placeholder="NIK" disabled>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" placeholder="Nama" disabled>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Umur</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="umur" name="umur" value="<?= $umur ?>" placeholder="Umur" disabled>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label for="pekerjaan" class="col-sm-2 control-label">Pekerjaan</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="pekerjaan" name="pekerjaan" required>
                      <option value='' selected disabled>-Pilih Pekerjaan</option>
                      <option value="1">PNS</option>
                      <option value="2">Wiraswasta</option>
                      <option value="3">Petani</option>
                      <option value="4">Buruh</option>
                    </select>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label for="penghasilan" class="col-sm-2 control-label">Penghasilan</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="penghasilan" name="penghasilan" required>
                      <option value='' selected disabled>-Pilih Penghasilan</option>
                      <option value="4">Kurang dari Rp. 3.000.000</option>
                      <option value="3">Rp. 3.000.000 - Rp. 5.000.000</option>
                      <option value="2">Rp. 5.000.000 - Rp. 8.000.000</option>
                      <option value="1">Lebih dari Rp. 8.000.000</option>
                    </select>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label for="jumlah_tanggungan" class="col-sm-2 control-label">Jumlah Tanggungan</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="jumlah_tanggungan" name="jumlah_tanggungan" required>
                      <option value='' selected disabled>-Pilih Tanggungan</option>
                      <option value="1">Tiada</option>
                      <option value="2">Kurang dari 3</option>
                      <option value="3">3 - 5</option>
                      <option value="4">Lebih dari 5</option>
                    </select>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label for="jenis_rumah" class="col-sm-2 control-label">Jenis Rumah</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="jenis_rumah" name="jenis_rumah" required>
                      <option value='' selected disabled>-Pilih Jenis Rumah</option>
                      <option value="1">Rumah Sendiri</option>
                      <option value="3">Rumah Sewa</option>
                      <option value="4">Rumah Kontrak</option>
                      <option value="2">Rumah Keluarga</option>
                    </select>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-xs waves-effect waves-light" id="btn_simpan">Masukkan Detail Kriteria</button>
                </div>
              </form>


            </div>
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->

      </div>
      <!-- /.row -->

      <div class="row small-spacing">
        <!-- /.col-xs-12 -->

        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title" id="header_absensi">Status Bantuan</h4>

            <div class="card-content">
              


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

  <?php $this->load->view('admin/scripts') ?>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>


  <script>
    var data_lama;


    async function cek_data(){
      const nik = $('#nik').val();
      let data
      try {
        data = await $.ajax({
					url: server_url_api + "topsis?nik=" + nik,
					type: 'get',
					async: false,
					beforeSend: function(res) {
						block_ui("Mengambil Data Kriteria");
					},
				});
        data = data.data
        data_lama = data
        console.log(data)
        if(data != null){
          $("#pekerjaan").val(data.bobot_pekerjaan)
          $("#penghasilan").val(data.bobot_penghasilan)
          $("#jumlah_tanggungan").val(data.bobot_jumlah_tanggungan)
          $("#jenis_rumah").val(data.bobot_jenis_rumah)
          $("#btn_simpan").html("Update Detail Kriteria")
        }
        await $.unblockUI();
      } catch (error) {
        await $.unblockUI();
				const statusCode = error.status;
				console.log(error)
				console.log(statusCode)
				if (statusCode == 0 || statusCode == 500) return toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");

				const message = error.responseJSON.message
				toastr.error(message);
      }
    }
    cek_data()

    function cek_status_bantuan_sosial(e) {
      e.preventDefault();
      const nik = $('#nik').val();
      const umur = $('#umur').val();
      const bobot_pekerjaan = $('#pekerjaan').val();
      const bobot_penghasilan = $('#penghasilan').val();
      const bobot_jumlah_tanggungan = $('#jumlah_tanggungan').val();
      const bobot_jenis_rumah = $('#jenis_rumah').val();
      var bobot_umur
      if (umur < 25) {
        bobot_umur = 1
      } else if (umur >= 25 && umur <= 35) {
        bobot_umur = 2
      } else if (umur >= 36 && umur <= 45) {
        bobot_umur = 3
      } else if (umur >= 46) {
        bobot_umur = 4
      }

      $.ajax({
        url: server_url_api + "topsis",
        type: 'POST',
        dataType: 'json',
        data: {
          nik: nik,
          bobot_umur: bobot_umur,
          bobot_pekerjaan: bobot_pekerjaan,
          bobot_penghasilan: bobot_penghasilan,
          bobot_jumlah_tanggungan: bobot_jumlah_tanggungan,
          bobot_jenis_rumah: bobot_jenis_rumah
        },
        beforeSend: function(res) {
          // block_ui("Loading Status Bantuan Menggunakan Metode Topsis");
        },
        success: function(data) {
          console.log(data)
          $.unblockUI();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          const statusCode = XMLHttpRequest.status;
          const responseJSON = XMLHttpRequest.responseJSON;
          console.log(statusCode);
          console.log(responseJSON)
          if (statusCode != 500 || statusCode != 0) {
            toastr.error(responseJSON.message);
          } else {
            toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
          }
          $.unblockUI();
        }
      })
    }
  </script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>