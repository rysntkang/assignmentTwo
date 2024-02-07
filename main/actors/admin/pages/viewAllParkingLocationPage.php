<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/viewParkingLocationController.php";
include "../../../controller/admin/searchParkingLocationController.php";

if(isset($_POST["updateParkingLocation"]))
{
    $updateLocationId = $_POST["updateParkingLocation"];
    $updateLocationName = $_POST["updateLocationName"];
    $updateAddress = $_POST["updateAddress"];

    $_SESSION['locationId'] = $updateLocationId;
    $_SESSION['locationName'] = $updateLocationName;
    $_SESSION['address'] = $updateAddress;
    
    header("location:index.php?page=updateParkingLocationPage");
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

    .search-container {
      float: right;
      margin: 1em;
    }

    .search-container input {
      height: 35px;
      margin-left: 1em;
      text-align: center;
    }

</style>

<div class="container">
    <div class="row">
        <div class="search-container ml-auto">
            <form method="POST">
                <input type="text" name="search" id="myInput" placeholder="Search">
            </form>
        </div>
    </div>
    <div class="row">
        <?php
        if(isset($_POST["search"]))
        {
            $locationName = $_POST["search"];
        
            $searchParkingLocation = new SearchParkingLocationController();
            $array = $searchParkingLocation->searchParkingLocation($locationName);

            if ($array[0] != "Success")
            {
                echo '<script>';
                echo "alert('$array[0]');";
                echo 'document.location = "index.php?page=viewAllParkingLocationPage";';
                echo '</script>';
            }
            else
            {
                echo '<table class ="table">';
                echo '  <tr>';
                echo '      <th class="text-center">Location Id</th>';
                echo '      <th class="text-center">Location Name</th>';
                echo '      <th class="text-center">Location Address</th>';
                echo '  </tr>';
                for($i = 1; $i < count($array); $i++)
                {
                    $row = $array[$i];
                    echo '  <tr>';
                    echo '      <td>' . $row['locationId'] . '</td>';
                    echo '      <td>' . $row['locationName'] . '</td>';
                    echo '      <td>' . $row['address'] . '</td>';
                    echo '      <td>';
                    echo '          <form method="POST">';
                    echo '              <input type="hidden" name="updateLocationName" value="' . $row['locationName'] . '"/>';
                    echo '              <input type="hidden" name="updateAddress" value="' . $row['address'] . '"/>';
                    echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">UPDATE</button>';
                    echo '          </form>';
                    echo '      </td>';
                    echo '  </tr>';
                }
                echo "</table>";
            }
        }else
        {
            $viewParkingLocation = new ViewParkingLocationController();
            $array = $viewParkingLocation->viewParkingLocation();
            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">Location Id</th>';
            echo '      <th class="text-center">Location Name</th>';
            echo '      <th class="text-center">Location Address</th>';
            echo '      <th class="text-center" colspan="2">Actions</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['locationId'] . '</td>';
                echo '      <td>' . $row['locationName'] . '</td>';
                echo '      <td>' . $row['address'] . '</td>';
                echo '      <td>';
                echo '          <form method="POST">';
                echo '              <input type="hidden" name="updateLocationName" value="' . $row['locationName'] . '"/>';
                echo '              <input type="hidden" name="updateAddress" value="' . $row['address'] . '"/>';
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">UPDATE</button>';
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>
