  <!--/#wrapper -->
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
		<script src="assets/script/html5shiv.min.js"></script>
		<script src="assets/script/respond.min.js"></script>
	<![endif]-->
  <!-- 
	================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?= base_url() ?>assets/scripts/jquery.min.js"></script>
  <script src="<?= base_url() ?>assets/scripts/modernizr.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/nprogress/nprogress.js"></script>
  <script src="<?= base_url() ?>assets/plugin/sweet-alert/sweetalert.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/waves/waves.min.js"></script>

  <script src="<?= base_url() ?>assets/sweetalert/sweetalert.js"></script>
  <script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
  <script src="<?= base_url() ?>assets/block/jquery.blockUI.js"></script>
  <script src="<?= base_url() ?>assets/my_main.js"></script>
  <script src="<?= base_url() ?>assets/scripts/main.min.js"></script>

  <?php
  if ($this->session->flashdata('info')) { ?>
    <script>
      toastr.success("<?= $this->session->flashdata('info') ?>");
    </script>
  <?php
  }
  ?>

  