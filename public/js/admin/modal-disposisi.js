document.addEventListener('click', setHiddenValue)

function setHiddenValue(e)
{
   if (e.target.classList.contains('btn-disposisi'))
   {
      const id_surat = e.target.getAttribute('data-id')

      // isi value input hidden nomor surat 
      const id_surat_hidden = document.getElementById('id-surat');
      id_surat_hidden.value = id_surat
   }
}