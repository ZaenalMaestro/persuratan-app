<?= $this->extend('layout/template') ?>

<?= $this->section('css') ?>
   <link rel="stylesheet" href="/ckeditor5/editor-style.css">
   <style>
      .komentar{
         color: salmon;
      }
   </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col-lg-9">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Surat Keluar</h6>
         </div>
         <div class="card-body ml-5" style="margin-right:2.2cm">
            <!-- ==== form ==== -->         
            <form>
               <!-- id surat keluar -->
               <input type="hidden" id="id-surat-keluar" value="<?= $surat_keluar['id'] ?>">
               <!-- nomor surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Nomor Surat</label>
                  <input type="text" id="nomor-surat" class="form-control" placeholder="Nomor surat" value="<?= $surat_keluar['nomor_surat'] ?>">
                  <div class="invalid-feedback">
                     format nomor surat tidak valid
                  </div>
               </div>
               
               <!-- tanggal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Tanggal Surat</label>
                  <input type="date" id="tanggal-surat" class="form-control" placeholder="Tanggal surat" value="<?= $surat_keluar['tanggal_surat'] ?>">
               </div>

               <!-- penerima surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Penerima Surat</label>
                  <input type="text" id="penerima-surat" class="form-control" placeholder="Penerima surat" value="<?= $surat_keluar['penerima'] ?>">
               </div>
               <!-- perihal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Perihal Surat</label>
                  <input type="text" id="perihal-surat" class="form-control" placeholder="Perihal surat" value="<?= $surat_keluar['perihal'] ?>">
               </div>

               <div class="form-group">
                  <label for="exampleFormControlSelect1" require>Pilih Template Surat</label>
                  <select class="form-control" id="pilih-template">
                     <option value="">Pilih template surat</option>
                     <?php foreach($templates as $template) : ?>
                        <option value="<?= $template['id'] ?>"><?= $template['nama_template'] ?></option>
                     <?php endforeach ?>
                  </select>
               </div>

               <!-- input template -->
               <div class="form-group template-container">
                  <label for="exampleFormControlTextarea1">Isi Surat</label>
                  <div id="toolbar-container"></div>
                  <!-- This container will become the editable. -->
                  <div id="editor"><?= $surat_keluar['isi_surat'] ?></div>
               </div>
               <button type="button" id="submit" class="btn btn-md btn-success btn-block">Simpan perubahan surat keluar</button>
            </form>
            <!-- ==== end form ==== -->
            <div class="komentar">
               <hr>
               <h5 class="font-italic">**Komentar:</h5>
               <?= $surat_keluar['komentar'] ?>
            </div>            
         </div>
      </div>
   </div>
</div>

<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script src="/js/admin/modal-disposisi.js"></script>
<script src="/ckeditor5/ckeditor.js"></script>
<!-- axios -->
<script src="/axios/axios.js"></script>




<script>
   let editor_template
   DecoupledEditor.create(document.querySelector('#editor'), {
         fontSize: {
            options: [
               'tiny', 'default', 'big'
            ]
         },
      })
      .then(editor => {
         editor_template = editor;
            const toolbarContainer = document.querySelector('#toolbar-container');

            toolbarContainer.appendChild(editor.ui.view.toolbar.element );
      })
      .catch(error => {
            console.error(error);
      });


      // ubah isi surat jika template telah dipilih
      document.querySelector('#pilih-template').addEventListener('change', function () {
         if(confirm('Mengganti template akan mengubah isi surat sebelumnya') == false) return
         const selected_template_id = this.value
         axios.get('/admin/template/all')
            .then(function (response) {
               let templates = response.data.templates
               templates.forEach(template => {
                  if(template.id == selected_template_id) return editor_template.setData(template.template)
               });
            })
            .catch(function (error) {
               // handle error
               console.log(error);
            })
      })

      // update data surat keluar
      document.querySelector('#submit').addEventListener('click', () => {
         const id_surat_keluar = document.getElementById('id-surat-keluar')
         const nomor_surat     = document.getElementById('nomor-surat')
         const tanggal_surat   = document.getElementById('tanggal-surat')
         const penerima_surat  = document.getElementById('penerima-surat')
         const perihal_surat   = document.getElementById('perihal-surat')
         const isi_surat       = editor_template.getData()

         let data = {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
            id: id_surat_keluar.value,
            nomor_surat: nomor_surat.value,
            tanggal_surat: tanggal_surat.value,
            penerima_surat: penerima_surat.value,
            perihal_surat: perihal_surat.value,
            isi_surat: editor_template.getData(),
         }


         // jika input valid kirim update data keserve
         if(inputValid(data)) update(data)
      });

      // validasi nomor surat
      document.getElementById('nomor-surat').addEventListener('keyup', function() {
         const tombol_submit =document.querySelector('#submit')
         if (!cekFormatNomorSurat(this.value)) {
            this.classList.add('is-invalid')
            return tombol_submit.style.display = 'none'
         }
         this.classList.remove('is-invalid')
         tombol_submit.style.display = 'block'
      })

      // kirim perubahan data keserver
      function update(data)
      {
         axios.put('<?= base_url('admin/surat-keluar') ?>', data)
            .then(function (response) {
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: response.data.pesan,
                  showConfirmButton: false,
                  timer: 2500
               })
               setTimeout(() => {
                  window.location.href = '/admin/surat-keluar'
               }, 2600);
         })
         .catch(function (error) {
            console.log(error);
         });
      }

      function inputValid(data)
      {
         validasi = true
         for (const [key, value] of Object.entries(data)) {
            if (!value) {
               validasi = false
               return alert('Semua form harus diisi')
            }
         }
         return validasi
      }

      // cek format nomor surat
      function cekFormatNomorSurat(get_nomor_surat) {
         const seksion_nomor_surat = get_nomor_surat.split('/')
         if(seksion_nomor_surat.length < 4) return false;
         else return true;
      }
</script>


<!-- modal edit tamu -->

<?= $this->endSection() ?>