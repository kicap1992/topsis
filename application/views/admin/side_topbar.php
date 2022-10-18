<div class="main-menu">
		<header class="header">
			<a href="<?= base_url("admin") ?>" class="logo"></i><?= $level ?></a>
			<button type="button" class="button-close fa fa-times js__menu_close"></button>
			<div class="user">
				<a href="#" class="avatar"><img src="<?= base_url() ?>assets/images/avatar-sm-5.jpg" alt=""><span class="status online"></span></a>
				<h5 class="name"><a href="3"><?= $nama ?></a></h5>
				<h5 class="position"><?= $level ?></h5>
				<!-- /.name -->

			</div>
			<!-- /.user -->
		</header>
		<!-- /.header -->
		<div class="content">

			<div class="navigation">
				<h5 class="title">Navigasi</h5>
				<!-- /.title -->
				<ul class="menu js__accordion">
					<li <?php if($header == "Halaman Utama"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin") ?>"><i class="menu-icon mdi mdi-view-dashboard"></i><span>Halaman Utama</span></a>
					</li>
					<li <?php if($header == "Halaman Jam Kerja"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/jam_kerja") ?>"><i class="menu-icon fa fa-clock-o"></i><span>Halaman Jam Kerja</span></a>
					</li>
					<li <?php if($header == "Halaman Pengaturan Libur"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/libur") ?>"><i class="menu-icon fa fa-calendar"></i><span>Pengaturan Libur</span></a>
					</li>
					<li <?php if($header == "Halaman Pengaturan Perjalanan Dinas"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/perjalanan_dinas") ?>"><i class="menu-icon fa fa-calendar"></i><span>Perjalanan Dinas</span></a>
					</li>
					<li <?php if($header == "Halaman Pengaturan Lokasi Dinas"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/pengaturan") ?>"><i class="menu-icon mdi mdi-desktop-mac"></i><span>Pengaturan Lokasi Dinas</span></a>
					</li>
					<li <?php if($header == "Halaman Karyawan"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/karyawan") ?>"><i class="menu-icon zmdi zmdi-accounts-alt"></i><span>Halaman Karyawan</span></a>
					</li>
					<li <?php if($header == "Halaman Laporan"){echo 'class="current"';} ?>>
						<a class="waves-effect" href="<?= base_url("admin/laporan") ?>"><i class="menu-icon zmdi zmdi-comment-list"></i><span>Halaman Laporan</span></a>
					</li>
					<li >
						<a class="waves-effect" href="<?= base_url("admin/logout") ?>"><i class="menu-icon mdi mdi-logout"></i><span>Logout</span></a>
					</li>
				</ul>
				<!-- /.menu js__accordion -->
				
			</div>
			<!-- /.navigation -->
		</div>
		<!-- /.content -->
	</div>
	<!-- /.main-menu -->

	<div class="fixed-navbar">
		<div class="pull-left">
			<button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
			<h1 class="page-title"><?= $header ?></h1>
			<!-- /.page-title -->
		</div>
		<!-- /.pull-left -->
		<div class="pull-right">
			
			<a href="#" class="ico-item mdi mdi-logout"></a>
		</div>
		<!-- /.pull-right -->
	</div>
	<!-- /.fixed-navbar -->