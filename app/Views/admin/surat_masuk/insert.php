<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Form Input Surat Masuk</h6>
      </div>
      <div class="card-body">
         <!-- ==== form ==== -->
         <form action="/admin/surat-masuk" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <!-- ==== nomor surat ==== -->
            <div class="form-group">
               <label for="nomorSurat">Nomor Surat</label>
               <input type="text" name="nomor-surat" class="form-control <?= ($validation->hasError('nomor-surat') ? 'is-invalid' : '') ?>" id="nomorSurat" placeholder="input nomor surat..." value="<?= old('nomor-surat') ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('nomor-surat') ?>
               </div>
            </div>

            <!-- ==== tanggal ==== -->
            <div class="form-group">
               <label for="tanggal">Tanggal</label>
               <input type="date" name="tanggal" class="form-control <?= ($validation->hasError('tanggal') ? 'is-invalid' : '') ?>" id="tanggal" placeholder="input tanggal surat..." value="<?= old('tanggal') ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('tanggal') ?> 
               </div>
            </div>
            
            <!-- === penerima surat === -->
            <div class="form-group">
               <label for="penerima">Penerima Surat</label>
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

            <!-- ==== perihal ==== -->
            <div class="form-group">
               <label for="perihal">Perihal</label>
               <input type="text" name="perihal" class="form-control <?= ($validation->hasError('perihal') ? 'is-invalid' : '') ?>" id="perihal" placeholder="input perihal surat..." value="<?= old('perihal') ?>">
               <div class="invalid-feedback">
                  <?= $validation->getError('perihal') ?> 
               </div>
            </div>

            <!-- ==== File surat ==== -->
            <!-- ==== file Jurnal ==== -->
            <div class="form-group">
               <label for="fileSurat">File Surat</label>
               <div class="custom-file">
                  <input type="file" class="custom-file-input <?= ($validation->hasError('jurnal') ? 'is-invalid' : '') ?>" name="file-surat" id="fileSurat"
                     aria-describedby="inputGroupFileAddon01" value="<?= old('file-surat') ?>">
                  <label class="custom-file-label file-surat" for="file-surat">Pilih file surat</label>
               </div>
               <small class="text-danger mt-1 text-small <?= ($validation->hasError('file-surat') ? 'd-block' : 'd-none') ?>">
                  <?= $validation->getError('file-surat') ?>
               </small>
            </div>

            <!-- tombol buat surat  -->
            <div class="row my-4">
               <div class="col text-right">
                  <button type="submit" class="btn btn-primary">Buat Surat masuk</button>
               </div>
            </div>
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

<script>
   $('input[type="file"]').change(function (e) {
      var fileName = e.target.files[0].name;
      $('.file-surat').html(fileName);      
   });
</script>


<!-- modal edit tamu -->

<?= $this->endSection() ?>