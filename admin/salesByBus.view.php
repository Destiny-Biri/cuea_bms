<?php
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;
?>

<div class="text-center">
	<h1>Sales Report</h1>
	<h4>This report shows top 10 sales by bus</h4>
</div>
<hr/>

<?php
BarChart::create(array(
	"dataStore"=>$this->dataStore('sales_by_bus'),
	"width"=>"80%",
	"height"=>"500px",
	"columns"=>array(
		"journey_id"=>array(
			"label"=>"Bus"
		),
		"sum"=>array(
			"type"=>"number",
			"label"=>"Amount",
			"prefix"=>"Kshs",
		)
	),
	"options"=>array(
		"title"=>"Sales By Bus"
	)
));
?>
<?php
Table::create(array(
	"dataStore"=>$this->dataStore('sales_by_bus'),
	"columns"=>array(
		"journey_id"=>array(
			"label"=>"Bus"
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
