<?php
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/updateParkingLocationController.php";
include "../../../controller/getParkingLocationController.php";

$locationId = $_SESSION['locationId'];

if(isset($_POST["updateLocation"]))
{
    $locationName = $_POST["locationName"];
    $description = $_POST["description"];
    $address = $_POST["address"];
    $rates = $_POST["rates"];
    $ratesLate = $_POST["ratesLate"];

    $updateParkingLocation = new UpdateParkingLocationController();
    $result = $updateParkingLocation->updateParkingLocation($locationId, $locationName, $description , $address, $rates, $ratesLate);

    if($result != "Success")
    {
        echo "<script>alert('$result');</script>";
    }
    else
    {
        header("location:index.php?page=viewAllParkingLocationPage");
    }
}

if(isset($_POST["back"]))
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

    .card-footer {
        background-color: #d9d9d9;
    }

    #updateButton {
        float: right;
        padding: auto;
    }

</style>

<?php

$getParkingLocation = new GetParkingLocationController();
$array = $getParkingLocation->getParkingLocation($locationId);

$locationName = $array[0]['locationName'];
$description = $array[0]['description'];
$address = $array[0]['address'];
$rates = $array[0]['rates'];
$ratesLate = $array[0]['ratesLate'];

?>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-1">
                        <label class="form-label">Update Parking Location</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location Name</label>
                        <input type="text" class="form-control" name="locationName" value="<?=$locationName?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" value="<?=$description?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="<?=$address?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hourly Rates:</label>
                        <input type="number" value="<?=$rates?>" min="1" max="10" step=".01" name="rates">
                        <label class="form-label">Hourly Late Rates:</label>
                        <input type="number" value="<?=$ratesLate?>" min="1" max="10" step=".01" name="ratesLate">
                    </div>
                    <button class="btn btn-success mr-auto" type="submit" name="updateLocation" id="updateButton">Update</button>
                    <button class="btn btn-secondary" type="submit" name="back">Back</button>
                </form>
            </div>
        </div>
    </div>
</div>