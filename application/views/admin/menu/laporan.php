<!DOCTYPE html>
<html lang="en">


<?php $this->load->view("admin/header"); ?>

<body>

  <?php $this->load->view("admin/side_topbar"); ?>

  <div id="wrapper">
    <div class="main-content">
      <div class="row small-spacing">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
          <div class="box-content card">
            <h4 class="box-title">Filter Laporan </h4>
            <!-- /.dropdown js__dropdown -->

            <!-- /#flot-chart-1.flot-chart -->
          </div>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->
        <div class="col-xs-2"></div>



      </div>

      <div class="row small-spacing">
        <div class="col-xs-12">
          <div class="box-content card">
            <h4 class="box-title">Laporan Absensi Bulan <?= $month ?>, Tahun <?= $year ?></h4>

            <div class="card-content">
              <div style="overflow-x: auto;" class="form-group">
                <table id="example" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Nama / NIP</th>
                      <th>Jabatan</th>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Jam Masuk</th>
                      <th>Jam Istirehat</th>
                      <th>Jam Masuk Kembali</th>
                      <th>Jam Pulang</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    for ($i = $first_date; $i <= $last_date; $i++) {

                      foreach ($list_karyawan as $key => $value) {
                        $tanggal = strlen($i) == 1 ? "0" . $i : $i;
                        // echo
                        $CI = &get_instance();
                        $CI->load->model('model');
                        $check_absensi = $CI->model->tampil_data_where('tb_absensi_karyawan', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

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

                        $check_libur = $CI->model->tampil_data_where('tb_informasi_libur', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

                        if (count($check_libur) > 0) {
                          $status = "Libur";
                          $idnya = $check_libur[0]->id_libur;
                        }

                        $check_perjalanan_dinas = $CI->model->tampil_data_where('tb_informasi_perjalanan_dinas', ['nik' => $value->nik, "tanggal" => $year . "-" . $month . "-" . $tanggal])->result();

                        if (count($check_perjalanan_dinas) > 0) {
                          $status = "Perjalanan Dinas";
                          $idnya = $check_perjalanan_dinas[0]->id_perjalanan_dinas;
                        }

                    ?>
                        <tr>
                          <td><?= $value->nama ?> / <?= $value->nik ?> </td>
                          <td><?= $value->jabatan ?></td>
                          <td><?= $tanggal ?>-<?= $month ?>-<?= $year ?></td>
                          <td><?= $status ?></td>
                          <td><?= $jam_masuk ?></td>
                          <td><?= $jam_istirehat ?></td>
                          <td><?= $jam_masuk_kembali ?></td>
                          <td><?= $jam_pulang ?></td>
                          <td>
                            <?php
                            if ($status == 'Libur' || $status == "Perjalanan Dinas") {
                            ?>
                              <center><button type='button' onclick='check_info("<?= $status ?>" ,<?= $idnya ?>)' title='Check Informasi <?= $status ?>' class='btn btn-primary btn-circle btn-sm waves-effect waves-light'><i class='ico zmdi zmdi-info-outline'></i></button></center>
                            <?php
                            } else {
                              echo "-";
                            }
                            ?>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>

                </table>
              </div>

              <div class="form-group text-center">
                <div id="iframeDisplay"></div>
                <button type="button" id="button_cetak" class="btn btn-primary btn-xs waves-effect waves-light" onclick="displayIframe()">Cetak Laporan</button>
              </div>
            </div>

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

  <div class="modal fade" id="modal_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" >
      <div class="modal-content">
       
      </div>
    </div>
  </div>

  <?php $this->load->view('admin/scripts') ?>

  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      var groupColumn = 2;
      var table = $('#example').DataTable({
        columnDefs: [{
          visible: false,
          targets: groupColumn
        }],
        order: [
          [groupColumn, 'asc']
        ],
        displayLength: 25,
        drawCallback: function(settings) {
          var api = this.api();
          var rows = api.rows({
            page: 'current'
          }).nodes();
          var last = null;

          api
            .column(groupColumn, {
              page: 'current'
            })
            .data()
            .each(function(group, i) {
              if (last !== group) {
                $(rows)
                  .eq(i)
                  .before('<tr class="group text-center"><td colspan="8">' + group + '</td></tr>');

                last = group;
              }
            });
        },
      });

      // Order by the grouping
      $('#example tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
          table.order([groupColumn, 'desc']).draw();
        } else {
          table.order([groupColumn, 'asc']).draw();
        }
      });
    });
  </script>

  <script>
    async function check_info(stat, id) {
      console.log(stat, id)
    }

    function displayIframe() {
      document.getElementById("iframeDisplay").innerHTML = "<iframe src=\"../HtmlPage1.html\" height=\"200\" width=\"300\" ></iframe>";

    }
  </script>


</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>