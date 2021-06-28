<?= $this->extend('layout/template') ?>

<?= $this->section('css') ?>
   <link rel="stylesheet" href="/ckeditor5/editor-style.css">
   <link rel="stylesheet" href="/ckeditor5/style.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col-lg-9">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Buat Template Baru</h6>
      </div>
      <div class="card-body mx-5">
         <!-- ==== form ==== -->         
         <form>
            <!-- nama template -->
            <div class="form-group">
               <label for="exampleFormControlInput1">Nama Template</label>
               <input type="text" id="nama-template" class="form-control" placeholder="Nama template">
            </div>

            <!-- input template -->
            <div class="form-group template-container">
               <label for="exampleFormControlTextarea1"></label>
               <div id="toolbar-container"></div>
               <!-- This container will become the editable. -->
               <div id="editor"></div>
            </div>
            <button type="button" id="submit" class="btn btn-md btn-primary btn-block">Simpan Template</button>
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
         const nama = document.getElementById('nama-template')
         const template = editor_template.getData();
         if(!nama.value || !template){
            return alert('form input harus terisi semua')
         }
         // Send a POST request
         axios.get('/admin/template/all')
            .then(function (response) {
               // handle success
               templates = response.data.templates;
               
               // cek nama template
               let template_exist = false
               templates.forEach(element => {
                  if(element.nama_template.toLowerCase() == nama.value.toLowerCase()) template_exist = true;
               });

               if(template_exist) return alert('Nama template telah digunakan')
               const data = {
                  <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                  nama_template: nama.value,
                  template,
               }
               axios.post('<?= base_url('admin/template/insert') ?>', data)
                  .then(function (response) {
                     Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.data.pesan,
                        showConfirmButton: false,
                        timer: 2500
                     })
                     setTimeout(() => {
                        window.location.href = '/admin/template'
                     }, 2600);
               })
               .catch(function (error) {
                  console.log(error);
               });
            })
            .catch(function (error) {
               // handle error
               console.log(error);
            })
      });
</script>


<!-- modal edit tamu -->

<?= $this->endSection() ?>