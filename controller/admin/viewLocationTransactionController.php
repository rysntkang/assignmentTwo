<?php
    
class viewLocationTransactionController extends TransactionEntity
{

    public function viewLocationTransaction($locationId)
    {
        $transaction = new TransactionEntity();
        $transaction->set_locationId($locationId);
        $array = $transaction->viewLocationSpec();

        return $array;
    }
}
?>