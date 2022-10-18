<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Kedisiplinan <?= $dinas ?> - <?= $header ?></title>

  <!-- Main Styles -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/styles/style.min.css">

  <!-- Material Design Icon -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material-design/css/materialdesignicons.css">

  <!-- mCustomScrollbar -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">

  <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

  <!-- Waves Effect -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugin/waves/waves.min.css">

  <!-- Sweet Alert -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/sweetalert/sweetalert.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets//images/favico/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets//images/favico/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets//images/favico/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets//images/favico/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets//images/favico/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets//images/favico/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets//images/favico/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets//images/favico/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets//images/favico/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/images/favico/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/images/favico/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/favico/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favico/<?= base_url() ?>assets/images/favico/favicon-16x16.png">

  <style type="text/css">
    .swal-modal .swal-text {
      text-align: center;
    }
  </style>

  <?php
  if ($header == "Halaman Karyawan" || $header == "Halaman Jam Kerja" || $header == "Halaman Utama" || $header == "Halaman Pengaturan Libur" || $header == "Halaman Pengaturan Perjalanan Dinas" || $header == "Halaman Laporan") { ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugin/datatables/media/css/dataTables.bootstrap.min.css">
    <style>
      .avatar {
        vertical-align: middle;
        width: 150px;
        height: 150px;
        border-radius: 50%;
      }
    </style>
  <?php
  }
  ?>

  <?php
  if ($header == "Halaman Pengaturan Libur" || $header == "Halaman Pengaturan Perjalanan Dinas") { ?>
    <link rel="stylesheet" href="<?= base_url() ?>assets/plugin/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <?php
  }
  ?>

</head>