<ul class="nav nav-secondary">
  <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" aria-expanded="false">
      <i class="fas fa-home"></i>
      <p>Dashboard</p>
    </a>
  </li>
  <li class="nav-section">
    <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Transaksi </h4>
  </li>
  <li class="nav-item {{ request()->routeIs('transactions.*') && request('tipe') === 'masuk' ? 'active' : '' }}">
    <a href="{{ route('transactions.index', 'masuk') }}" aria-expanded="false">
      <i class="fa fa-arrow-down"></i>
      <p>Obat Masuk</p>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('transactions.*') && request('tipe') === 'keluar' ? 'active' : '' }}">
    <a href="{{ route('transactions.index', 'keluar') }}" aria-expanded="false">
      <i class="fa fa-arrow-up"></i>
      <p>Obat Keluar</p>
    </a>
  </li>

  <li class="nav-section">
    <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Master Data</h4>
  </li>
  <li class="nav-item {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
    <a href="{{ route('medicines.index') }}" aria-expanded="false">
      <i class="fas fa-pills"></i>
      <p>Obat</p>
    </a>
  </li>
  @if (auth()->user()->hasRole('admin'))
    <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
      <a href="{{ route('settings.index') }}" aria-expanded="false">
        <i class="fas fa-cogs"></i>
        <p>Settings</p>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <a href="{{ route('users.index') }}" aria-expanded="false">
        <i class="fas fa-users"></i>
        <p>Users</p>
      </a>
    </li>
  @endif

</ul>
