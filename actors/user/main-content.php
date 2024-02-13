<?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    include('pages/'. $page . '.php');
  } else {
    include('pages/viewAllParkingLocationPage.php'); // Load a default page if no page is specified
  }