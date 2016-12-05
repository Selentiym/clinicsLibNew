<div class="fed_center h-card">
	<div class="logo_center">
		<?php
			$filename = $model -> giveImageFolderRelativeUrl() . $model -> logo;
			//if (!file_exists($filename)) {
			if (!$model -> logo) {
				//echo $filename;
				$filename = Yii::app() -> baseUrl . '/images/noImage.jpg';
			}
		?>
		<img style="width:90%" src="<?php echo $filename; ?>" alt="<?php echo $model->name; ?>" class="u-logo"/>
		<?php if ($tr2 = $model -> checkTrigger(2)): ?><h3><?php echo $tr2; ?></h3><?php endif; ?>
		<?php if ($prMrt = $model -> giveMinMrtPrice()) : ?><p>МРТ от <?php echo $prMrt -> price; ?>р</p> <? endif; ?>
		<?php if ($prKt = $model -> giveMinKtPrice()) : ?><p>КТ от <?php echo $prKt -> price; ?>р</p> <? endif; ?>
	</div>
	<div class="text_center">
		<h2><a href="<?php echo Yii::app() -> baseUrl.'/clinics/'. $model -> verbiage; ?>" class="p-name u-url"><?php echo $model -> name; ?></a>
		</h2>
		<ul>
			<?php
				$column_class = array('button_left', 'button_right');
				$column = -1;
				$no_disp = array(2, 13);
				foreach ($model -> giveTriggerValuesObjects($model -> triggers) as $tr) {
					if (!in_array($tr -> trigger -> id,$no_disp)){
						$column = ($column + 1) % 2;
						echo "<li><button class=".$column_class[$column].">".$tr -> value."</button></li>";
					}
				}
			?>
		</ul>

		<p><?php echo $model -> working_hours; ?></p>
		<p class="p-adr"><?php echo $model -> address; ?></p>
		<a class="zapis_na_priem" href="#">Записаться на прием</a>
		<p class="p-tel"><?php echo 'Телефоны для записи:'.$model -> phone; ?></p>
	</div>
</div>
<div class="clear"></div>