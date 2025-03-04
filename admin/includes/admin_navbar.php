<?php include_once "../../config/connect.php"; ?>
<style>
  /* Sticky Navbar */
  .navbar {
    position: sticky;
    top: 0;
    z-index: 100;
  }

  /* Full screen height for body and sidebar */
  .full-screen {
    min-height: 100vh;
    display: flex;
    flex-direction: row;
  }

  /* Sidebar with fixed position */
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: 250px;
    background-color: #343a40;
    color: white;
    padding-top: 20px;
    padding-left: 10px;
    z-index: 99;
    overflow-y: auto;
    transition: all 0.3s ease;
  }

  .sidebar .nav-link {
    color: white;
    font-size: 14px;
  }

  .sidebar .nav-link:hover {
    background-color: #495057;
  }

  .sub-category {
    padding-left: 20px;
  }

  /* Main Content Area */
  .main-content {
    margin-left: 250px;
    padding: 20px;
    flex-grow: 1;
    transition: margin-left 0.3s ease;
  }

  /* Hide sidebar on small screens */
  @media (max-width: 768px) {
    .sidebar {
      position: absolute;
      width: 100%;
      height: auto;
      display: none;
    }

    .sidebar.show {
      display: block;
    }

    .main-content {
      margin-left: 0;
    }

    /* Sidebar Toggler on Left */
    .sidebar-toggler {
      display: block;
      background-color: #343a40;
      color: white;
      border: none;
      padding: 10px;
      font-size: 16px;
      margin-left: 20px;
      margin-top: 15px;
      cursor: pointer;
    }
  }

  /* Sidebar Toggler on Desktop - Hide */
  @media (min-width: 768px) {
    .sidebar-toggler {
      display: none;
    }
  }
  .table-container {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      max-width: 100%;
    }
</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Sidebar Toggler for Mobile -->
    <button class="sidebar-toggler d-lg-none" id="sidebar-toggler">
      <i class="bi bi-layout-sidebar-inset"></i>
    </button>

    <!-- Admin Panel Text in the Center -->
    <a class="navbar-brand " href="http://localhost/readrainbow/admin/index.php">Admin Panel</a>

    <!-- Logout Button on Right -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="btn btn-danger" href="#">Logout</a>
      </li>
    </ul>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
