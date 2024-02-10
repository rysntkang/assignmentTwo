<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingSlotsEntity.php";
include "../../../entities/userEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/admin/getUsersController.php";
include "../../../controller/CheckInTransactionController.php";
include "../../../controller/ViewTransactionController.php";
include "../../../controller/CheckOutTransactionController.php";

$locationId = $_SESSION['locationId'];
$locationName = $_SESSION['locationName'];
$description = $_SESSION['description'];
$address = $_SESSION['address'];
$rates = $_SESSION['rates'];
$ratesLate = $_SESSION['ratesLate'];
$capacity = $_SESSION['capacity'];
$occupied = $_SESSION['occupied'];

$slotId = $_SESSION['slotId'];
$availability = $_SESSION['availability'];
$slotNum = $_SESSION['slotNum'];

if(isset($_POST["checkInTransaction"]))
{
    $userId = $_POST["userId"];
    //locationId from $_SESSION['locationId']
    //slotId from $_SESSION['slotId']
    $startTime = date("Y-m-d H:i:s");
    $duration = $_POST["duration"];

    $checkInTransaction = new CheckInTransactionController();
    $error = $checkInTransaction->checkInTransaction($userId, $locationId, $slotId, $startTime, $duration);

    if ($error == "Success")
    {
        $_SESSION['availability'] = 0;
        header("location:index.php?page=viewParkingSlotPage");
    }
    else
    {
        echo "<script>alert('$error');</script>";
    }

}


if(isset($_POST["checkOutTransaction"]))
{

    $transactionId = $_POST["checkOutTransaction"];
    //locationId from $_SESSION['locationId']
    //slotId from $_SESSION['slotId']
    $endTime = $_POST["checkOutEndTime"];
    $totalCost = $_POST["checkOutTotalCost"];

    $checkOutTransaction = new CheckOutTransactionController();
    $error = $checkOutTransaction->checkOutTransaction($transactionId, $locationId, $slotId, $endTime, $totalCost);
 
    header("location:index.php?page=viewAllParkingSlotsPage");
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
        echo '      <th class="text-center">Start Time</th>';
        echo '      <th class="text-center">Duration</th>';
        echo '      <th class="text-center">Expected End Time</th>';
        echo '      <th class="text-center">Actions</th>';
        echo '  </tr>';
        $row = $array[0];
        echo '  <tr>';
        echo '      <td>' . $row['username'] . '</td>';
        echo '      <td>' . $row['firstName'] . " " . $row['surname'] . '</td>';
        echo '      <td>' . $row['emailAddress'] . '</td>';                   
        echo '      <td>' . $row['startTime'] . '</td>';
        echo '      <td>' . $row['duration'] . '</td>';

        //Adding duration to the startTime to get an expectedEndTime (Assuming not late)
        $startTimeDateTime = new DateTime($row['startTime']);
        $endTimeDateTime = clone $startTimeDateTime;
        $endTimeDateTime->modify("+" . $row['duration'] . " hours");
        $expectedEndTime = $endTimeDateTime->format("Y-m-d H:i:s");
        
        //Calculating the total cost of the transaction (Assuming not late)
        $totalCost = $row['duration'] * $rates;

        echo '      <td>' . $expectedEndTime . '</td>';
        echo '      <td>';
        echo '          <form method="POST">';
        echo '              <input type="hidden" name="checkOutEndTime" value="' . $expectedEndTime . '"/>';
        echo '              <input type="hidden" name="checkOutTotalCost" value="' . $totalCost . '"/>';
                            //Manually Check Out
        echo '              <button class="btn btn-info" style="height:40px" value="' . $row['transactionId'] . '" name="checkOutTransaction">Check Out</button>';
        echo '          </form>';
        echo '      </td>';
        echo '  </tr>';
    }
    //else, slot has not been booked yet, can book users in.
    else {
        $getUsers = new GetUsersController();
        $array = $getUsers->getUsers();
    
        echo '<div class="row">';
        echo    '<div class="card" id="form-card">';
        echo        '<div class="card-body">';
        echo            '<form method="POST">';
        echo                '<div class="mb-3">';
        echo                    '<label for="date" class="form-label">User:</label>';
        echo                    '<select name="userId">';
        for($i = 0; $i < count($array); $i++)
        {
            $row = $array[$i];
            echo                '<option value=' . $row['userId'] . '>' . $row['username'] . '</option>';
        }
        echo                    '</select>';
        echo                '</div>';
        echo                '<div class="mb-3">';
        echo                    '<label for="date" class="form-label">Duration:</label>';
        echo                    '<input type="number" value="1" min="1" max="999" step="0.1" name="duration">';
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