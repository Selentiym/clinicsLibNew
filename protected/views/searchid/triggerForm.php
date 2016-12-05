<div>
	<h2>Генератор search_id</h2>
	Выберите триггеры из списка.<br/>
	<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/chosen.jquery.min.js'); ?>
	<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/css/chosen.min.css'); ?>
	<?php
	$triggers= CHtml::listData(TriggerValues::model()->findAll(), 'id', 'value');
	echo CHtml::activeDropDownList(TriggerValues::model(),'id',$triggers, array('name'=>$id.'_name_array[]','multiple' => 'multiple', 'id' => $id),array());
	echo CHtml::activeDropDownList(Objects::model(),'id',CHtml::listData(Objects::model()->findAll(), 'id', 'name'), array('name'=>$id.'_type', 'id' => $id.'_type'),array());
	//echo CHtml::DropDownList($model, 'object_type', CHtml::listData(Objects::model()->findAll(), 'id', 'name'));
	echo CHtml::htmlButton('Показать id', array('id' => $id.'_button'));
	?>
	Резальтат:<br/>
	<input type='text' id="<?php echo $id; ?>_rez"/>
	</div>
	<?php
		Yii::app()->clientScript->registerScript('generateName', "
			$(document).ready(function () {
				$('#".$id."_button').click(MakeSearchId);
			});
			var urlVar = 'http://'+document.location.hostname + '".Yii::app() -> baseUrl."';
			function MakeSearchId()
			{	
				$.ajax({
					url:urlVar + '/home/GenerateSId',
					dataType:'html',
					data:{data:$('#".$id."').val(),type:$('#".$id."_type').val()},
					success: function(rez){
						$('#".$id."_rez').val(urlVar+'/'+rez);
					}
				});
			}
		",CClientScript::POS_HEAD);
	?>
</div>