// baseurl
let baseurl = 'http://localhost:8080';
/*

/*
 * fungsi load semua data video dari database ketika halaman diload
 */
// window.onload = loadData();

/*
 * ketika tombol pengujian diklik
 */
document.querySelector('.pengujian').addEventListener('click', function () {
   const video = document.getElementById('preview');
   const btnFile = document.getElementById('file_video');
   const fileField = document.querySelector('input[type="file"]');
   const key_twofish = document.querySelector('#key_twofish');

   // tampilkan nama file
   document.querySelector('.nama_file').textContent = fileField.files[0].name;

   // tampilkan ukuran file
   const ukuran = fileField.files[0].size / 1048576;
   document.querySelector('.ukuran_file').textContent = ukuran.toFixed(2) + ' Mb';

   // validasi input
   if (validateErrors(fileField, key_twofish, video) == false) {
      // inisilisasi formdata
      const formData = new FormData();

      formData.append('video', fileField.files[0]);
      formData.append('key', key_twofish.value);
      formData.append('ukuran_file', ukuran.toFixed(2));
      xhrRequest(baseurl + '/uji', 'POST', formData, 'enkripsi');
   }
})


// melakukan request ajax
function xhrRequest(url, request, fileField, pesan) {
   const xhr = new XMLHttpRequest();
   if (request.toLowerCase() == 'post') {
      const progressbar = document.querySelector('.progress');

      xhr.open(request, url);
      xhr.upload.addEventListener('progress', e => {
         const percent = e.lengthComputable ? (e.loaded / e.total) * 99 : 0;
         progressbar.classList.add('d-block');
         const progress = document.querySelector('.pb-dashboard');
         progress.style.width = percent.toFixed(0) + '%';
         progress.textContent = 'Sedang diproses...';
      });

      xhr.onload = function () {
         input.value = null;
         videoSource.removeAttribute('src');
         key_twofish.value = '';
         if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            progressbar.classList.remove('d-block');
            progressbar.classList.add('d-none');
            video.classList.replace('d-block', 'd-none');

            const respond = JSON.parse(xhr.responseText);
            document.querySelector('.kecepatan_enkripsi').textContent = respond.kecepatan_enkripsi;
            document.querySelector('.kecepatan_dekripsi').textContent = respond.kecepatan_dekripsi
            Swal.fire({
               position: 'center',
               icon: 'success',
               title: 'Pengujian Selesai',
               showConfirmButton: false,
               timer: 2000
            });
            loadData();
         }
      }
      xhr.send(fileField);
   } else {
      xhr.open(request, url);
      xhr.onload = function () {
         if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            bodyTable(response.data);
         }
      }
      xhr.send();
   }
}


/*
 * fungsi load semua data video dari database
 */
function loadData() {
   xhrRequest(baseurl + '/testing', 'GET');
}


/*
 * fungsi untuk memuat data kedalam datatable
 */
function bodyTable(data) {
   let table = '';
   let nomor = 1;
   data.forEach(video => {
      table += `<tr>
                  <td class="text-center">${nomor++}</td>
                  <td class="text-left" style="width: 350px">${video.nama_file}</td>
                  <td class="text-center">${video.ukuran_file} Mb</td>
                  <td class="text-center">${video.kecepatan_enkripsi}</td>
                  <td class="text-center">${video.kecepatan_dekripsi}</td>
               </tr>`;
   });
   document.querySelector('.tabel-video').innerHTML = table;
}

/*
 * Validasi input
 */
function validateErrors(fileField, key_twofish, video) {
   let pesanError = {};

   //validasi file input 
   if (fileField.files[0] == undefined) {
      pesanError.video = 'File tidak boleh kosong';
   } else if (fileField.files[0].type != 'video/mp4') {
      pesanError.video = 'Format file bukan .mp4';
   } else if (video.duration > 300) {
      pesanError.video = 'Durasi video maksimal 5 menit';
   }
   // else if (video.duration < 120) {
   //    pesanError.video = 'Durasi video minimal 2 menit';
   // } 
   else if (fileField.size > 5242880) {
      pesanError.video = 'file upload maksimal 5 Mb';
   }
   //  else if (fileField.size < 2097152) {
   //    pesanError.video = 'file upload minimal dari 2 Mb';
   // }

   // validasi key input
   if (key_twofish.value == '') {
      pesanError.key = 'Key tidak boleh kosong';
   } else if (key_twofish.value.length < 8) {
      pesanError.key = 'Key minimal 8 karakter';
   }

   /*
   return true : jika ada pesan error
   return false : jika tidak ada pesan error
   */
   return tampilError(pesanError, fileField, key_twofish);
}

/*
 * tampilkan pesan error 
 */
function tampilError(pesanError, fileField, key_twofish) {
   if (pesanError.hasOwnProperty('video') == true || pesanError.hasOwnProperty('key') == true) {
      if (pesanError.hasOwnProperty('video')) {
         fileField.classList.add('is-invalid');
         document.getElementById('error-video').innerHTML = pesanError.video
      } else {
         fileField.classList.remove('is-invalid');
      }

      if (pesanError.hasOwnProperty('key')) {
         key_twofish.classList.add('is-invalid');
         document.getElementById('error-key').innerHTML = pesanError.key
      } else {
         key_twofish.classList.remove('is-invalid');
      }
      return true;
   } else {
      fileField.classList.remove('is-invalid');
      key_twofish.classList.remove('is-invalid');
      return false;
   }
}

// video preview
const input = document.getElementById('file_video');
const video = document.getElementById('preview');
const videoSource = document.createElement('source');
input.addEventListener('change', function () {

   if (video.duration > 300) {
      const fileField = document.querySelector('input[type="file"]');
      fileField.classList.add('is-invalid');
      document.getElementById('error-video').innerHTML = 'Durasi video maksimal 5 menit';
   }
   const files = this.files || [];

   if (!files.length) return;

   const reader = new FileReader();

   reader.onload = function (e) {
      videoSource.setAttribute('src', e.target.result);
      video.appendChild(videoSource);
      // video.load();
      // video.play();
   };

   reader.onprogress = function (e) {
      console.log('progress: ', Math.round((e.loaded * 100) / e.total));
   };

   reader.readAsDataURL(files[0]);
});