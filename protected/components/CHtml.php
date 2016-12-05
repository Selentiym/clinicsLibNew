<?php
	class CHtml extends Html {
		public static function activeDropDownList($model,$attribute,$data,$htmlOptions=array(),$selected_ids=array(),$chosenOptions='') {
			$selected = array();
			$selected_ids = array_filter($selected_ids);
			if (count($selected_ids) > 0) {
				foreach($selected_ids as $id){
					$selected[$id] = array('selected' => 'selected');
				}
			}
			$extra_htmlOptions = array('options' => $selected);
			if (($htmlOptions['multiple'] != 'multiple')&&(count($selected) > 1)){
				$htmlOptions['multiple'] = 'multiple';
			}
			parent::resolveNameID($model,$attribute,$htmlOptions);
			$htmlOptions = array_merge_recursive($htmlOptions, $extra_htmlOptions);
			echo parent::activeDropDownList($model,$attribute,$data,$htmlOptions);
			Yii::app()->clientScript->registerScript('chosen_'.$htmlOptions['id'], "
				$('#".$htmlOptions['id']."').chosen(".$chosenOptions.");
			",CClientScript::POS_READY);
		}
		public static function link($text, $url='#',$htmlOptions=array ( )) {
			$htmlOptions ['rel'] = 'nofollow';
			return parent::link($text, $url, $htmlOptions);
		}
		public static function activeDropDownListChosen2($model,$attribute,$data,$htmlOptions=array(),$selected_ids=array(),$select2Options='') {
			$selected = array();
			$selected_ids = array_filter($selected_ids);
			if (is_array($data)) {
				asort($data);
			}
			if (count($selected_ids) > 0) {
				foreach($selected_ids as $id){
					$selected[$id] = array('selected' => 'selected');
				}
			}
			$extra_htmlOptions = array('options' => $selected);
			if (($htmlOptions['multiple'] != 'multiple')&&(count($selected) > 1)){
				$htmlOptions['multiple'] = 'multiple';
			}
			parent::resolveNameID($model,$attribute,$htmlOptions);
			if ($htmlOptions['empty_line']) {
				//print_r($data);
				//array_unshift($data, '');
				$data[''] = '' ;
				unset($htmlOptions['empty_line']);
			}
			$htmlOptions = array_merge_recursive($htmlOptions, $extra_htmlOptions);
			echo parent::activeDropDownList($model,$attribute,$data,$htmlOptions);
			Yii::app()->clientScript->registerScript('select2_'.$htmlOptions['id'], "
				$('#".$htmlOptions['id']."').select2(".$select2Options.");
			",CClientScript::POS_END);
		}
		public static function DropDownListChosen2($name,$id,$data,$htmlOptions=array(),$selected_ids=array(),$select2Options='not select') {
			$htmlOptions['id'] = $id;
			$selected = array();
			//$selected_ids = array();
			$selected_ids = array_filter($selected_ids);
			if (is_array($data)) {
				asort($data);
			}
			if ($htmlOptions['placeholder']) {
				$data[0] = $htmlOptions['placeholder'];
				if (count($selected_ids) < 1) {
					$selected_ids = array(0);
				}
				unset($htmlOptions['placeholder']);
			}
			if (count($selected_ids) > 0) {
				foreach($selected_ids as $id){
					$selected[$id] = array('selected' => 'selected');
				}
			}
			$extra_htmlOptions = array('options' => $selected);
			if (($htmlOptions['multiple'] != 'multiple')&&(count($selected) > 1)){
				$htmlOptions['multiple'] = 'multiple';
			}
			if ($htmlOptions['empty_line']) {
				//print_r($data);
				//array_unshift($data, '');
				$data[''] = '' ;
				unset($htmlOptions['empty_line']);
			}
			$htmlOptions['name'] = $name;
			
			$htmlOptions = array_merge_recursive($htmlOptions, $extra_htmlOptions);
			echo parent::DropDownList($name,'',$data,$htmlOptions);
			if ($select2Options !== 'not select') {
				Yii::app()->clientScript->registerScript('select2_'.$htmlOptions['id'], "
					$('#".$htmlOptions['id']."').select2(".$select2Options.");
				",CClientScript::POS_READY);
			}
		}
		public static function giveAttributeArray($models, $attribute){
			$rez = array();
			if (is_array($models)&&(!empty($models))) {
				foreach($models as $model) {
					$rez [] = $model -> $attribute;
				}
			}
			return array_filter($rez);
		}
		/**
		 * Returnes the string that consists of $props or just elements delimited by $del.
		 * @arg string del - the delimeter
		 * @arg array array - the array of objects or elements
		 * @arg string prop - the name of the property of an object to be concated
		 * @return string - look higher
		 */
		public static function giveStringFromArray($array = array(),$del = ',', $prop = false){
			$rez = '';
			//echo $prop.' - prop<br/>';
			if ((is_array($array))&&(!empty($array))) {
				if ($prop) {
					foreach($array as $element) {
						$rez .= $element -> $prop . $del . ' ';
					}
				} else {
					foreach($array as $element) {
						$rez .= $element . $del . ' ';
					}
				}
				$rez = substr($rez, 0, strrpos($rez, $del));
			}
			return $rez;
		}
		/**
		 * Returnes the string that consists of $props delimited by $del.
		 * @arg string del - the delimeter
		 * @arg string idString - the string to be executed
		 * @arg string modelClass - the class of the model that is to be searched by
		 * @arg string prop - the name of the property of an object to be concated
		 * @return string - look higher
		 */
		public static function giveStringFromIdString($modelClass, $idString = '', $prop = 'id', $del = ','){
			$criteria = new CDbCriteria;
			$criteria -> addInCondition('id',array_filter(explode(';',$idString)));
			$models = $modelClass::model() -> findAll($criteria);
			return CHtml::giveStringFromArray($models, $del, $prop);
		}
		/**
		 * $input_text - исходная строка
		 * $limit = 50 - количество слов по умолчанию
		 * $end_str - символ/строка завершения. Вставляется в конце обрезанной строки
		 */
		public static function cutText($input_text, $limit = 50, $end_str = '') {
			$input_text = strip_tags($input_text);
			$words = explode(' ', $input_text); // создаём из строки массив слов
			if ($limit < 1 || sizeof($words) <= $limit) { // если лимит указан не верно или количество слов меньше лимита, то возвращаем исходную строку
				return $input_text;
			}
			$words = array_slice($words, 0, $limit); // укорачиваем массив до нужной длины
			$out = implode(' ', $words);
			return $out.$end_str; //возвращаем строку + символ/строка завершения
		}
		public static function giveFirstP($text){
			
			$patern="#<[\s]*p[\s]*>([^<]*)<[\s]*/p[\s]*>#i";
			echo $text;
			if(preg_match($patern, $text, $matches)) {
				return $matches[1];
			}
			print_r($matches);
		}
		public static function ajaxShowButton($url, $text, $param, $show = ''){
			Yii::app() -> getClientScript() -> registerScript('ajaxShow','
				showInfoAjaxButton(".ajaxShow");
			');
			echo '<span class="ajaxShow" data-url="'.$url.'" data-param="'.$param.'" data-show="'.$show.'">'.$text.'</span>';
		}
	}
?>