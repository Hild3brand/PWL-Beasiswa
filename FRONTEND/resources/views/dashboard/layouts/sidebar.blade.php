<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    @if($role_id == 1)
    <p class="text-center" aria-current="page"><b>Admin Menu</b></p>
    @endif
    @if($role_id == 2)
    <p class="text-center" aria-current="page"><b>Fakultas Menu</b></p>
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
    </ul>

    <ul class="nav flex-column">
      @if($role_id == 2)
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/users*') ? 'active' : '' }}" href="/dashboard/admin/users">
          <span data-feather="users"></span>
          Beasiswa Internal
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard/admin/fakultas*') ? 'active' : '' }}" href="/dashboard/admin/fakultas">
          <span data-feather="briefcase"></span>
          Pengajuan Beasiswa
        </a>
      </li>
      @endif
    </ul>
  </div>
</nav>