<!DOCTYPE html>
<html lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">

   <title><?= $role ?> - <?= $title ?></title>

   <!-- Custom fonts for this template-->
   <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   
   <!-- Custom styles for this template-->
   <link href="/css/sb-admin-2.min.css" rel="stylesheet">

   <!-- data tables -->
   <link rel="stylesheet" href="/css/dataTables.bootstrap4.css">
   
   <link rel="stylesheet" href="/css/mystyle.css">
   <style type="/text/css">
      /* Chart.js */
      @keyframes chartjs-render-animation {
         from {
            opacity: .99
         }

         to {
            opacity: 1
         }
      }

      .chartjs-render-monitor {
         animation: chartjs-render-animation 1ms
      }

      .chartjs-size-monitor,
      .chartjs-size-monitor-expand,
      .chartjs-size-monitor-shrink {
         position: absolute;
         direction: ltr;
         left: 0;
         top: 0;
         right: 0;
         bottom: 0;
         overflow: hidden;
         pointer-events: none;
         visibility: hidden;
         z-index: -1
      }

      .chartjs-size-monitor-expand>div {
         position: absolute;
         width: 1000000px;
         height: 1000000px;
         left: 0;
         top: 0
      }

      .chartjs-size-monitor-shrink>div {
         position: absolute;
         width: 200%;
         height: 200%;
         left: 0;
         top: 0
      }
   </style>
</head>

<body id="page-top">
   <div id="wrapper">