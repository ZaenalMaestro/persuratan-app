<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
   <div class="col">
   <div class="card shadow mb-4">
      <div class="card-header py-3">
         <div class="row">
            <div class="col-md-10">
               <h6 class="m-0 font-weight-bold text-primary">Surat Keluar</h6>
            </div>
            <div class="col-md-2 text-right">
               <a href="/ketua/surat-keluar/print" target="_blank" class="btn btn-sm btn-info">Print Surat Keluar</a>
            </div>
         </div>
      </div>
      <div class="card-body">
         <!-- ==== table ==== -->
         <table id="data-surat" class="table table-bordered table-hover" style="width:100%">
                  <thead>
                     <tr class="text-center">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Penerima</th>
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
                           <td width="15%"><!-- tombol download -->
                              <a href="/ketua/surat-keluar/download/<?= $surat['id'] ?>" target="_blank" class="btn btn-success btn-sm">Download Surat</a>
                           </td>
                        </tr>
                     <?php endforeach ?>
                  </tbody>
               </table>
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

<!-- modal edit tamu -->

<?= $this->endSection() ?>