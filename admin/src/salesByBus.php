<?php

require_once "../vendor/koolreport/core/autoload.php";
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
			->query("SELECT journey_id,amount FROM booking")
			->pipe(new Group(array(
				"by"=>"journey_id",
				"sum"=>"amount"
			)))
			->pipe(new Sort(array(
				"amount"=>"desc"
			)))
			->pipe(new Limit(array(10)))
			->pipe($this->dataStore('sales_by_bus'));
	}
}