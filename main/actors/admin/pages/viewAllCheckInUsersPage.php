<?php 
include "../../../dbConnection.php";
include "../../../entities/userEntity.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/admin/viewUserController.php";
include "../../../controller/admin/viewParkedUsersController.php";

if(isset($_POST["viewAllParkingSlots"]))
{
    $viewLocationId = $_POST["viewAllParkingSlots"];
    $_SESSION['locationId'] = $viewLocationId;

    header("location:index.php?page=viewAllParkingSlotsPage");
}

if(isset($_POST["viewParkingSlots"]))
{
    $viewLocationId = $_POST["viewLocationId"];
    $_SESSION['locationId'] = $viewLocationId;
    $slotId = $_POST["viewParkingSlots"];
    $_SESSION['slotId'] = $slotId;

    header("location:index.php?page=viewParkingSlotPage");
}

?>

<style>
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

</style>

<div class="container">
    <div class="row">
        <?php
            $viewParkedUsers = new viewParkedUsersController();
            $array = $viewParkedUsers->viewParkedUsers();
            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">Username</th>';
            echo '      <th class="text-center">Location Name</th>';
            echo '      <th class="text-center">Address</th>';
            echo '      <th class="text-center">Start Time</th>';
            echo '      <th class="text-center">Duration</th>';
            echo '      <th class="text-center">Action</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['username'] . '</td>';
                echo '      <td>' . $row['locationName'] . '</td>';
                echo '      <td>' . $row['address'] . '</td>';
                echo '      <td>' . $row['startTime'] . '</td>';
                echo '      <td>' . $row['intendedDuration'] . '</td>';
                echo '      <td>';
                echo '          <form method="POST">';
                echo '              <input value="' . $row['locationId'] . '" name="viewLocationId" hidden>';
                //Update Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['slotId'] . '" name="viewParkingSlots">View Slot</button>';
                //View Location Button
                echo '              <button class="btn btn-info" style="height:40px" value="' . $row['locationId'] . '" name="viewAllParkingSlots">View Location</button>';
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        ?>
    </div>
</div>
