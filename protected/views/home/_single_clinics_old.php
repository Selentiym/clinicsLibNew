<div class="single_object">
	<div class="left_side">
		<div class="object_image_cont">
			<img src="<?php echo $data -> giveImageFolderRelativeUrl() . $data -> logo;?>" alt="<?php echo $data->name; ?>"/>
		</div>
		<div class="reviews">
			<?php echo CHtml::link('Отзывы', Yii::app()->baseUrl.'/clinics/reviews/'.$data->verbiage); ?>
		</div>
	</div>
	<div class="right_side">
		<h2 class="name"><span><?php echo $data -> name; ?></span></h2>
		<div class="rateit" data-rateit-value="<?php echo $data->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
		<div class="specialities">
			<?php
				$spec_arr = $data -> giveSpecialities();
				asort($spec_arr);
				echo CHtml::giveStringFromArray($spec_arr, ',');
			?>
		</div>
		<?php if ($data -> experience) : ?>
		<div class="experience">
			<?php echo get_class($data) == 'clinics' ? 'Существует ' : 'Стаж ' ;  echo $data -> experience; ?> лет
		</div>
		<?php endif; ?>
		<div class="description">
			<?php echo $data -> text; ?>
		</div>
	</div>
	<div class="bottom">
		<div class="assign"><a href=""><span>Записаться на прием</span></a></div>
		<div class="more_info"><a href="<?php echo Yii::app() -> baseUrl . '/clinics/' . $data -> verbiage; ?>"><span>Подробнее..</span></a></div>
	</div>
</div>