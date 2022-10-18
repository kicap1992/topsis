<!DOCTYPE html>
<html lang="en">


<?php $this->load->view("admin/header"); ?>

<body>

  <?php $this->load->view("admin/side_topbar"); ?>

  <div id="wrapper">
    <div class="main-content">
      <div class="row small-spacing">
        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title">List Hari Jam Kerja</h4>
            <!-- /.dropdown js__dropdown -->
            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_list_hari" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Hari</th>
                      <th>Jam Masuk</th>
                      <th>Jam Istirehat</th>
                      <th>Jam Masuk Kembali</th>
                      <th>Jam Pulang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody style="text-align: center;">
                    <tr id="senin">
                      <td class="harinya">Senin</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('senin')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="selasa">
                      <td class="harinya">Selasa</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('selasa')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="rabu">
                      <td class="harinya">Rabu</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('rabu')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="kamis">
                      <td class="harinya">Kamis</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('kamis')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="jumat">
                      <td class="harinya">Jumat</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('jumat')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="sabtu">
                      <td class="harinya">Sabtu</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('sabtu')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                    <tr id="ahad">
                      <td class="harinya">Ahad</td>
                      <td class="jam_masuk">-</td>
                      <td class="jam_istirehat">-</td>
                      <td class="jam_masuk_kembali">-</td>
                      <td class="jam_pulang">-</td>
                      <td><button type='button' onclick="edit_hari_kerja('ahad')" title='Edit Detail Karyawan' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico fa fa-edit'></i></button></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <br>
            </div>

            <!-- /#flot-chart-1.flot-chart -->
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->



      </div>
      <!-- /.row -->

      <?php $this->load->view('admin/footer') ?>

    </div>
    <!-- /.main-content -->
  </div>

  <div class="modal fade" id="modal_jam_kerja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <form class="modal-content" onsubmit="return edit_jam_kerja(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel-1"></h4>
          <!-- <p style="font-size: 10px;"><i>(Geserkan marker ke titik kordinat dinas)</i></p> -->
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nik">Jam Masuk</label>
            <input type="hidden" id="hari">
            <input type="time" class="form-control" id="jam_masuk" required>
          </div>
          <div class="form-group">
            <label for="nik">Jam Istirehat</label>
            <input type="time" class="form-control" id="jam_istirehat" required>
          </div>
          <div class="form-group">
            <label for="nik">Jam Masuk Kembali</label>
            <input type="time" class="form-control" id="jam_masuk_kembali" required>
          </div>
          <div class="form-group">
            <label for="nik">Jam Pulang</label>
            <input type="time" class="form-control" id="jam_pulang" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-xs waves-effect waves-light">Simpan Perubahan</button>
          <button type="button" class="btn btn-danger btn-xs waves-effect waves-light" data-dismiss="modal">Batalkan</button>
        </div>
      </form>
    </div>
  </div>

  <?php $this->load->view('admin/scripts') ?>

  <!-- <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script> -->

  <script>
    var id_dinas = <?= $id_dinas ?>;
    var all_data = [];

    async function get_all_data() {
      let data;
      try {
        data = await $.ajax({
          url: server_url_api + "jam_kerja?id_dinas=" + id_dinas,
          type: 'get',
          async: false,
          beforeSend: function(res) {
            block_ui("Mengambil Data Jam Kerja");
          },
        });
        data = data.data
        all_data = data
        data.forEach((item, index) => {
          $("#table_list_hari #" + item['hari'] + " .jam_masuk").html(tConvert(item['jam_masuk']))
          $("#table_list_hari #" + item['hari'] + " .jam_istirehat").html(tConvert(item['jam_istirehat']))
          $("#table_list_hari #" + item['hari'] + " .jam_masuk_kembali").html(tConvert(item['jam_masuk_kembali']))
          $("#table_list_hari #" + item['hari'] + " .jam_pulang").html(tConvert(item['jam_pulang']))
        })
        // data_karyawan = data;
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
    get_all_data();

    function edit_hari_kerja(hari) {
      // console.log(all_data)
      $("#hari").val(null)
      $("#jam_masuk").val(null)
      $("#jam_istirehat").val(null)
      $("#jam_masuk_kembali").val(null)
      $("#jam_pulang").val(null)
      all_data.forEach((item, index) => {
        if (item['hari'] == hari) {
          const jam_masuk = $("#jam_masuk").val(item['jam_masuk'])
          const jam_istirehat = $("#jam_istirehat").val(item['jam_istirehat'])
          const jam_masuk_kembali = $("#jam_masuk_kembali").val(item['jam_masuk_kembali'])
          const jam_pulang = $("#jam_pulang").val(item['jam_pulang'])
        }

      })
      $(".modal .modal-title").html(`Jam Kerja Hari ${uppercaseWord(hari)}`)
      $("#hari").val(hari)
      $('#modal_jam_kerja').modal('show');
      console.log(hari)
    }

    function edit_jam_kerja(e) {
      e.preventDefault()
      const hari = $("#hari").val()
      const jam_masuk = $("#jam_masuk").val()
      const jam_istirehat = $("#jam_istirehat").val()
      const jam_masuk_kembali = $("#jam_masuk_kembali").val()
      const jam_pulang = $("#jam_pulang").val()

      if (jam_masuk >= jam_istirehat && jam_masuk >= jam_masuk_kembali && jam_masuk >= jam_pulang) return toastr.error("Jam Karja Harus Berurutan Dari Jam Masuk Sampai Jam Pulang Dan Tidak Bisa Sama");
      if (jam_istirehat >= jam_masuk_kembali && jam_istirehat >= jam_pulang) return toastr.error("Jam Karja Harus Berurutan Dari Jam Masuk Sampai Jam Pulang Dan Tidak Bisa Sama");
      if (jam_masuk_kembali >= jam_pulang) return toastr.error("Jam Karja Harus Berurutan Dari Jam Masuk Sampai Jam Pulang Dan Tidak Bisa Sama");

      let cari_data = null;
      for (const data of all_data) {
        if (data['hari'] == hari) {
          cari_data = data;
        }
      }

      if (cari_data != null) {
        if (cari_data['jam_masuk'] == jam_masuk && cari_data['jam_istirehat'] == jam_istirehat && cari_data['jam_masuk_kembali'] == jam_masuk_kembali && cari_data['jam_pulang'] == jam_pulang) return toastr.error("Tiada Perubahan Data Yang Dilakukan");
      }

      swal({
        text: `Edit Jam Kerja\nHari ${hari} ?`,
        icon: "info",
        buttons: {
          cancel: true,
          confirm: true,
        },
        // dangerMode: true,
      }).then((yes) => {
        if (yes) {
          // console.log("tambah karyawan",nik,nama,jabatan,alamat)
          $.ajax({
            url: server_url_api + "jam_kerja",
            type: 'post',
            data: {
              id_dinas: id_dinas,
              hari: hari,
              jam_masuk: jam_masuk,
              jam_istirehat: jam_istirehat,
              jam_masuk_kembali: jam_masuk_kembali,
              jam_pulang: jam_pulang,
            },
            beforeSend: function(res) {
              $('#modal_jam_kerja').modal('hide');
              block_ui("Menyimpan Perunahan Jam Kerja");
            },
            success: function(response) {
              $.unblockUI();
              // window.location.reload();
              console.log(response)
              get_all_data()
              // $('#table_list_karyawan').dataTable().fnDestroy();
              // datatables()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $.unblockUI();
              // console.log(errorThrown)
              // console.log(textStatus)
              const statusCode = XMLHttpRequest.status;
              const responseJSON = XMLHttpRequest.responseJSON;
              console.log(statusCode);
              console.log(responseJSON)
              if (statusCode != 500 || statusCode != 0) {
                toastr.error(responseJSON.message);
              } else {
                toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
              }


            }
          });
        }
      });

      // console.log("sini edit jam kerja");
    }
  </script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>