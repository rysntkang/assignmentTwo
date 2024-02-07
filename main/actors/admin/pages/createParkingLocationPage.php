<?php 
include "../../../dbConnection.php";
include "../../../entities/parkingLocationEntity.php";
include "../../../controller/admin/createParkingLocationController.php";

if(isset($_POST["createLocation"]))
{
    $locationName = $_POST["locationName"];
    $address = $_POST["addressName"];

    if(empty($locationName))
    {
        $error = "Please enter a location name.";
        echo "<script>alert('$error');</script>";
    }
    else
    {
        $createParkingLocation = new CreateParkingLocationController();
        $error = $createParkingLocation->createParkingLocation($locationName, $address);

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

    #role {
        width: 300px;
        height: 40px;
    }

    #createButton {
        float: right;
        padding: auto;
    }

    #addressInput {
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
                        <input type="text" name="locationName" id="extendedInput">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Address:</label>
                        <input type="text" name="addressName" id="addressInput">
                    </div>
                    <button class="btn btn-success" type="submit" name="createLocation" id="createButton">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>