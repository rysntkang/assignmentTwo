<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/viewParkingLocationController.php";
include "../../../controller/admin/searchParkingController.php";

if(isset($_POST["updateParkingLocation"]))
{
    $updateLocationId = $_POST["updateParkingLocation"];
    $updateLocationName = $_POST["locationName"];
    $updateDescription = $_POST["description"];
    $updateAddress = $_POST["address"];
    $updateRates = $_POST["rates"];
    $updateRatesLate = $_POST["ratesLate"];


    $_SESSION['locationId'] = $updateLocationId;
    $_SESSION['locationName'] = $updateLocationName;
    $_SESSION['description'] = $updateDescription;
    $_SESSION['address'] = $updateAddress;
    $_SESSION['rates'] = $updateRates;
    $_SESSION['ratesLate'] = $updateRatesLate;

    header("location:index.php?page=updateParkingLocationPage");
}

if(isset($_POST["viewAllParkingSlots"]))
{
    $viewLocationId = $_POST["viewAllParkingSlots"];
    $viewLocationName = $_POST["locationName"];
    $viewDescription = $_POST["description"];
    $viewAddress = $_POST["address"];
    $viewRates = $_POST["rates"];
    $viewRatesLate = $_POST["ratesLate"];
    $viewCapacity = $_POST["capacity"];
    $viewOccupied = $_POST["occupied"];

    $_SESSION['locationId'] = $viewLocationId;
    $_SESSION['locationName'] = $viewLocationName;
    $_SESSION['description'] = $viewDescription;
    $_SESSION['address'] = $viewAddress;
    $_SESSION['rates'] = $viewRates;
    $_SESSION['ratesLate'] = $viewRatesLate;
    $_SESSION['capacity'] = $viewCapacity;
    $_SESSION['occupied'] = $viewOccupied;

    header("location:index.php?page=viewAllParkingSlotsPage");
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
      text-align: right;
    }

</style>

<div class="container">
    <div class="row">
        <div class="search-container ml-auto">
            <form method="POST">
                <label for="locationName">Name:</label>
                <input type="text" name="searchLocationName">

                <label for="description">Description:</label>
                <input type="text" name="searchDescription">

                <label for="address">Address</label>
                <input type="text" name="searchAddress">

                <button type="submit" name="search" class="btn btn-primary" style="height:40px">Search</button>
            </form>
        </div>
    </div>
    <div class="row">
        <?php
        if(isset($_POST["search"]))
        {
            $locationName = $_POST["searchLocationName"];
            $description = $_POST["searchDescription"];
            $address = $_POST["searchAddress"];

            $searchParking = new SearchParkingController();
            $array = $searchParking->searchParking($locationName, $description, $address);

            if ($array[0] != "Success")
            {
                echo '<script>';
                echo "alert('$array[0]');";
                //echo 'document.location = "index.php?page=viewAllParkingLocationPage";';
                echo '</script>';
            }
            else
            {
                echo '<table class ="table">';
                echo '  <tr>';
                echo '      <th class="text-center">Location Id</th>';
                echo '      <th class="text-center">Location Name</th>';
                echo '      <th class="text-center">Location Description</th>';
                echo '      <th class="text-center">Location Address</th>';
                echo '      <th class="text-center">Hourly Rates</th>';
                echo '      <th class="text-center">Late Hourly Rates</th>';
                echo '      <th class="text-center">Capacity</th>';
                echo '      <th class="text-center">Occupied</th>';
                echo '      <th class="text-center">Actions</th>';
                echo '  </tr>';
                for($i = 1; $i < count($array); $i++)
                {
                    $row = $array[$i];
                    echo '  <tr>';
                    echo '      <td>' . $row['locationId'] . '</td>';
                    echo '      <td>' . $row['locationName'] . '</td>';
                    echo '      <td>' . $row['description'] . '</td>';                   
                    echo '      <td>' . $row['address'] . '</td>';
                    echo '      <td>' . $row['rates'] . 'SGD/Hr</td>';
                    echo '      <td>' . $row['ratesLate'] . 'SGD/Hr</td>';
                    echo '      <td>' . $row['capacity'] . '</td>';
                    echo '      <td>' . $row['occupied'] . '</td>';
                    echo '      <td>';
                    echo '          <form method="POST">';
                    echo '              <input type="hidden" name="locationName" value="' . $row['locationName'] . '"/>';
                    echo '              <input type="hidden" name="description" value="' . $row['description'] . '"/>';
                    echo '              <input type="hidden" name="address" value="' . $row['address'] . '"/>';
                    echo '              <input type="hidden" name="rates" value="' . $row['rates'] . '"/>';
                    echo '              <input type="hidden" name="ratesLate" value="' . $row['ratesLate'] . '"/>';
                    echo '              <input type="hidden" name="capacity" value="' . $row['capacity'] . '"/>';
                    echo '              <input type="hidden" name="occupied" value="' . $row['occupied'] . '"/>';
                                        //Update Button
                    echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">Update</button>';
                                        //View More Detail Button
                    echo '              <button class="btn btn-info" style="height:40px" value="' . $row['locationId'] . '" name="viewAllParkingSlots">View Details</button>';
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
            echo '      <th class="text-center">Location Description</th>';
            echo '      <th class="text-center">Location Address</th>';
            echo '      <th class="text-center">Hourly Rates</th>';
            echo '      <th class="text-center">Late Hourly Rates</th>';
            echo '      <th class="text-center">Capacity</th>';
            echo '      <th class="text-center">Occupied</th>';
            echo '      <th class="text-center">Actions</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['locationId'] . '</td>';
                echo '      <td>' . $row['locationName'] . '</td>';
                echo '      <td>' . $row['description'] . '</td>';                   
                echo '      <td>' . $row['address'] . '</td>';
                echo '      <td>' . $row['rates'] . 'SGD/Hr</td>';
                echo '      <td>' . $row['ratesLate'] . 'SGD/Hr</td>';
                echo '      <td>' . $row['capacity'] . '</td>';
                echo '      <td>' . $row['occupied'] . '</td>';
                echo '      <td>';
                echo '          <form method="POST">';
                echo '              <input type="hidden" name="locationName" value="' . $row['locationName'] . '"/>';
                echo '              <input type="hidden" name="description" value="' . $row['description'] . '"/>';
                echo '              <input type="hidden" name="address" value="' . $row['address'] . '"/>';
                echo '              <input type="hidden" name="rates" value="' . $row['rates'] . '"/>';
                echo '              <input type="hidden" name="ratesLate" value="' . $row['ratesLate'] . '"/>';
                echo '              <input type="hidden" name="capacity" value="' . $row['capacity'] . '"/>';
                echo '              <input type="hidden" name="occupied" value="' . $row['occupied'] . '"/>';
                                    //Update Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">Update</button>';
                                    //View Parking Slots
                echo '              <button class="btn btn-info" style="height:40px" value="' . $row['locationId'] . '" name="viewAllParkingSlots">View Parking Slots</button>';
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>