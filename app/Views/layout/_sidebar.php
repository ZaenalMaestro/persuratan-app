<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center my-4" href="index.html">
      <div class="sidebar-brand-icon mt-5">
         <h5 class="font-weight-bolder"><?= strtoupper($role) ?></h5>
         <?php if(session('role') == 'user') : ?>
            <div class="sidebar-brand-text mx-1"><?= session('nama') ?></div>
         <?php endif ?>
      </div>
   </a>

   <!-- Divider -->
   <hr class="sidebar-divider my-0">

   <!-- Heading -->
   <div class="sidebar-heading mt-3">
      Menu
   </div>

   <!-- Nav Item - dashboard -->
   <li class="nav-item <?= ($active_link == 'dashboard') ? 'active' : '' ?>">
      <a class="nav-link" href="/<?= strtolower($role) ?>">
         <i class="fas fa-tachometer-alt"></i>
         <span>Dashboard</span></a>
   </li>

   <!-- === nav item data surat === -->
   <li class="nav-item <?= ($active_link == 'surat_masuk' || $active_link == 'surat_keluar') ? 'active' : '' ?>">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <i class="fas fa-envelope"></i>
         <span>Surat</span>
      </a>
      <div id="collapseTwo" class="collapse <?= ($active_link == 'surat_masuk' || $active_link == 'surat_keluar') ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
         <div class="bg-white py-2 collapse-inner rounded">
         <a class="collapse-item <?= ($active_link == 'surat_masuk') ? 'active' : '' ?>" href="/admin/surat-masuk">Surat Masuk</a>
         <a class="collapse-item <?= ($active_link == 'surat_keluar') ? 'active' : '' ?>" href="/admin/surat-keluar">Surat Keluar</a>
         </div>
      </div>
   </li>

   <!-- Nav Item - penerima surat -->
   <li class="nav-item <?= ($active_link == 'penerima_surat') ? 'active' : '' ?>">
      <a class="nav-link" href="/<?= strtolower($role) ?>/#">
         <i class="fas fa-user"></i>
         <span>Penerima Surat</span></a>
   </li>

   <!-- Nav Item - keluar -->
   <li class="nav-item">
      <a class="nav-link" href="/logout">
         <i class="fas fa-sign-out-alt"></i>
         <span>Keluar</span></a>
   </li>


   <!-- Divider -->
   <hr class="sidebar-divider d-none d-md-block">

   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>

</ul>