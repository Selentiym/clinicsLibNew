<?php $this -> controller -> renderPartial('//siteSearch/frameSelect',array('select_code' => CHtml::dropDownList($modelName.'SearchForm[district]', (isset($fromPage['district'])? $fromPage['district']: ''), $district, array('empty' => CHtml::encode('Район'), 'class' => 'extended_select')))); ?>
<?php
	if ($filterForm) {
		//echo "<textarea>filter</textarea>";
		foreach($filterForm as $key => $fields):
			$items = array();
			$items[null] = key($fields);
			$fieldArray = array_values($fields);
			foreach ($fieldArray[0] as $f) :
				$items[$f->id] = $f->value;       
			
			endforeach;
			$this -> controller -> renderPartial('//siteSearch/frameSelect',array('select_code' => CHtml::dropDownList($modelName.'SearchForm[' . $key .']',  (isset($fromPage[$key])? $fromPage[$key]: ''), $items, array('class' => 'extended_select'))));
			//echo CHtml::dropDownList($modelName.'SearchForm[' . $key .']',  (isset($fromPage[$key])? $fromPage[$key]: ''), $items, array('class' => 'extended_select'));
		endforeach;
	}
?>