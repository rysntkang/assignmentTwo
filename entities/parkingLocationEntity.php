<?php

class ParkingLocationEntity extends Dbh
{
    private $locationId;
    private $locationName;
    private $address;

    public function __construct(){
    }

    //locationId
    public function get_locationId(){
        return $this->locationId;
    }

    public function set_locationId($locationId){
        $this->locationId = $locationId;
    }

    //locationName
    public function get_locationName(){
        return $this->locationName;
    }

    public function set_locationName($locationName){
        $this->locationName = $locationName;
    }

    //address
    public function get_address(){
        return $this->address;
    }

    public function set_address($address){
        $this->address = $address;
    }

    //Adding new Parking Locations
    protected function create(){
        $error;
		$conn = $this->connectDB();
        $sql = "INSERT INTO location (locationName, address) VALUES ('$this->locationName', '$this->address')";
        $result = $conn->query($sql);

		$error = "Success";
		return $error;
    }

    //Viewing All Parking Locations
	protected function view()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM location";
        $result = $conn->query($sql);

		//checks to see if there are return results
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
				//adds the necessary components to use for the view in the table
                $current = array(
                    'locationId' => $row['locationId'],
					'locationName' => $row['locationName'],
					'address' => $row['address']
                );
				//pushes them into the array (current)
                array_push($array, $current);
            }
        }

        return $array;
    }

    //Search for specific parking location based on the name
    protected function search()
    {
        $error;
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM location WHERE locationName = '$this->locationName'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            $error = "Success";
            array_push($array, $error);
            while ($row = $result->fetch_assoc())
            {
                $current = array(
                    'locationId' => $row['locationId'],
					'locationName' => $row['locationName'],
					'address' => $row['address']
                );
                array_push($array, $current);
            }
            return $array;
        }
        else {
            $error = "No records found";
            array_push($array, $error);
            return $array;
        }
    }

    //Update Location
    protected function update()
    {
        $error;
        $conn = $this->connectDB();
        $sql = "UPDATE location SET locationName = '$this->locationName', address = '$this->address' WHERE locationId = '$this->locationId'";
        $result = $conn->query($sql);

        $error = "Success";
        return $error;
    }

}

?>