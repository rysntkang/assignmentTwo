<?php 
include "../../../dbConnection.php";
include "../../../entities/userEntity.php";
include "../../../controller/registerController.php";

if (isset($_POST["register"])) {

    $firstName = $_POST['regFirstName'];
    $surname = $_POST['regSurname'];
    $phoneNum = $_POST['regPhoneNum'];
    $emailAddress = $_POST['regEmailAddress'];
    $username = $_POST['regUsername'];
    $password = $_POST['regPassword'];
    $userProfileId = 1;

    $registerUser = new RegisterController();
    $result = $registerUser->registerUser($username, $password, $firstName, $surname, $phoneNum, $emailAddress, $userProfileId);

    if ($result == "Success")
    {
        header("location:index.php?page=viewAllUsersPage");
    }
    else
    {
        echo "<script>alert('Unable to register.');</script>";
        header("location:index.php?page=registerAdminPage");
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
                    <div class="mb-1">
                        <label class="form-label">Register Admin User</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="regFirstName">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Surname:</label>
                        <input type="text" class="form-control" name="regSurname">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" class="form-control" name="regEmail">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username:</label>
                        <input type="text" class="form-control" name="regUsername">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="text" class="form-control" name="regPassword">
                    </div>
                    <button class="btn btn-success" type="submit" name="register" id="createButton">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>