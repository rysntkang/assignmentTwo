<?php

class ParkingSlotsEntity extends Dbh
{
    private $slotId;
    private $locationId;
    private $availability;

    public function __construct(){
    }

    //slotId
    public function get_slotId(){
        return $this->slotId;
    }

    public function set_slotId($slotId){
        $this->slotId = $slotId;
    }

    //locationId
    public function get_locationId(){
        return $this->locationId;
    }

    public function set_locationId($locationId){
        $this->locationId = $locationId;
    }

    //availability
    public function get_availability(){
        return $this->availability;
    }
    
    public function set_availability($availability){
        $this->availability = $availability;
    }

    //slotNum
    public function get_slotNum(){
        return $this->slotNum;
    }
    
    public function set_slotNum($slotNum){
        $this->slotNum = $slotNum;
    }

    //Viewing All Slots depending on the LocationID
    protected function viewAll()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM parkingSlots WHERE locationId = '$this->locationId'";
    
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(
                    //parkingSlots
                    'slotId' => $row['slotId'],
                    'availability' => $row['availability'],
                    'slotNum' => $row['slotNum']
                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    } 
}

?>