<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/viewParkingLocationController.php";
include "../../../controller/admin/searchParkingController.php";

if(isset($_POST["updateParkingLocation"]))
{
    $updateLocationId = $_POST["updateParkingLocation"];
    $_SESSION['locationId'] = $updateLocationId;

    header("location:index.php?page=updateParkingLocationPage");
}

if(isset($_POST["viewAllParkingSlots"]))
{
    $viewLocationId = $_POST["viewAllParkingSlots"];
    $_SESSION['locationId'] = $viewLocationId;

    header("location:index.php?page=viewAllParkingSlotsPage");
}

if(isset($_POST["viewLocationSpecificParkedUsers"]))
{
    $viewLocationId = $_POST["viewLocationSpecificParkedUsers"];
    $_SESSION['locationId'] = $viewLocationId;

    header("location:index.php?page=viewLocationSpecificParkedUsersPage");
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

    .form-inline {
      float: right;
      margin: 1em;
    }

</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <form method = "POST">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Name, Description, Address</span>
                    </div>
                    <input type="text" class="form-control" name="searchLocationName">
                    <input type="text" class="form-control" name="searchDescription">
                    <input type="text" class="form-control" name="searchAddress">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="search">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form method = "POST">
                <div class="form-inline">
                    <label class="mr-2">Sort:</label>
                    <select name="filterType" class="form-control mr-2">
                    <option value="all">All</option>
                        <option value="available">Available</option>
                        <option value="full">Full</option>
                    </select>
                    <button type="submit" class="btn btn-primary" name="filter">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
        
    <div class="row">
        <?php
        //Got Search
        if(isset($_POST["search"]))
        {
            $locationName = $_POST['searchLocationName'];
            $description = $_POST['searchDescription'];
            $address = $_POST['searchAddress'];

            $searchParking = new SearchParkingController();
            $array = $searchParking->searchParking($locationName, $description, $address);

            if ($array[0] != "Success")
                {
                    echo '<script>';
                    echo "alert('$array[0]');";
                    header("location:index.php?page=viewAllParkingLocationPage");
                    echo '</script>';
                }
                else
                {
                    if(isset($_POST["filter"])){
                        if ($_POST["filterType"] == "available") {
                            $array = array_filter($array, function($row) {
                                return $row['capacity'] >= $row['occupied'];
                            });
                        } elseif ($_POST["filterType"] == "full") {
                            $array = array_filter($array, function($row) {
                                return $row['capacity'] <= $row['occupied'];
                            });
                        }                        
                    }

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
                                            //Update Button
                        echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">Update</button>';
                                            //View More Detail Button
                        echo '              <button class="btn btn-info" style="height:40px" value="' . $row['locationId'] . '" name="viewAllParkingSlots">View Details</button>';
                                            //View All Parked Users in that Location Button
                                            if ($row['occupied'] > 0) {
                                            echo '<button class="btn btn-secondary" style="height:40px" value="' . $row['locationId'] . '" name="viewLocationSpecificParkedUsers">List Users</button>';
                                            }
                        echo '          </form>';
                        echo '      </td>';
                        echo '  </tr>';
                    }
                    echo "</table>";
                }
        }
                
        //Default, Never Search
        else
        {
            $viewParkingLocation = new ViewParkingLocationController();
            $array = $viewParkingLocation->viewParkingLocation();

            if (isset($_POST["filter"])) {
                if ($_POST["filterType"] == "available") {
                    $array = array_filter($array, function($row) {
                        return $row['capacity'] > $row['occupied'];
                    });
                } elseif ($_POST["filterType"] == "full") {
                    $array = array_filter($array, function($row) {
                        return $row['capacity'] <= $row['occupied'];
                    });
                }
            }
            
       
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
                                    //Update Button
                echo '              <button class="btn btn-primary" style="height:40px" value="' . $row['locationId'] . '" name="updateParkingLocation">Update</button>';
                                    //View Parking Slots
                echo '              <button class="btn btn-info" style="height:40px" value="' . $row['locationId'] . '" name="viewAllParkingSlots">View Parking Slots</button>';
                                    //View all users that are parked to that specific location
                                    if ($row['occupied'] > 0) {
                                        echo '<button class="btn btn-secondary" style="height:40px" value="' . $row['locationId'] . '" name="viewLocationSpecificParkedUsers">List Users</button>';
                                    }
                echo '          </form>';
                echo '      </td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>