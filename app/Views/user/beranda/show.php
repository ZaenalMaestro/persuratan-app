<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
   <div class="col-xl-12 col-md-12 mb-1">
      <!-- ==== card === -->
      <div class="card">
         <div class="card-body">
            <h3 class="card-title text-center text-dark"><?= $penelitian->judul ?></h3>
               <h6 class="card-text text-center text-dark font-italic">Peneliti : <?= $penelitian->nama_peneliti ?></h6>
               <hr>
               <div class="row">
                  <div class="col-md-8 mr-5 ml-3 mb-4">      
                     <img src="/img/gambar/<?= $penelitian->nama_gambar ?>" class="card-img" alt="image">                  
                     <h3 class="card-text text-dark my-3">Deskripsi</h3>
                     <p class="card-text text-justify"><?= $penelitian->deskripsi ?></p>
                  </div>
                  <div class="col-md-3 align-item-center">
                     <a href="/jurnal/<?= $penelitian->jurnal ?>" target="_blank" class="btn btn-primary btn-md btn-block mb-2">PDF</a>
                     <ul class="list-group">
                        <li class="list-group-item">
                           <span class="font-weight-bold text-dark d-block">peneliti:</span>
                           <?= $penelitian->nama_peneliti ?>
                        </li>
                        <li class="list-group-item">
                           <span class="font-weight-bold text-dark d-block">Publikasi:</span>
                           <?= $penelitian->waktu ?>
                        </li>
                        <li class="list-group-item">
                           <span class="font-weight-bold text-dark d-block">Lokasi Penelitian:</span>
                           <?= $penelitian->tempat_palaksanaan ?>
                        </li>
                     </ul>
                  </div>
               </div>
               <!-- ==== dokumentasi penelitian ==== -->
               <div class="row">
                  <div class="col ml-3">
                     <hr>
                     <h3 class="card-title text-dark text-left">Dokumentasi</h3>
                     <?php foreach($dokumentasi as $doc) : ?>
                        <img src="/img/dokumentasi/<?= $doc->nama_gambar ?>" class="rounded mx-3 my-3" alt="image" width="300">
                     <?php endforeach ?>
                  </div>
               </div>
               <!-- ==== end dokumentasi penelitian ==== -->

         </div>
      </div>
      <!-- ==== end card === -->
   </div>
</div>




<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>

<?= $this->endSection() ?>