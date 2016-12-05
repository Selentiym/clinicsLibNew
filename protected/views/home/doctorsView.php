<?php $cs = Yii::app()->getClientScript(); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/objects_list.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/clinicsView.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/doctorsView.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/rateit.css?' . time()); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/map.js'); ?>
<?php $cs -> registerScriptFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU"); ?>
<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.rateit.min.js?' . time()); ?>
<?php $cs -> registerScript('Rate','Rate()',CClientScript::POS_READY); ?>
<?php $cs -> registerScript('Order','
	$("#sortby a").click(function(e){
		
		$("#sortByField").val($(this).attr("sort"));
		$("#searchForm").submit();
		return false;
	});
',CClientScript::POS_READY);
$cs -> registerScript('Insets','
	$("#personal_object_cont .menu  .item").click(function(){
		$("#personal_object_cont .menu  .item").each(function(){
			$("#"+$(this).attr("word")).css("display","none");
			$(this).removeClass("active");
		});
		$(this).addClass("active");
		$("#"+$(this).attr("word")).css("display","block");
	});
',CClientScript::POS_READY); 
$cs -> registerScript('show_hide','
	var cont;
	$(".show").click(function(){
		$(this).hide();
		$(this).parent().children(".full").show();
		$(this).parent().children(".short").hide();
		$(this).parent().children(".hide").show();
		var cont = $(this).parents(".single_review");
		cont.saveHeight = cont.css("max-height");
		cont.css("max-height","none");
		//$(this).parent().css("max-height","none");
		
	});
	$(".hide").click(function(){
		$(this).parent().children(".full").hide();
		$(this).parent().children(".short").show();
		$(this).hide();
		$(this).parent().children(".show").show();
	});
',CClientScript::POS_READY);

	$adress = $model -> address;
	//$adress = "Санкт-петербург, проспект металлистов, 25к1";
	//$key = "ключ апи яндекс карт";
	$found = array();
	if (trim($adress)) {
		$adress1=urlencode($adress);
		$url="http://geocode-maps.yandex.ru/1.x/?geocode=".$adress1;//."&key=".$key;
		//echo $url;
		$content=file_get_contents($url);
		//echo $content;
		preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
		preg_match('/<found>(.*?)<\/found>/',$content,$found);
	}
	if (trim(next($found)) > 0) {
		$coordinaty=explode(' ',trim(strip_tags($point[1])));
		
		$cs -> registerScript('mapAct','
			addCoords(['.$coordinaty[1].', '.$coordinaty[0].'],"'.$model -> name.', '.$adress.'");
		',CClientScript::POS_READY);
	} else {
		$cs -> registerScript('mapAct','
			$("#map").html("Не удалось найти местоположение заправшиваемого объекта. Пожалуйста, сообщите о данной ошибке в техподдержку сайта. Адрес: '.$adress.'.");
		',CClientScript::POS_READY);
	}

	//$this -> renderPartial('//home/searchForm', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage,'page' => $page));
?>
<div id="personal_background">
<div class="content_block" id="personal_object_cont">
	<div id="links">
		<a href="<?php echo Yii::app() -> baseUrl; ?>">Главная</a>
		<?php $val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
		<a href="<?php echo Yii::app() -> baseUrl .'/'. $modelName.'?clear=';?>"><?php echo $modelName == "clinics" ? 'Клиники' : 'Врачи' ; ?></a>
		
		
		<a href=""><?php echo $model -> name; ?></a>
	</div>
	<div class="main_part">
		<div class="left_side">
			
		</div>
		<div class="center">
			<div class="image_cont">
				<img src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo $model->name; ?>"/>
			</div>
			<h2 class="name object_name"><?php echo $model -> name; ?></h2>
			<div class="rateit" data-rateit-value="<?php echo $model->rating; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
			<div class="specialities">
				<?php
					$spec_arr = $model -> giveSpecialities();
					asort($spec_arr);
					echo CHtml::giveStringFromArray($spec_arr, ',');
				?>
			</div>
			<?php if ($data -> experience) : ?>
			<div class="experience">
				<?php echo get_class($data) == 'clinics' ? 'Существует ' : 'Стаж ' ;  echo $data -> experience; ?> лет
			</div>
			<?php endif; ?>
			<div class="object_text">
				<?php echo $model -> text; ?>
			</div>
			
			<div class="assign_cont objects_cont">
				<div class="assign"><a href=""><span>Записаться на прием</span></a></div>
				<?php $price = current($pricelist); ?>
				<?php if ($price) : ?>
				<div class="consult"><div class="price_img"></div><span>Консультация специалиста <?php echo $price -> price; ?></span></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="right_side">
			<div id="map"></div>
		</div>
		<div id="left_column">
			<div id="doc_spec">
				<div class="im"><span></span></div>
				<div class="content">
					<span class="heading">Специализация:</span>
					<?php foreach ($spec_arr as $spec) {
						echo "<br/> - ".$spec;
					} ?>
				</div>
			</div>
			<?php if (($model -> address) || ($model -> phone)) : ?>
			<div id="doc_info">
				<div class="im"><span></span></div>
				<div class="content">
					<span class="heading">Информация о враче:</span>
					<?php
						if ($model -> address) {
							echo "<br/>".$model -> address;
						}
						if ($model -> phone) {
							echo "<br/>"."Запись по телефону: ".$model -> phone;
						}
					?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($model -> education) : ?>
			<div id="doc_ed">
				<div class="im"><span></span></div>
				<div class="content">
					<span class="heading">Образование:</span>
					<?php
						echo $model -> education;
					?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($model -> curses) : ?>
			<div id="doc_qual">
				<div class="im"><span></span></div>
				<div class="content">
					<span class="heading">Курсы повышения квалификации:</span>
					<?php
						echo $model -> curses;
					?>
				</div>
			</div>
			<?php endif; ?>
			<?php if (count ($pricelist) > 0) : ?>
			<div id="doc_serv">
				<div class="im"><span></span></div>
				<div class="content">
					<span class="heading">Услуги:</span>
					<?php
						foreach($pricelist as $service) {
							echo "<br/> - ".$service -> name;
						}
					?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		
		<div id="right_column">
			<div id="reviews">
			<?php $this -> renderPartial('//home/_doctor_reviews', array('id'=>$model -> id,'reviews' => $model->comments)); ?>
			</div>
		</div>
	</div>
	

	

</div>
</div>
<?php if (!empty($similar)) : ?>
<div id="other_docs" class="content_block">
	<h3>Другие специалисты:</h3>
	<?php
		foreach($similar as $doc){
			echo "<div class='dop_doc'>";
			$this -> renderPartial('//home/_short_doctor',array('data' => $doc));
			echo "</div>";
		}
	?>
</div>
<?php endif; ?>