$(document).ready(function () {
   $('#tabel-video').DataTable({
      "processing": true,
      "ajax": 'http://localhost:8080/testing',
      "columns": [{
            "data": "nomor"
         },
         {
            "data": "nama_file"
         },
         {
            "data": "ukuran_file"
         },
         {
            "data": "kecepatan_enkripsi"
         },
         {
            "data": "kecepatan_dekripsi"
         },

      ],
      "columnDefs": [{
            "targets": [0, 2, 3, 4],
            "className": "text-center"
         },
         {
            "targets": 2,
            "className": "text-left",
         }
      ]
   });
});