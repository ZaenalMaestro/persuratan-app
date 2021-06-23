<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Data Surat Masuk</title>
   <style>
      body{
         margin: 40px;
      }
      table, td, th {
         border: 1px solid black;
         padding: 10px;
      }

      table {
         width: 100%;
         border-collapse: collapse;
      }
      .text-center{
         text-align: center;
      }
      .text-left{
         text-align: left;
      }
      .text-right{
         text-align: right;
      }
      .text-justify{
         text-align: justify;
      }
      .text-bold{
         font-weight: bold;
      }
      .mb-0{
         margin-bottom: -15px;
      }
      .mb-1{
         margin-bottom: 10px;
      }

      hr{
         border-top: 3px solid black;
         margin-top: -5px;
      }
   </style>
</head>
<body>
   <h2 class="text-center mb-0">LP2M Universitas Negeri Makassar</h2>
   <p class="text-center mb-1">Alamat : Jl. A. P. Pettarani, Tidung, Kec. Rappocini, Kota Makassar, Sulawesi Selatan</p>
   <hr>
   <h4 class="text-center mb-1"><?= $judul ?></h4>
   <table>
      <thead>
         <tr>
            <th>No.</th>
            <th>Nomor Surat</th>
            <th>Tanggal</th>
            <th>Penerima</th>
            <th>Disposisi</th>
         </tr>
      </thead>
      <tbody>
         <?php $nomor = 1; foreach($surat as $print ) : ?>
            <tr class="text-left">
               <td class="text-center"><?= $nomor++ ?></td>
               <td><?= $print['nomor_surat'] ?></td>
               <td><?= $print['tanggal'] ?></td>
               <td><?= $print['penerima'] ?></td>
               <?php if($print['disposisi'] == 'disposisi') : ?>
                  <td>Sudah</td>
               <?php else : ?>
                  <td>Belum</td>
               <?php endif; ?>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</body>
</html>