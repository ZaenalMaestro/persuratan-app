<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
   <div class="col-xl-12 col-md-12 mb-1">
      <!-- ==== card === -->
      <div class="card">
         <div class="card-body mx-3">
            <!-- ==== form ==== -->
            <form action="/user/data/penelitian" method="post" enctype="multipart/form-data" class="mb-3">
               <?= csrf_field() ?>
               <input type="hidden" name="_method" value="PUT">
               <input type="hidden" name="id_penelitian" value="<?= $penelitian->id_penelitian ?>">
               <!-- ==== judul penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputJudul" class="col-sm-3 col-form-label text-dark">Judul Penelitian</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control <?= ($validation->hasError('judul') ? 'is-invalid' : '') ?>"
                        name="judul" id="inputJudul" placeholder="Input judul penelitian..."
                        value="<?= $penelitian->judul ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('judul') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== Nama peneliti ==== -->
               <div class="form-group row mb-4">
                  <label for="inputNama" class="col-sm-3 col-form-label text-dark">Nama Peneliti</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : '') ?>"
                        name="nama" id="inputNama" placeholder="Input nama peneliti..."
                        value="<?= $penelitian->nama_peneliti ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('nama') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== Tanggal Penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputTanggal" class="col-sm-3 col-form-label text-dark">Tanggal Penelitian</label>
                  <div class="col-sm-9">
                     <input type="date"
                        class="form-control <?= ($validation->hasError('tanggal') ? 'is-invalid' : '') ?>"
                        name="tanggal" id="inputTanggal" value="<?= $penelitian->waktu ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('tanggal') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== tempat Penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputTempat" class="col-sm-3 col-form-label text-dark">Tempat Penelitian</label>
                  <div class="col-sm-9">
                     <input type="text"
                        class="form-control <?= ($validation->hasError('tempat') ? 'is-invalid' : '') ?>" name="tempat"
                        id="inputTempat" placeholder="Input tempat penelitian..."
                        value="<?= $penelitian->tempat_palaksanaan ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('tempat') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== deskripsi penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputDeskripsi" class="col-sm-3 col-form-label text-dark">Deskripsi</label>
                  <div class="col-sm-9">
                     <textarea class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : '') ?>" name="deskripsi" id="inputDeskripsi" placeholder="Input deskripsi penelitian..." rows="6"><?= $penelitian->deskripsi ?></textarea>
                     <div class="invalid-feedback">
                        <?= $validation->getError('deskripsi') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== file Jurnal ==== -->
               <div class="form-group row mb-4">
                  <label for="inputJudul" class="col-sm-3 col-form-label text-dark">Jurnal Penelitian</label>
                  <div class="col-sm-9">
                     <div class="input-group">
                        <div class="custom-file">
                           <input type="file"
                              class="custom-file-input <?= ($validation->hasError('jurnal') ? 'is-invalid' : '') ?>"
                              name="jurnal" id="inputJurnal"
                              aria-describedby="inputGroupFileAddon01">
                           <label class="custom-file-label jurnal" for="inputJurnal"
                              value="<?= old('jurnal') ?>"><?= $penelitian->jurnal ?></label>
                        </div>
                     </div>
                     <small
                        class="text-danger mt-1 text-small <?= ($validation->hasError('jurnal') ? 'd-block' : 'd-none') ?>">
                        <?= $validation->getError('jurnal') ?>
                     </small>
                  </div>
               </div>               

               <!-- ==== tombol submit==== -->
               <div class="row">
                  <div class="col text-right">
                     <button class="btn btn-success" type="submit">Ubah Data Penelitian</button>
                  </div>
               </div>
            </form>
            <hr>
            <!-- ==== end form ==== -->

            <!-- ==== form gambar ==== -->
            <form action="/user/data/gambar" method="post" enctype="multipart/form-data" class="my-5">
                  <?= csrf_field() ?>
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="old_gambar" value="<?= $penelitian->nama_gambar ?>">
                  <input type="hidden" name="id_penelitian" value="<?= $penelitian->id_penelitian ?>">
               <div class="form-group row mb-4">
                  <label for="inputGambar" class="col-sm-3 col-form-label text-dark">Gambar Penelitian</label>
                  <div class="col-sm-9">
                     <div class="input-group">
                        <div class="custom-file">
                           <input type="file"
                              class="custom-file-input <?= ($validation->hasError('gambar') ? 'is-invalid' : '') ?>"
                              id="inputGambar" name="gambar">
                           <label class="custom-file-label gambar" for="inputGroupFile02"
                              aria-describedby="inputGroupFileAddon02">
                              <?= $penelitian->nama_gambar ?>
                           </label>
                           </div>
                           <div class="input-group-append">
                              <button class="input-group-text" type="submit">Ubah gambar</button>
                        </div>
                     </div>                     
                     <small
                        class="text-danger text-small <?= ($validation->hasError('gambar') ? 'd-block' : 'd-none') ?>">
                        <?= $validation->getError('gambar') ?>
                     </small><br>
                     <img src="/img/gambar/<?= $penelitian->nama_gambar ?>" alt="images" class="img-thumbnail mt-2"
                        width="200">
                  </div>
               </div>
            </form>
            <hr>
            <!-- ==== form gambar ==== -->

            <!-- ==== form dokumentasi ==== -->
            <div class="form-group row my-4">
               <label for="inputDokumentasi" class="col-sm-3 col-form-label text-dark">Dokumentasi Penelitian</label>
                  <div class="col-sm-9">
                     <form action="/user/data/dokumentasi" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penelitian" value="<?= $penelitian->id_penelitian ?>">
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" class="custom-file-input <?= ($validation->hasError('dokumentasi') ? 'is-invalid' : '') ?>" id="inputDokumentasi" name="dokumentasi[]" multiple>
                              <label class="custom-file-label dokumentasi" for="inputDokumentasi" aria-describedby="inputGroupFileAddon02">
                                 Pilih gambar dokumentasi
                              </label>
                              </div>
                              <div class="input-group-append">
                                 <button class="input-group-text" type="submit">Tambah Dokumentasi</button>
                           </div>
                        </div>
                        <!-- ==== pesan validasi error -->
                        <small
                           class="text-danger text-small <?= ($validation->hasError('dokumentasi') ? 'd-block' : 'd-none') ?>">
                           <?= $validation->getError('dokumentasi') ?>
                        </small><br>
                     </form>

                     <div class="row">
                        <?php foreach($dokumentasi as $doc) :?>
                           <div class="col-md-3 mb-4">
                              <form action="/user/data/dokumentasi/<?= $doc->id_gambar ?>" method="post">
                                 <?= csrf_field() ?>
                                 <input type="hidden" name="_method" value="DELETE">
                                 <button type="submit" class="btn btn-sm btn-danger btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-trash"></i></span>
                                    <span class="text">hapus</span>
                                 </button>
                                 <img src="/img/dokumentasi/<?= $doc->nama_gambar ?>" alt="images" class="img-thumbnail"
                                    width="200">
                              </form>
                           </div>
                        <?php endforeach ?>
                     </div>
                  </div>
            </div>
                  <!-- ==== end form dokumentasi ==== -->
         </div>
      </div>
      <!-- ==== end card === -->
   </div>
</div>

<!-- ==== script ==== -->
<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>
<script>
   $(document).ready(function () {
      $('#data-penelitian').DataTable();
   });

   $('input[type="file"]').change(function (e) {
      const form = e.target.getAttribute('id');
      var fileName = e.target.files[0].name;
      
      if(form === 'inputJurnal') {
         $('.jurnal').html(fileName);
      }else if(form === 'inputGambar') {
         $('.gambar').html(fileName);
      }else if(form === 'inputDokumentasi') {
         let multipleFile = ''
         for (let i = 0; i < e.target.files.length; i++) {
            if(i > 0) multipleFile += ' - '            
            multipleFile += e.target.files[i].name;
         }
         $('.dokumentasi').html(multipleFile);
      }
      
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