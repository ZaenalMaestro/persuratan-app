<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-6">
               <h6 class="m-0 font-weight-bold text-primary">Surat Keluar</h6>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
               <a href="/sekertaris/surat-keluar/print" target="_blank" class="btn btn-sm btn-success">Print Surat Keluar</a>
               <a href="/sekertaris/surat-keluar/insert" class="btn btn-sm btn-primary">Buat Surat Keluar</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         <!-- ==== table ==== -->
            <div class="table-responsive">
               <table id="data-surat" class="table table-bordered table-hover" style="width:100%">
                  <thead>
                     <tr class="text-center">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Penerima</th>
                        <th>status</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1; foreach($surat_hari_ini as $surat) :?>
                        <tr class="text-center">
                           <td width="1%"><?= $no++ ?></td>
                           <td width="13%"><?= $surat['tanggal_surat'] ?></td>
                           <td width="20%"><?= $surat['nomor_surat'] ?></td>
                           <td><?= $surat['perihal'] ?></td>
                           <td width=""><?= $surat['penerima'] ?></td>
                           <td width=""><?= $surat['status_komentar'] ?></td>
                           <td width="15%">
                              <?php if($surat['status_komentar'] == 'diterima') :?>
                                 <button type="button" disabled class="btn btn-sm btn-secondary">Review</button>
                                 <button type="button" disabled class="btn btn-sm btn-secondary">Terima</button>
                              <?php else : ?>
                                 <a href="/sekertaris/surat-keluar/<?= $surat['id'] ?>" class="btn btn-sm btn-primary">Review</a>

                                 <form action="/sekertaris/surat-keluar/terima" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id" value="<?= $surat['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('yakin terima surat keluar?')">Terima</button>
                                 </form>
                              <?php endif; ?>
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
<script src="/js/admin/modal-disposisi.js"></script>

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