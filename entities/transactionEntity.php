<?php

class TransactionEntity extends Dbh
{
    private $transactionId;
    private $userId;
    private $slotId;
    private $startTime;
    private $endTime;
    private $totalCost;
    private $duration;

    private $locationId;

    public function __construct(){
    }

    //locationId
    public function get_locationId(){
        return $this->locationId;
    }

    public function set_locationId($locationId){
        $this->locationId = $locationId;
    }

    //transactionId
    public function get_transactionId(){
        return $this->transactionId;
    }

    public function set_transactionId($transactionId){
        $this->transactionId = $transactionId;
    }

    //userId
    public function get_userId(){
        return $this->userId;
    }

    public function set_userId($userId){
        $this->userId = $userId;
    }

    //slotId
    public function get_slotId(){
        return $this->slotId;
    }
    
    public function set_slotId($slotId){
        $this->slotId = $slotId;
    }

    //startTime
    public function get_startTime(){
        return $this->startTime;
    }
    
    public function set_startTime($startTime){
        $this->startTime = $startTime;
    }

    //endTime
    public function get_endTime(){
        return $this->endTime;
    }
    
    public function set_endTime($endTime){
        $this->endTime = $endTime;
    }

    //totalCost
    public function get_totalCost(){
        return $this->totalCost;
    }
    
    public function set_totalCost($totalCost){
        $this->totalCost = $totalCost;
    }

    //duration
    public function get_duration(){
        return $this->duration;
    }
    
    public function set_duration($duration){
        $this->duration = $duration;
    }

    protected function checkIn() {
        $error;
		$conn = $this->connectDB();

        // Your insert query
        $sql = "INSERT INTO transactions (userId, slotId, startTime, duration) 
        VALUES ('$this->userId','$this->slotId','$this->startTime','$this->duration')";

        $result = $conn->query($sql);

        if ($result) {
            //Change Availability from parkingslots to 0
            $sql = "UPDATE parkingslots SET availability = 0 WHERE slotId = '$this->slotId'";
            $result_mysql = $conn->query($sql);

            //Increase the Occupied by 1 from locations
            $sql = "UPDATE locations SET occupied = occupied + 1 WHERE locationId = '$this->locationId'";
            $result_mysql = $conn->query($sql);
        }

		$error = "Success";
		return $error;
    }

    //Viewing All transaction depending on the slotId
    protected function view()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT transactions.transactionId, transactions.startTime, transactions.endTime, transactions.duration, users.username, users.firstName, users.surname, users.emailAddress 
        FROM transactions LEFT OUTER JOIN users ON users.userId = transactions.userId 
        WHERE slotId = '$this->slotId' AND endTime IS NULL; ";
    
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(
                    //parkingSlots
                    'transactionId' => $row['transactionId'],
                    'startTime' => $row['startTime'],
                    'endTime' => $row['endTime'],
                    'duration' => $row['duration'],
                    'username' => $row['username'],
                    'firstName' => $row['firstName'],
                    'surname' => $row['surname'],
                    'emailAddress' => $row['emailAddress']

                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

    protected function checkOut() {
        $error;
		$conn = $this->connectDB();

        // Your insert query
        $sql = "UPDATE transactions SET endTime = '$this->endTime', totalCost = '$this->totalCost'
        WHERE transactionId = '$this->transactionId'";

        $result = $conn->query($sql);

        if ($result) {
            //Change Availability from parkingslots to 0
            $sql = "UPDATE parkingslots SET availability = 1 WHERE slotId = '$this->slotId'";
            $result_mysql = $conn->query($sql);

            //Increase the Occupied by 1 from locations
            $sql = "UPDATE locations SET occupied = occupied - 1 WHERE locationId = '$this->locationId'";
            $result_mysql = $conn->query($sql);
        }

		$error = "Success";
		return $error;
    }



}

?>