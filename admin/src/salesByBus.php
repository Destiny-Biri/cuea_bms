<?php

require_once "koolreport/core/autoload.php";
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;

class SalesByBus extends \koolreport\KoolReport{
	public  function settings()
	{
		return array(
			"dataSources"=>array(
				"sales"=>array(
					"connectionString"=>"mysql:host=localhost;dbname=bus_management_system",
					"username"=>"root",
					"password"=>"",
					"charset"=>"utf8"
				)
			)
		);
	}

	public function setup()
	{
		$this->src('sales')
			->query("SELECT r.route_name, b.amount FROM booking as b, journey as j, route as r WHERE r.route_id = j.route_id AND b.journey_id = j.journey_id GROUP BY(j.route_id)")

			->pipe(new Sort(array(
				"amount"=>"desc"
			)))
			->pipe(new Limit(array(10)))
			->pipe($this->dataStore('sales_by_bus'));
	}
}