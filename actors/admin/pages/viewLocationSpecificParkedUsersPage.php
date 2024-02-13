<?php 
include "../../../dbConnection.php";
include "../../../entities/transactionEntity.php";
include "../../../controller/admin/ViewLocationTransactionController.php";

$locationId = $_SESSION['locationId'];

if(isset($_POST["viewParkingSlots"]))
{
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
