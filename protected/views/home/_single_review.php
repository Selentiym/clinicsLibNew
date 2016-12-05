<div class="single_review">
	<div class="name"><?php echo $review -> user_first_name; ?></div>
	<?php
		$len = 30;
		if (strlen($review -> text) > $len) {
			$toDisp = "<div class='short'>".CHtml::cutText($review -> text, $len)."</div>";
			$toDisp .= '<br/><div class="show"></div>';
			$toDisp .= "<div class='full' style='display:none'>".$review -> text."</div>";
			$toDisp .= '<br/><div class="hide" style="display:none"></div>';
		} else {
			$toDisp = "<div class='full'>".$review -> text."</div>";
		}
	?>
	<div class="text"><?php echo $toDisp; ?></div>
</div>