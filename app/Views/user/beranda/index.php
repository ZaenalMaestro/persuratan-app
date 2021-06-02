<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="row">
   <div class="col-xl-12 col-md-12 mb-1">
      <?php foreach($daftar_penelitian as $penelitian) : ?>
         <!-- ==== card === -->
         <div class="card mb-3">
            <div class="row no-gutters">
               <!-- ==== card image ==== -->
               <div class="col-md-2">
                  <img src="/img/gambar/<?= $penelitian->nama_gambar ?>" class="card-img" alt="image">
               </div>
               <!-- ==== end card image ==== -->

               <!-- ==== card body ==== -->
               <div class="col-md-10">
                  <div class="card-body">
                     <h3 class="text-dark"><?= ucwords($penelitian->judul) ?></h3>
                     <p class="card-text mt-0"><small class="text-muted">Peneliti :
                           <?= $penelitian->nama_peneliti ?></small></p>
                     <p class="card-text"><?= word_limiter($penelitian->deskripsi, 30) ?></p>
                     <a href="/user/detail/<?= $penelitian->id_penelitian ?>" class="card-link">Detail penelitian →</a>
                  </div>
               </div>
               <!-- ==== end card body ==== -->
            </div>
         </div>
         <!-- ==== end card === -->
      <?php endforeach; ?>
      <!-- ==== pagination ==== -->
      <?= $pager->links('daftar_penelitian', 'penelitian_pager') ?>
   </div>
</div>




<script src="/js/sweetalert2.js"></script>
<script src="/js/jquery.js"></script>

<script src="/js/dataTables.js"></script>
<script src="/js/dataTables.bootstrap4.js"></script>

<?= $this->endSection() ?>