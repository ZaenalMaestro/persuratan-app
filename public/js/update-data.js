/*
 * mengisi data pada modal ketika tombol enkripsi / dekripsi pada table diklik
 */
document.addEventListener('click', function (e) {
   if (e.target.classList.contains('to-enkripsi')) {
      document.querySelector('.modal-title').textContent = 'Enkripsi Video';
      document.querySelector('#judul-video').value = e.target.dataset.name;
      document.querySelector('.id-video').value = e.target.dataset.id;
      document.querySelector('.key-update').value = '';
      const tombol = document.querySelector('.tombol');
      if (tombol.classList.contains('to-dekripsi-update')) tombol.classList.remove('to-dekripsi-update');
      tombol.textContent = 'Enkripsi';
      tombol.classList.add('btn-primary');
      tombol.classList.remove('btn-success');
      tombol.classList.add('to-enkripsi-update');

   } else if (e.target.classList.contains('to-dekripsi')) {
      document.querySelector('.modal-title').textContent = 'Dekripsi Video';
      document.querySelector('#judul-video').value = e.target.dataset.name;
      document.querySelector('.id-video').value = e.target.dataset.id;
      document.querySelector('.key-update').value = '';
      const tombol = document.querySelector('.tombol');
      if (tombol.classList.contains('to-enkripsi-update')) tombol.classList.remove('to-enkripsi-update');
      tombol.textContent = 'Dekripsi';
      tombol.classList.add('btn-success');
      tombol.classList.remove('btn-primary');
      tombol.classList.add('to-dekripsi-update');
   }
});


/*
 * ketika tombol enkripsi / dkripsi pada modal di klik
 */
document.addEventListener('click', function (e) {
   const id = document.querySelector('.id-video');
   const name = document.querySelector('#judul-video');
   const key = document.querySelector('.key-update');
   params = `id=${id.value}&name=${name.value}&key=${key.value}`;
   /* inisialisasi xhr object*/
   const xhr = new XMLHttpRequest();
   if (e.target.classList.contains('to-enkripsi-update')) {
      /*validasi key*/
      if (validasiKey()) {
         /* jika tombol enkripsi diklik*/
         xhr.open('POST', 'http://localhost:8080/enkripsi-update');
         progressModal();
         xhr.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
               closeModal();
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Video berhasil di-enkripsi',
                  showConfirmButton: false,
                  timer: 2000
               });
               loadData();
            } else {
               closeModal();
               Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Video gagal di-enkripsi',
                  showConfirmButton: false,
                  timer: 2000
               });
               location.reload();
            }
         }
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xhr.send(params);
      }
   } else if (e.target.classList.contains('to-dekripsi-update')) {
      if (validasiKey()) {
         xhr.open('POST', 'http://localhost:8080/dekripsi-update');
         progressModal();
         xhr.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
               const respond = JSON.parse(xhr.responseText);
               if (respond.status === 200) {
                  closeModal();
                  Swal.fire({
                     position: 'center',
                     icon: 'success',
                     title: 'Video Berhasil di-dekripsi',
                     showConfirmButton: false,
                     timer: 2000
                  });
                  loadData();
               } else {
                  closeModal();
                  Swal.fire({
                     position: 'center',
                     icon: 'error',
                     title: 'Video gagal di-didekripsi',
                     showConfirmButton: false,
                     timer: 2000
                  });
               }
            } else {
               closeModal();
               Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Video gagal di-dekripsi',
                  showConfirmButton: false,
                  timer: 2000
               });
               location.reload();
            }
         }
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xhr.send(params);
      }
   }
});


/*
 * Fungsi untuk menampilkan progress bar
 */
function progressModal() {
   var width = 1;
   const progress = document.querySelector('.pb-modal');
   progress.style.width = 0 + '%';
   progress.textContent = 0 + '%';
   const tampilProgress = document.querySelector('#pb-modal');
   tampilProgress.classList.add('d-block');

   var progressInterval = setInterval(() => {
      if (width >= 99) {
         clearInterval(progressInterval);
      } else {
         console.log(width);
         width++;
         progress.style.width = width + '%';
         progress.textContent = width + '%';
      }
   }, 70);
}

/*
 * Fungsi untuk menutup modal box kita video telah selesai di enkripsi /dekripsi
 */
function closeModal() {
   document.querySelector('.modal').style.display = 'none';
   document.querySelector('.modal-backdrop').style.display = 'none';
   document.querySelector('#page-top').classList.remove('modal-open');
   const tampilProgress = document.querySelector('#pb-modal');
   tampilProgress.classList.remove('d-block');
}

/*
 * Validasi key input
 */

function validasiKey() {
   const key = document.querySelector('.key-update');
   if (key.value.length < 8) {
      key.classList.add('is-invalid');
      document.querySelector('#kunci-video').textContent = 'Key minimal 8 karakter';
      return false;
   } else {
      key.classList.remove('is-invalid');
      return true;
   }
}

