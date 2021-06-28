<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-6">
               <h6 class="m-0 font-weight-bold text-primary">Template Surat</h6>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
               <a href="/admin/template/create" class="btn btn-sm btn-primary">Buat Template</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         <!-- ==== table ==== -->
            <div class="table-responsive">
               <table id="data-surat" class="table table-bordered table-hover" style="width:100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Nama Template</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($templates as $index => $template) : ?>
                        <tr class="text-center">
                           <td><?= ++$index ?></td>
                           <td class="text-left"><?= $template['nama_template'] ?></td>
                           <td>
                              <a href="/admin/template/edit/<?= $template['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                              <form action="" method="post" class="d-inline">
                                 <?= csrf_field() ?>
                                 <input type="hidden" name="_method" value="DELETE">
                                 <input type="hidden" name="id" value="<?= $template['id'] ?>">
                                 <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus <?= $template['nama_template'] ?> ?')">Hapus</button>
                              </form>
                           </td>
                        </tr>
                     <?php endforeach; ?>
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