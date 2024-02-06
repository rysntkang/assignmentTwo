<?php
include "config.php";
include "../dbConnection.php";
include "../entities/userEntity.php";
include "../controller/loginController.php";
include "../header.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) {

        $username = $_POST['logUsername'];
        $password = $_POST['logPassword'];
    
        $login = new LoginController();
        $error = $login->loginUser($username, $password);
    
        if ($error == "Success")
        {
          redirectHomePage($_SESSION["currentUserProfileId"]);
        }
        else
        {
          echo "<script>alert('$error');</script>";
        }

    } elseif (isset($_POST["register"])) {
        redirect("/registerUserPage.php");
    }
}

function redirectHomePage($userProfileId){
  if ($userProfileId == 1){
    redirect("/actors/admin");
  }
  elseif ($userProfileId == 2){
    redirect("actors/user");
  }
}

?>

<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<body class="login-page">

<style>
    #page-title{
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
    }
  </style>
<br>
<br>
<br>
<h1 class="text-center text-white px-4 py-5" id="page-title"><b>Login</b></h1>

<div class="login-box col-md-auto align-items-center">
  <div class="card card-navy my-3">
    <div class="card-body">
      <p class="login-box-msg">Enter your credentials:</p>
      <form id="login-frm" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="logUsername" id="logUsername" autofocus placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="logPassword" id="logPassword" autofocus placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Log in</button>
          </div>
      </form>
    </div>
  </div>
</div>


<div class="col-md-auto align-items-center">
  <div class="card card-navy my-3">
    <div class="card-body">
      <form method="post">
        <button type="submit" name="register" class="btn btn-secondary btn-block">Create another account</button>
      </form>
    </div>
  </div>
</div>

</body>
</html> 