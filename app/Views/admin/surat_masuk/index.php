<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-6">
               <h6 class="m-0 font-weight-bold text-primary">Surat Masuk</h6>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
               <a href="/admin/surat-masuk/print" target="_blank" class="btn btn-sm btn-success mr-2">Print Surat Masuk</a>
               <a href="/admin/surat-masuk/insert" class="btn btn-sm btn-primary">Buat Surat Masuk</a>
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
                        <th>Nama</th>
                        <th>Tanggal Surat</th>
                        <th>Perihal</th>
                        <th>Disposisi</th>
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
                              <?php if($surat['disposisi'] == 'disposisi') : ?>
                                 <span class="text-success font-weight-bolder">&#10003;</span>
                              <?php else : ?>
                                 <span class="text-success font-weight-bolder">-</span>
                              <?php endif ?>
                           </td>
                           <td>
                              <!-- === edit ===  -->
                              <a href="/admin/surat-masuk/<?= $surat['nomor_surat'] ?>" class="btn btn-sm btn-success">Edit</a>
                              <!-- === hapus === -->
                              <form action="/admin/surat-masuk" method="POST" class="d-inline">
                                 <?= csrf_field() ?>
                                 <input type="hidden" name="_method" value="DELETE">
                                 <input type="hidden" name="nomor-surat" value="<?= $surat['nomor_surat'] ?>">
                                 <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('yakin hapus surat <?= $surat['penerima'] ?> : <?= $surat['perihal'] ?>?')">hapus</button>
                              </form>
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

<!-- Modal -->
<div class="modal fade" id="disposisiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         <!-- === form ==== -->
         <form action="/admin" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="nomor-surat" id="nomor-surat">
            <div class="form-group">
               <label for="exampleFormControlSelect1">Nama Penerima</label>
               <select class="form-control <?= ($validation->hasError('penerima') ? 'is-invalid' : '') ?>" id="penerima" name="penerima">
                  <option value="">Pilih Penerima</option>
                  <?php foreach($penerima_surat as $penerima) : ?>
                     <?php if(strtolower($penerima['nama_lengkap']) !== 'operator' ) : ?>
                        <option value="<?= $penerima['nama_lengkap'] ?>"><?= $penerima['nama_lengkap'] ?></option>
                     <?php endif; ?>
                  <?php endforeach ?>
               </select>
               <div class="invalid-feedback">
                     <?= $validation->getError('penerima') ?>
                  </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Disposisi</button>
         </form>

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