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
							<button type="button" class="btn btn-primary btn-xs" onclick="tambah_penduduk()">
								<i class="fa fa-plus"></i> Tambah Penduduk
							</button>
							<br /> <br />
							<div style="overflow-x: auto">
								<table id="table_list_penduduk" class="table table-striped table-bordered display" style="width:100%">
									<thead>
										<tr>
											<th>NIK</th>
											<th>Nama</th>
											<th>Umur</th>
											<th>No HP</th>
											<th>Jenis Kelamin</th>
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
					"url": server_url + "admin/",
					"type": "POST",
					data: {
						proses: 'table_penduduk'
					},

				},

				"columnDefs": [{
					"targets": [5],
					"orderable": false,
				}, ],
			});
		}
		datatables()

		function tambah_penduduk() {
			// enable nik
			$('#nik').prop('disabled', false);
			// hide button update
			$('#btn_update_penduduk').hide();
			// show button simpan
			$('#btn_add_penduduk').show();
			// clear all input in modal
			// status tambah
			$('#status').val('tambah');
			$('#form_add_penduduk').trigger('reset')
			$('#modal_add_penduduk').modal('show')
			$('#modal_add_penduduk').find('.modal-title').text('Tambah Penduduk')

		}

		async function edit_penduduk(nik) {
			// disable nik
			$('#nik').attr('disabled', true)
			// show button update
			$('#btn_update_penduduk').show();
			// hide button simpan
			$('#btn_add_penduduk').hide();
			// clear all input in modal
			// status edit
			$('#status').val('edit');
			$('#form_add_penduduk').trigger('reset')
			$('#modal_add_penduduk').modal('show')
			$('#modal_add_penduduk').find('.modal-title').text('Edit Penduduk')

			let data;
			try {
				data = await $.ajax({
					url: server_url_api + "penduduk?nik=" + nik,
					type: 'get',
					async: false,
					beforeSend: function(res) {
						block_ui("Mengambil Data Penduduk");
					},
				});

				data = data.data
				data_lama = data
				console.log(data)
				$('#nik').val(data.nik)
				$('#nama').val(data.nama)
				$('#tgl_lahir').val(data.tgl_lahir)
				$('#jenis_kelamin').val(data.jenis_kelamin)
				$('#alamat').val(data.alamat)
				$('#no_hp').val(data.no_hp)
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

		// tambah_edit_penduduk
		function tambah_edit_penduduk(e) {
			e.preventDefault();
			const status = $('#status').val();
			const nik = $('#nik').val();
			const nama = $('#nama').val();
			const tgl_lahir = $('#tgl_lahir').val();
			const jenis_kelamin = $('#jenis_kelamin').val();
			const alamat = $('#alamat').val();
			const no_hp = $('#no_hp').val();

			console.log(status, nik, nama, tgl_lahir, jenis_kelamin, alamat, no_hp);

			if (status == 'edit') {
				const data = {
					nik: nik,
					nama: nama,
					tgl_lahir: tgl_lahir,
					jenis_kelamin: jenis_kelamin,
					alamat: alamat,
					no_hp: no_hp,
				}
				if (JSON.stringify(data) === JSON.stringify(data_lama)) {
					return toastr.warning("Data tidak ada yang berubah");
				}
			}

			// show swal before submit
			swal({
				title: "Apakah anda yakin?",
				text: "Data akan "+ ( status == 'tambah' ? 'ditambahkan' : 'diubah' ) +"!",
				icon: "info",
				buttons: true,
				dangerMode: false,
			}).then((willDelete) => {
				if (willDelete) {
					$.ajax({
						type: status == 'tambah' ? 'post' : 'put',
						url: server_url_api + "penduduk",
						data: {
							nik: nik,
							nama: nama,
							tgl_lahir: tgl_lahir,
							jenis_kelamin: jenis_kelamin,
							alamat: alamat,
							no_hp: no_hp
						},
						dataType: "JSON",
						beforeSend: function(res) {
							block_ui("Menyimpan Data Penduduk");
						},
						success: function(response) {

							// close modal
							$('#modal_add_penduduk').modal('hide')
							$('#table_list_penduduk').dataTable().fnDestroy();
							datatables();
							toastr.success(response.message)
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
					});
				}
			});


		}

		function hapus_penduduk(id) {
			swal({
				title: "Apakah anda yakin?",
				text: "Data akan dihapus!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			}).then((willDelete) => {
				if (willDelete) {
					$.ajax({
						type: 'delete',
						url: server_url_api + "penduduk/",
						data : {
							nik : id
						},
						dataType: "JSON",
						beforeSend: function(res) {
							block_ui("Menghapus Data Penduduk");
						},
						success: function(response) {
							console.log(response)
							$('#table_list_penduduk').dataTable().fnDestroy();
							datatables();
							toastr.success(response.message)
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
					});
				}
			});
		}
	</script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>