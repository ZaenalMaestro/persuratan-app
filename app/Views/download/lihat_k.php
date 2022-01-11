<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lihat Surat Keluar</title>
   <link rel="stylesheet" href="/css/download.css">   
   <link rel="stylesheet" href="/css/preview.css">
</head>
<body>
   <a href="/ketua/surat-keluar" class="btn btn-print back">kembali</a>
   <h1 class="judul">Lihat Surat Keluar</h1>
   <div class="content">
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
      <hr class="horizontal-line">
      <div class="isi-surat">
         <?= $surat_keluar['isi_surat'] ?>
      </div>
   </div>
</body>
</html>
