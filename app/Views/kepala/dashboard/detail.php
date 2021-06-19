<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Detail Surat</h6>
      </div>
      <div class="card-body">
         <!-- ==== nomor surat ==== -->
         <div class="row mb-3">
            <div class="col-md-3 h5">Nomor Surat</div>
            <div class="col"><span class="mr-5">:</span> <?= $detail_surat['nomor_surat'] ?></div>
         </div>

         <!-- ==== tanggal ==== -->
         <div class="row mb-3">
            <div class="col-md-3 h5">Tanggal</div>
            <div class="col"><span class="mr-5">:</span> <?= $detail_surat['tanggal'] ?></div>
         </div>

         <!-- ==== penerima ==== -->
         <div class="row mb-3">
            <div class="col-md-3 h5">Penerima</div>
            <div class="col"><span class="mr-5">:</span> <?= $detail_surat['penerima'] ?></div>
         </div>

         <!-- ==== Perihal ==== -->
         <div class="row mb-3">
            <div class="col-md-3 h5">Perihal</div>
            <div class="col"><span class="mr-5">:</span> <?= $detail_surat['perihal'] ?></div>
         </div>

         <!-- ==== File Surat ==== -->
         <div class="row mb-3">
            <div class="col-md-3 h5">File Surat</div>
            <div class="col"><span class="mr-5">:</span> <?= $detail_surat['file_surat'] ?></div>
         </div>

         <!-- tombol download -->
         <a href="/surat/<?= $folder ?>/<?= $detail_surat['file_surat'] ?>" target="_blank" class="btn btn-success">Download Surat</a>
      </div>

   </div>
   </div>
</div>


<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>

<script>
   $(document).ready(function () {
      $('#data-surat').DataTable();
   });

   // tampil modal jika validasi error
   <?php if($validation->getError('penerima')) : ?>
      $(window).on('load', function() {
         $('#disposisiModal').modal('show');
      });

      // hilangkan pesan error jika user memeilih penerima
      const penerima = document.getElementById('penerima')
      penerima.addEventListener('change', () => {
         penerima.classList.remove('is-invalid')
      })
   <?php endif ?>
</script>

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