<?php 
include "config.php";
include "../dbConnection.php";
include "../entities/userEntity.php";
include "../controller/registerUserController.php";
include "../header.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {

        $name = $_POST['regName'];
        $surname = $_POST['regSurname'];
        $phoneNum = $_POST['regPhoneNum'];
        $emailAddress = $_POST['regEmailAddress'];
        $username = $_POST['regUsername'];
        $password = $_POST['regPassword'];
        $userProfileId = 2;

        $registerUser = new registerUserController();
        $result = $registerUser->registerUser($username, $password, $name, $surname, $phoneNum, $emailAddress, $userProfileId);
    
        if ($result != "Success")
        {
            echo "<script>alert('$result');</script>";
        }
        else
        {
            echo "<script>alert('Unable to register.');</script>";
            redirect("/registerUserPage.php");
        }

    } elseif (isset($_POST["back"])) {
        redirect("/loginPage.php");
    }
};

?>

<style>
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
    }
</style>


<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<body class="login-page">

<br>
<br>
<br>
<h1 class="text-center text-white px-4 py-5" id="page-title"><b>Register</b></h1>

<div class="login-box col-md-auto align-items-center">
  <div class="card card-navy my-3">
    <div class="card-body">
      <p class="login-box-msg">Register</p>
      <form id="login-frm" method="post">

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regName" autofocus placeholder="First Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regSurname" autofocus placeholder="Surname" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regPhoneNum" autofocus placeholder="Phone Number" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regEmailAddress" autofocus placeholder="Email Address" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regUsername" autofocus placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" id="regPassword" autofocus placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-4">
          </div>
          <div class="col-4">
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
          </div>
          <div class="col-4">
            <button type="submit" name="back" class="btn btn-primary btn-block" formnovalidate>Back</button>
          </div>
      </form>
    </div>
  </div>
</div>

</body>
</html> 