<?php
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/updateParkingLocationController.php";

$locationId = $_SESSION['locationId'];
$locationName = $_SESSION['locationName'];
$address = $_SESSION['address'];


if(isset($_POST["updateLocation"]))
{
    $locationName = $_POST["locationName"];
    $address = $_POST["address"];
    
    $updateParkingLocation = new UpdateParkingLocationController();
    $result = $updateParkingLocation->updateParkingLocation($locationId, $locationName, $address);

    if($result != "Success")
    {
        echo "<script>alert('$result');</script>";
    }
    else
    {
        header("location:index.php?page=viewAllParkingLocationPage");
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

    #updateButton {
        float: right;
        padding: auto;
    }

</style>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="locationName" class="form-label">Location Name</label>
                        <input type="text" class="form-control" name="locationName" value="<?=$locationName?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="<?=$address?>" required>
                    </div>
                    <button class="btn btn-success" type="submit" name="updateLocation" id="updateButton">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>