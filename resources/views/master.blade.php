<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'App Pegawai')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    * {
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: #f4f6ff;
      min-height: 100vh;
    }

    /* ===== NAVBAR ===== */
    .navbar-custom {
      background-color: #6176ee;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1030;
      height: 65px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 25px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .navbar-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .navbar-left .user-logo {
      background-color: #f0cb50;
      color: #fff;
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: 600;
      font-size: 16px;
    }

    .navbar-left .user-text h4 {
      color: #fff;
      font-size: 15px;
      font-weight: 600;
      margin: 0;
    }

    .navbar-left .user-text p {
      color: rgba(255, 255, 255, 0.8);
      font-size: 12px;
      margin: 0;
      line-height: 1.2;
    }

    .navbar-brand {
      color: #fff;
      font-weight: 600;
      letter-spacing: 0.5px;
      font-size: 18px;
      margin-left: auto;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      position: fixed;
      top: 65px;
      left: 0;
      height: calc(100vh - 65px);
      width: 260px;
      background: #ffffff;
      padding: 20px 15px;
      border-right: 1px solid #e0e0e0;
      transition: width 0.3s ease;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
      overflow-y: auto;
    }

    .sidebar.collapsed {
      width: 90px;
      padding: 20px 10px;
    }

    /* ===== TOGGLE BUTTON ===== */
    .toggle-btn {
      cursor: pointer;
      position: absolute;
      right: -20px;
      background: #6176ee;
      color: #fff;
      border-radius: 50%;
      width: 45px;
      height: 36px;
      display: flex;
      justify-content: center;
      align-items: center;
      border: 3px solid #fff;
      font-size: 18px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    .toggle-btn:hover {
      background: #5165d6;
    }

    /* ===== NAV LINKS ===== */
    .nav-links {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .nav-links a {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 8px 12px;
      border-radius: 8px;
      text-decoration: none;
      color: #555;
      font-size: 15px;
      font-weight: 500;
    }

    .nav-links a:hover:not(.active) {
      background: #f4f5f9;
      color: #333;
    }

    .nav-links a.active {
      background: #6176ee;
      color: white;
      box-shadow: 0 4px 6px rgba(97, 118, 238, 0.3);
    }

    .sidebar.collapsed .nav-links a span {
      display: none;
    }

    .sidebar.collapsed .nav-links a {
      justify-content: center;
      gap: 0;
    }

    /* ===== MAIN CONTENT ===== */
    main {
      flex-grow: 1;
      padding: 25px;
      margin-top: 65px;
      margin-left: 260px;
      transition: margin-left 0.3s ease;
    }

    .sidebar.collapsed ~ main {
      margin-left: 90px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
      .sidebar {
        display: none;
      }

      main {
        margin-left: 0 !important;
      }

      .navbar-toggler {
        display: block;
      }
    }
  </style>
</head>

<body>
  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-custom">
    <div class="navbar-left">
      <div class="user-logo">AP</div>
      <div class="user-text">
        <h4>APP PEGAWAI</h4>
        <p>Web developer</p>
      </div>
    </div>
    <a class="navbar-brand" href="#">WELCOME MY APP</a>
  </nav>

  <!-- ===== SIDEBAR ===== -->
  <div id="sidebar" class="sidebar d-none d-lg-block">
    <button id="toggleBtn" class="toggle-btn">
      <i data-feather="x"></i>
    </button>

    <ul class="nav-links">
      <li>
        <a href="{{ route('employees.index') }}" class="sidebar-link {{ Request::is('employees*') ? 'active' : '' }}">
          <i data-feather="users"></i><span>Employees</span>
        </a>
      </li>
      <li>
        <a href="{{ route('departments.index') }}" class="sidebar-link {{ Request::is('departments*') ? 'active' : '' }}">
          <i data-feather="layers"></i><span>Department</span>
        </a>
      </li>
      <li>
        <a href="{{ route('positions.index') }}" class="sidebar-link {{ Request::is('positions*') ? 'active' : '' }}">
          <i data-feather="briefcase"></i><span>Positions</span>
        </a>
      </li>
      <li>
        <a href="{{ route('attendance.index') }}" class="sidebar-link {{ Request::is('attendance*') ? 'active' : '' }}">
          <i data-feather="calendar"></i><span>Attendance</span>
        </a>
      </li>
      <li>
        <a href="{{ route('salaries.index') }}" class="sidebar-link {{ Request::is('salaries*') ? 'active' : '' }}">
          <i data-feather="file-text"></i><span>Reports</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <main>
    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    feather.replace();

    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');

    // === Simpan & ambil status sidebar dari localStorage ===
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
      sidebar.classList.add('collapsed');
      toggleBtn.innerHTML = '<i data-feather="menu"></i>';
    } else {
      toggleBtn.innerHTML = '<i data-feather="x"></i>';
    }
    feather.replace();

    if (toggleBtn && sidebar) {
      toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        const collapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', collapsed);
        toggleBtn.innerHTML = collapsed
          ? '<i data-feather="menu"></i>'
          : '<i data-feather="x"></i>';
        feather.replace();
      });
    }
  </script>
</body>
</html>
