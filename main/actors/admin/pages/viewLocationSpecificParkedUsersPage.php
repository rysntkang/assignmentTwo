<?php 
include "../../../dbConnection.php";
include "../../../entities/transactionEntity.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/viewLocationTransactionController.php";
include "../../../controller/getParkingLocationController.php";

$locationId = $_SESSION['locationId'];

if(isset($_POST["viewParkingSlots"]))
{
    $slotId = $_POST["viewParkingSlots"];

    $_SESSION['slotId'] = $slotId;

    header("location:index.php?page=viewParkingSlotPage");
}

if(isset($_POST["back"]))
{
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

    .input-group {
      float: right;
      margin: 1em;
    }

    .input-group input {
      height: 35px;
      margin-left: 1em;
    }

    #back-button {
        padding: auto;
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
        
          <div class="mb-1">
            <label class="form-label">View All Currently Parked Users within this Parking Location:</label>
          </div>

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
            $viewLocationTransaction = new ViewLocationTransactionController();
            $array = $viewLocationTransaction->viewLocationTransaction($locationId);
            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">Username</th>';
            echo '      <th class="text-center">Name</th>';
            echo '      <th class="text-center">Email Address</th>';
            echo '      <th class="text-center">Start Time</th>';
            echo '      <th class="text-center">Duration</th>';
            echo '      <th class="text-center">Slot Number</th>';
            echo '      <th class="text-center">Actions</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['username'] . '</td>';
                echo '      <td>' . $row['firstName'] . ' ' . $row['surname'] . '</td>';
                echo '      <td>' . $row['emailAddress'] . '</td>';
                echo '      <td>' . $row['startTime'] . '</td>';
                echo '      <td>' . $row['actualDuration'] . '</td>';
                echo '      <td>' . $row['slotNum'] . '</td>';
                echo '      <form method="POST">';
                echo '      <td><button class="btn btn-primary" style="height:40px" value="' . $row['slotId'] . '" name="viewParkingSlots">View</button></td>';
                echo '      </form>';
                echo '  </tr>';
            }
            echo "</table>";
        ?>
    </div>
</div>
