// baseurl
let baseurl = 'http://localhost:8080';
let batasDownload = true;

// video preview
const input = document.getElementById('file_video');
const video = document.getElementById('preview');

// inisilisasi formdata
const formData = new FormData();

/*
 * mengambil file video dan key enkripsi
 */
const fileField = document.querySelector('input[type="file"]');
const key_twofish = document.querySelector('#key_twofish');

// ketika tombol dekripsi diklik
const buttonDekripsi = document.querySelector('.dekripsi');
buttonDekripsi.addEventListener('click', function () {
   // validasi input
   let batasDownload = true;
   document.querySelector('.hitung-mundur').textContent = '10'
   if (validateErrors(fileField, key_twofish) == false) {
      formData.append('video', fileField.files[0]);
      formData.append('key', key_twofish.value);
      xhrRequest(baseurl + '/dekripsi', 'POST', formData, 'dekripsi');
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
            const respond = JSON.parse(xhr.responseText);

            progressbar.classList.remove('d-block');
            progressbar.classList.add('d-none');

            if (respond.status === 200) {
               const judulVideo = document.querySelector('.judul-video');
               judulVideo.classList.remove('d-none');
               judulVideo.textContent = respond.nama_video

               const downloadVideo = document.querySelector('.download-video');
               downloadVideo.classList.remove('d-none')
               downloadVideo.setAttribute('data-name', respond.nama_video)
               downloadVideo.setAttribute('href', '#')

               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Video Berhasil di-' + pesan,
                  showConfirmButton: false,
                  timer: 2000
               });

               // hapus link download dan video dekripsi setelah 10 detik jika tidak didownload
               deleteAfterTenSeconds(10, respond.nama_video);
            } else {
               progressbar.classList.replace('d-block', 'd-none');
               progressbar.classList.add('d-none');

               Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Video Tidak dapat di-' + pesan,
                  showConfirmButton: false,
                  timer: 2000
               });
               setTimeout(() => location.reload(), 3000);
            }
         }
      }
      xhr.send(fileField);
   }
}

// download file
document.addEventListener('click', (e) => {
   if (e.target.classList.contains('download')) {
      batasDownload = false
      e.preventDefault()
      const filename = e.target.getAttribute('data-name')
      const xhr = XMLHttpRequest()
      xhr.open('GET', 'http://localhost:8080/video/temp/' + filename, true)
      xhr.responseType = 'blob'

      xhr.addEventListener('progress', function (event) {
         let percentComplete = Math.round((event.loaded * 99) / event.total);

         const progressbar = document.querySelector('.pb-show');
         progressbar.classList.replace('d-none', 'd-block');

         const pbDownload = document.querySelector('.pb-download');
         pbDownload.style.width = percentComplete + "%";
         pbDownload.textContent = 'Download ' + percentComplete + ' %';

         if (percentComplete === 99) {
            setTimeout(() => {
               progressbar.classList.replace('d-block', 'd-none');
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Video Berhasil terdownload',
                  showConfirmButton: false,
                  timer: 2000
               });

               const judulVideo = document.querySelector('.judul-video');
               judulVideo.classList.add('d-none');

               const downloadVideo = document.querySelector('.download-video');
               downloadVideo.classList.add('d-none')

               document.querySelector('.hitung-mundur').textContent = '10'
               // hapus video dekripsi
               deleteVideoDekripsi(filename)
            }, 3000)

         }
      })

      xhr.onreadystatechange = function () {
         if (this.readyState === 4 && this.status === 200) {
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(xhr.response)
            link.download = filename
            link.click();
         }
      }
      xhr.send()
   }
});

// hapus video setelah didownload
function deleteVideoDekripsi(filename) {
   const xhr = new XMLHttpRequest();
   const params = "filename=" + filename
   xhr.open('POST', baseurl + '/deleteVideo', true)
   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
   xhr.send(params)
}

function deleteAfterTenSeconds(decrement, filename) {
   let noteDelete = document.querySelector('.note-delete')
   const interval = setInterval(() => {
      if (batasDownload === false) { // menghentikan batas donwload
         clearInterval(interval)
         return document.querySelector('.hitung-mundur').textContent = '-'
      } else if (decrement == 0) {
         clearInterval(interval)
         deleteVideoDekripsi(filename)
         pesanTerhapus()
         document.querySelector('.hitung-mundur').textContent = '10'

         const judulVideo = document.querySelector('.judul-video');
         judulVideo.classList.add('d-none');

         const downloadVideo = document.querySelector('.download-video');
         downloadVideo.classList.add('d-none')

         return

      } else {
         document.querySelector('.hitung-mundur').textContent = decrement
         decrement--
      }
   }, 1000);
}

function pesanTerhapus() {
   Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Link download dan video dekripsi dihapus! ',
      showConfirmButton: false,
      timer: 2000
   });
}
