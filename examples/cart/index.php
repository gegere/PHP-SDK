<?php
include('Cart.php');

$Booking = new Booking();

// start a new booking session
if(isset($_GET['slip'])) {
	// slips contain all the details needed to book the item
	$Booking->set($_GET['slip']);
	// lets redirect so it doesn't continue to append to the booking
	header("Location: {$_SERVER['SCRIPT_NAME']}");
	exit;
}

// CLEAR CART
if(isset($_GET['reset'])) {
	$Booking->clear();
	header("Location: {$_SERVER['SCRIPT_NAME']}");
	exit;
}

header('Content-type: text/html; charset=utf-8');

$date = (isset($_GET['date'])) ? date('Y-m-d',strtotime($_GET['date'])) : date('Y-m-d');
?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style type="text/css">
html { margin-bottom: 200px; }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
<div class="row">
<div class="col">
<h1>Reservations Booking Demo</h1>
<p>This is a bare bones example of how to query inventory items from the Checkfront API, add them to a booking session, and create a new booking. This is a shopping cart style demo that allows you to add and remove multiple items to a booking before proceeding.</p>
</div>
</div>
<div class="row">
<!-- it may be preferred to set this in your local session -->
<div class="col">
<p>&nbsp;</p>
<form method="get" action="" accept-charset="utf-8">
Date: <input type="date" name="date" value="<?php echo $date?>" /> <input type="submit" class="btn btn-link" value="Search" />
<ul style="list-style: none; padding:0">
<?php

$items = $Booking->query_inventory(
	array(
		'start_date'=>$date,
		'end_date'=>$date,
		// change these booking parameters to suit your setup:
		'param'=>array( 'guests' => 1 )
	)
);

if (!empty($items)) {
	$c = 0;
	foreach($items as $item_id => $item) {
		if (empty($item['rate']['slip'])) continue;
		echo '<li style="padding: 1em; border-bottom: solid 1px #ccc;">';
		echo "<input type='checkbox' name='slip[]' value='{$item['rate']['slip']}' id='item_{$item_id}' /><strong> {$item['name']}</strong><br />";
		echo " -  {$item['rate']['available']} available for {$item['rate']['summary']['date']}<br />";
		//	echo '<p>' . nl2br($item['summary']) . '</p>';
		echo "&nbsp; <small style='color: #999;'>SLIP: {$item['rate']['slip']}</small><br />";
		echo '</li>';
		// Let's only show 5 for the sake of the demo;
		if($c++ == 20) break;
	}
}
?>
</ul>
<div class="text-center">
<input type="submit" class="btn btn-success" value="Add To Booking">
</div>
</form>
</div>
<div class="col-6">
<form method="get" action="create.php">
<h3>Shopping Cart <?php echo intval(count($Booking->cart))?></h3>
<ul style="padding: 0; list-style: none;">
<?php
if(count($Booking->cart)) {
	foreach($Booking->cart as $line_id => $item) {
		echo "<li style='padding: 5px'><strong>{$item['name']}</strong> ({$item['rate']['qty']})<br />";
		echo $item['rate']['total'];
		if($item['date']['summary']) {
			echo '<br /><span style="font-size: .9em; color: #444">' . $item['date']['summary'] . '</span>';
		}
		echo "</li>";
	}
	echo "<li><span style='font-family:monospace;font-size: .9em; color: #333'>Sub-total: {$_SESSION['sub_total']}<br/>";
	echo "Tax: {$_SESSION['tax_total']}<br/>";
	echo "Total: {$_SESSION['total']}</span></li>";
	echo '<li><input type="submit" name="create" value=" Book Now " /></li>';
	echo '<li><input type="button" name="cancel" value=" Clear All " onClick="window.location=\'' . $_SERVER['SCRIPT_NAME'] . '?reset=1\';" /></li>';

} else {
	echo '<p>EMPTY</p>';
}
?>
</ul>

<a href="<?php echo $_SERVER['SCRIPT_NAME']?>?reset=1">Clear session</a>
</form>
<pre style="margin-left: 10px">
<strong>Debug Information</strong>
Cart ID: <input type="text" readonly="readonly" name="cart_id" value="<?php echo session_id()?>" /><br />
<pre><?php if (!empty($Booking->Checkfront->error)) print_r($Booking->Checkfront->error)?></pre>
</div>
</div>
</div>
</body>
</html>
