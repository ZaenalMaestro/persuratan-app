<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
   <div class="col-xl-12 col-md-12 mb-1">
      <!-- ==== card === -->
      <div class="card">
         <div class="card-body mx-3">
            <!-- ==== form ==== -->
            <form action="/user/data/insert" method="post" enctype="multipart/form-data">
               <?= csrf_field() ?>
               <!-- ==== judul penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputJudul" class="col-sm-3 col-form-label text-dark">Judul Penelitian</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control <?= ($validation->hasError('judul') ? 'is-invalid' : '') ?>" name="judul" id="inputJudul"
                        placeholder="Input judul penelitian..." autofocus value="<?= old('judul') ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('judul') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== Nama peneliti ==== -->
               <div class="form-group row mb-4">
                  <label for="inputNama" class="col-sm-3 col-form-label text-dark">Nama Peneliti</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : '') ?>" name="nama" id="inputNama"
                        placeholder="Input nama peneliti..." value="<?= old('nama') ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('nama') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== Tanggal Penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputTanggal" class="col-sm-3 col-form-label text-dark">Tanggal Penelitian</label>
                  <div class="col-sm-9">
                     <input type="date" class="form-control <?= ($validation->hasError('tanggal') ? 'is-invalid' : '') ?>" name="tanggal" id="inputTanggal" value="<?= old('tanggal') ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('tanggal') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== tempat Penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputTempat" class="col-sm-3 col-form-label text-dark">Tempat Penelitian</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control <?= ($validation->hasError('tempat') ? 'is-invalid' : '') ?>" name="tempat" id="inputTempat" placeholder="Input tempat penelitian..." value="<?= old('tempat') ?>">
                     <div class="invalid-feedback">
                        <?= $validation->getError('tempat') ?>
                     </div>
                  </div>
               </div>

               <!-- ==== deskripsi penelitian ==== -->
               <div class="form-group row mb-4">
                  <label for="inputDeskripsi" class="col-sm-3 col-form-label text-dark">Deskripsi</label>
                  <div class="col-sm-9">
                     <textarea class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : '') ?>" name="deskripsi" id="inputDeskripsi" placeholder="Input deskripsi penelitian..." rows="6"><?= old('deskripsi') ?></textarea>
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
                           <input type="file" class="custom-file-input <?= ($validation->hasError('jurnal') ? 'is-invalid' : '') ?>" name="jurnal" id="inputJurnal"
                              aria-describedby="inputGroupFileAddon01" value="<?= old('jurnal') ?>">
                           <label class="custom-file-label jurnal" for="inputJurnal">Pilih jurnal</label>
                        </div>
                     </div>
                     <small class="text-danger mt-1 text-small <?= ($validation->hasError('jurnal') ? 'd-block' : 'd-none') ?>">
                        <?= $validation->getError('jurnal') ?>
                     </small>                        
                  </div>
               </div>

               <!-- ==== file gambar ==== -->
               <div class="form-group row mb-4">
                  <label for="inputGambar" class="col-sm-3 col-form-label text-dark">Gambar Penelitian</label>
                  <div class="col-sm-9">
                     <div class="input-group mb-3">
                        <div class="custom-file">
                           <input type="file" class="custom-file-input <?= ($validation->hasError('gambar') ? 'is-invalid' : '') ?>" name="gambar" id="inputGambar"
                              aria-describedby="inputGroupFileAddon01" value="<?= old('gambar') ?>">
                           <label class="custom-file-label gambar" for="inputJurnal">Pilih gambar</label>
                        </div>
                     </div>
                     <small class="text-danger mt-1 text-small <?= ($validation->hasError('gambar') ? 'd-block' : 'd-none') ?>">
                        <?= $validation->getError('gambar') ?>
                     </small>       
                  </div>
               </div>

               <!-- ==== file dokumentasi ==== -->
               <div class="form-group row mb-4">
                  <label for="inputDokumentasi" class="col-sm-3 col-form-label text-dark">Dokumentasi Penelitian</label>
                  <div class="col-sm-9">
                     <div class="input-group mb-3">
                        <div class="custom-file">
                           <input type="file" class="custom-file-input <?= ($validation->hasError('dokumentasi') ? 'is-invalid' : '') ?>" name="dokumentasi[]" multiple id="inputDokumentasi"
                              aria-describedby="inputGroupFileAddon01" value="<?= old('dokumentasi') ?>">
                           <label class="custom-file-label dokumentasi" for="inputJurnal">Pilih gambar dokumentasi</label>
                        </div>
                     </div>
                     <small class="text-danger mt-1 text-small <?= ($validation->hasError('dokumentasi') ? 'd-block' : 'd-none') ?>">
                        <?= $validation->getError('dokumentasi') ?>
                     </small>    
                  </div>
               </div>

               <!-- ==== tombol submit==== -->
               <div class="row">
                  <div class="col text-right">
                     <button class="btn btn-primary" type="submit">Simpan Data Penelitian</button>
                  </div>
               </div>
            </form>
            <!-- ==== end form ==== -->
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
<?= $this->endSection() ?>