// baseurl
let baseurl = 'http://localhost:8080';
/*
load data
*/
// window.onload = loadData();



// video preview
const input = document.getElementById('file_video');
const video = document.getElementById('preview');
const videoSource = document.createElement('source');
const teks = document.querySelector('#teks-video');
input.addEventListener('change', function () {
   const files = this.files || [];

   if (!files.length) return;

   const reader = new FileReader();

   reader.onload = function (e) {
      video.classList.replace('d-none', 'd-block');
      video.muted = false;
      teks.style.display = 'none';
      videoSource.setAttribute('src', e.target.result);
      video.appendChild(videoSource);
      video.load();
      video.play();
   };

   reader.onprogress = function (e) {
      const progressDisplay = document.querySelector('.progress-preview');
      progressDisplay.classList.replace('d-none', 'd-block');
      const progressPreview = document.querySelector('.pb-preview');
      let persen = Math.round((e.loaded * 100) / e.total);
      progressPreview.style.width = persen + "%";
      progressPreview.textContent = 'Video Preview...';
      if (persen == 100) {
         progressDisplay.classList.replace('d-block', 'd-none');
      }
   };

   reader.readAsDataURL(files[0]);
});


// inisilisasi formdata
const formData = new FormData();

/*
 * mengambil file video dan key enkripsi
 */
const fileField = document.querySelector('input[type="file"]');
const key_twofish = document.querySelector('#key_twofish');

// ketika tombol enkripsi diklik
const buttonEnkripsi = document.querySelector('.enkripsi');
buttonEnkripsi.addEventListener('click', function () {
   // validasi input
   if (validateErrors(fileField, key_twofish, video) == false) {
      formData.append('video', fileField.files[0]);
      formData.append('key', key_twofish.value);
      xhrRequest(baseurl + '/enkripsi', 'POST', formData, 'enkripsi');
   }
});

// validasi input
function validateErrors(fileField, key_twofish, video) {
   let pesanError = {};
   const maxUpload = 1048576 * 100
   //validasi file input 
   if (fileField.files[0] == undefined) {
      pesanError.video = 'File tidak boleh kosong';
   } else if (fileField.files[0].type != 'video/mp4') {
      pesanError.video = 'Format file bukan .mp4';
   } else if (fileField.files[0].size > maxUpload) {
      pesanError.video = 'file upload maksimal 100 Mb';
   }

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

// tampilkan pesan error
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

// melakukan request ajax
function xhrRequest(url, request, fileField, pesan) {
   const xhr = new XMLHttpRequest();
   if (request.toLowerCase() == 'post') {
      const progressbar = document.querySelector('.progress-enkripsi');

      xhr.open(request, url);
      xhr.upload.addEventListener('progress', e => {
         const percent = e.lengthComputable ? (e.loaded / e.total) * 99 : 0;
         progressbar.classList.add('d-block');
         const progress = document.querySelector('.pb-dashboard');
         progress.style.width = percent.toFixed(0) + '%';
         progress.textContent = percent.toFixed(0) + '%';

      });

      xhr.onload = function () {
         input.value = null;
         key_twofish.value = '';
         if (this.readyState == 4 && this.status == 200) {
            progressbar.classList.remove('d-block');
            progressbar.classList.add('d-none');
            teks.classList.add('d-none');
            video.classList.replace('d-block', 'd-none');
            video.muted = true;
            const respond = JSON.parse(xhr.responseText);
            console.log(respond);
            
            if (respond.status === 200) {
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Video Berhasil di-' + pesan,
                  showConfirmButton: false,
                  timer: 2000
               });
               setTimeout(() => location.reload(), 3000)
               
            } else {
               progressbar.classList.replace('d-block', 'd-none');
               progressbar.classList.add('d-none');
               video.muted = true;
               Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Video Tidak dapat di-' + pesan,
                  showConfirmButton: false,
                  timer: 2000
               });
            }
         }
      }
      xhr.send(fileField);
   } 
}
