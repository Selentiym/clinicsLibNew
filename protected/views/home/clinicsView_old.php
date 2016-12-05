<?php $cs = Yii::app()->getClientScript(); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/objects_list.css'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/clinicsView.css'); ?>
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
',CClientScript::POS_READY); ?>
<?php $cs -> registerScript('Insets','
	$("#personal_object_cont .menu  .item").click(function(){
		$("#personal_object_cont .menu  .item").each(function(){
			$("#"+$(this).attr("word")).css("display","none");
			$(this).removeClass("active");
		});
		$(this).addClass("active");
		$("#"+$(this).attr("word")).css("display","block");
	});
',CClientScript::POS_READY); ?>
<?php $cs -> registerScript('show_hide','
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
',CClientScript::POS_READY); ?>
<?php
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
	} else {
		echo "asd";
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
?>
<?php
	//$this -> renderPartial('//home/searchForm', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage,'page' => $page));
?>
<div class="content_block" id="personal_object_cont">
	<div id="links">
		<a href="<?php echo Yii::app() -> baseUrl; ?>">Главная</a>
		<?php $val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
		<a href="<?php echo Yii::app() -> baseUrl .'/'. $modelName.'?clear=';?>"><?php echo $modelName == "clinics" ? 'Клиники' : 'Врачи' ; ?></a>
		
		
		<a href=""><?php echo $model -> name; ?></a>
	</div>
	<div class="main_part">
		<div class="left_side">
			<div class="image_cont">
				<img src="<?php echo $model -> giveImageFolderRelativeUrl() . $model -> logo;?>" alt="<?php echo $model->name; ?>"/>
			</div>
		</div>
		<div class="center">
			<h2 class="name object_name"><?php echo $model -> name; ?></h2>
			<div class="object_text">
				<?php echo $model -> text; ?>
			</div>
			<div class="small_info">
				<div class="time">
					<div class="time_img"></div>
					<div class="text"><?php echo $model -> working_hours; ?></div>
				</div>
				<div class="address">
					<div class="address_img"></div>
					<div class="text"><?php echo $model -> address; ?></div>
				</div>
			</div>
			<div class="assign_cont objects_cont">
				<div class="assign"><a href=""><span>Записаться на прием</span></a></div>
				<div class="number"><div class="tel_img"></div><div class="tel_number">Запись по телефону: +0000000000</div></div>
			</div>
		</div>
		<div class="right_side">
			<div id="map"></div>
		</div>
	</div>
	<div class="menu">
		<div word="doctors_list" class="item <?php echo ($word == 'main') ? 'active' : '' ; ?>">Доктора <span class="amount">(<?php echo count($model -> doctors); ?>)</span></div>
		<div word="info" class="item <?php echo ($word == 'info') ? 'active' : '' ; ?>">О клинике</div>
		<div word="prices" class="item <?php echo ($word == 'prices') ? 'active' : '' ; ?>">Цены</div>
		<div word="reviews" class="item <?php echo ($word == 'reviews') ? 'active' : '' ; ?>">Отзывы <span class="amount">(<?php echo count($model->comments); ?>)</span></div>
	</div>
</div>
<div class="content_block_no_padding">
	<div id="doctors_list" style="display:<?php echo $word == 'main' ? 'block' : 'none' ;?>">
		<?php foreach($model -> doctors as $doctor) {
			$this -> renderPartial('//home/_single_doctors', array('data' => $doctor));
		} ?>
	</div>
	<div id="info" style="display:<?php echo $word == 'info' ? 'block' : 'none' ;?>">
		<?php $this -> renderPartial('//home/_clinicInfo', array('clinic' => $model)); ?>
	</div>
	<div id="prices" style="display:<?php echo $word == 'prices' ? 'block' : 'none' ;?>">
		<?php $this -> renderPartial('//home/_priceList', array('prices' => $pricelist)); ?>
	</div>
	<div id="reviews" style="display:<?php echo $word == 'reviews' ? 'block' : 'none' ;?>">
		<?php $this -> renderPartial('//home/_clinic_reviews', array('id'=>$model -> id,'reviews' => $model->comments)); ?>
	</div>
</div>