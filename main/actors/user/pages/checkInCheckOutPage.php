<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingSlotsEntity.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../entities/userEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/getUsersController.php";
include "../../../controller/CheckInTransactionController.php";
include "../../../controller/ViewTransactionController.php";
include "../../../controller/CheckOutTransactionController.php";
include "../../../controller/getParkingLocationController.php";
include "../../../controller/getParkingSlotController.php";

$locationId = $_SESSION['locationId'];
$slotId = $_SESSION['slotId'];

//Retrieve Details from parkingLocations DB based on $locationId
$getParkingLocation = new GetParkingLocationController();
$array = $getParkingLocation->getParkingLocation($locationId);

$locationName = $array[0]['locationName'];
$description = $array[0]['description'];
$address = $array[0]['address'];
$rates = $array[0]['rates'];
$ratesLate = $array[0]['ratesLate'];
$capacity = $array[0]['capacity'];
$occupied = $array[0]['occupied'];

$getParkingSlot = new GetParkingSlotController();
$array = $getParkingSlot->getParkingSlot($slotId);

$availability = $array[0]['availability'];
$slotNum = $array[0]['slotNum'];

if(isset($_POST["checkInTransaction"]))
{
    //Using the currentUserProfileId, which was set upon login
    $userId = $_SESSION["currentUserProfileId"];

    //locationId from $_SESSION['locationId']
    //slotId from $_SESSION['slotId']

    //startTime need to change to this format
    $startTime = $_POST["startTime"];
    $actualDate = date("Y-m-d H:i:s");

    $startTimeDateTime = new DateTime($startTime);
    $startTime = $startTimeDateTime->format('Y-m-d H:i');
    
    //Check if user has entered a date in the past.
    if ($startTime < $actualDate){
      echo "<script>alert('The date you have entered is in the past.');</script>";
    }
    else {
      $intendedDuration = $_POST["intendedDuration"];
      $actualDuration = $_POST["actualDuration"];

      //Adding duration to the startTime to get an expectedEndTime
      $startTimeDateTime = new DateTime($startTime);
      $endTimeDateTime = clone $startTimeDateTime;

      $endTimeDateTime->modify("+" . $intendedDuration . " hours");
      $expectedEndTime = $endTimeDateTime->format("Y-m-d H:i");

      //Parking ends at $expectedEndTime
      
      //Calculating the total cost of the transaction 
      $totalCost = $intendedDuration * $rates;

      //Total Cost of parking will be $totalCost
      //The Late rates will be $ratesLate / Hr.
      
      $checkInTransaction = new CheckInTransactionController();
      $error = $checkInTransaction->checkInTransaction($userId, $locationId, $slotId, $startTime, $actualDuration, $intendedDuration);

      if ($error == "Success")
      {
        $notificationMsg = json_encode("Dear ". $_SESSION['currentUsername'] . ".\nYour parking will end at " . $expectedEndTime . ".\nThe Total Costs of parking will be " . $totalCost . ".\nDo note that the Late rates will be " . $ratesLate . "/Hr.");
        $_SESSION['availability'] = 0;
        echo "<script>alert('$notificationMsg')
        window.location.replace('index.php?page=checkInCheckOutPage')</script>";
      }
      else
      {
        echo "<script>alert('$error');</script>";
      }
    }
}


if(isset($_POST["checkOutTransaction"]))
{

    $transactionId = $_POST["checkOutTransaction"];
    //locationId from $_SESSION['locationId']
    //slotId from $_SESSION['slotId']
    $endTime = $_POST["checkOutEndTime"];
    $totalCost = $_POST["checkOutTotalCost"];

    $intendedCost = $_POST["checkOutIntendedCost"];
    $lateCost = $_POST["checkOutLateCost"];

    $checkOutTransaction = new CheckOutTransactionController();
    $error = $checkOutTransaction->checkOutTransaction($transactionId, $locationId, $slotId, $endTime, $totalCost);

    if ($lateCost != 0) {
    $notificationMsg = json_encode("Dear ". $_SESSION['currentUsername'] . ".\nYour costs will be $" . $intendedCost . ".\nYour additional late cost will be $". $lateCost . ".\nYour total costs will be $". $totalCost . ".");

    } else {
    $notificationMsg = json_encode("Dear ". $_SESSION['currentUsername'] . ".\nYour total costs will be $" . $intendedCost . ".");
    }
    echo "<script>alert('$notificationMsg')
    window.location.replace('index.php?page=viewAllParkingSlotsPage')</script>";
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

    #form-card {
      margin-top: 5em !important;
      margin-left: auto;
      margin-right: auto;
      width: 40%;
      background-color: #d9d9d9;
    }

    #createButton {
        float: right;
        padding: auto;
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
            <label for="date" class="form-label">Slot Number: </label>
            <?php echo($slotNum) ?>
          </div>

        </div>
      </div>
  </div>

  <?php
    //if availability == 0, slot has been booked already.
    if ($availability == 0) {
        //use the ViewTransactionController
        $viewTransaction = new ViewTransactionController();
        $array = $viewTransaction->viewTransaction($slotId);

        echo '<table class ="table">';
        echo '  <tr>';
        echo '      <th class="text-center">Username</th>';
        echo '      <th class="text-center">Name</th>';
        echo '      <th class="text-center">Email Address</th>';
        echo '      <th class="text-center">Check In Time</th>';
        echo '      <th class="text-center">Intended Duration</th>';
        echo '      <th class="text-center">Expected Check Out Time</th>';
        echo '      <th class="text-center">Actual Check Out Time <br> FOR TESTING</th>';
        echo '      <th class="text-center">Actions</th>';
        echo '  </tr>';
        $row = $array[0];
        echo '  <tr>';
        echo '      <td>' . $row['username'] . '</td>';
        echo '      <td>' . $row['firstName'] . " " . $row['surname'] . '</td>';
        echo '      <td>' . $row['emailAddress'] . '</td>';                   
        echo '      <td>' . $row['startTime'] . '</td>';
        echo '      <td>' . $row['intendedDuration'] . '</td>';

        //Adding duration to the startTime to get an expectedEndTime
        $startTimeDateTime = new DateTime($row['startTime']);
        $endTimeDateTime = clone $startTimeDateTime;
        $endTimeDateTime->modify("+" . $row['intendedDuration'] . " hours");
        $expectedEndTime = $endTimeDateTime->format("Y-m-d H:i");

        $startTimeDateTime = new DateTime($row['startTime']);
        $endTimeDateTime = clone $startTimeDateTime;
        $endTimeDateTime->modify("+" . $row['actualDuration'] . " hours");
        $actualEndTime = $endTimeDateTime->format("Y-m-d H:i");
        
        //Calculating the total cost of the transaction 
        $intendedCosts = $row['intendedDuration'] * $rates;
        if ($row['actualDuration'] > $row['intendedDuration'])
        {
          $lateCosts = ($row['actualDuration'] - $row['intendedDuration']) * $ratesLate;
        } 
        else 
        { 
          $lateCosts = 0; 
        }
        $totalCost = $intendedCosts + $lateCosts;

        echo '      <td>' . $expectedEndTime . '</td>';
        echo '      <td>' . $actualEndTime . '</td>';
        echo '      <td>';
        echo '          <form method="POST">';
        echo '              <input type="hidden" name="checkOutEndTime" value="' . $expectedEndTime . '"/>';
        echo '              <input type="hidden" name="checkOutTotalCost" value="' . $totalCost . '"/>';
        echo '              <input type="hidden" name="checkOutIntendedCost" value="' . $intendedCosts . '"/>';
        echo '              <input type="hidden" name="checkOutLateCost" value="' . $lateCosts . '"/>';
                            //Check Out
        echo '              <button class="btn btn-info" style="height:40px" value="' . $row['transactionId'] . '" name="checkOutTransaction">Check Out</button>';
        echo '          </form>';
        echo '      </td>';
        echo '  </tr>';
    }
    //else, slot has not been booked yet, can book users in.
    else {    
        echo '<div class="row">';
        echo    '<div class="card" id="form-card">';
        echo        '<div class="card-body">';
        echo            '<form method="POST">';
        echo                '<div class="form-group">';
        echo                    '<label for="datetime">Date and Time:</label>';
        echo                    '<input type="datetime-local" class="form-control" id="datetime" name="startTime" required>';
        echo                '</div>';
        echo                '<div class="form-group">';
        echo                    '<label for="duration" class="form-label">Intended Duration:</label>';
        echo                    '<input type="number" value="1" min="1" max="999" step="1" name="intendedDuration" required>';
        echo                '</div>';
        echo                '<div class="form-group">';
        echo                    '<label for="duration" class="form-label">Actual Duration:</label>';
        echo                    '<input type="number" value="1" min="1" max="999" step="1" name="actualDuration" required>';
        echo                '</div>';
                            //Manually Check In
        echo                '<button class="btn btn-success" type="submit" name="checkInTransaction" id="createButton">Check In</button>';
        echo            '</form>';
        echo        '</div>';
        echo    '</div>';
        echo '</div>';
    }
    ?>
</div>