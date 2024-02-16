<?php
    
class viewParkedUsersController extends TransactionEntity
{

    public function viewParkedUsers()
    {
        $transaction = new TransactionEntity();
        $array = $transaction->viewParked();

        return $array;
    }
}
?>