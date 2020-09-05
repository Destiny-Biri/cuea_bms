<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
?>
<?php
BarChart::create(array(
	"dataStore"=>$this->dataStore('sales_by_bus'),
	"width"=>"100%",
	"height"=>"200px",
	"columns"=>array(
		"route_name"=>array(
			"label"=>"Route"
		),
		"amount"=>array(
			"type"=>"number",
			"label"=>"Amount",
			"prefix"=>"Kshs ",
		)
	),
	"options"=>array(
		"title"=>"Sales By Route"
	)
));
?>
<?php
Table::create(array(
	"dataStore"=>$this->dataStore('sales_by_bus'),
	"columns"=>array(
		"route_name"=>array(
			"label"=>"Route Name"
		),
		"amount"=>array(
			"type"=>"number",
			"label"=>"Amount",
			"prefix"=>"Kshs",
		)
	),
	"cssClass"=>array(
		"table"=>"table table-hover table-bordered"
	)
));
?>
