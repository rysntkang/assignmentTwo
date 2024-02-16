<?php
    
class RegisterAdminController extends UserEntity
{

    public function registerUser($username, $password, $firstName, $surname, $phoneNum, $emailAddress, $userProfileId) {
        $user = new UserEntity();
        $user->set_username($username);
        $user->set_password($password);
        $user->set_firstName($firstName);
        $user->set_surname($surname);
        $user->set_phoneNum($phoneNum);
        $user->set_emailAddress($emailAddress);
        $user->set_userProfileId($userProfileId);

        $error = $user->register();
        return $error;
    }
}
?>