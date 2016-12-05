<div class="content_block" id="search_block">

<?php $cs = Yii::app()->getClientScript(); ?>
<?php $cs -> registerScript('SpecChoose','$(".speciality_shortcut").click(function(){
	var go = $(this).attr("spec_id");
	$("#search_speciality").val(go);
	$("#searchForm").submit();
})',CClientScript::POS_READY); ?>
<?php $cs -> registerScript('PageScript','$(".pageNum").click(function(){
	$("#page").val($(this).html());
	$("#searchForm").submit();
});
$("#list_left").click(function(){
	var obj = $("#page");
	obj.val(obj.val()*1 - 1);
	$("#searchForm").submit();
});
$("#list_right").click(function(){
	var obj = $("#page");
	obj.val(obj.val()*1 + 1);
	$("#searchForm").submit();
});
',CClientScript::POS_END);
?>
<form id="searchForm" method="post" action="<?php echo Yii::app() -> baseUrl.'/'.$modelName; ?>">
	<div class="row">
		<div class="buttons">
			
				<input name="modelName" id="modelNameCont" type="hidden" value='<?php echo $modelName; ?>'/>
				<input name="sortBy" id="sortByField" type="hidden" value='<?php echo $_POST["sortByField"]; ?>'/>
				<input name="page" id="page" type="hidden" value='<?php echo $page; ?>'/>
				<div modelName='doctors' class="mnchange doctors <?php echo ($modelName == 'doctors') ? 'active' : ''; ?>">Доктора</div>
				<div modelName='clinics' class="mnchange clinics <?php echo ($modelName == 'clinics') ? 'active' : ''; ?>">Клиники</div>
				<?php
					$cs = Yii::app()->getClientScript();
					$cs -> registerScript('modelName_change','
						$(".mnchange").click(function(){
							$(".mnchange").removeClass("active");
							$(this).addClass("active");
							var modelName = $(this).attr("modelName");
							$("#search_speciality").attr("name",modelName + "SearchForm[speciality]");
							$("#search_metro").attr("name",modelName + "SearchForm[metro]");
							$("#modelNameCont").val(modelName);
							$("#searchForm").attr("action","'.Yii::app() -> baseUrl.'/"+modelName);
							//alert($("#searchForm").attr("action"));
						});
						$(".adv_search a span").click(function(event){
							event.preventDefault();
							location.href="'.Yii::app() -> baseUrl.'/"+$("#modelNameCont").val()+"/";
						});
						$("#search_speciality").change(function(){
							$("#searchForm").submit();
						});
					',CClientScript::POS_END);
					$cs -> registerScript('reset','
						$("#reset").click(function(){
							location.href = $("#searchForm").attr("action")+"?clear=1";
						});
					',CClientScript::POS_END);
				?>
		</div>
		<div class="speciality_dropdown select">
			<div class="image"><span></span></div>
			<div class="select_cont">
				<?php $specialities = Filters::model() -> giveSpecialities(); ?>
				<?php $val = $_POST["clinicsSearchForm"]["speciality"] ? $_POST["clinicsSearchForm"]["speciality"] : $_POST["doctorsSearchForm"]["speciality"]; ?>
				<?php echo CHtml::DropDownListChosen2($modelName.'SearchForm[speciality]','search_speciality', $specialities,array('placeholder' => 'Выберите специализацию'),array($val)); ?>
				
			</div>
		</div>
		<div class="metro_dropdown select">
			<div class="image"><span></span></div>
			<div class="select_cont">
				<?php $metro_obj = Metro::model()->findAll(array('order' => 'name ASC')); ?>
				<?php $val = $_POST["clinicsSearchForm"]["metro"] ? $_POST["clinicsSearchForm"]["metro"] : $_POST["doctorsSearchForm"]["metro"]; ?>
				<?php echo CHtml::DropDownListChosen2($modelName.'SearchForm[metro]','search_metro', CHtml::listData($metro_obj, 'id', 'name'),array('placeholder' => 'Выберите метро'),array($val)); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<input type="button" value="Сбросить" id="reset" class="search_submit"/>
		<input type="submit" value="Найти" class="search_submit"/>
	</div>
	<div class="row adv_search">
		<a href="" class="advanced_search"><span>Расширенный поиск</span></a>
	</div>
		<div  id="extended_search">
		<div id="note">Расширенный поиск</div>
		<?php $this->widget('application.components.widgets.sitesearch.SiteSearch', array('filterForm' => $filterForm, 'modelName' => $modelName, 'fromPage' => $fromPage)); ?>
	</div>
</form>
</div>