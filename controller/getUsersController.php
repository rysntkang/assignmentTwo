<?php

class GetUsersController extends UserEntity
{
    public function getUsers()
    {
        $user = new UserEntity();
        $array = $user->viewUsers();

        return $array;
    }
}
?>