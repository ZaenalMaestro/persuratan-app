<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- ==== jumlah data persuratan ==== -->
<div class="row">
   <!-- ==== surat Masuk ==== -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
         <div class="row no-gutters align-items-center">
            <div class="col mr-2">
               <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $total_surat_masuk ?></div>
               <div class="h3 text-xs font-weight-bold text-primary mb-1"><h5>Surat Masuk</h5></div>
            </div>
            <div class="col-auto">
               <i class="fas fa-envelope fa-fw fa-2x text-gray-300"></i>
            </div>
         </div>
         </div>
      </div>
   </div>

   <!-- ==== Surat Keluar ==== -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
         <div class="row no-gutters align-items-center">
            <div class="col mr-2">
               <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $total_surat_keluar ?></div>
               <div class="h3 text-xs font-weight-bold text-primary mb-1"><h5>Surat Keluar</h5></div>
            </div>
            <div class="col-auto">
               <i class="fas fa-envelope fa-fw fa-2x text-gray-300"></i>
            </div>
         </div>
         </div>
      </div>
   </div>

   <!-- ==== Disposisi ==== -->
   <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
         <div class="card-body">
         <div class="row no-gutters align-items-center">
            <div class="col mr-2">
               <div class="h2 mb-0 font-weight-bold text-gray-800"><?= $total_disposisi ?></div>
               <div class="h3 text-xs font-weight-bold text-primary mb-1"><h5>Disposisi</h5></div>
            </div>
            <div class="col-auto">
               <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
         </div>
         </div>
      </div>
   </div>
</div>
<!-- ==== end jumlah data persuratan ==== -->

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Surat Hari Ini</h6>
      </div>
      <div class="card-body">
         <!-- ==== table ==== -->
            <div class="table-responsive">
               <table id="data-surat" class="table table-bordered table-hover" style="width:100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Surat</th>
                        <th>Perihal</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1; foreach($surat_hari_ini as $surat) :?>
                        <tr class="text-center">
                           <td><?= $no++ ?></td>
                           <td><?= $surat['penerima'] ?></td>
                           <td><?= $surat['tanggal'] ?></td>
                           <td width="30%"><?= $surat['perihal'] ?></td>
                           <td>
                           <a href="/kepala/detail/<?= $surat['id'] ?>" class="btn btn-sm btn-success">detail</a>
                           </td>
                        </tr>
                     <?php endforeach ?>
                  </tbody>
               </table>
            </div>
            <!-- ==== end table ==== -->
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