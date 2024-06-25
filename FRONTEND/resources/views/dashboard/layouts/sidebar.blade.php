<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    @if($role_id == 1)
    <p class="text-center" aria-current="page"><b>Admin Menu</b></p>
    @endif
    @if($role_id == 2)
    <p class="text-center" aria-current="page"><b>Fakultas Menu</b></p>
    @endif
    @if($role_id == 3)
    <p class="text-center" aria-current="page"><b>Program Studi Menu</b></p>
    @endif
    @if($role_id == 4)
    <p class="text-center" aria-current="page"><b>Mahasiswa Menu</b></p>
    @endif
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="/dashboard">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>
      @if($role_id == 1)
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/admin/users">
          <span data-feather="users"></span>
          Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/admin/roles">
          <span data-feather="users"></span>
          Roles
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/fakultas*') ? 'active' : '' }}" href="/dashboard/admin/fakultas">
          <span data-feather="briefcase"></span>
          Fakultas
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/prodi*') ? 'active' : '' }}" href="/dashboard/admin/prodi">
          <span data-feather="file"></span>
          Program Studi
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/beasiswa*') ? 'active' : '' }}" href="/dashboard/admin/beasiswa">
          <span data-feather="file-plus"></span>
          Beasiswa
        </a>
      </li>
      @endif
      @if($role_id == 2)
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/fakultas/beasiswa">
          <span data-feather="users"></span>
          Beasiswa Internal
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/fakultas*') ? 'active' : '' }}" href="/dashboard/fakultas/pengajuan">
          <span data-feather="briefcase"></span>
          Pengajuan Beasiswa
        </a>
      </li>
      @endif
      @if($role_id == 3)
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/prodi/beasiswa">
          <span data-feather="users"></span>
          Beasiswa Internal
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/fakultas*') ? 'active' : '' }}" href="/dashboard/prodi/pengajuan">
          <span data-feather="briefcase"></span>
          Pengajuan Beasiswa
        </a>
      </li>
      @endif
      @if($role_id == 4)
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/mahasiswa/beasiswa">
          <span data-feather="users"></span>
          Beasiswa Internal
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/fakultas*') ? 'active' : '' }}" href="/dashboard/mahasiswa/pengajuan">
          <span data-feather="briefcase"></span>
          Pengajuan Beasiswa
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>