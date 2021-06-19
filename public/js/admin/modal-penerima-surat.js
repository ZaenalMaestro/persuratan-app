const btn_tambah = document.querySelector('.btn-tambah')
const form_tambah = document.querySelector('.form-tambah')
const form_edit   = document.querySelector('.form-edit')
const modal_title = document.querySelector('.modal-title')

// selector input form edit
const input_nama_penerima  = document.querySelector('#input-nama-penerima')
const penerima_surat_lama  = document.querySelector('#penerima-surat-lama')
const nomor_induk_lama     = document.querySelector('#nomor-induk-lama')
const input_level     = document.querySelector('#nomor-level')
const input_nomor_induk    = document.querySelector('#input-nomor-induk')
const input_password    = document.querySelector('#input-password')
const opt_kepala    = document.querySelector('#opt-kepala')
const opt_sekertaris    = document.querySelector('#opt-sekertaris')
const opt_ketua    = document.querySelector('#opt-ketua')

document.addEventListener('click', setFormEdit)
btn_tambah.addEventListener('click', showFormTambah)

function setFormEdit(e)
{
   if (e.target.classList.contains('btn-edit'))
   {
      showFormEdit()
      setModalTitle('Form Edit Penerima Surat')
      const nomor_induk = e.target.getAttribute('data-nomor-induk')
      const nama        = e.target.getAttribute('data-nama')
      const level        = e.target.getAttribute('data-level')

      // set value input edit 
      input_nama_penerima.value  = nama
      penerima_surat_lama.value  = nama
      nomor_induk_lama.value     = nomor_induk
      input_nomor_induk.value    = nomor_induk

      // set option edit leve
      if(level == 'ketua') opt_ketua.setAttribute('selected', 'selected')
      else if(level == 'kepala') opt_kepala.setAttribute('selected', 'selected')
      else if(level == 'sekertaris') opt_sekertaris.setAttribute('selected', 'selected')
   }
}

// tampilkan form edit
function showFormEdit()
{
   form_edit.classList.replace('d-none', 'd-block')
   form_tambah.classList.replace('d-block', 'd-none')
   setModalTitle('Form Edit Penerima Surat')
}

// tampilkan form tambah
function showFormTambah()
{
   form_edit.classList.replace('d-block', 'd-none')
   form_tambah.classList.replace('d-none', 'd-block')
   setModalTitle('Form Tambah Penerima Surat')
}

function setModalTitle(title)
{
   modal_title.innerHTML = title
}