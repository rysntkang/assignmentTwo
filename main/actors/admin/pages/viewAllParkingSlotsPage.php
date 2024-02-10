<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingSlotsEntity.php";
include "../../../controller/admin/viewAllParkingSlotsController.php";

$locationId = $_SESSION['locationId'];
$locationName = $_SESSION['locationName'];
$description = $_SESSION['description'];
$address = $_SESSION['address'];
$rates = $_SESSION['rates'];
$ratesLate = $_SESSION['ratesLate'];
$capacity = $_SESSION['capacity'];
$occupied = $_SESSION['occupied'];

if(isset($_POST["viewParkingSlots"]))
{
    $slotId = $_POST["viewParkingSlots"];
    $availability = $_POST["availability"];
    $slotNum = $_POST["slotNum"];

    $_SESSION['slotId'] = $slotId;
    $_SESSION['availability'] = $availability;
    $_SESSION['slotNum'] = $slotNum;

    header("location:index.php?page=viewParkingSlotPage");
}

?>

<style>

    .card {
      margin-top: 5em !important;
      margin-left: auto;
      margin-right: auto;
      width: 90%;
      background-color: #d9d9d9;
    }

    .table {
        margin-top: 1em !important;
        margin-left: auto;
        margin-right: auto;
        border-style: solid;
        border-color: black;
        background-color: #D9D9D9;
        width: 100%;
        text-align: center;
    }

    th, td , tr{
      border-style: solid;
      border-color: black;
    }

    .search-container {
      float: right;
      margin: 1em;
    }

    .search-container input {
      height: 35px;
      margin-left: 1em;
      text-align: right;
    }

</style>

<div class="container">
  <div class="row">
    <div class="card">
      <div class="card-body">
        
          <div class="mb-3">
            <label for="date" class="form-label">Location Name:</label>
            <?php echo($locationName) ?>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Description:</label>
            <?php echo($description) ?>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Address:</label>
            <?php echo($address) ?>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Hourly Rates:</label>
            <?php echo($rates) ?>
            <label for="date" class="form-label">Hourly Late Rates:</label>
            <?php echo($ratesLate) ?>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Total Number of Slots</label>
            <?php echo($capacity) ?>
          </div>
          <div class="mb-3">
            <label for="date" class="form-label">Number of occupied parking slots:</label>
            <?php echo($occupied) ?>
          </div>
        </div>
      </div>
  </div>
    <div class="row">
        <?php
            $viewAllParkingSlots = new ViewAllParkingSlotsController();
            $array = $viewAllParkingSlots->viewAllParkingSlots($locationId);

            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">Slot Number</th>';
            echo '      <th class="text-center">Available?</th>';
            echo '      <th class="text-center" colspan="2" style="width:20%">Actions</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['slotNum'] . '</td>';
                
                if ($row['availability'] == 1 ){
                  $availability = "Yes";
                } 
                  else {
                    $availability = "No";
                  }

                echo '      <td>' . $availability . '</td>';
                echo '      <td>';
                echo '          <form method="POST">';
                echo '              <input type="hidden" name="slotNum" value="' . $row['slotNum'] . '"/>';
                echo '              <input type="hidden" name="availability" value="' . $row['availability'] . '"/>';
                                    //Update Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['slotId'] . '" name="viewParkingSlots">View</button>';
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        ?>
    </div>
</div>