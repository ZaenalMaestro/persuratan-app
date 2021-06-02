document.addEventListener('click', setHiddenValue)

function setHiddenValue(e)
{
   if (e.target.classList.contains('btn-disposisi'))
   {
      const nomor_surat = e.target.getAttribute('data-nomor-surat')

      // isi value input hidden nomor surat 
      const input_nomor_surat = document.getElementById('nomor-surat');
      input_nomor_surat.value = nomor_surat
   }
}