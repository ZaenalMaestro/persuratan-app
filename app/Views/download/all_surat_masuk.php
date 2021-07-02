<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Download Surat masuk</title>
   <link rel="stylesheet" href="/css/download.css">
</head>
<body>   
   <div class="content">
      <div class="noPrint container">
         <button onclick="window.print()" class="btn btn-print">Print</button>
      </div>

      <img src="/assets/img/asset-unm/logo-unm-surat.PNG" alt="" class="img">
      <p class="header">
               KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,<br>
         RISET, DAN TEKNOLOGI<br>
         UNIVERSITAS NEGERI MAKASSAR (UNM)<br>
         <span class="lp2m-text">LEMBAGA PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT</span><br>
      </p>
      <p class="address">Menara Pinisi Lantai 10 Jl. A.P. Pettarani Makassar 90222</p>
      <p class="telp">Telp. (0411) 865677, Fax(0411) 861377</p>
      <p class="web">Laman: <a href="www.unm.ac.id">www.unm.ac.id</a> E-Mail : <a href="lppm@unm.ac.id">lppm@unm.ac.id</a></p>
      </p>
      <hr class="horizontal-line-table">
      <div class="isi-surat-table">
         <p class="title-isi-surat">Laporan Surat Masuk:</p>
         <table class="table-surat-keluar">
            <thead>
               <tr>
                  <th>No.</th>
                  <th>Nomor Surat</th>
                  <th>Tanggal Surat</th>
                  <th>Perihal</th>
                  <th>Penerima</th>
                  <th>Disposisi</th>
               </tr>
            </thead>
            <tbody>
               <?php $nomor = 1; foreach($surat as $print ) : ?>
                  <tr class="text-left">
                     <td class="text-center"><?= $nomor++ ?></td>
                     <td><?= $print['nomor_surat'] ?></td>
                     <td class="text-center"><?= $print['tanggal'] ?></td>
                     <td><?= $print['perihal'] ?></td>
                     <td width="15%"><?= $print['penerima'] ?></td>
                     <?php if($print['disposisi'] == 'disposisi'): ?>
                        <td class="text-center">Ya</td>
                     <?php else: ?>
                        <td class="text-center">Belum</td>
                     <?php endif ?>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</body>
</html>
