<?= $this->extend('layout/template') ?>

<?= $this->section('css') ?>
   <link rel="stylesheet" href="/ckeditor5/editor-style.css">
   <link rel="stylesheet" href="/ckeditor5/style.css">
   <style>
      /*Textbox*/
      .ck-editor__editable {
         min-height: 150px;
      }
      .isi-surat{
         width:607.44px;
      }
   </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col-lg-9">
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Surat Keluar</h6>
         </div>
         <div class="card-body ml-5" style="margin-right:2.2cm">
            <!-- ==== form ==== -->         
            <form>
               <!-- id surat keluar -->
               <input type="hidden" id="id-surat-keluar" value="<?= $surat_keluar['id'] ?>">
               <!-- nomor surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Nomor Surat</label>
                  <input type="text" id="nomor-surat" class="form-control" placeholder="Nomor surat" value="<?= $surat_keluar['nomor_surat'] ?>" disabled>
               </div>
               
               <!-- tanggal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Tanggal Surat</label>
                  <input type="date" id="tanggal-surat" class="form-control" placeholder="Tanggal surat" value="<?= $surat_keluar['tanggal_surat'] ?>" disabled>
               </div>

               <!-- penerima surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Penerima Surat</label>
                  <input type="text" id="penerima-surat" class="form-control" placeholder="Penerima surat" value="<?= $surat_keluar['penerima'] ?>" disabled>
               </div>
               <!-- perihal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1">Perihal Surat</label>
                  <input type="text" id="perihal-surat" class="form-control" placeholder="Perihal surat" value="<?= $surat_keluar['perihal'] ?>" disabled>
               </div>
               <!-- perihal surat -->
               <div class="form-group">
                  <label for="exampleFormControlInput1 mb-0">Isi Surat</label>
                  <hr>
                     <div class="isi-surat"><?= $surat_keluar['isi_surat'] ?></div>
                  <hr>
               </div>

               <!-- input template -->
               <div class="form-group template-container">
                  <label for="exampleFormControlTextarea1">Berikan Komentar</label>
                  <div id="toolbar-container"></div>
                  <!-- This container will become the editable. -->
                  <div id="editor"><?= $surat_keluar['komentar'] ?></div>
               </div>
               <button type="button" id="submit" class="btn btn-md btn-success btn-block">Tambahkan komentar</button>
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

      document.querySelector('#submit').addEventListener('click', () => {
         // get input form tambah surat
         const id_surat_keluar = document.getElementById('id-surat-keluar')

         let data = {
            <?= csrf_token() ?>: '<?= csrf_hash() ?>',
            id: id_surat_keluar.value,
            komentar: editor_template.getData(),
         }
         console.log(data)
         // jika input valid kirim update data keserve
         if(inputValid(data)) kirimKomentar(data)
      });

      // kirim perubahan data keserver
      function kirimKomentar(data)
      {
         axios.put('<?= base_url('sekertaris/surat-keluar/komentar') ?>', data)
            .then(function (response) {
               Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: response.data.pesan,
                  showConfirmButton: false,
                  timer: 2500
               })
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
               return alert('Anda belum memberikan komentar')
            }
         }
         return validasi
      }
</script>


<!-- modal edit tamu -->

<?= $this->endSection() ?>