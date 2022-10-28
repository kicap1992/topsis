<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Sistem Bantuan Sosial Tunai Dinas Sosial, Pariwisata dan Kebudayaan Pinrang - Halaman Login</title>
	<link rel="stylesheet" href="<?= base_url() ?>assets/styles/style.min.css">

	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets<?= base_url() ?>assets/images/favico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() ?>assets/images/favico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/images/favico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/favico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favico/<?= base_url() ?>assets/images/favico/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/favico/<?= base_url() ?>assets/images/favico/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/sweetalert/sweetalert.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/toastr/toastr.min.css">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugin/waves/waves.min.css">

</head>

<body>

	<div id="single-wrapper">
		<form action="#" class="frm-single" onsubmit="return login(event)">
			<div class="inside">
				<div class="title">Sistem Bantuan Sosial Tunai </div>
				<!-- /.title -->
				<div class="frm-title">Dinas Sosial, Pariwisata dan Kebudayaan Kabupaten Pinrang </div>
				<!-- /.frm-title -->
				<div class="frm-input"><input type="text" placeholder="Username" class="frm-inp" id="username" required><i class="fa fa-user frm-ico"></i></div>
				<!-- /.frm-input -->
				<div class="frm-input"><input type="password" placeholder="Password" class="frm-inp" id="password" required><i class="fa fa-lock frm-ico"></i></div>
				<!-- /.frm-input -->

				<button type="submit" class="frm-submit">Login<i class="fa fa-arrow-circle-right"></i></button>

				<div class="frm-footer">Airlangga IT © 2022.</div>
				<!-- /.footer -->
			</div>
			<!-- .inside -->
		</form>
		<!-- /.frm-single -->
	</div>
	<!--/#single-wrapper -->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="<?= base_url() ?>assets/script/html5shiv.min.js"></script>
		<script src="<?= base_url() ?>assets/script/respond.min.js"></script>
	<![endif]-->
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?= base_url() ?>assets/scripts/jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/scripts/modernizr.min.js"></script>
	<script src="<?= base_url() ?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/plugin/nprogress/nprogress.js"></script>
	<script src="<?= base_url() ?>assets/plugin/waves/waves.min.js"></script>

	<script src="<?= base_url() ?>assets/sweetalert/sweetalert.js"></script>
	<script src="<?= base_url() ?>assets/toastr/toastr.min.js"></script>
	<script src="<?= base_url() ?>assets/block/jquery.blockUI.js"></script>
	<script src="<?= base_url() ?>assets/my_main.js"></script>
	<script src="<?= base_url() ?>assets/scripts/main.min.js"></script>
	<script>
		var datanya = $.ajax({
			url: server_url_api ,
			type: 'get',
			// data: {id_pengembang : $("#id_pengembang").val()},
			async: false,
		})
		console.log(datanya)
		async function login(e) {
			e.preventDefault();
			const username = $("#username").val();
			const password = $("#password").val();


			// block_ui("coba");

			$.ajax({
				url: server_url_api + "login_admin?username=" + username + "&password=" + password,
				type: 'get',
				beforeSend: function(res) {

					block_ui("Sedang Login");
				},
				success: function(response) {
					// $.unblockUI();
					// swal({
					// 	title: "Success",
					// 	text: "Anda Berhasil Login",
					// 	icon: "success",
					// 	buttons: {
					// 		cancel: false,
					// 		confirm: false,
					// 	},
					// 	timer: 2000
					// 	// dangerMode: true,
					// })
					// delay(1500)
					window.location.replace(server_url + "admin")
					// console.log(response)
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$.unblockUI();
					// console.log(errorThrown)
					// console.log(textStatus)
					const statusCode = XMLHttpRequest.status;
					const responseJSON = XMLHttpRequest.responseJSON;
					// console.log(statusCode);
					// console.log(responseJSON)
					if (statusCode == 400) {
						toastr.error(responseJSON.message);
					} else {
						toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
					}



				}
			});
		}
		// block_ui("coba");
	</script>
</body>

<!-- Dibuat oleh kicap karan. https://www.kicap-karan.com -->

</html>