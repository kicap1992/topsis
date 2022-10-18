<!DOCTYPE html>
<html lang="en">


<?php $this->load->view("admin/header"); ?>

<body>

	<?php $this->load->view("admin/side_topbar"); ?>

	<div id="wrapper">
		<div class="main-content">
			<div class="row small-spacing">
				<div class="col-xs-12">
					<div class="box-content">
						<h4 class="box-title" id="header_peta">Peta Absensi</h4>

						<!-- /.dropdown js__dropdown -->
						<div class="form-group">
							<div id="map" style="width: 100%; height: 500px"></div>
						</div>
						<!-- /#flot-chart-1.flot-chart -->
					</div>
					<!-- /.box-content -->
				</div>
				<!-- /.col-xs-12 -->

				<div class="col-xs-12">
					<div class="box-content">
						<h4 class="box-title" id="header_absensi">Absensi Karyawan</h4>

						<div class="card-content">
							<div style="overflow-x: auto">
								<table id="table_list_karyawan" class="table table-striped table-bordered display" style="width:100%">
									<thead>
										<tr>
											<th>NIP</th>
											<th>Nama</th>
											<th>Status</th>
											<th>Last Updated</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($list_karyawan as $key => $value) {
												?>
												<tr>
													<td><?=$value->nik?></td>
													<td><?=$value->nama?></td>
													<td id="status_<?=$value->nik?>"> <?=$value->status_kerja?> </td>
													<td id="lu_<?=$value->nik?>"> - </td>
												</tr>
												<?php
											}
										?>
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

	<?php $this->load->view('admin/scripts') ?>
	<script src="<?= base_url() ?>assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url() ?>assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7B9RynI4hQM_Y4BG9GYxsTLWwYkGASRo&libraries=geometry,drawing,places&v=weekly&region=ID&language=id"></script>

	<script>
		$('#table_list_karyawan').DataTable({

		})
		var id_dinas = <?= $id_dinas ?>;
		$("#header_peta").html(`Peta Absensi <i>(${getTodayDate()})</i>`)
		$("#header_absensi").html(`Absensi Karyawan <i>(${getTodayDate()})</i>`)

		let markersOverlay = [];

		function addInfoWindow(marker, message) {

			var infoWindow = new google.maps.InfoWindow({
				content: message
			});

			google.maps.event.addListener(marker, 'click', function() {
				infoWindow.open(map, marker);
			});
		}
		async function initMap() {
			map = new google.maps.Map(document.getElementById("map"), {
				zoom: 17.5,
				center: {
					lat: <?= $lat ?>,
					lng: <?= $lng ?>
				},
				mapTypeId: 'hybrid',
				streetViewControl: false,
			});

			const cityCircle = new google.maps.Circle({
				strokeColor: "#FF0000",
				strokeOpacity: 0.3,
				strokeWeight: 0.3,
				fillColor: "#FF0000",
				fillOpacity: 0.3,
				map,
				center: {
					lat: <?= $lat ?>,
					lng: <?= $lng ?>
				},
				radius: <?= $radius ?>,
			});

			const marker = new google.maps.Marker({
				position: {
					lat: <?= $lat ?>,
					lng: <?= $lng ?>
				},
				map: map,
				title: 'Center',
				icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
			});

			markersOverlay[0] = marker;

			let dinas_html = `<div class="card-content">
					<div class="form-group>
						<label for="nik"><?= $dinas ?></label>						
					</div>
				</div>`

			addInfoWindow(marker, dinas_html);

			setInterval(
				async function() {
					clearOverlays()
					markers = []
					markers = [{
						lat: <?= $lat ?>,
						lng: <?= $lng ?>

					}]
					let all_data;
					try {
						const the_data = await $.ajax({
							url: server_url_api + "get_today_absensi?id_dinas=" + id_dinas,
							type: 'get',
							async: false,
							beforeSend: function(res) {
								// block_ui("Mengambil Data Karyawan");
							},
						});
						// console.log(the_data);
						all_data = the_data.data;

						for (let i = 0; i < all_data.length; i++) {
							markers.push(all_data[i])
							// console.log(all_data)
						}

						let arr = []
						for (let i = 0; i < markers.length; i++) {
							console.log(markers[i]['lat'])
							let latlng = new google.maps.LatLng(markers[i]['lat'], markers[i]['lng']);
							arr.push(latlng);
							let color = i > 0 ? 'blue' : 'green'

							const marker = new google.maps.Marker({
								position: {
									lat: markers[i]['lat'],
									lng: markers[i]['lng']
								},
								map: map,
								title: 'Center',
								icon: `https://maps.google.com/mapfiles/ms/icons/${color}-dot.png`,
							});

							markersOverlay[i] = marker;
							if (i > 0) {
								let html = `<div class="card-content">
									<div class="form-group>
										<label for="nik">NIK</label>
										<input type="text" class="form-control" value="${markers[i]['nik']}" disabled>
									</div>
									<div class="form-group>
										<label for="nik">Nama</label>
										<input type="text" class="form-control" value="${markers[i]['nama']}" disabled>
									</div>
									<div class="form-group>
										<label for="nik">Last Updated</label>
										<input type="text" class="form-control" value="${markers[i]['last_updated']}" disabled>
									</div>
									<div class="form-group>
										<label for="nik">Status</label>
										<input type="text" class="form-control" value="${markers[i]['status']}" disabled>
									</div>
								</div>`
								$("#lu_"+markers[i]['nik']).html(markers[i]['last_updated']);
								$("#status_"+markers[i]['nik']).html(markers[i]['status']);
								addInfoWindow(marker, html);
							} else {
								addInfoWindow(marker, dinas_html);
							}
						}





						var bounds = new google.maps.LatLngBounds();

						if (markers.length > 1) {
							for (var i = 0; i < arr.length; i++) {
								bounds.extend(arr[i]);
							}
							map.fitBounds(bounds);

						}

					} catch (e) {
						console.log(e)
					}
				}, 5000)

		}
		google.maps.event.addDomListener(window, 'load', initMap);

		function clearOverlays() {
			if (markersOverlay) {
				for (i in markersOverlay) {
					markersOverlay[i].setMap(null);
				}
			}
		}
	</script>

</body>

<!-- Dibuat oleh Kicap Karan. https://www.kicap-karan.com -->

</html>