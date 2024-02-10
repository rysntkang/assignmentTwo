<?php

class ParkingLocationEntity extends Dbh
{
    private $locationId;
    private $locationName;
    private $description;
    private $address;
    private $rates;
    private $ratesLate;
    private $capacity;
    private $occupied;

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

    //description
    public function get_description(){
        return $this->description;
    }
    
    public function set_description($description){
        $this->description = $description;
    }

    //address
    public function get_address(){
        return $this->address;
    }

    public function set_address($address){
        $this->address = $address;
    }

    //rates
    public function get_rates(){
        return $this->rates;
    }
    
    public function set_rates($rates){
        $this->rates = $rates;
    }

    //ratesLate
    public function get_ratesLate(){
        return $this->ratesLate;
    }

    public function set_ratesLate($ratesLate){
        $this->ratesLate = $ratesLate;
    }

    //capacity
    public function get_capacity(){
        return $this->capacity;
    }

    public function set_capacity($capacity){
        $this->capacity = $capacity;
    }

    //occupied
    public function get_occupied(){
        return $this->occupied;
    }

    public function set_occupied($occupied){
        $this->occupied = $occupied;
    }

    protected function create() {
        $error;
        $conn = $this->connectDB();
    
        // Your insert query
        $sql = "INSERT INTO locations (locationName, description, address, rates, ratesLate, capacity, occupied) 
        VALUES ('$this->locationName','$this->description','$this->address','$this->rates','$this->ratesLate','$this->capacity','$this->occupied')";
    
        // Execute the insert query
        $result = $conn->query($sql);
    
        if ($result) {
            // Get the last inserted ID after a successful insert
            $locationId = $conn->insert_id;
    
            // Insert parking slots depending on the number of capacity specified.
            for ($i = 1; $i <= $this->capacity; $i++) {
                $sql_capacity = "INSERT INTO parkingslots (locationId, availability, slotNum) VALUES ($locationId, 1, $i)";
                $result_capacity = $conn->query($sql_capacity);
    
                if (!$result_capacity) {
                    // Handle the error if parking slot insertion fails
                    $error = "Error inserting parking slot: " . $conn->error;
                    return $error;
                }
            }
    
            $error = "Success";
        } else {
            // Handle the error if location insertion fails
            $error = "Error inserting location: " . $conn->error;
        }
    
        // Close connection
        $conn->close();
    
        return $error;
    }

    //Viewing All Locations
    protected function view()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM locations";
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
                    'description' => $row['description'],
					'address' => $row['address'],
                    'rates' => $row['rates'],
                    'ratesLate' => $row['ratesLate'],
                    'capacity' => $row['capacity'],
                    'occupied' => $row['occupied']
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
        $sql = "SELECT * FROM locations WHERE 1";

        if (!empty($this->locationName)) {
            $sql .= " AND locationName LIKE '%" . $this->locationName . "%'";
        }

        if (!empty($this->description)) {
            $sql .= " AND description LIKE '%" . $this->description . "%'";
        }
        
        if (!empty($this->address)) {
            $sql .= " AND address LIKE '%" . $this->address . "%'";
        }

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
                    'description' => $row['description'],
					'address' => $row['address'],
                    'rates' => $row['rates'],
                    'ratesLate' => $row['ratesLate'],
                    'capacity' => $row['capacity'],
                    'occupied' => $row['occupied']
                );
                array_push($array, $current);
            }
        }
        else {
            $error = "No records found";
            array_push($array, $error);
        }
        return $array;
    }

    //Update Location
    protected function update()
    {
        $error;
        $conn = $this->connectDB();
        $sql = "UPDATE locations 
        SET locationName = '$this->locationName', 
        description = '$this->description', 
        address = '$this->address', 
        rates = '$this->rates', 
        ratesLate = '$this->ratesLate'
        WHERE locationId = '$this->locationId'";
        $result = $conn->query($sql);

        $error = "Success";
        return $error;
    }

    //View All Fully Booked Parking Locations
    protected function viewFullBooked()
    {
        $array = [];
        $conn = $this->connectDB();
        $sql = "SELECT * FROM locations WHERE capacity = occupied";
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
        else {
            //Don do anything, dont need to return.
        }

        return $array;
    }        
}

?>