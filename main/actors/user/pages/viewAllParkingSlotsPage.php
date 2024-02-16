<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingSlotsEntity.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/viewAllParkingSlotsController.php";
include "../../../controller/getParkingLocationController.php";
include "../../../controller/user/viewCheckInSlotController.php";

$locationId = $_SESSION['locationId'];

if(isset($_POST["check"]))
{
    $slotId = $_POST["check"];
    $_SESSION['slotId'] = $slotId;

    header("location:index.php?page=checkInCheckOutPage");
}

if(isset($_POST["back"]))
{
  unset($_SESSION['locationId']);
  header("location:index.php?page=viewAllParkingLocationPage");
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

<?php

$getParkingLocation = new GetParkingLocationController();
$array = $getParkingLocation->getParkingLocation($locationId);

$locationName = $array[0]['locationName'];
$description = $array[0]['description'];
$address = $array[0]['address'];
$rates = $array[0]['rates'];
$ratesLate = $array[0]['ratesLate'];
$capacity = $array[0]['capacity'];
$occupied = $array[0]['occupied'];

?>

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
          <div class="mb-3">
            <form method = "POST">
              <button class="btn btn-secondary" type="submit" name="back">Back</button>
            </form>
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
                                    if ($row['availability'] == 1){
                                    //Check In Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['slotId'] . '" name="check">Check In</button>';
                                    } else {
                                      //Get the userId from the transaction, matching with the specific slot.
                                      $viewCheckInSlot = new ViewCheckInSlotController();
                                      $array1 = $viewCheckInSlot->viewCheckInSlot($row['slotId']);
                                      //IF the userId from the transaction matches with the current userId, show the Check out Button
                                      if ($array1[0]['userId'] == $_SESSION['currentUserId']) {
                                      //Check Out Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['slotId'] . '" name="check">Check Out</button>';                                        
                                      }
                                    }
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        ?>
    </div>
</div>