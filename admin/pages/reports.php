<div class="grid-x grid-margin-x">
	<div class="large-9 cell">
		<h2>Reports</h2>
		<?php
		if(isset($_GET['report'])){
			switch ($_GET['report']){
				case 'journey':
					require_once ('src/salesByBus.php');
					$salesByBus = new SalesByBus();
					$salesByBus->run()->render();
					break;
				case 'route':
//					require_once ('src/salesByBus.php');
//					$salesByBus = new SalesByBus();
//					$salesByBus->run()->render();
					break;
				case 'dailysales':
//					require_once ('src/salesByBus.php');
//					$salesByBus = new SalesByBus();
//					$salesByBus->run()->render();
					break;
				case 'monthlysales':
//					require_once ('src/salesByBus.php');
//					$salesByBus = new SalesByBus();
//					$salesByBus->run()->render();
					break;
				case 'customer':
//					require_once ('src/salesByBus.php');
//					$salesByBus = new SalesByBus();
//					$salesByBus->run()->render();
					break;
				default:
					break;
			}
		}else{
			echo "<p>Select a report type</p>";
		}

?>
	</div>

	<div class="large-3 cell">
		<h4>Select Report Type</h4>
		<ul class="menu vertical">
			<li><a href="index.php?action=view&view=reports&report=journey">Sales By Journey</a></li>
			<li><a href="index.php?action=view&view=reports&report=route">Sales By Route</a></li>
			<li><a href="index.php?action=view&view=reports&report=dailysales">Daily Sales</a></li>
			<li><a href="index.php?action=view&view=reports&report=monthlysales">Monthly Sales</a></li>
			<li><a href="index.php?action=view&view=reports&report=customer">Sales By Customer</a></li>
			<li><a href="index.php?action=view&view=reports&report=customer">Route Frequency</a></li>

		</ul>
	</div>
</div>

