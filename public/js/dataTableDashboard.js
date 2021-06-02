$(document).ready(function () {
   $('#tabel-video').DataTable({
      "processing": true,
      "ajax": 'http://localhost:8080/show',
      "columns": [{
            "data": "nomor"
         },
         {
            "data": "nama_video"
         },
         {
            "data": "status"
         },
         {
            "data": "aksi"
         },

      ],
      "columnDefs": [{
            "targets": [0, 2, 3],
            "className": "text-center"
         },
         {
            "targets": 2,
            "width": "60px",
            "render": function (data, type, row) {
               return '<span class="badge badge-primary">Enkripsi</span>';
            }
         },
         {
            "targets": 3,
            "width": "200px",
            "render": function (data, type, row) {
               return `<a href="video/${data.nama_video}" download class="btn btn-sm btn-danger ml-2">
                           <i class="fas fa-download"></i><span> Download</span>
                        </a>`;
            }
         }
      ]
   });
});