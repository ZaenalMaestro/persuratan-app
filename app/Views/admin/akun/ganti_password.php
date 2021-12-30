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
            <h6 class="m-0 font-weight-bold text-primary">Ganti Password</h6>
         </div>
         <div class="card-body ml-5" style="margin-right:2.2cm">
            <!-- ==== form ==== -->         
            <form action="/<?= strtolower($role) ?>/password/update" method="POST">
               <?= csrf_field() ?>
               <input type="hidden" name="_method" value="PUT">
               <!-- nomor surat -->
               <input type="hidden" name="nomor_induk" value="<?= session('nomor_induk') ?>">
               <div class="form-group">
                  <label for="exampleFormControlInput1">Nama</label>
                  <input type="text" id="nomor-surat" class="form-control" value="<?= session('nama') ?>" disabled>
               </div>
               <div class="form-group">
                  <label for="exampleFormControlInput1">Password Baru</label>
                  <input type="text" id="password" name="password" class="form-control" placeholder="password" >
               </div>

               <!-- <input type="checkbox" name="" id="show-password" value="show">
               <label for="">Tampilkan password</label> -->
               
               <button type="submit" id="submit" class="btn btn-md btn-primary btn-block">Ganti Password</button>
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

<!-- ==== tampil pesan jika telah menambahkan data ==== -->
<?php if(session()->getFlashData('pesan')) :?>
   <script>
         setTimeout(() => {
            Swal.fire({
               position: 'center',
               icon: 'success',
               title: '<?= session()->getFlashData('pesan') ?>',
               showConfirmButton: false,
               timer: 2500
            })
         }, 1000);
   </script>
<?php elseif(session()->getFlashData('pesan_error')) :?>
   <script>
         setTimeout(() => {
            Swal.fire({
               position: 'center',
               icon: 'error',
               title: '<?= session()->getFlashData('pesan_error') ?>',
               showConfirmButton: false,
               timer: 2500
            })
         }, 1000);
   </script>
<?php endif ?>

<!-- modal edit tamu -->

<?= $this->endSection() ?>