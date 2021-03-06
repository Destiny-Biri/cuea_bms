<?php
require('class.route.php');
require('class.bus.php');
require('class.crew.php');
require('class.trip.php');
require('class.order.php');
require('class.orderDetail.php');
require('class.receipt.php');
?>
<?php

class DB
{

	public $conn;

	function __construct()
	{
		$servername = 'localhost';
		$username = 'root';
		$password = "";
		$dbname = "bus_management_system";
		// Create connection
		$this->conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
		return $this->conn;
	}


	/**
	 * Fetch the order with the booking id
	 * @param String bookingId
	 *  */
	function fetchOrderByBookingId(String $bookingId): Order
	{
		$sql = "SELECT o.booking_id,o.journey_id,o.booking_time,o.email, o.amount, r.route_name, o.order_status, j.departure_date, j.departure_time, j.vehicle_reg,j.route_id, j.driver_id, j.conductor_id, b.color,b.model,b.coach,b.no_of_seats,r.start_point, r.end_point, r.distance,r.duration, j.driver_name,j.conductor_name,b.imgurl,b.normal_seats,b.vip_seats FROM booking as o, journey as j, route as r, bus as b WHERE o.booking_id = '$bookingId' AND j.journey_id = o.journey_id AND j.route_id = r.route_id  AND j.vehicle_reg = b.registration AND j.route_id = r.route_id";

		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$order = new Order($row['booking_id'], $row['journey_id'], $row['booking_time'], $row['email'],
					$row['amount'], $row['route_name'], $row['order_status'],$row['departure_date'],
					$row['departure_time'],$row['vehicle_reg'],$row['route_id'],$row['driver_id'],$row['conductor_id'],
					$row['color'],$row['model'],$row['coach'],$row['no_of_seats'],$row['start_point'],$row['end_point'],
					$row['distance'],$row['duration'],$row['driver_name'],$row['conductor_name'],$row['imgurl'],$row['normal_seats'],$row['vip_seats']
				);
			}
			return $order;
		} else {
			return [];
		}
	}

	function fetchOrderDetails(String $bookingId): Array
	{
		$sql = "SELECT booking_id, booking_detail_id, seat_id, assignedTo, journeyId,price FROM booking_detail WHERE booking_id = $bookingId";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$orderDetail[] = new OrderDetail($row['booking_id'], $row['booking_detail_id'], $row['seat_id'], $row['assignedTo'], $row['journeyId'], $row['price']);
			}
			return $orderDetail;
		} else {
			return [];
		}

	}


	/**
	 * Fetch orders placed by a user
	 * @param String
	 * */

	function fetchOrdersByEmail(String $email): array
	{
		$sql = "SELECT o.booking_id,o.journey_id,o.booking_time,o.email, o.amount, r.route_name, o.order_status, j.departure_date, j.departure_time, j.vehicle_reg,j.route_id, j.driver_id, j.conductor_id, b.color,b.model,b.coach,b.no_of_seats,r.start_point, r.end_point, r.distance,r.duration, j.driver_name,j.conductor_name,b.imgurl,b.normal_seats,b.vip_seats FROM booking as o, journey as j, route as r, bus as b WHERE email = '$email' AND j.journey_id = o.journey_id AND j.route_id = r.route_id  AND j.vehicle_reg = b.registration ORDER BY o.booking_time DESC";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$orders[] = new Order($row['booking_id'], $row['journey_id'], $row['booking_time'], $row['email'],
					$row['amount'], $row['route_name'], $row['order_status'],$row['departure_date'],
					$row['departure_time'],$row['vehicle_reg'],$row['route_id'],$row['driver_id'],$row['conductor_id'],
					$row['color'],$row['model'],$row['coach'],$row['no_of_seats'],$row['start_point'],$row['end_point'],
					$row['distance'],$row['duration'],$row['driver_name'],$row['conductor_name'],$row['imgurl'],$row['normal_seats'],$row['vip_seats']
				);
			}
			return $orders;
		} else {
			return [];
		}
	}


///Fetch all the orders that have been placed
	function fetchAllOrders()
	{
		$sql = "SELECT o.booking_id,o.journey_id,o.booking_time,o.email, o.amount, r.route_name, o.order_status, j.departure_date, j.departure_time, j.vehicle_reg,j.route_id, j.driver_id, j.conductor_id, b.color,b.model,b.coach,b.no_of_seats,r.start_point, r.end_point, r.distance,r.duration, j.driver_name,j.conductor_name,b.imgurl,b.normal_seats,b.vip_seats FROM booking as o, journey as j, route as r, bus as b WHERE j.journey_id = o.journey_id AND j.route_id = r.route_id  AND j.vehicle_reg = b.registration AND j.route_id = r.route_id";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$orders[]  = new Order($row['booking_id'], $row['journey_id'], $row['booking_time'], $row['email'],
					$row['amount'], $row['route_name'], $row['order_status'],$row['departure_date'],
					$row['departure_time'],$row['vehicle_reg'],$row['route_id'],$row['driver_id'],$row['conductor_id'],
					$row['color'],$row['model'],$row['coach'],$row['no_of_seats'],$row['start_point'],$row['end_point'],
					$row['distance'],$row['duration'],$row['driver_name'],$row['conductor_name'],$row['imgurl'],$row['normal_seats'],$row['vip_seats']
				);
			}
			return $orders;
		} else {
			return [];
		}
	}

	/**
	 * Bus functions
	 *
	 * **/

	/**
	 * @param String $registration
	 * @param String $color
	 * @param String $model
	 * @param String $couch
	 * @param int $noOfSeats
	 * @param $normal_seats
	 * @param $vip_seats
	 * @param String $imgUrl
	 * @return array|bool
	 */
	Function addBus(String $registration, String $color, String $model, String $couch, int $noOfSeats, $normal_seats,
					$vip_seats, String $imgUrl)
	{
		$query = "REPLACE INTO bus(registration,color, model,coach, no_of_seats, normal_seats,vip_seats, imgurl) VALUES('$registration','$color','$model','$couch', $noOfSeats, $normal_seats, $vip_seats, '$imgUrl')";
		if ($this->conn->query($query)) {
			//add the bus seats
			//Add the seats for staff
			$res = $this->addBusSeats(2, 0, 0, $registration, 'S');

			//If the number of normal seats is greater than 2 add the normal seats
			if ($normal_seats > 0) {
				$this->addBusSeats($normal_seats, 1, 0, $registration, 'N');

			}
			if ($vip_seats > 0) {
				$this->addBusSeats($vip_seats, 1, 1, $registration, 'V');
			}
			return true;
		} else {
			return $this->conn->error_list;
		}

	}

	function getAllBuses()
	{
		$sql = "SELECT * FROM bus";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$buses[] = new Bus($row['registration'], $row['color'], $row['model'], $row['coach'], $row['no_of_seats'],$row['imgurl'],$row['normal_seats'],$row['vip_seats']);
			}
			return $buses;
		} else {
			return [];
		}

	}

	/**
	 * @param String $registration
	 * @return array|Bus
	 */
	function getBusDetail(String $registration)
	{
		$sql = "SELECT * FROM bus WHERE registration = '$registration'";
		if($result = $this->conn->query($sql)){
			$row = $result->fetch_assoc();
			$bus = new Bus($row['registration'],$row['color'],$row['model'],$row['coach'],$row['no_of_seats'],$row['imgurl'],$row['normal_seats'],$row['vip_seats'] );
			return $bus;
		}else{
			return $this->conn->error_list;
		}

	}


	/**
	 * Delete a bus
	 * @param String $registration
	 * @return bool
	 */
	Function deleteBus(String $registration)
	{
		$sql = "DELETE FROM bus WHERE registration = '$registration' ";
		if($this->conn->query($sql)){
			return true;
		} else {
			return $this->conn->error;
		}
	}

	/**
	 * Delete a journey
	 * @param int $journeyId
	 * @return bool
	 */
	function deleteJourney(int $journeyId) {
		$sql = "DELETE FROM journey WHERE journey_id = $journeyId ";
		if($this->conn->query($sql)) {
			return true;
		}else {
				return $this->conn->error;
			}
	}

	/**
	 * Delete routes
	 * @param int $routeId
	 ** @return bool
	 */
	function deleteRoute(int $routeId) {
		$sql = "DELETE FROM route WHERE route_id = $routeId ";
		if($this->conn->query($sql)) {
			return true;
		}else {
				return $this->conn->error;
			}
	}

	function deleteCrewMember(int $crewId) {
		$sql = "DELETE FROM crew WHERE crew_id = $crewId ";
		if($this->conn->query($sql)) {
			return true;
		}else {
			return $this->conn->error;
		}
	}


	Function updateBus()
	{
	}

	/**
	 * Route/Destination functions
	 *
	 */
	Function addRoute(String $routeName, String $start_point, String $end_point)
	{
		$query = "INSERT INTO route(route_name, start_point, end_point) VALUES ('$routeName', '$start_point', '$end_point')";
		if ($this->conn->query($query)) {
			return true;
		} else {
			return $this->conn->error_list;
		}

	}

	/**
	 * @param String departureDate y-m-d
	 * @param String departureTime H:i:s
	 * @param int $premium_price Price of premium seats
	 * @param int $normal_price Price of normal seats
	 */
	function addScheduledTrip(String $departureDate, String $departureTime, String $vehicleReg, String $routeId,
							  String $driverId, String $conductorId, int $normal_price, int $premium_price, String
							  $driver_name, String $conductor_name)

	{
		try{
			$sql = "INSERT INTO journey(departure_date, departure_time, vehicle_reg,route_id, driver_id, conductor_id, normal_price, premium_price, driver_name, conductor_name) VALUES('$departureDate', '$departureTime', '$vehicleReg', $routeId, $driverId, $conductorId, $normal_price, $premium_price, '$driver_name', '$conductor_name')";
			$this->conn->query($sql);
			if($this->conn->affected_rows > 0){
				return true;
			}else{
				throw new Exception($this->conn->error);
			}
		}catch (Exception $e){
			return $this->conn->error_list;
		}



	}


// When a trip is created seats will need to initialized for the trip

//Returns an [Array] of [Route]
	Function getAllRoutes()
	{
		$sql = "SELECT * FROM route";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$routes[] = new Route($row['start_point'], $row['end_point'], $row['route_id'], $row['route_name'], $row['distance'], $row['duration']);
			}
			return $routes;
		} else {
			return [];
		}
	}

	function getAllTrips()
	{
		$sql = "SELECT j.journey_id, j.departure_date, j.departure_time, j.vehicle_reg, j.route_id, b.color, b.model,b.coach,b.no_of_seats, j.driver_id,j.conductor_id, r.start_point, r.end_point, r.route_name, r.distance, r.duration,j.driver_name, j.conductor_name, b.imgurl, b.normal_seats, b.vip_seats FROM journey AS j, bus as b, route as r WHERE j.vehicle_reg = b.registration AND j.route_id = r.route_id";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$trips[] = new Trip($row['journey_id'], $row['departure_date'], $row['departure_time'], $row['vehicle_reg'], $row['route_id'], $row['driver_id'], $row['conductor_id'], $row['color'], $row['model'], $row['coach'], $row['no_of_seats'], $row['start_point'], $row['end_point'], $row['route_name'], $row['distance'], $row['duration'],$row['driver_name'], $row['conductor_name'],$row['imgurl'],$row['normal_seats'],$row['vip_seats']);
			}
			return $trips;
		} else {
			return [];
		}
	}


	Function deleteRouteById(String $route_id)
	{
		$query = "DELETE FROM route WHERE route_id = $route_id";
	}

	/**
	 * @param int $routeId
	 * @param String $start_point
	 * @param String $end_point
	 * @param String $route_name
	 * @return bool|string
	 */
	Function updateRoute(int $routeId, String $start_point, String $end_point, String $route_name)
	{
		try {
			$sql = "UPDATE route SET route_name = '$route_name', start_point = '$start_point', end_point = '$end_point' WHERE route_id = $routeId";
			if($this->conn->query($sql)){
				return true;
			}else{
				return $this->conn->error;
			}
		} catch (Exception $e){
			return $e->getMessage();
		}


	}


	/**
	 * Fetch a list of crew
	 * @param String crew_type
	 * Conductor or Driver
	 **/

	function getCrew(String $crew_type)
	{
		$sql = "SELECT * FROM crew WHERE crew_type = '{$crew_type}'";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$crew[] = new Crew($row['crew_id'], $row['crew_type'], $row['crew_name'], "");
			}
			return $crew;
		} else {
			return [];
		}
	}

    /**
     * This function gets all the crew members from the database in ASC order
     * @return array
     */
	function fetchAllCrew() : Array {
	    $sql = "SELECT * FROM crew ORDER BY crew_name ASC ";
	    $result = $this->conn->query($sql);
	    if($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
               $crew[] = new Crew($row['crew_id'],$row['crew_type'],$row['crew_name'], '');
           }
            return $crew;
        }else {
	        return [];
        }
    }


// Login functions
	function checkIfUserExists(String $email, String $password)
	{
		$password = md5($password);
		$sql = "SELECT * FROM users WHERE email = '$email' and password='{$password}' AND userType = 'customer' AND status = 1 ";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
		    return true;
		} else {
			return false;
		}
	}

    /**
     * @param String $email
     * @param String $password
     * @param String $name
     * @param String $mobile
     * @param String $userType
     * @return bool|string
     */
	function addUser(String $email, String $password, String $name, String $mobile, String $userType)
	{
		$hashedPassword = md5($password);
		$sql = "INSERT INTO users(email, password, name, mobile, userType) VALUES ('{$email}','{$hashedPassword}', '{$name}','{$mobile}','{$userType}')";
		if ($this->conn->query($sql)) {
            $this->conn->close();
			return true;
		} else {
			return $this->conn->error;
		}
	}

	/**
	 * @param String This can be either end_point or start_point
	 */
	function fetchDistinctDestinations(String $origin)
	{
		$sql = "SELECT DISTINCT($origin) AS point FROM route ORDER BY '$origin'";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$point[] = $row;
			}
			return $point;
		} else {
			return [];
		}
	}

	function fetchJourneyThatMatchesCriteria($start_point, $end_point, $departureDate)
	{
		$sql = "SELECT j.journey_id, j.departure_date, j.departure_time, j.vehicle_reg, j.route_id, r.distance, r.duration, b.imgurl,b.model,b.coach,b.color,b.no_of_seats, j.normal_price,j.premium_price FROM journey as j, route as r, bus as b
	WHERE r.route_id = j.route_id AND r.start_point = '{$start_point}' AND r.end_point = '{$end_point}' AND j.departure_date = '$departureDate' AND j.vehicle_reg = b.registration";

		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$scheduledTrips[] = $row;
			}

			return $scheduledTrips;
		} else {
			return [];
		}
	}

	function fetchAvailableSeatsForJourney($journeyId)
	{
		$sql = "SELECT j.journey_id, j.normal_price, j.premium_price, j.route_id,  bs.seat_id, bs.isUsable, bs.isPremium, bs.busId, bs.seatName FROM bus_seat as bs , journey as j WHERE bs.isUsable = 1 AND j.vehicle_reg = bs.busId  AND bs.seat_id NOT IN (SELECT seat_id FROM booking_detail as bd WHERE bd.journeyId = $journeyId) AND journey_id = $journeyId ";

		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$availableSeats[] = $row;
			}
			return $availableSeats;
		} else {
			return [];
		}
	}

    /**
     * Get all the users from the user table on the database
     * @return array This returns an array of users
     */
    public function fetchAllUsers() : array
    {
        $sql = "SELECT * FROM users WHERE userType = 'customer' ORDER BY  name ASC";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }

    }


	/**
	 * This creates a journey every other day from the start date to the end date at the times stated. The database enforces that resources cannot be overbooked. This only applies to a bus
	 * @param String $startDate The date when the schedule starts
	 * @param String $scheduledTime The time this journey is scheduled to start
	 * @param String $vehicle_reg The vehicle registration
	 * @param int $route_id What route is this journey
	 * @param int $driver_id The id of the driver
	 * @param int $conductorId THe if of the conductor
	 * @param int $normal_price The base price of this journey
	 * @param int $premium_price The price for the VIP seats of this journey
	 * @param  String $driverName The name of the driver
	 * @param  String $conductorName The name of the conductor
	 * @param  String the end date if recurring
	 * @return bool status It shall return a string with the exception message if the insert was not successful
	 */
	function createRecurringJourney(String $startDate, String $scheduledTime, String $vehicle_reg, int $route_id, int
	$driver_id, $conductorId, $normal_price, $premium_price, String $endDate, String $driverName, String $conductorName)
	{
		try {
			/// We shall add one day from the start date
			$interval = DateInterval::createFromDateString('1 day');
			$begin = new DateTime($startDate);
			$end = new DateTime($endDate);
			$period = new DatePeriod($begin, $interval, $end);
			foreach ($period as $dt) {
				$departureDate = $dt->format('Y-m-d');
				$sql = "INSERT INTO journey (departure_date, departure_time,vehicle_reg, route_id, driver_id, conductor_id, normal_price, premium_price, driver_name, conductor_name) VALUES ('{$departureDate}','{$scheduledTime}','{$vehicle_reg}', $route_id, $driver_id, $conductorId, $normal_price,$premium_price, $driverName,$conductorName) ";

				if (!$this->conn->query($sql)) {
					throw new Exception($this->conn->error);
				}
			}
			$this->conn->close();
			return true;
		} catch (Exception $e) {
			return $e->getMessage();
		}

	}


	function populateSchedule()
	{

	}

	/**
	 * This method is for making bookings
	 * Its shall use a transaction
	 * @param int $journeyId The journeyId
	 * @param string $email The email or username of the currently logged in user
	 * @param double $amount The total amount of this transaction
	 * @param string $orderStatus the status of this order which by default is draft
	 * @param array $bookingDetail An array of seatNo and price separated by _
	 */

	function makeBooking($journeyId, String $email, String $amount, String $orderStatus, array $bookingDetail)
	{
		try {
			$bookingTime = Date('Y-m-d H:i:s');
			$this->conn->begin_transaction();
			$sql = "
	INSERT INTO booking(journey_id, booking_time,email, amount, order_status) VALUES ($journeyId,'$bookingTime','$email',$amount,'$orderStatus');
	";

			$this->conn->query($sql);
			$bookingId = $this->conn->insert_id;

			/// Loop through the booking detail
			/// Explode the $bookingDetail array to get the $seatId and the $price of the seat
			/// Generate a query based on the elements
			foreach ($bookingDetail as $bd) {
				$pieces = explode('_', $bd);
				$seatId = $pieces[0];
				$price = $pieces[1];
				$query2 = "INSERT INTO booking_detail(booking_id,seat_id, assignedTo, journeyId, price) VALUES (" . $bookingId . ",$seatId,'$email',$journeyId,$price);";
				$this->conn->query($query2);

			}
			$this->conn->commit();
			$this->conn->close();
			return $bookingId;
		} catch (Exception $e) {
			var_dump($e->getMessage());
			die();
		}
	}


	function initJourney()
	{

	}

	function fetchBusSeats()
	{

	}

	/**
	 * Add the seats to a bus that has been added.
	 * @param int $noOfSeats The number of seats that shall be allocated for this purpose
	 * @param int $isUsable Can the seat be sold
	 * @param int $isPremium Is this a normal or VIP seat
	 * @param String $busId The registration of the bus
	 * @param String $seatName This name should be used when an image reference is available for seating. For Staff pass S,VIP V, Normal N
	 */
	function addBusSeats(int $noOfSeats, $isUsable, $isPremium, String $busId, String $seatName)
	{
		try {
			for ($i = 1; $i <= $noOfSeats; $i++) {

				$sql = "INSERT INTO bus_seat(isUsable,isPremium,busId, seatName) VALUES($isUsable, $isPremium,'$busId','$seatName$i')";
				if (!$this->conn->query($sql)) {
					throw new Exception($this->conn->error);
				}

			}

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getReceipt(String $transactionCode) {
		$sql = "SELECT * FROM receivables WHERE txtcode = '$transactionCode'";
		if($result = $this->conn->query($sql)){
			if($result->num_rows>0){
				$row = $result->fetch_assoc();
				return $receipt = new Receipt($row['receiptId'],$row['txtcode'],(double)$row['amount'],(int)$row['is_valid']);
			}else{
				return 0;
			}


		}else{
			return $this->conn->error_list;
		}


	}

	public function validateTransaction($transactionCode, $bookingId, $amount, String $orderStatus = 'AwaitingBookingConfirmation')
	{
		$transactionDate = Date("Y-m-d H:i:s");
		try {
			//Start a transaction
			$this->conn->begin_transaction();
			$sql = "UPDATE booking SET order_status = '$orderStatus' WHERE booking_id = $bookingId";
			$sql2 = "INSERT INTO payment (transaction_code, amount, booking_id, transaction_date) VALUES ('$transactionCode', $amount,$bookingId, '$transactionDate')";
			$this->conn->query($sql);
			$this->conn->query($sql2);
			$this->conn->commit();

		} catch (Exception $e) {
			return $e->getMessage();
		}

	}

    /**
     * This function adds a driver or a conductor to the crew table on the database
     * @param String $crew_name This is the name of the crew member
     * @param String $crew_type This is either Driver or Conductor
     * @return bool
     */
    public function addNewCrew(String $crew_name, String $crew_type) : bool
    {
        $result = false;
        $sql = "INSERT INTO crew(crew_name, crew_type) VALUES ('$crew_name', '$crew_type')";
        if($this->conn->query($sql)){
            $result = true;
        }
        return $result;
    }

    public function checkIfAdminExists(string $username, string $password)
    {
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE email = '$username' and password='{$password}' AND userType = 'admin'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
        	return true;
        } else {
            return $this->conn->error;
        }
    }

    /**
     * Fetch all the payments
     * @return array|string
     */
    public function fetchAllTransactions()
    {
        try{
            $payments = Array();
            $sql = "SELECT * FROM payment";
            $result = $this->conn->query($sql);
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
                    $payments[] =  $row;
                }
                return $payments;
            }else{
                return  [];
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

	/**
	 * Get the route using the route id
	 * @param int $routeId
	 * @return Route|string
	 */
	public function fetchRouteById(int $routeId)
	{
		try {
			$sql = "SELECT * FROM route WHERE route_id = $routeId";
			if($result = $this->conn->query($sql)){
				if($result->num_rows > 0 ) {
					$row = $result->fetch_assoc();
					$route = new Route($row['start_point'], $row['end_point'],$routeId,$row['route_name'],$row['distance'],
						$row['duration']);
					return $route;
				}

			}
		} catch (Exception $e){
			return $e->getMessage();
		}

	}

	public function fetchJourneyDetails(int $journeyId)
	{
		$details = Array();
		try{
			$sql = "SELECT * FROM booking_detail AS bd, booking as b, journey as j, route as r WHERE bd.journeyId = $journeyId AND bd.journeyId = b.journey_id AND r.route_id = j.route_id";
			if($result = $this->conn->query($sql)){
				if($result->num_rows > 0 ) {
					while ($row = $result->fetch_assoc()){
						$details[] =  $row;
					}
					return $details;
				}else{
					return $details;
				}
			}
		} catch (Exception $e){
			return $e->getMessage();
		}


	}

    /**
     * @param int $booking_id
     * @param String $status
     * @return bool|string
     */
    public function confirmBooking(int $booking_id, String $status)
    {
        $sql = "UPDATE booking SET order_status = '{$status}' WHERE booking_id = $booking_id";
        try{
            if($this->conn->query($sql)){
                $result = $this->conn->affected_rows;
                if($result > 0){
                    return true;
                }
            }
        }
        catch (Exception $e){
            return $e->getMessage();
        }
    }

	public function updateUser($email, $name, $mobile, int $userId, int $status)
	{
		try{
			$sql = "UPDATE users SET email = '$email', name = '$name',  mobile = '$mobile', status = $status WHERE userId = $userId ";

			$this->conn->query($sql);
			if($this->conn->affected_rows>0){
				return true;
			}else{
			    return $this->conn->error_list;

			}
		}catch (Exception $e){
			return $this->conn->error_list;
		}
	}

	public function fetchUserDetailByEmail($email)
	{
		try{
			$sql = "SELECT * FROM users WHERE email = '$email' ";
			 $result = $this->conn->query($sql);
			if($result->num_rows > 0) {
				return $result->fetch_assoc();
			}
		}catch (Exception $e){
			return $e->getMessage();
		}


	}

	public function addNewUser($email, $name, $mobile, $password, $userType)
	{

		try{
			$hashPassword = md5($password);
			$sql = "INSERT INTO users(email, password, name, mobile, userType) VALUES  ('$email', '$hashPassword', '$name', '$mobile', '$userType') ";

			if($this->conn->query($sql)){
				return true;
			}else{
			    return  $this->conn->error_list;
			}

		}catch (Exception $e){
			return $e->getMessage();
		}

	}

	/**
	 * Check if a registration number is unique
	 * @param string $registration
	 * @return bool|int|mixed|mysqli_result
	 */
	public function checkIfUniqueRegistration(string $registration)
	{
		try{
			$sql = "SELECT COUNT(bus.registration) FROM bus WHERE  bus.registration = '$registration'";
			$result = $this->conn->query($sql);
			$row = $result->fetch_assoc();
			return (int)$row['COUNT(bus.registration)'];
		}catch (Exception $e){
			return $e->getCode();
		}
	}

	public function checkIfRouteExists(string $start, string $stop)
	{
		try{
			$sql = "SELECT COUNT(route_id) AS result FROM route WHERE start_point = '$start' AND end_point = '$stop' ";
			if($result = $this->conn->query($sql)){
				$row = $result->fetch_assoc();
				return (int)$row['result'];
			}else{
				throw new Exception($this->conn->error);
			}
		}
		catch (Exception $e){
			return $e->getMessage();
		}

	}


}


?>