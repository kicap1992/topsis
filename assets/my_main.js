// get the http url
var url = window.location.href;
// console.log(url)
// var server_url = url;
// var server_url_api = server_url + "api/";
var server_url = "http://127.0.0.1/coba/";
var server_url_api = "http://127.0.0.1/coba/api/";
console.log(server_url, server_url_api)

const delay = ms => new Promise(res => setTimeout(res, ms));

function block_ui(message) {
  $.blockUI({
    message: message,
    css: {
      border: 'none',
      padding: '15px',
      backgroundColor: '#000',
      '-webkit-border-radius': '10px',
      '-moz-border-radius': '10px',
      opacity: .5,
      color: '#fff'
    }
  });
}

function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
  // console.log(evt.key)
}

function tConvert(time) {
  // Check correct time format and split into components
  time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

  if (time.length > 1) { // If time format correct
    time = time.slice(1);  // Remove full string match value
    time[5] = +time[0] < 12 ? ' am' : ' pm'; // Set AM/PM
    time[0] = +time[0] % 12 || 12; // Adjust hours
  }
  return time.join(''); // return adjusted time or original string
}

function uppercaseWord(word) {
  return word.charAt(0).toUpperCase() + word.slice(1)
}


function getTodayDate() {
  let today = new Date();
  today.toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' });
  let dd = String(today.getDate()).padStart(2, '0');
  let mm = String(today.getMonth() + 1).padStart(2, '0'); //janvier = 0
  let yyyy = today.getFullYear();

  return `${dd}-${mm}-${yyyy}`;
  //return dd + '/' + mm + '/' + yyyy; // change form if you need
}

function check_file(file) {
  //create let variable file_name = file.name , file_size = file.size
  let file_name = file.name
  let file_size = file.size
  //create if file_size > 1000000 then alert("File size is too big") else if file_name.length > 50 then alert("File name is too long") else return true
  if (file_size > 1500000) {
    toastr.error("Maksimal ukuran file adalah 1.5 MB")
    //input id=foto = null
    document.getElementById('foto').value = null
    document.getElementById('foto').focus()
    return false
  }
  // else if filename != .jpg  .png  then toast("File type is not allowed")

  else if (file_name.substr(file_name.length - 4) != ".jpg" && file_name.substr(file_name.length - 4) != ".png") {
    toastr.error("File type is not allowed")
    document.getElementById('foto').value = null
    document.getElementById('foto').focus()
    return false
  }

  else {
    return true
  }
}


function selectElement(id, valueToSelect) {    
  let element = document.getElementById(id);
  element.value = valueToSelect;
}