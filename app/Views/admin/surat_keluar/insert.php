<?= $this->extend('layout/template') ?>

<?= $this->section('css') ?>
   <link rel="stylesheet" href="/ckeditor5/editor-style.css">
   <link rel="stylesheet" href="/ckeditor5/style.css">
   <link rel="stylesheet" href="/css/mystyle.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col-lg-9">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat Surat Keluar</h6>
         </div>
         <div class="card-body ml-5" style="margin-right:2.2cm">
            <!-- ==== form ==== -->         
            <form>
               <!-- nomor surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Nomor Surat</label>
                  <input type="text" id="nomor-surat" class="form-control" placeholder="Nomor surat" value="<?= $nomor_surat ?>" disabled>
               </div>
               
               <!-- tanggal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Tanggal Surat</label>
                  <input type="date" id="tanggal-surat" class="form-control" placeholder="Tanggal surat" require autofocus>
               </div>

               <!-- penerima surat -->
               <div class="form-group">
                  <label for="penerima">Penerima Surat</label>
                  <select class="form-control <?= ($validation->hasError('penerima') ? 'is-invalid' : '') ?>" id="penerima" name="penerima">
                     <option value="">-- Pilih Penerima Surat --</option>
                     <?php foreach($penerima_surat as $penerima) : ?>
                        <?php if(strtolower($penerima['nama_lengkap']) !== 'operator' ) : ?>
                           <option value="<?= $penerima['nama_lengkap'] ?>"><?= $penerima['nama_lengkap'] ?></option>
                        <?php endif; ?>
                     <?php endforeach ?>
                  </select>
                  <!-- input penerima surat manual -->
                  <input type="text" id="penerima-manual" class="form-control" placeholder="masukkan penerima surat" require>
                  <div class="invalid-feedback">
                        <?= $validation->getError('penerima') ?>
                  </div>
               </div>

               <!-- perihal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Perihal Surat</label>
                  <input type="text" id="perihal-surat" class="form-control" placeholder="Perihal surat" require>
               </div>

               <div class="form-group">
                  <label for="exampleFormControlSelect1" require>Pilih Template Surat</label>
                  <select class="form-control" id="pilih-template">
                     <option value="">-- Pilih template surat --</option>
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
                  <div id="editor"></div>
               </div>
               <button type="button" id="submit" class="btn btn-md btn-primary btn-block">Simpan Surat Keluar</button>
            </form>
            <!-- ==== end form ==== -->
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
   DecoupledEditor
      .create(document.querySelector('#editor'), {
         fontSize: {
            options: [
               9, 11, 'default',13,14,17,19,21
            ],
            supportAllValues: true
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

      document.querySelector('#submit').addEventListener('click', () => {
         // get input form tambah surat
         const nomor_surat    = document.getElementById('nomor-surat')
         const tanggal_surat  = document.getElementById('tanggal-surat')

         const select_penerima_surat = document.getElementById('penerima')
         let penerima_surat = select_penerima_surat.value
         const penerima_manual = document.getElementById('penerima-manual')
         if(!select_penerima_surat.value) penerima_surat = penerima_manual.value
         
         const perihal_surat  = document.getElementById('perihal-surat')
         const isi_surat      = editor_template.getData()
         

         let data = {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
            nomor_surat: nomor_surat.value,
            tanggal_surat: tanggal_surat.value,
            penerima_surat: penerima_surat,
            perihal_surat: perihal_surat.value,
            isi_surat: editor_template.getData(),
         }
         
         if(inputValid(data)) insert(data)
      });

      // kirim data keserver
      function insert(data)
      {
         axios.post('<?= base_url('admin/surat-keluar') ?>', data)
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

      // menampilkan input manual jika dropdown penerima surat tidak diisi
      document.getElementById('penerima').addEventListener('change', function() {
         const penerima_manual = document.getElementById('penerima-manual')

         if (!this.value) return penerima_manual.style.display = 'block'
         penerima_manual.style.display = 'none'
         penerima_manual.value = ''
      })
</script>


<!-- modal edit tamu -->

<?= $this->endSection() ?>