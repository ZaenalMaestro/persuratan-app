<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
   <div class="col-xl-12 col-md-12 mb-1">
      <!-- ==== card === -->
      <div class="card">         
         <div class="card-body">
            <div class="row mb-3">
               <div class="col">
                  <h4 class="card-title">Daftar Penelitian</h4>
               </div>
               <div class="col text-right">
                  <a href="/user/data/create" class="btn btn-primary btn-sm">Tambah Penelitian</a>
               </div>
            </div>

            <!-- ==== table ==== -->
            <table id="data-penelitian" class="table table-striped table-bordered" style="width:100%">
               <thead>
                  <tr class="text-center">
                     <th>No.</th>
                     <th>Judul</th>
                     <th>Peneliti</th>
                     <th>Publish</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($daftar_penelitian as $index => $penelitian) : ?>
                  <tr>
                     <td class="text-center"><?= ++$index ?></td>
                     <td><?= $penelitian->judul ?></td>
                     <td width="20%"><?= $penelitian->nama_peneliti ?></td>
                     <td  width="15%" class="text-center"><?= $penelitian->waktu ?></td>
                     <td width="13%" class="text-center">
                        <a href="/user/data/edit/<?= $penelitian->id_penelitian ?>" class="btn btn-success btn-sm">Edit</a>
                        <form action="/user/data/<?= $penelitian->id_penelitian ?>" method="post" class="d-inline">
                           <?= csrf_field() ?>
                           <input type="hidden" name="_method" VALUE="DELETE">
                           <button class="btn btn-danger btn-sm" type="submit">hapus</button>
                        </form>
                     </td>
                  </tr>
                  <?php endforeach ?>
               </tbody>
            </table>
            <!-- ==== end table ==== -->
         </div>
      </div>
      <!-- ==== end card === -->
   </div>
</div>

<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script>
   $(document).ready(function () {
      $('#data-penelitian').DataTable();
   });
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

<?= $this->endSection() ?>