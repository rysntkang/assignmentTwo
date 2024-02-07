<aside class="main-sidebar">
  <a href="index.php" class="brand-link navbar-gray text-sm">
    <span class="brand-text font-weight-light">Parking</span>
  </a>


  <?php
  ob_start();

  //Admin Side bar
  if($_SESSION["currentUserProfileId"] == 1)
  {
    echo 
    '<div class="sidebar">
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat" role="menu">
        
      <li class="nav-header">Users</li>

        <li class="nav-item">
          <a href="index.php?page=viewAllUsersPage" class="nav-link nav-home">
            <i class="nav-icon fas fa-address-card active"></i>
            <p>View All Users</p>
          </a>
        </li>

        <li class="nav-header">Parking Locations</li>

        <li class="nav-item">
          <a href="index.php?page=viewAllParkingLocationPage" class="nav-link nav-home">
            <i class="nav-icon fas fa-parking"></i>
            <p>View All Parking Locations</p>
          </a>
        </li>

        <li class="nav-item">
        <a href="index.php?page=createParkingLocationPage" class="nav-link nav-home">
          <i class="nav-icon fas fa-parking"></i>
          <p>Add Parking Location</p>
        </a>
      </li>

      </ul>
    </nav>
  </div>';
  }

  //User Side Bar
  elseif ($_SESSION["currentUserProfileId"] == 2)
  {
    echo '  
    <div class="sidebar">
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat" role="menu">
        <li class="nav-header">Work Slots</li>
        <li class="nav-item">
          <a href="index.php?page=viewWorkslotsBoundary" class="nav-link nav-home">
            <i class="nav-icon fas fa-briefcase active"></i>
            <p>View Workslots</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=createWorkslotsBoundary" class="nav-link nav-home">
            <i class="nav-icon fas fa-clock"></i>
            <p>Create Workslots</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>';
  }

  ?>

  <!-- Admin Side Bar -->
</aside>

<!-- For redirect, use this format: href="index.php?page=<YOUR BOUNDARY FILE NAME>"-->