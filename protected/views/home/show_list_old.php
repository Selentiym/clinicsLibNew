<?php $cs = Yii::app()->getClientScript(); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/objects_list.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/rateit.css?' . time()); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.rateit.min.js?' . time()); ?>
<?php $cs -> registerScript('Rate','Rate()',CClientScript::POS_READY); ?>
<?php $cs -> registerScript('Order','
	$("#sortby a").click(function(e){
		
		$("#sortByField").val($(this).attr("sort"));
		$("#searchForm").submit();
		return false;
	});
',CClientScript::POS_READY); ?>

<?php
	$this -> renderPartial('//home/searchForm', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage,'page' => $page));
?>
<div id="objects_list">
	<div id="column1" class="content_column">
		<div id="links" class="content_block">
			<a href="<?php echo Yii::app() -> baseUrl.'/'; ?>">Главная</a>
			<?php $val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
			<?php if (false) : ?>
			<a href="<?php echo Yii::app() -> baseUrl .'/'. $modelName.'?clear=1';?>"><?php echo $modelName == "clinics" ? 'Клиники' : 'Врачи' ; ?></a>
			<? endif; ?>
			<a href="<?php echo Yii::app() -> baseUrl .'/'. $modelName;?>"><?php echo $modelName == "clinics" ? 'Клиники' : 'Врачи' ; ?></a>
			
			
			<?php if ($val) : ?>
			<a href="">
			<?php
				$all_spec = clinics::model() -> giveAllSpecialities();
				echo $all_spec[$val];
			?></a>
			<?php endif; ?>
		</div>
		<div id="search_menu">
			<div id="search_info">
				Найдено <span><?php echo $total; ?></span> <?php echo $modelName=='clinics' ? 'клиник' : 'врачей'; ?>
			</div>
			<div id="sortby">
				Сортиовать по: <a href="" sort = "rating">Рейтинг</a><a href="" sort="experience">Опыт</a><? if ($modelName=='doctors') ?><a href="" sort = "price">Цена</a><?// endif; ?>
			</div>
		</div>
		<div id="the_list">
			<?php
				if ($objects) {
					foreach($objects as $object) {
						$this -> renderPartial('//home/_single_'.$modelName, array('data' => $object));
					}
				}
			?>
		</div>
		<div id="pager" class="content_block">
			<?php
				$start = max(1,$page - 2);
				$stop = min($page + 2, $maxPage);
				if ($start != $page) {
					echo "<div id='list_left'></div>";
				}
				for ($i = $start; $i <= $stop; $i++){
					$active = $page == $i ? 'active' : '' ;
					echo "<div class='pageNum ".$active."'>".$i."</div>";
				}
				if (($stop != $page)&&($stop > 0)) {
					echo "<div id='list_right'></div>";
				}
			?>
		</div>
		<?php
			if ($description) :
				$description = CHtml::tag('div', array('class' => 'description'), $description -> text);
			?>
			<div id="search_description" class="content_block">
				<?php echo $description; ?>
			</div>
			<?php endif; ?>

	</div>
	<div id="column2" class="content_column">
		<h2 id="all_spec">Все специальности</h2>
		<div id="spec_list">
		<?php $val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
		<?php
			function GiveFirstLetter($arg){
				return mb_substr($arg,0,1,'utf-8');
			}
			$firstLetter = '';//GiveFirstLetter(current($specialities));
			//echo "<div class='letter'>".$firstLetter."</div>";
			if (!empty($specialities)){
				asort($specialities);
				foreach($specialities as $id => $sp) {
					if ($firstLetter != GiveFirstLetter($sp)) {
						$firstLetter = GiveFirstLetter($sp);
						echo "<div class='letter'>".$firstLetter."</div>";
					}
					$this -> renderPartial('//home/_speciality_shortcut',array('id' => $id,'spec' => $sp, 'active' => $id == $val ? 'active' : ''));
				}
			}
		?>
		</div>
	</div>
</div>