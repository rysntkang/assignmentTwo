<?php 
include "../../../dbConnection.php";
include "../../../entities/userEntity.php";
include "../../../controller/admin/viewUserController.php";
include "../../../controller/admin/searchUserController.php";

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

    .input-group input {
      height: 35px;
      margin-left: 1em;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            
        </div>
        <div class="col-md-3">
            <div class="input-group">
                <form method = "POST">
                    <div class="input-group">
                        <input type="username" class="form-control" name="username">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" name="search">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        if(isset($_POST["search"]))
        {
            $username = $_POST["username"];
        
            $searchUser = new SearchUserController();
            $array = $searchUser->searchUser($username);

            if ($array[0] != "Success")
            {
                echo '<script>';
                echo "alert('$array[0]');";
                echo 'document.location = "index.php?page=viewAllUsersPage";';
                echo '</script>';
            }
            else
            {
                echo '<table class ="table">';
                echo '  <tr>';
                echo '      <th class="text-center">User ID</th>';
                echo '      <th class="text-center">Username</th>';
                echo '      <th class="text-center">First Name</th>';
                echo '      <th class="text-center">Surname</th>';
                echo '      <th class="text-center">Phone Number</th>';
                echo '      <th class="text-center">Email Address</th>';
                echo '  </tr>';
                for($i = 1; $i < count($array); $i++)
                {
                    $row = $array[$i];
                    echo '  <tr>';
                    echo '      <td>' . $row['userId'] . '</td>';
                    echo '      <td>' . $row['username'] . '</td>';
                    echo '      <td>' . $row['firstName'] . '</td>';
                    echo '      <td>' . $row['surname'] . '</td>';
                    echo '      <td>' . $row['phoneNum'] . '</td>';
                    echo '      <td>' . $row['emailAddress'] . '</td>';
                    echo '  </tr>';
                }
                echo "</table>";
            }
        }else
        {
            $viewUser = new ViewUserController();
            $array = $viewUser->viewUser();
            echo '<table class ="table">';
            echo '  <tr>';
            echo '      <th class="text-center">User ID</th>';
            echo '      <th class="text-center">Username</th>';
            echo '      <th class="text-center">First Name</th>';
            echo '      <th class="text-center">Surname</th>';
            echo '      <th class="text-center">Phone Number</th>';
            echo '      <th class="text-center">Email Address</th>';
            echo '  </tr>';
            foreach($array as $row)
            {
                echo '  <tr>';
                echo '      <td>' . $row['userId'] . '</td>';
                echo '      <td>' . $row['username'] . '</td>';
                echo '      <td>' . $row['firstName'] . '</td>';
                echo '      <td>' . $row['surname'] . '</td>';
                echo '      <td>' . $row['phoneNum'] . '</td>';
                echo '      <td>' . $row['emailAddress'] . '</td>';
                echo '  </tr>';
            }
            echo "</table>";
        }
        ?>
    </div>
</div>
