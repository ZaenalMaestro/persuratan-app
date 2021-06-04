<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-6">
               <h6 class="m-0 font-weight-bold text-primary">Data Penerima Surat</h6>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
               <button type="button" class="btn btn-sm btn-primary btn-tambah" data-toggle="modal" data-target="#disposisiModal">Tambahkan Penerima Surat</button>
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
                        <th>NIK</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $no = 1; foreach($penerima_surat as $penerima) :?>
                        <tr class="text-center">
                           <td><?= $no++ ?></td>
                           <td class="text-left"><?= $penerima['nama_lengkap'] ?></td>
                           <td><?= $penerima['nomor_induk'] ?></td>
                           <td>
                              <button type="button" class="btn btn-sm btn-success btn-edit" data-nama="<?= $penerima['nama_lengkap'] ?>" data-nomor-induk="<?= $penerima['nomor_induk'] ?>" data-toggle="modal" data-target="#disposisiModal">Edit</button>

                              <form action="/admin/penerima-surat" method="POST" class="d-inline">
                                 <?= csrf_field() ?>
                                 <input type="hidden" name="_method" value="DELETE">
                                 <input type="hidden" name="penerima" value="<?= $penerima['nama_lengkap'] ?>">
                                 <input type="hidden" name="nomor-induk" value="<?= $penerima['nomor_induk'] ?>">
                                 <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('yakin hapus <?= $penerima['nama_lengkap'] ?>?')">hapus</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Form Tambah Penerima Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

         <!-- === form tambah ==== -->
         <form action="/admin/penerima-surat" method="post" class="d-block form-tambah">
            <?= csrf_field() ?>
            
            <!-- ==== nama penerima ==== -->
            <div class="form-group">
               <label for="nama-penerima">Nama Penerima</label>
               <input type="text" name="nama-penerima" class="form-control <?= ($validation->hasError('nama-penerima') && $validation->hasError('form-tambah') ? 'is-invalid' : '') ?>" id="nama-penerima" placeholder="input nama penerima surat..." value="<?= $validation->hasError('form-tambah') ? old('nama-penerima') : '' ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('nama-penerima') ?> 
               </div>
            </div>

            <!-- ==== Nomor Induk ==== -->
            <div class="form-group">
               <label for="nomor-induk">Nomor Induk</label>
               <input type="text" name="nomor-induk" class="form-control <?= ($validation->hasError('nomor-induk') && $validation->hasError('form-tambah') ? 'is-invalid' : '') ?>" id="nomor-induk" placeholder="input nomor induk..." value="<?= $validation->hasError('form-tambah') ? old('nomor-induk') : '' ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('nomor-induk') ?> 
               </div>
            </div>

            <!-- ==== Password ==== -->
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : '') ?>" id="password" placeholder="input password...">
               <div class="invalid-feedback">
                  <?= $validation->getError('password') ?> 
               </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Tambahkan penerima surat</button>
         </form>

         <!-- === form edit ==== -->
         <form action="/admin/penerima-surat" method="post" class="d-none form-edit">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="nomor-induk-lama" id="nomor-induk-lama" value="<?= old('nomor-induk-lama') ?>">
            <input type="hidden" name="nama-penerima-lama" id="penerima-surat-lama">
            <!-- ==== nama penerima ==== -->
            <div class="form-group">
               <label for="nama-penerima">Nama Penerima</label>
               <input type="text" name="nama-penerima" class="form-control <?= ($validation->hasError('nama-penerima') ? 'is-invalid' : '') ?>" id="input-nama-penerima" placeholder="input nama penerima surat..." value="<?= old('nama-penerima') ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('nama-penerima') ?> 
               </div>
            </div>

            <!-- ==== Nomor Induk ==== -->
            <div class="form-group">
               <label for="nomor-induk">Nomor Induk</label>
               <input type="text" name="nomor-induk" class="form-control <?= ($validation->hasError('nomor-induk') ? 'is-invalid' : '') ?>" id="input-nomor-induk" placeholder="input nomor induk..." value="<?= old('nomor-induk') ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('nomor-induk') ?> 
               </div>
            </div>

            <!-- ==== Password ==== -->
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : '') ?>" id="input-password" placeholder="input password...">
               <div class="invalid-feedback">
                  <?= $validation->getError('password') ?> 
               </div>
            </div>

            <button type="submit" class="btn btn-success btn-block">Edit penerima surat</button>
         </form>

      </div>
    </div>
  </div>
</div>

<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script src="/js/admin/modal-penerima-surat.js"></script>

<script>
   $(document).ready(function () {
      $('#data-surat').DataTable();
   });

   // tampil modal jika validasi error
   <?php if($validation->hasError('form-edit')) : ?>
      $(window).on('load', function() {
         $('#disposisiModal').modal('show');
         showFormEdit()
         document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-edit')){
               input_nomor_induk.classList.remove('is-invalid')
               input_nama_penerima.classList.remove('is-invalid')
               input_password.classList.remove('is-invalid')
            }
         })
      });
   <?php elseif($validation->hasError('form-tambah')) : ?>
      $(window).on('load', function() {
         $('#disposisiModal').modal('show');
         showFormTambah()
         document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-edit')){
               input_nomor_induk.classList.remove('is-invalid')
               input_nama_penerima.classList.remove('is-invalid')
               input_password.classList.remove('is-invalid')
            }
         })
      });
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