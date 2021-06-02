<?= $this->include('layout/_header'); ?>


<!-- sidebar -->
<?= $this->include('layout/_sidebar') ?>
<!-- content wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
   <!-- main content -->
   <div id="content">
      <!-- top bar -->


      <!-- page content -->
      <div class="container-fluid">
         <h1 class="h3 mb-0 text-gray-800 my-4"><?= $title ?></h1>
         <?= $this->renderSection('content') ?>
      </div>
   </div>
   <!-- footer -->
   <?= $this->include('layout/_footer') ?>