const btn_tambah = document.querySelector('.btn-tambah')
const form_tambah = document.querySelector('.form-tambah')
const form_edit   = document.querySelector('.form-edit')
const modal_title = document.querySelector('.modal-title')

// selector input form edit
const input_nama_penerima  = document.querySelector('#input-nama-penerima')
const nomor_induk_lama     = document.querySelector('#nomor-induk-lama')
const input_nomor_induk    = document.querySelector('#input-nomor-induk')

document.addEventListener('click', setFormEdit)
btn_tambah.addEventListener('click', () => {
   showFormTambah()
   setModalTitle('Form Tambah Penerima Surat')
})

function setFormEdit(e)
{
   if (e.target.classList.contains('btn-edit'))
   {
      showFormEdit()
      setModalTitle('Form Edit Penerima Surat')
      const nomor_induk = e.target.getAttribute('data-nomor-induk')
      const nama        = e.target.getAttribute('data-nama')

      // set value input edit 
      input_nama_penerima.value  = nama
      nomor_induk_lama.value     = nomor_induk
      input_nomor_induk.value    = nomor_induk
   }
}

// tampilkan form edit
function showFormEdit()
{
   form_edit.classList.replace('d-none', 'd-block')
   form_tambah.classList.replace('d-block', 'd-none')
}

// tampilkan form tambah
function showFormTambah()
{
   form_edit.classList.replace('d-block', 'd-none')
   form_tambah.classList.replace('d-none', 'd-block')
}

function setModalTitle(title)
{
   modal_title.innerHTML = title
}