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
            <h4 class="box-title">Form Libur </h4>
            <form class="card-content" onsubmit="return tambah_libur(event)">
              <div class="form-group">
                <label for="tanggal_libur">Range Tanggal</label>
                <input type="text" name="tanggal_libur" class="form-control" value="" reqruied />
              </div>
              <div class="form-group">
                <label for="tanggal_libur">List Karyawan</label>
                <div class="row small-spacing" style="overflow-x: auto;">
                  <div class="col-xs-9">
                    <select multiple id="select_list_karyawan" class="form-control" onchange="check_dulu()" required>

                    </select>
                  </div>
                  <div class="col-xs-3">
                    <li class="checkbox">
                      <input type="checkbox" id="chk-2"><label for="chk-2">Semua</label>
                    </li>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="tanggal_libur">Keterangan</label>
                <textarea name="" id="ket" cols="30" rows="10" class="form-control" style="resize: none" placeholder="Keterangan Libur" required></textarea>
              </div>

              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-xs waves-effect waves-light">
                  Tambah Libur
                </button>
              </div>
            </form>

          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->



      </div>

      <div class="row small-spacing">
        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title">List Libur</h4>
            <div class="card-content">
              <div style="overflow-x: auto">
                <table id="table_list_libur" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Range Tanggal</th>
                      <th>List Karyawan</th>
                      <th>Created At</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <?php $this->load->view('admin/footer') ?>

    </div>
    <!-- /.main-content -->
  </div>

  <div class="modal fade" id="modal_informasi_libur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1">
    <div class="modal-dialog modal-lg" role="document">
      <form class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel-1"> Informasi Libur</h4>
          <!-- <p style="font-size: 10px;"><i>(Geserkan marker ke titik kordinat dinas)</i></p> -->
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nik">Range Tanggal</label>
            <input type="text" class="form-control" id="range_tanggal" disabled>
          </div>
          <div class="form-group">
            <label for="nik">List Karayawn</label>
            <textarea name="list_karyawan" class="form-control" id="list_karyawan" cols="30" rows="10" style="resize: none;" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="nama">Keterangan</label>
            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10" style="resize: none;" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="nama">Created At</label>
            <input type="text" class="form-control" id="created_at" disabled>
          </div>

        </div>

      </form>
    </div>
  </div>

  <?php $this->load->view('admin/scripts') ?>
  <!-- Select2 -->
  <script src="<?= base_url() ?>assets/plugin/select2/js/select2.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>

  <script>
    var table;

    function datatables() {
      table = $('#table_list_libur').DataTable({
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
          "url": server_url + "admin/libur",
          "type": "POST",
          data: {
            proses: 'table_libur'
          },

        },

        "columnDefs": [{
          "targets": [2, 4],
          "orderable": false,
        }, ],
      });
    }
    datatables()

    async function check_info(id_libur) {
      // console.log(id_libur)
      let data
      try {
        data = await $.ajax({
          url: server_url_api + "libur?id_libur=" + id_libur + "&id_dinas=" + id_dinas,
          type: 'get',
          async: false,
          beforeSend: function(res) {
            block_ui("Mengambil Data Informasi Libur");
          },
        });
        data = data.data
        console.log(data);

        await $.unblockUI();
        $("#range_tanggal").val(data.range_tanggal)
        $("#keterangan").val(data.ket)
        $("#list_karyawan").val(data.list_karyawan)
        $("#created_at").val(data.created_at)
        $('#modal_informasi_libur').modal('show');
      } catch (error) {
        await $.unblockUI();
        const statusCode = error.status;
        console.log(error)
        console.log(statusCode)
        if (statusCode == 0 || statusCode == 500) return toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");

        const message = error.responseJSON.message
        toastr.error(message);


      }
      // $('#modal_informasi_libur').modal('show');
    }
  </script>

  <script>
    var id_dinas = <?= $id_dinas ?>;
    let today = new Date().toLocaleDateString()
    let start_tanggal, end_tanggal

    // console.log(today)
    $(function() {
      $('input[name="tanggal_libur"]').daterangepicker({
        opens: 'left',
        minDate: today
      }, function(start, end, label) {
        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        start_tanggal = start.format('YYYY-MM-DD')
        end_tanggal = end.format('YYYY-MM-DD')
      });
    });


    let data_karyawan_count = 0;

    async function check_data_karyawan() {
      try {
        data = await $.ajax({
          url: server_url_api + "karyawanAll",
          type: 'get',
          async: false,
          beforeSend: function(res) {
            block_ui("Mengambil Data Karyawan");
          },
        });
        data = data.data
        // await $.unblockUI();
        const select_list_karyawan = document.getElementById("select_list_karyawan")
        data_karyawan_count = data.length;
        for (let i = 0; i < data.length; i++) {
          let option = document.createElement("option");
          option.value = data[i]['nik'];
          option.text = data[i]['nama'] + " - " + data[i]['nik'];
          select_list_karyawan.appendChild(option)
        }
        // console.log(data);
        await $.unblockUI();
      } catch (error) {
        await $.unblockUI();
        const statusCode = error.status;
        console.log(error)
        console.log(statusCode)
        if (statusCode == 0 || statusCode == 500) return toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");

        // const message = error.responseJSON.message
        toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");


      }
    }
    check_data_karyawan()

    $("#select_list_karyawan").select2({
      placeholder: " -Pilih Karyawan",
      allowClear: true
    });
    $("#chk-2").click(function() {
      if ($("#chk-2").is(':checked')) {
        console.log("ini checked")
        $("#select_list_karyawan > option").prop("selected", "selected");
        $("#select_list_karyawan").trigger("change");
      } else {
        console.log("ini dischecked")
        $("#select_list_karyawan").val('').change();
      }
    });

    function check_dulu() {
      // console.log("sini check dulu");
      const count = $("#select_list_karyawan option:selected").length;
      if (count == data_karyawan_count) {
        document.getElementById("chk-2").checked = true
      } else {
        document.getElementById("chk-2").checked = false
      }
    }


    function tambah_libur(e) {
      e.preventDefault();
      // console.log("sini tambah libur")
      // console.log(start_tanggal,end_tanggal)
      const list_karyawan = $("#select_list_karyawan").val();
      const ket = $("#ket").val();
      // console.log(ket);
      let data = new FormData()
      data.append('id_dinas', id_dinas)
      data.append('list_karyawan', JSON.stringify(list_karyawan))
      data.append('start_tanggal', start_tanggal)
      data.append('end_tanggal', end_tanggal)
      data.append('ket', ket)

      swal({
        text: `Informasi Libur Akan Ditambah ?`,
        icon: "info",
        buttons: {
          cancel: true,
          confirm: true,
        },
        // dangerMode: true,
      }).then((yes) => {
        $.ajax({
          url: server_url_api + "libur",
          type: 'post',
          contentType: false,
          processData: false,
          data,
          beforeSend: function(res) {
            // $('#modal_karyawan').modal('hide');
            block_ui("Menambah Libur");
          },
          success: function(response) {
            $.unblockUI();
            // window.location.reload();
            console.log(response)
            // $('#table_list_libur').dataTable().fnDestroy();
            // datatables()
            $("#select_list_karyawan").val('').change();
            $("#ket").val("")
            $('#table_list_libur').dataTable().fnDestroy();
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
            if (statusCode != 500 && statusCode != 0) {
              toastr.error(responseJSON.message);
            } else {
              toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
            }


          }
        });
      })

    }
  </script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>