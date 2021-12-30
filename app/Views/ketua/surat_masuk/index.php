<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-10">
               <h6 class="m-0 font-weight-bold text-primary">Surat Masuk</h6>
            </div>
            <div class="col-md-2 text-right">
               <a href="/ketua/surat-masuk/print" target="_blank" class="btn btn-sm btn-info">Print Surat Masuk</a>
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
                              <!-- tombol download -->
                              <a href="/ketua/surat-masuk/lihat/<?= $surat['nomor_surat'] ?>" class="btn btn-sm btn-primary">Lihat</a>
                              <a href="/surat/<?= $folder ?>/<?= $surat['file_surat'] ?>" target="_blank" class="btn btn-success btn-sm">Download Surat</a>
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

<script>
   $(document).ready(function () {
      $('#data-surat').DataTable();
   });
</script>


<?= $this->endSection() ?>