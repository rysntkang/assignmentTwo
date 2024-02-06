<?php
    
class registerUserController extends UserEntity
{

    public function registerUser($username, $password, $name, $surname, $phoneNum, $emailAddress, $userProfileId) {
        $user = new UserEntity();
        $user->set_username($username);
        $user->set_password($password);
        $user->set_name($name);
        $user->set_surname($surname);
        $user->set_phoneNum($phoneNum);
        $user->set_emailAddress($emailAddress);
        $user->set_userProfileId($userProfileId);

        $error = $user->register();
        return $error;
    }
}
?>