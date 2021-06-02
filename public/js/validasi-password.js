const nama                 = document.querySelector('.nama');
const nomor_induk          = document.querySelector('.nomor_induk');
const password             = document.querySelector('.password');
const konfirmasi_password  = document.querySelector('.konfirmasi-password');
const btn_registrasi = document.querySelector('.btn-registrasi');
const pesan_invalid = document.querySelector('.pesan-invalid');

nama.addEventListener('keyup', () => {
   if(nama.classList.contains('is-invalid')) nama.classList.remove('is-invalid')   
})
nomor_induk.addEventListener('keyup', () => {
   if(nomor_induk.classList.contains('is-invalid')) nomor_induk.classList.remove('is-invalid')   
})

konfirmasi_password.addEventListener('keyup', function () {
   if (password.value !== konfirmasi_password.value) {
      konfirmasi_password.classList.add('is-invalid')
      pesan_invalid.innerHTML = 'Konfirmasi password tidak sesuai'
      btn_registrasi.setAttribute('type', 'button')
   } else {
      konfirmasi_password.classList.remove('is-invalid')
      btn_registrasi.setAttribute('type', 'submit')
   }
})

password.addEventListener('keyup', function () {
   if (password.classList.contains('is-invalid')) password.classList.remove('is-invalid')
   
   if (password.value !== konfirmasi_password.value && konfirmasi_password.value) {
      konfirmasi_password.classList.add('is-invalid')
      pesan_invalid.innerHTML = 'Konfirmasi password tidak sesuai'
      btn_registrasi.setAttribute('type', 'button')
   } else {
      konfirmasi_password.classList.remove('is-invalid')
      btn_registrasi.setAttribute('type', 'submit')
   }
})