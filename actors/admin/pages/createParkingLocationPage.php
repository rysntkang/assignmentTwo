<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/createParkingLocationController.php";

if(isset($_POST["createLocation"]))
{
    $locationName = $_POST["locationName"];
    $description = $_POST["description"];
    $address = $_POST["address"];
    $rates = $_POST["rates"];
    $ratesLate = $_POST["ratesLate"];
    $capacity = $_POST["capacity"];

    //extract just digits
    preg_match('/\d+(\.\d+)?/', $rates, $match);
    $rates = $match[0];
    preg_match('/\d+(\.\d+)?/', $ratesLate, $match);
    $ratesLate = $match[0];

    if(empty($locationName))
    {
        $error = "Please enter a location name.";
        echo "<script>alert('$error');</script>";
    }
    else
    {
        $createParkingLocation = new CreateParkingLocationController();
        $error = $createParkingLocation->createParkingLocation($locationName, $description, $address, $rates, $ratesLate , $capacity);

        if($error != "Success")
        {
            echo "<script>alert('$error');</script>";
        }
        else
        {
            header("location:index.php?page=viewAllParkingLocationPage");
        }
    }
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

    .card-footer {
        background-color: #d9d9d9;
    }

    #createButton {
        float: right;
        padding: auto;
    }

    #longInput {
        width: 500px;
    }

</style>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="date" class="form-label">Location Name:</label>
                        <input type="text" class="form-control" name="locationName">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Description:</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Address:</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Hourly Rates:</label>
                        <input type="number" value="1" min="1" max="10" step="1" name="rates">
                        <label for="date" class="form-label">Hourly Late Rates:</label>
                        <input type="number" value="3" min="1" max="10" step="1" name="ratesLate">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Number of parking slots:</label>
                        <input type="number" value="5" min="1" max="10" name="capacity">
                    </div>
                    <button class="btn btn-success" type="submit" name="createLocation" id="createButton">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>