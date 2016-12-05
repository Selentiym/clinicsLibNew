<?php
		function renderArrow($value, $arg)
		{
			echo CHtml::tag('span',array('style' => 'display:block;width:40px;height:20px;text-align:center;background:#49afcd;cursor:pointer;border-radius:5px;','onClick' => 'TakePage('.$arg.')'),$value);
		}
		if (is_a($clinic, 'clinics'))
		{
			echo CHtml::openTag('table', array('class' => 'clinic_card', 'id' => 'clinic_card_table'));
			echo CHtml::openTag('tbody');
			echo CHtml::openTag('tr');
			echo CHtml::openTag('td', array('class' => 'leftNav'));
			if ($left) {
				renderArrow('<--', $page - 1);
			}
			echo CHtml::closeTag('td');
			echo CHtml::openTag('td', array('class' => 'clinic_info'));
			$this -> renderPartial('//home/_single_clinics', array('data' => $clinic));
			echo CHtml::closeTag('td');
			echo CHtml::openTag('td', array('class' => 'rightNav'));
			if ($right) {
				renderArrow('-->', $page + 1);
			}
			echo CHtml::closeTag('td');
			echo CHtml::closeTag('tr');
			echo CHtml::closeTag('tbody');
			echo CHtml::closeTag('table');
		}
?>