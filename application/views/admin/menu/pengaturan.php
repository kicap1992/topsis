<!DOCTYPE html>
<html lang="en">


<?php $this->load->view("admin/header"); ?>

<body>

  <?php $this->load->view("admin/side_topbar"); ?>

  <div id="wrapper">
    <div class="main-content">
      <div class="row small-spacing">
        <div class="col-lg-3 col-md-2"></div>
        <div class="col-xs-12 col-lg-6 col-md-8">
          <form class="box-content" onsubmit="return simpan_radius(event)">
            <h4 class="box-title">Pengaturan Radius</h4>
            <div class="input-group margin-bottom-20">
              <input type="text" id="radius" class="form-control" placeholder="Masukkan Radius (meter)" required minlength="1" maxlength="3" value="<?= $radius ?>" onkeypress="return isNumberKey(event)">
              <span class="input-group-addon  b-0 text-grey">meter</span>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary btn-xs waves-effect waves-light">Simpan Radius</button>
            </div>
          </form>
          <!-- /.box-content -->
        </div>
        <!-- /.col-xs-12 -->
        <div class="col-lg-3 col-md-2"></div>
      </div>
      <div class="row small-spacing">
        <div class="col-xs-12">
          <div class="box-content">
            <h4 class="box-title">Pengaturan Titik Lokasi Dinas</h4>

            <!-- /.dropdown js__dropdown -->
            <div class="form-group">
              <div id="map" style="width: 100%; height: 500px"></div>
            </div>
            <!-- /#flot-chart-1.flot-chart -->
            <div class="form-group">
              <input type="text" placeholder="Masukkan Alamat Untuk Mengubah Kordinat" id="alamat" class="form-control">
              <!-- <center><button type="button" class="btn btn-primary btn-xs waves-effect waves-light" onclick="buka_modal_pengaturan()">Atur Titik Kordinat</button></center> -->
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

  <div class="modal fade" id="modal_pengaturan_kordinat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel-1" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onclick="rewind_button()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel-1">Pengaturan Titik Kordinat Dinas</h4>
          <p style="font-size: 10px;"><i>(Geserkan marker ke titik kordinat dinas)</i></p>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <!-- <input type="text" placeholder="Masukkan Alamat" id="alamat"> -->
            <!-- <input type="text" placeholder="Masukkan Alamat" id="alamat" class="form-control"> -->
          </div>
          <div class="form-group">
            <div id="map2" style="width: 100%; height: 500px"></div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" style="display:none" class="button_simpan_marker btn btn-success btn-xs waves-effect waves-light" onclick="simpan_marker()">Simpan Marker</button>
          <button type="button" style="display:none" class="button_simpan_marker btn btn-danger btn-xs waves-effect waves-light" onclick="rewind_button()" data-dismiss="modal">Batalkan</button>
          <button type="button" id="button_tambah_marker" class="btn btn-primary btn-xs waves-effect waves-light" onclick="get_center()">Letak
            Marker</button>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('admin/scripts') ?>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7B9RynI4hQM_Y4BG9GYxsTLWwYkGASRo&libraries=geometry,drawing,places&v=weekly&region=ID&language=id">
  </script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7B9RynI4hQM_Y4BG9GYxsTLWwYkGASRo&&language=id&region=ID&callback=initAutocomplete&libraries=places&v=weekly&sensor=false" defer></script> -->
  <script>
    let map;
    async function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 19.5,
        center: {
          lat: <?= $lat ?>,
          lng: <?= $lng ?>
        },
        mapTypeId: 'hybrid',
        streetViewControl: false,
      });

      const marker = new google.maps.Marker({
        position: {
          lat: <?= $lat ?>,
          lng: <?= $lng ?>
        },
        map: map,
        title: 'Center',
        icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
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
    }
    google.maps.event.addDomListener(window, 'load', initMap);
  </script>

  <script>
    // function buka_modal_pengaturan() {
    //   $('#modal_pengaturan_kordinat').modal('show');
    // }

    var geocoder = new google.maps.Geocoder();
    var marker;
    var lat, lng;

    function geocodePosition(pos) {
      geocoder.geocode({
        latLng: pos
      });
    }

    function updateMarkerPosition(latLng) {
      // document.getElementById('info').value = [
      console.log(latLng.lat(), latLng.lng())
      lat = latLng.lat()
      lng = latLng.lng()
      console.log(lat, lng)

    }


    let map2;

    function initAutocomplete() {
      map2 = new google.maps.Map(document.getElementById("map2"), {
        center: {
          lat: -3.916417,
          lng: 119.7329218
        },
        zoom: 16,
        mapTypeId: "hybrid"
      }); // Create the search box and link it to the UI element.


      const input = document.getElementById("alamat");
      const searchBox = new google.maps.places.SearchBox(input);

      // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input); // Bias the SearchBox results towards current map's viewport.

      map2.addListener("bounds_changed", () => {
        searchBox.setBounds(map2.getBounds());
      });
      // more details for that place.

      searchBox.addListener("places_changed", () => {
        if (typeof marker !== 'undefined') {
          // console.log('ada');
          marker.setMap(null);
        }

        const places = searchBox.getPlaces();
        console.log(places)
        // $("#sini_modal").modal();
        if (places.length == 0) {
          return;
        } // Clear out the old markers.


        const bounds = new google.maps.LatLngBounds();
        // console.log(bounds);

        places.forEach(place => {
          // console.log(place)
          if (!place.geometry) {
            console.log("Returned place contains no geometry");
            return;
          }

          if (place.geometry.viewport) {
            var centernya = map2.setCenter(place.geometry.location);
            map2.fitBounds(place.geometry.viewport);
            map2.setZoom(14);
          } else {
            var centernya = map2.setCenter(place.geometry.viewport);
            map2.setCenter(place.geometry.location);
            map2.setZoom(14);
          }
          // console.log(updateMarkerPosition(place.geometry.location));
          $("#alamat").val("");
          $('#modal_pengaturan_kordinat').modal('show');
        });

      });
    }
    google.maps.event.addDomListener(window, 'load', initAutocomplete);

    function get_center() {
      // set marker to null to remove marker
      const rndInt = Math.floor(Math.random() * 6) + 1

      let center = map2.getCenter();
      lat = center.lat()
      lng = center.lng()

      // console.log(lat, lng)
      // add marker to map2
      marker = new google.maps.Marker({
        uniqueId: rndInt,
        position: {
          lat: center.lat(),
          lng: center.lng()
        },
        map: map2,
        title: 'Center',
        icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
        draggable: true,
      });

      // add listener to marker
      google.maps.event.addListener(marker, 'dragend', function(event) {
        updateMarkerPosition(event.latLng);
      });

      $(".button_simpan_marker").removeAttr("style");
      $("#button_tambah_marker").attr("style", "display:none");

    }

    function simpan_marker() {


      $.ajax({
        url: server_url_api + "pengaturan_lokasi",
        type: 'put',
        data: {
          id: <?= $id_dinas ?>,
          lat: lat,
          lng: lng
        },
        beforeSend: function(res) {
          $('#modal_pengaturan_kordinat').modal('hide');
          block_ui("Mengubah Titik Kordinat Dinas");
        },
        success: function(response) {
          $.unblockUI();
          window.location.reload();
          // console.log(response)
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $.unblockUI();
          // console.log(errorThrown)
          // console.log(textStatus)
          const statusCode = XMLHttpRequest.status;
          const responseJSON = XMLHttpRequest.responseJSON;
          console.log(statusCode);
          console.log(responseJSON)
          if (statusCode != 500) {
            toastr.error(responseJSON.message);
          } else {
            toastr.error("Jaringan atau server bermasalah, sila refresh kembali halaman");
          }


        }
      });

    }


    function rewind_button() {
      $(".button_simpan_marker").attr("style", "display:none");
      $("#button_tambah_marker").removeAttr("style");
      lat = null;
      lng = null;
    }
  </script>

  <script>
    function simpan_radius(e) {
      e.preventDefault();
      const radius = $("#radius").val();

      if (radius == <?= $radius ?>) return toastr.warning("Tiada Perubahan Radius");

      swal({
        text: `Ubah radius dari <?= $radius ?> meter menjadi  \n ${radius} meter`,
        icon: "info",
        buttons: {
          cancel: true,
          confirm: true,
        },
        // dangerMode: true,
      }).then((yes) => {
        if (yes) {
          $.ajax({
            url: server_url_api + "pengaturan_radius",
            type: 'put',
            data: {
              id: <?= $id_dinas ?>,
              radius: radius,
            },
            beforeSend: function(res) {

              block_ui("Mengubah Radius");
            },
            success: function(response) {
              $.unblockUI();
              window.location.reload();
              // console.log(response)
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              $.unblockUI();
              // console.log(errorThrown)
              // console.log(textStatus)
              const statusCode = XMLHttpRequest.status;
              const responseJSON = XMLHttpRequest.responseJSON;
              console.log(statusCode);
              console.log(responseJSON)
              if (statusCode != 500) {
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