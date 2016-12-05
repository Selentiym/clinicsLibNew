<h2 id="price_heading">Цены клиники</h2>
<div id="price_cont">
<?php
	$obj = new clinics;
	$prices = $obj -> preparePrices($prices);
	foreach($prices as $name => $price) {
		echo "<div class='single_price'>";
		echo "<span class='price_name'>".$name."</span>";
		echo "<span class='price_value'>".$price." руб.</span>";
		echo "</div>";
	}
?>
</div>
<div id="small_clinic_info">
	some text
</div>