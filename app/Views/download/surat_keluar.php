<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Download Surat Keluar</title>
   <link rel="stylesheet" href="/css/download.css">
   <style>
      figure.image{
         margin-inline: 0;
         margin-bottom: -120px;
      }
      .image {
         display: flex;
         justify-content: center;
         padding: 0;
      }

      .image-style-align-right {
         width: 100%;
         display: flex;
         justify-content: end;
      }
      .image-style-align-left {
         width: 100%;
         display: flex;
         justify-content: start;
      }
   </style>
</head>
<body>   
   <div class="content">
      <div class="noPrint container">
         <button onclick="window.print()" class="btn btn-print">Download</button>
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
      <hr class="horizontal-line">
      <div class="isi-surat">
         <?= $surat_keluar['isi_surat'] ?>
      </div>
   </div>
</body>
</html>
