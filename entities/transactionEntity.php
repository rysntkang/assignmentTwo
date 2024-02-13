<?php

class TransactionEntity extends Dbh
{
    private $transactionId;
    private $userId;
    private $slotId;
    private $startTime;
    private $endTime;
    private $totalCost;
    private $actualDuration;
    private $intendedDuration;

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

    //actualDuration
    public function get_actualDuration(){
        return $this->actualDuration;
    }
    
    public function set_actualDuration($actualDuration){
        $this->actualDuration = $actualDuration;
    }

    //intendedDuration
    public function get_intendedDuration(){
        return $this->intendedDuration;
    }
    
    public function set_intendedDuration($intendedDuration){
        $this->intendedDuration = $intendedDuration;
    }

    protected function checkIn() {
        $error;
		$conn = $this->connectDB();

        $sql = "INSERT INTO transactions (userId, slotId, startTime, actualDuration, intendedDuration) 
        VALUES ('$this->userId','$this->slotId','$this->startTime','$this->actualDuration', '$this->intendedDuration')";

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
        $sql = "SELECT transactions.transactionId, transactions.startTime, transactions.endTime, transactions.actualDuration, transactions.intendedDuration, users.username, users.firstName, users.surname, users.emailAddress 
        FROM transactions 
        JOIN users ON users.userId = transactions.userId 
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
                    'actualDuration' => $row['actualDuration'],
                    'intendedDuration' => $row['intendedDuration'],
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

    protected function viewLocationSpec(){
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT transactions.transactionId, transactions.startTime, transactions.actualDuration, transactions.intendedDuration, users.username, users.firstName, users.surname, users.emailAddress, parkingslots.slotNum, parkingslots.slotId, parkingslots.availability
                FROM transactions
                JOIN users ON users.userId = transactions.userId
                JOIN parkingslots ON parkingslots.slotId = transactions.slotId
                JOIN locations ON parkingslots.locationId = locations.locationId
                WHERE locations.locationId = '$this->locationId' AND transactions.endTime IS NULL;";
    
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
                    'actualDuration' => $row['actualDuration'],
                    'intendedDuration' => $row['intendedDuration'],
                    'username' => $row['username'],
                    'firstName' => $row['firstName'],
                    'surname' => $row['surname'],
                    'emailAddress' => $row['emailAddress'],
                    'slotNum' => $row['slotNum'],
                    'slotId' => $row['slotId'],
                    'availability' => $row['availability']

                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

    protected function viewCurrentlyCheckIn(){
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT transactions.transactionId, transactions.startTime, transactions.actualDuration, transactions.intendedDuration, 
        parkingslots.slotNum, parkingslots.slotId, parkingslots.availability, parkingslots.locationId,
        locations.locationName, locations.address, locations.capacity, locations.occupied, locations.rates, locations.ratesLate
                FROM transactions
                JOIN parkingslots ON parkingslots.slotId = transactions.slotId
                JOIN locations ON parkingslots.locationId = locations.locationId
                WHERE transactions.userId = '$this->userId' AND transactions.endTime IS NULL;";
    
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(

                    'transactionId' => $row['transactionId'],
                    'startTime' => $row['startTime'],
                    'actualDuration' => $row['actualDuration'],
                    'intendedDuration' => $row['intendedDuration'],
                    'slotNum' => $row['slotNum'],
                    'slotId' => $row['slotId'],
                    'availability' => $row['availability'],
                    'locationId' => $row['locationId'],
                    'locationName' => $row['locationName'],
                    'address' => $row['address'],
                    'capacity' => $row['capacity'],
                    'occupied' => $row['occupied'],
                    'rates' => $row['rates'],
                    'ratesLate' => $row['ratesLate']

                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

    protected function viewAllPrevCheckIn(){
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT transactions.transactionId, transactions.startTime, transactions.endTime, transactions.actualDuration, transactions.intendedDuration, 
        parkingslots.slotNum, parkingslots.slotId, parkingslots.availability, parkingslots.locationId,
        locations.locationName, locations.address, locations.rates, locations.ratesLate
                FROM transactions
                JOIN parkingslots ON parkingslots.slotId = transactions.slotId
                JOIN locations ON parkingslots.locationId = locations.locationId
                WHERE transactions.userId = '$this->userId' AND transactions.totalCost IS NOT NULL;";
    
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(

                    'transactionId' => $row['transactionId'],
                    'startTime' => $row['startTime'],
                    'endTime' => $row['endTime'],
                    'actualDuration' => $row['actualDuration'],
                    'intendedDuration' => $row['intendedDuration'],
                    'slotNum' => $row['slotNum'],
                    'slotId' => $row['slotId'],
                    'availability' => $row['availability'],
                    'locationId' => $row['locationId'],
                    'locationName' => $row['locationName'],
                    'address' => $row['address'],
                    'rates' => $row['rates'],
                    'ratesLate' => $row['ratesLate']

                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

}

?>