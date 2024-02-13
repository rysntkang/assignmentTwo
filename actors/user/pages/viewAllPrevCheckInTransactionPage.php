<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/admin/viewParkingLocationController.php";
include "../../../controller/user/viewCurrentlyCheckInTransactionController.php";
include "../../../controller/CheckOutTransactionController.php";
include "../../../controller/user/viewAllPrevCheckInTransactionController.php";

if(isset($_POST["checkOutTransaction"]))
{
    $transactionId = $_POST["checkOutTransaction"];
    $locationId = $_POST["checkOutLocationId"];
    $slotId = $_POST["checkOutSlotId"];
    $endTime = $_POST["checkOutEndTime"];
    $totalCost = $_POST["checkOutTotalCost"];

    $checkOutTransaction = new CheckOutTransactionController();
    $error = $checkOutTransaction->checkOutTransaction($transactionId, $locationId, $slotId, $endTime, $totalCost);
 
    header("location:index.php?page=viewCurrentlyCheckInTransactionPage");
}

if(isset($_POST["viewMoreParking"]))
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

    .form-inline {
      float: right;
      margin: 1em;
    }

</style>

<div class="container mt-4">
        
    <div class="row">
        <?php
        $ViewAllPrevCheckInTransaction = new ViewAllPrevCheckInTransactionController();
        $array = $ViewAllPrevCheckInTransaction->ViewAllPrevCheckInTransaction($_SESSION["currentUserProfileId"]);

        if (empty($array)){
            echo '<div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="date" class="form-label">Currently No Parking Slots being booked.</label>
                            <form method="POST">
                            <button class="btn btn-info" style="height:40px" name="viewMoreParking">View More Parking Locations</button>
                            </form>
                        </div>
                    </div>
                  </div>';
        }
        else {
            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">Location Name</th>';
            echo '      <th class="text-center">Address</th>';
            echo '      <th class="text-center">Slot Num</th>';
            echo '      <th class="text-center">Duration</th>';
            echo '      <th class="text-center">Start Time</th>';
            echo '      <th class="text-center">End Time</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['locationName'] . '</td>';
                echo '      <td>' . $row['address'] . '</td>';                 
                echo '      <td>' . $row['slotNum'] . '</td>';
                echo '      <td>' . $row['actualDuration'] . '</td>';
                echo '      <td>' . $row['startTime'] . '</td>';
                echo '      <td>' . $row['endTime'] . '</td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>