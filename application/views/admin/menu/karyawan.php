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
            <h4 class="box-title">List Karyawan </h4>
            <!-- /.dropdown js__dropdown -->
            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_list_karyawan" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>No Telpon</th>
                      <th>Jabatan</th>
                      <th>Pangkat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                </table>
              </div>
              <br>
              <div class="form-group text-center">
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" onclick="buka_modal_tambah()">Tambah Karyawan</button>
              </div>
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

  <div class="modal fade" id="modal_karyawan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <form class="modal-content" onsubmit="return tambah_edit(event)">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel-1"></h4>
          <!-- <p style="font-size: 10px;"><i>(Geserkan marker ke titik kordinat dinas)</i></p> -->
        </div>
        <div class="modal-body">
          <div class="form-group text-center" id="div_img" style="display: none;">
            <img src="" class="avatar" id="img_container" />
          </div>
          <div class="form-group">
            <label for="nik">Foto</label>
            <input type="file" class="form-control" id="foto" required="true">
          </div>
          <div class="form-group">
            <label for="nik">NIP Karyawan</label>
            <input type="hidden" id="status_form">
            <input type="text" class="form-control" id="nik" placeholder="Masukkan NIK Karyawan" minlength="16" maxlength="16" onkeypress="return isNumberKey(event)" required>
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Karyawan" required>
          </div>
          <div class="form-group">
            <label for="nama">No Telepon</label>
            <input type="text" class="form-control" id="no_telpon" placeholder="Masukkan No Telepon Karyawan" minlength="11" maxlength="13" onkeypress="return isNumberKey(event)" required>
          </div>
          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" placeholder="Masukkan Jabatan Karyawan" required>
          </div>
          <div class="form-group">
            <label for="pangkat">Pangkat</label>
            <select name="pangkat" id="pangkat" class="form-control" required>
              <option value="" disabled selected>-Pilih Pangkat</option>
              <option value="Tiada">Tiada</option>
              <option value="I A">I A</option>
              <option value="I B">I B</option>
              <option value="I C">I C</option>
              <option value="I D">I D</option>
              <option value="II A">II A</option>
              <option value="II B">II B</option>
              <option value="II C">II C</option>
              <option value="II D">II D</option>
              <option value="III A">III A</option>
              <option value="III B">III B</option>
              <option value="III C">III C</option>
              <option value="III D">III D</option>
              <option value="IV A">IV A</option>
              <option value="IV B">IV B</option>
              <option value="IV C">IV C</option>
              <option value="IV D">IV D</option>
            </select>
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
              <option value="" disabled selected>-Pilih Status</option>
              <option value="PNS" >PNS</option>
              <option value="Kontrak" >Kontrak</option>
            </select>
          </div>
          <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" required>
          </div>
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" style="resize: none;" placeholder="Masukkan Alamat" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="button_simpan_edit" class="btn btn-primary btn-xs waves-effect waves-light"></button>
          <button type="button" class="btn btn-danger btn-xs waves-effect waves-light" data-dismiss="modal">Batalkan</button>
        </div>
      </form>
    </div>
  </div>

  <?php $this->load->view('admin/scripts') ?>

  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>

  <script async>
    var id_dinas = <?= $id_dinas ?>;

    var data_karyawan;

    var table;

    function datatables() {
      table = $('#table_list_karyawan').DataTable({
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
          "url": server_url + "admin/karyawan",
          "type": "POST",
          data: {
            proses: 'table_karyawan'
          },

        },

        "columnDefs": [{
          "targets": [0],
          "orderable": false,
        }, ],
      });
    }
    datatables()

    document.getElementById("foto").onchange = function() {
      let foto_produk = document.getElementById('foto').files[0];
      check_file(foto_produk)
    }

    function buka_modal_tambah() { // buka modal untuk tambah karyawan
      $(".modal-title").html("Form Tambah Karyawan")
      $("#status_form").val("tambah")
      $("#button_simpan_edit").html("Tambah Karyawan")
      $("#nik").val(null)
      $("#foto").val(null)
      $("#nama").val(null)
      $("#no_telpon").val(null)
      $("#jabatan").val(null)
      $("#alamat").html(null)
      $("#tanggal_lahir").val(null)
      $("#nik").attr("disabled", false)
      $("#foto").attr('required', true)
      $("#div_img").attr('style', "display : none")
      selectElement('pangkat', '');
      selectElement('status', '');
      $('#modal_karyawan').modal('show');
    }

    async function karyawan_edit(nik) {
      // console.log(nik);
      $(".modal-title").html("Form Edit Karyawan")
      $("#status_form").val("edit")
      $("#button_simpan_edit").html("Edit Karyawan")
      $("#foto").attr('required', false)
      $("#foto").val(null)
      $("#div_img").removeAttr("style")


      let data;
      try {
        data = await $.ajax({
          url: server_url_api + "karyawan?nik=" + nik + "&id_dinas=" + id_dinas,
          type: 'get',
          async: false,
          beforeSend: function(res) {
            block_ui("Mengambil Data Karyawan");
          },
        });
        data = data.data
        data_karyawan = data;
        await $.unblockUI();
        $("#nik").val(data.nik)
        $("#nama").val(data.nama)
        $("#no_telpon").val(data.no_telpon)
        $("#jabatan").val(data.jabatan)
        $("#tanggal_lahir").val(data.tanggal_lahir)
        $("#alamat").html(data.alamat)
        $("#nik").attr("disabled", true)
        $("#img_container").attr("src", server_url + data.image)
        selectElement('pangkat', data.pangkat);
        selectElement('status', data.status);
        $('#modal_karyawan').modal('show');
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

    function tambah_edit(e) {
      e.preventDefault();
      const status_form = $("#status_form").val()

      const foto = document.getElementById('foto').files[0]
      const nik = $("#nik").val()
      const nama = $("#nama").val()
      const no_telpon = $("#no_telpon").val()
      const jabatan = $("#jabatan").val()
      const alamat = $("#alamat").val()
      const pangkat = $("#pangkat").val()
      const status = $("#status").val()
      const tanggal_lahir = $("#tanggal_lahir").val()

      // console.log(pangkat,status,tanggal_lahir)
      let data = new FormData()
      data.append('nik', nik)
      data.append('proses', status)
      data.append('foto', foto == undefined ? 'tiada' : foto)
      data.append('nama', nama)
      data.append('no_telpon', no_telpon)
      data.append('jabatan', jabatan)
      data.append('alamat', alamat)
      data.append('id_dinas', id_dinas)
      data.append('status_form', status_form)
      data.append('pangkat', pangkat)
      data.append('status', status)
      data.append('tanggal_lahir', tanggal_lahir)
      if (status_form == "tambah") {

        swal({
          text: `Tambah Karyawan Dengan\nNIK : ${nik},\nNama : ${nama}`,
          icon: "info",
          buttons: {
            cancel: true,
            confirm: true,
          },
          // dangerMode: true,
        }).then((yes) => {
          if (yes) {
            // console.log("tambah karyawan", nik, nama, jabatan, alamat)
            $.ajax({
              url: server_url_api + "karyawan",
              type: 'post',
              contentType: false,
              processData: false,
              data,
              beforeSend: function(res) {
                $('#modal_karyawan').modal('hide');
                block_ui("Menambah Karyawan");
              },
              success: function(response) {
                $.unblockUI();
                // window.location.reload();
                console.log(response)
                $('#table_list_karyawan').dataTable().fnDestroy();
                datatables()
                toastr.success(response.message);
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
      }

      if (status_form == 'edit') {
        // console.log(nik,nama,no_telpon,jabatan,alamat)
        // if (nik == data_karyawan.nik && nama == data_karyawan.nama && no_telpon == data_karyawan.no_telpon && jabatan == data_karyawan.jabatan && alamat == data_karyawan.alamat) return toastr.warning("Tiada Perubahan Data Karyawan");

        // console.log("sini berlaku edit")

        swal({
          text: `Edit Data Karyawan ?`,
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
              url: server_url_api + "karyawan",
              type: 'post',
              contentType: false,
              processData: false,
              data,
              beforeSend: function(res) {
                $('#modal_karyawan').modal('hide');
                block_ui("Edit Data Karyawan");
              },
              success: function(response) {
                $.unblockUI();
                // window.location.reload();
                $('#table_list_karyawan').dataTable().fnDestroy();
                datatables()
                // console.log(response)
                toastr.success(response.message);
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
      }
      // console.log("sini tambah atau edit", status)
    }

    function hapus_karyawan(nik) {
      // console.log(nik)
      swal({
        text: `Hapus Data Karyawan Dengan\nNIK : ${nik}\n?`,
        icon: "warning",
        dangerMode: true,
        buttons: {
          cancel: true,
          confirm: true,
        },
        // dangerMode: true,
      }).then((yes) => {
        if (yes) {
          // console.log("hapus karyawan")
          $.ajax({
            url: server_url_api + "karyawan",
            type: 'delete',
            data: {
              id_dinas: id_dinas,
              nik: nik,
            },
            beforeSend: function(res) {
              $('#modal_karyawan').modal('hide');
              block_ui("Hapus Karyawan");
            },
            success: function(response) {
              $.unblockUI();
              // window.location.reload();
              $('#table_list_karyawan').dataTable().fnDestroy();
              datatables()
              console.log(response)
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

    }
  </script>


</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>