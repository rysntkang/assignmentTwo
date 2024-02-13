<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/admin/viewParkingLocationController.php";
include "../../../controller/user/viewCurrentlyCheckInTransactionController.php";
include "../../../controller/CheckOutTransactionController.php";

if(isset($_POST["checkOutTransaction"]))
{
    $transactionId = $_POST["checkOutTransaction"];
    $locationId = $_POST["checkOutLocationId"];
    $slotId = $_POST["checkOutSlotId"];
    $endTime = $_POST["checkOutEndTime"];
    $totalCost = $_POST["checkOutTotalCost"];

    $checkOutTransaction = new CheckOutTransactionController();
    $error = $checkOutTransaction->checkOutTransaction($transactionId, $locationId, $slotId, $endTime, $totalCost);

    $notificationMsg = json_encode("Dear ". $_SESSION['currentUsername'] . ".\nYour parking will end at " . $expectedEndTime . ".\nThe Total Costs of parking will be " . $totalCost . ".\nDo note that the Late rates will be " . $ratesLate . "/Hr.");
    echo "<script>alert('$notificationMsg');</script>";
 
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
        $viewCurrentlyCheckInTransaction = new viewCurrentlyCheckInTransactionController();
        $array = $viewCurrentlyCheckInTransaction->viewCurrentlyCheckInTransaction($_SESSION["currentUserProfileId"]);

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
            echo '      <th class="text-center">Occupancy</th>';
            echo '      <th class="text-center">Address</th>';
            echo '      <th class="text-center">Slot Num</th>';
            echo '      <th class="text-center">Intended <br>Duration</th>';
            echo '      <th class="text-center">Start Time</th>';
            echo '      <th class="text-center">Action</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['locationName'] . '</td>';
                echo '      <td>' . $row['occupied'] . '/' . $row['capacity'] . '</td>'; 
                echo '      <td>' . $row['address'] . '</td>';                 
                echo '      <td>' . $row['slotNum'] . '</td>';
                echo '      <td>' . $row['intendedDuration'] . '</td>';
                echo '      <td>' . $row['startTime'] . '</td>';

                //Adding duration to the startTime to get an expectedEndTime and actualEndTime
                $startTimeDateTime = new DateTime($row['startTime']);
                $endTimeDateTime = clone $startTimeDateTime;
                $endTimeDateTime->modify("+" . $row['intendedDuration'] . " hours");
                $expectedEndTime = $endTimeDateTime->format("Y-m-d H:i");

                $startTimeDateTime = new DateTime($row['startTime']);
                $endTimeDateTime = clone $startTimeDateTime;
                $endTimeDateTime->modify("+" . $row['actualDuration'] . " hours");
                $actualEndTime = $endTimeDateTime->format("Y-m-d H:i");
                
                //Calculating the total cost of the transaction 
                $intendedCosts = $row['intendedDuration'] * $row['rates'];
                if ($row['actualDuration'] > $row['intendedDuration'])
                {
                $lateCosts = ($row['actualDuration'] - $row['intendedDuration']) * $row['ratesLate'];
                } else { $lateCosts = 0; }
                $totalCost = $intendedCosts + $lateCosts;

                echo '      <td>';
                echo '          <form method="POST">';
                echo '              <input type="hidden" name="checkOutEndTime" value="' . $expectedEndTime . '"/>';
                echo '              <input type="hidden" name="checkOutTotalCost" value="' . $totalCost . '"/>';
                echo '              <input type="hidden" name="checkOutLocationId" value="' . $row['locationId'] . '"/>';
                echo '              <input type="hidden" name="checkOutSlotId" value="' . $row['slotId'] . '"/>';
                                    //View Parking Slots
                echo '              <button class="btn btn-info" style="height:40px" value="' . $row['transactionId'] . '" name="checkOutTransaction">Check Out</button>';
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>