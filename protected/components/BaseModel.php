<?php
class BaseModel extends CTModel
{
	/**
	 * @param integer PAGE_SIZE - number of objects on a single page
	 */
	const PAGE_SIZE = 18;
	/**
	 * @var array SFields specific fields. Those will not be taken into account in the default search function.
	 */
	public $SFields = array('district','metro','research','submitted','price');//,'speciality');
	/**
	 * @var integer type. Stores id of the object's type.
	 */
	public $type = 1;
	
	/** лишняя функция.
	 * @arg array search a search array that specifies what is being searched
	 * @arg array objects an array of object which are to be filtered according to search options
	 * @return an array of model object that fit the search options 
	 * (unlike search function this one is overriden in every doughter class and contains options that are specific)
	 */
	public function init()
	{
		parent::init();
		$num = Objects::model() -> getNumber(get_class($this));
		if ($num) {
			$this -> type = $num;
		}
	}
	/**
	 * @arg array search a search array that specifies which filterform will be displayed
	 * @return filter form that is to be displayed on the searchpage. It is the interface to search. 
	 * The form is different for different specialities.
	 */
	public function giveFilterForm($search)
	{
		$speciality = $search['speciality'];
		//Если специальность выбрана, то делаем форму с фильтрами.
		if ($speciality) {
			//считываем данные по специальности
			$criteria = new CDbCriteria;
			//$criteria -> with = array('speciality'=>array('condition' => 'id = :id', 'params' => array(':id' => $speciality)));
			$criteria -> compare('object_type', Objects::model() -> getNumber(get_class($this)));
			$criteria -> compare('speciality_id', $speciality);
			$filter = Filters::model() -> find($criteria);
			//определяем какие поля должны быть (айди триггеров)
			$filterFields = array_map('trim', explode(';', $filter->fields));
			//получаем объекты триггеров вместе со значениями. Связь trigger_values связывает триггеры со значениями has_many
			$triggers_obj = Triggers::model()->with('trigger_values')->findAll();
			$triggers = array();
			//задаем массив для создания формы.
			foreach ($triggers_obj as $trigger) {
				if (in_array($trigger->id, $filterFields))
					$triggers[$trigger->verbiage][$trigger->name] = $trigger->trigger_values;
			}
			//print_r($triggers);
			if(Yii::app()->request->isAjaxRequest)
				$filterForm = CJSON::encode($triggers); //$metros_array = array_map('trim', explode(';', $clinic->metro_station));
			else
				$filterForm = $triggers;  
		} else {
		   $filterForm = null;
		}
       return $filterForm; 
	}
	
	/**
	 * @arg array search a search array that specifies what is being searched
	 * @arg string order - a field to be ordered by
	 * @arg integer limit - a limit of objects to be found
	 * @param CDbCriteria $initialCrit
	 * @return an array of model object that fit the search options
	 */
	public function userSearch($search,$order='rating',$limit=-1, CDbCriteria $initialCrit = null)
	{
		//$objects = $this -> model() -> findAll('rating DESC');
		//Если поле сортировки не задано, сортируем по рейтингу
		if (!$order) {
			$order='rating';
		}
		if (is_a($initialCrit, 'CDbCriteria')) {
			$criteria = $initialCrit;
		} else {
			$criteria = new CDbCriteria();
		}
		$criteria -> addCondition("`ignore_clinic`=0");
		//По цене будет отдельная сортировка
		if (!in_array($order, array('priceUp','priceDown'))) {
			$criteria -> order = $order.' DESC';
		}
		$objects = $this -> model() -> findAll($criteria);
		$objects_filtered = array();
		//print_r($search);
		$search = array_filter($search);
		//var_dump($search);
		$filter = array();
		foreach ($search as $key => $option) {
			//если поле не относится к особым, тогда сохраняем условие на него.
			if (!in_array($key, $this -> SFields))
			{
				if (trim($option) != "") {
					$filter[] = $option;
				}
			}
		}
		$count = count($filter);
		$count_success = 0;
		foreach ($objects as $object) {
			if ($object == $this) {
				continue;
			}
			$triggers_array = array_map('trim', explode(';', $object->triggers));
			$triggers_array[] = '';
			//$object -> triggers = $triggers_array;
			//$this -> triggers_array = $triggers_array;
			
			if (!($object -> SFilter($search)))
			{
				continue;
			}
			
			/*if (empty($filter)) {
				$objects_filtered[] = $object;
				continue;
			} */
			//echo $object -> name.' ';print_r($triggers_array);
			/* common filters */
			if (!empty($filter)) {
				//echo $object -> verbiage.'<br/>';
				//var_dump($filter);
				//var_dump($triggers_array);
				//break;
				$common = array_intersect($filter, $triggers_array);
				if (count($common) != $count)
					continue;                           
			}
			/* speciality */
			//если специальность не входит в список триггеров, то пропускаем этот объект.
			/*if ((!in_array($spec_id, $triggers_array))&&($spec_id != -1)){
				echo $spec_id;
				continue;
			}*/
			//echo "<br/>spec_search";
			/*if (!empty($triggers_array)) {
				foreach ($triggers_array as $trigger)
					$triggers .= $trigger->trigger->name . ':&nbsp;&nbsp; ' .  $trigger->value . '<br/> ';
			}*/
			
			$object -> getReadyToDisplay();
			$count_success ++;
			$objects_filtered[] = $object;
			if ($count_success == $limit) {
				break;
			}
		}
		$rez['objects'] = $objects_filtered;
		if (($order == 'priceUp')||($order=='priceDown')) {
			$toEnd = [];
			$toSort = [];
			foreach ($objects_filtered as $obj) {
				if (!$obj->giveMinMrtPrice()) {
					$toEnd[] = $obj;
				} else {
					$toSort[] = $obj;
				}
			}
			if ($order == 'priceDown') {
				usort($toSort, function ($o1, $o2) {
					$pr1 = $o1->giveMinMrtPrice()->price;
					$pr2 = $o2->giveMinMrtPrice()->price;
					return ($pr2 - $pr1);
				});
			}
			if ($order == 'priceUp') {
				usort($toSort, function ($o1, $o2) {
					$pr1 = $o1->giveMinMrtPrice()->price;
					$pr2 = $o2->giveMinMrtPrice()->price;
					return ($pr1 - $pr2);
				});
			}
			//За одно возвращаем модель описания к заданному поиску.
			$rez['objects'] = array_merge($toSort, $toEnd);
		}
		$rez['description'] = Description::model() -> giveModelByTriggerArray($filter, get_class($this));
		return $rez;
	}
	
	/** лишняя функция.
	 * @arg array search a search array that specifies what is being searched
	 * @arg array objects an array of object which are to be filtered according to search options
	 * @return array - an array of model object that fit the search options
	 * (unlike search function this one is overriden in every doughter class and contains options that are specific)
	 */
	/*public function customSearch($search, $objects)
	{
		//Чтобы не было проблем при ненаследовнии.
		return $objects;
	}*/
	/**
	 * @arg array search a search array that specifies what is being searched
	 * @return boolean true if this object satisfies searching criteria and false if not
	 * (unlike search function this one is overriden in every descendant and contains options that are specific)
	 */
	public function SFilter($search)
	{
		//фильтруем по станциям метро и районам. В родителе, потому что у всех есть эти поля.
		$ok = true;
		/*if ($search['metro'] != 0) {
			$ok &= (!($search['metro']))||((in_array($search['metro'], array_map('trim', explode(';', $this->metro_station)))));
		}*/
		if (!empty($search['metro'])) {
			//Если хотя бы одна станция выбрана, то пробегаем по всем выбранным и смотрим, есть ли хоть какая-нибудь.
			$check = false;
			$metroArr = array_filter(array_map('trim', explode(';', $this->metro_station)));
			//print_r($metroArr);
			//print_r($search['metro']);
			foreach($search['metro'] as $id) {
				if (in_array($id, $metroArr)) {
					//Если есть, то замечательно.
					$check = true;
					break;
				}
			}
			$ok &= $check;
		}
		$triggers_array = array_map('trim', explode(';', $this->triggers));
		if ($search['research']) {
			$search['research'] = array_filter($search['research']);
			if (!empty($search['research'])) {
				$check = (count(array_intersect($search['research'],$triggers_array)) == count($search['research']));
				$ok &= $check;
			}
		}
		if ($search['district'] != 0) {
			$ok &= (!($search['district']))||((in_array($search['district'], array_map('trim', explode(';', $this->district)))));
		}
		return $ok;
	}
	/**
	 * Transforms parameters like districts from a string to an array 
	 * in order to display them in the corresponding view.
	 * Currently it is in base model, but should be different in all of them.
	 */
	public function getReadyToDisplay()
	{
		/* metro stations */
		$metros_array = array_map('trim', explode(';', $this->metro_station));
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $metros_array);
		$metros_array = Metro::model()->findAll($criteria);

		if (!empty($metros_array)) {
			foreach ($metros_array as $metro)
				$metros .= $metro->name . ', ';
		}
		$metros = substr($metros, 0, strrpos($metros, ','));
		$this->metros_display = $metros;

		/* districts */
		$districts_array = array_map('trim', explode(';', $this->district));
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $districts_array);
		$districts_array = Districts::model()->findAll($criteria);

		if (!empty($districts_array)) {
			foreach ($districts_array as $district)
				$districts .= $district->name . ', ';
		}
		$districts = substr($districts, 0, strrpos($districts, ','));
		$this->districts_display = $districts;
		/* triggers */
		$criteria = new CDbCriteria();
		$criteria->addInCondition("t.id", array_map('trim', explode(';', $this->triggers)));
		$criteria->with = array('trigger');
		$criteria->limit = 5;
		$criteria->together = true;

		$this -> triggers_display = TriggerValues::model()->findAll($criteria);
		//print_r($this -> triggers_display);
		//echo "<br/>";
		return;
	}
	/**
	 * Tansforms data into correct encoding and writes it to a file.
	 */
	public function my_fputcsv($file, $array, $separator) {
		foreach ($array as $key => $string) {
			$array[$key] = mb_convert_encoding($string, $this -> exportFileEncoding, $this -> codeFileEncoding);
		}
		fputcsv($file, $array, $separator);
	}
	public function my_fgetcsv($file, $number, $separator) {
		$array = fgetcsv($file, $number, $separator);
		if (is_array($array))
		{
			foreach ($array as $key => $string) {
				$array[$key] = mb_convert_encoding($string, $this -> codeFileEncoding, $this -> exportFileEncoding);
			}
			return $array;
		} else {
			return false;
		}
	}
	/**
	 * @arg array fields - default fields (default - present in the database) that are to be exported
	 * @return exported csv file
	 */
	public function ExportCsv($fields,$prices)
	{
		header('Content-type: text/csv; charset=windows-1251');
		$filename = "php://output";
		//echo $filename;
		header('Content-Disposition: attachment; filename="'.get_class($this).'-export-' . date('YmdHi') .'.csv"');//*/
		$objects = $this->findAll();
		//Базовые поля.
		//$fields = $this -> fields;
		
		//Поля, добавленные через админку.
		$criteria = new CDbCriteria;
		$criteria -> compare('object_type', Objects::model() -> getNumber(get_class($this)));
		$customFields = CHtml::listData(Fields::model()->findAll($criteria), 'id','title');
		//Названия всех экспортируемых полей.
		if ((is_array($customFields))&&(is_array($fields))&&(is_array($prices))) {
			$names = array_merge(array_values($fields), array_values($customFields), array_values($prices));
		} elseif((is_array($customFields))&&(is_array($fields))) {
			$names = array_merge(array_values($fields), array_values($customFields));
		} elseif(is_array($fields)) {
			$names = array_values($fields);
		} else {
			$names = Array();
		}
		if ($file = fopen($filename, 'w'))
		{
			$this -> my_fputcsv($file, $names,";");
			foreach($objects as $object)
			{
				$current_object_array = Array();
				foreach($fields as $key => $v)
				{
					switch($key)
					{
						case 'district':
							$distr_arr = $object -> giveDistrNames();
							$current_object_array[] = implode(",", $distr_arr);
						break;
						case 'triggers':
							$trigger_arr = $object -> giveTriggerValues();
							$current_object_array[] = implode(",", $trigger_arr);
						break;
						case 'metro_station':
							$metro_arr = $object -> giveSubwayNames();
							$current_object_array[] = implode(",", $metro_arr);
						break;
						default:
						//echo $key."<br/>";
						$current_object_array[] = $object -> $key;
					}
				}


				foreach($customFields as $key => $v)
				{
					$criteria = new CDbCriteria();					
					$criteria -> compare('object_id', $object -> id);
					$criteria -> compare('field_id', $key);
					$field = FieldsValue::model() -> find($criteria);
					if (($field)&&($field -> value)) 
					{
						$current_object_array[] = $field -> value;
					} else {
						$current_object_array[] = '';
					}
				}
				//Экспорт всех запрошенных цен клиники.
				$has = CHtml::listData($object -> prices,'name','price');
				//print_r($has);
				foreach($prices as $priceName) {
					//echo $has[$priceName].'<br/>';
					$current_object_array[] = $has[$priceName];
				}
				$this -> my_fputcsv($file, $current_object_array, ";");
				//break;//удалить!
			}
			fclose($file);
			return true;
			//$this -> disableProfilers();
			
		} else {
			throw new Exception("Export File does not open.");
			return false;
		}
	}
	//import data function. $handle is a handle to a csv-encoded file to be analyzed
	public function ImportCsv($handle = false, $fields = Array (), $prices = array())
	{
		//echo "start";
		if ($handle)
		{
			$firstline = $this -> my_fgetcsv($handle, 2000, ';');
			//Получили массив <название в файле экспорта> => <поле в таблице>
			//$fields = array_flip($this -> fields);
			$fields = array_flip($fields);
			$keys = array_keys($fields);
			$prices = array_values($prices);
			//Получили список id-шников нестандартных полей, использованных в файле.
			$customFieldsIds = Array();
			foreach ($firstline as $key)
			{
				/*it was: if (!in_array($key, $keys))
				{
					
					$field = Fields::model() -> findByAttributes(array('title' => $key,'object_type' => Objects::model() -> getNumber(get_class($this))));
					//Сохраняем id-шник, если поняли, что это за поле.
					if ($field) 
					{
						$customFieldsIds[] = $field -> id;
					} else {
						$customFiledsIds[] = -1;
					}
				}*/
				
				if (!in_array($key, $keys))
				{
					//Если ключа нет в массиве стандартных полей, то ищем его сначала среди цен.
					if (in_array($key,$prices)) {
						$prices_keys [] = $key;
					} else {
						$field = Fields::model() -> findByAttributes(array('title' => $key,'object_type' => Objects::model() -> getNumber(get_class($this))));
						//Сохраняем id-шник, если поняли, что это за поле.
						if ($field) 
						{
							$customFieldsIds[] = $field -> id;
						} else {
							$customFiledsIds[] = -1;
						}
					}
				}
			}
			while(($line = $this -> my_fgetcsv($handle, 2000, ';')) !== false)
			{
				//Пробегаемся по всем стандартным ключам, расположенным в начале.
				//print_r($line);
				reset($line);
				reset($customFieldsIds);
				$customFields = Array();
				$toAddPrices = Array();
				foreach ($firstline as $key)
				{
					//Если поле стандартное, тогда добавляем его как атрибут модели клиника. $object_arr - массив будущих атрибутов модели клиника
					//echo "<br/>".($key);
					
					if (in_array(trim($key), $keys))
					{
						
						switch ($fields[($key)])
						{
							case 'district':
								$distr_ids = $this -> giveDistrictIdsByNameString(current($line));
								
								$object_arr['district'] = implode(';', $distr_ids);
							break;
							case 'triggers':
								$trigger_ids = $this -> giveTriggersByNameString(current($line));
								$object_arr['triggers'] = implode(';',$trigger_ids);
							break;
							case 'metro_station':
								$metro_ids = $this -> giveSubwayIdsByNameString(current($line));
								$object_arr['metro_station'] = implode(";", $metro_ids);
							break;
							default:
								$object_arr[$fields[($key)]] = current($line);
								//echo "<br/>".$fields[($key)];
								
						}
						if(next($line)===false)
						{
							break;
						}
					} else {//Если же поле не стандартное, то сохраняем его значение в массив, где ключ - id-шник поля.
						//Проверяем сначала не является ли поле ценой
						if (in_array(trim($key),$prices_keys)) {
							$toAddPrices[$key] = current($line);
						} else {
							$id = current($customFieldsIds);
							if ($id != -1)
							{
								$customFields[$id] = current($line);
							}
							next($customFieldsIds);
							
						}
						if(next($line)===false)
						{
							break;
						}
					}
				}
				//Заносим данные в базу.
				//Если не существует объекта с таким verbiage
				//print_r($object_arr);
				//print_r($firstline);
				//echo "123";
				//return;
				if (!$this -> findByAttributes(array('verbiage' => $object_arr['код'])))
				{
					$modelName = get_class($this);
					$object = new $modelName();
					$object -> attributes = $object_arr;
					if ($object_arr['logo']) {
						$object -> logo = $object_arr['logo'];
					}
					
					
					//Сохраняем объект
					if ($object -> save())
					{
						//echo $clinic -> id;
						$id = $object -> id;
						//Устанавливаем значения кастомных полей.
						foreach($customFields as $fid => $value)
						{
							$fields_assign = new FieldsValue();
							$fields_assign -> object_id = $id;
							$fields_assign -> field_id = $fid;
							$fields_assign -> value = $value;
							//stopped here
							if (strlen($value)>0)
							{
								if (!$fields_assign -> save())
								{
									//echo "not saved";
									new CustomFlash('warning', 'FieldsValue', 'NotSaved'.$fields_assign -> object_id.'_'.$fields_assign -> field_id, 'Поле '.$modelName == 'clinics'? 'клиники' : 'доктора'.' с номером '.$fields_assign -> object_id. ' и значением '.$fields_assign -> value. ' не добавлено.');
									//print_r($fields_assign -> getErrors());
								}
							}
						}
						//Добавляем цены.
						foreach($toAddPrices as $priceName => $priceValue){
							$price = new Pricelist;
							$price -> object_type = Objects::model() -> getNumber(get_class($this));
							$price -> object_id = $object -> id;
							$price -> name = $priceName;
							$price -> price = $priceValue;
							if (!$price -> save()) {
								echo $price -> name." ".$price -> object_id." not saved<br/>";
							}
						}
					} else {
						$errors[$object -> name] = $object -> getErrors();
					}
				} else {
					$exist[] = $object_arr['код'];
					//echo "exists";
				}
				//break;
			}
			//fclose($handle);
			if (!empty($exist))
			{
				Yii::app() -> user -> setFlash('clinicExists', 'Объекты с адресами:<br/>'.implode("<br/>",$exist)." - уже есть в базе данных.");
			}
			if (!empty($errors))
			{
				$string = CHtml::encode("При импорте возникли следующие ошибки:")."<br/>";
				foreach ($errors as $name => $errors)
				{
					$string .= CHtml::encode("Объект с названием ".$name.":")."<br/>";
					$content = "";
					foreach($errors as $field => $error)
					{
						$content .= CHtml::tag('li', array() ,"Поле: ".$field.", ошибка: ".implode(", ",$error));
					}
					$string .= CHtml::tag('ol',array(),$content);
				}//*/
				Yii::app() -> user -> setFlash('errorsWhileImporting',$string);
			}else {
				Yii::app()->user->setFlash('successfull'.$modelName.'Import', 'Список объектов успешно импортирован.');
			}
		}
		return true;
	}
	public function giveDistrictIdsByNameString($NameString)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData(Districts::model()->findAll($criteria), 'id','name'));//костыль. переписать

	}
	public function giveSubwayIdsByNameString($NameString)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData(Metro::model()->findAll($criteria), 'id','name'));//костыль. переписать
	}
	public function giveTriggersByNameString($NameString)
	{
		$trigger_values = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("value", $trigger_values);
		return array_keys(CHtml::listData(TriggerValues::model()->findAll($criteria), 'id','value'));//костыль. переписать
	}
	/*
	* Common function
	*/
	public function giveIdsByNameString($NameString, $model)
	{
		$names = array_map('trim', explode(',',$NameString));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("name", $names);
		return array_keys(CHtml::listData($model -> findAll($criteria), 'id','name'));//костыль. переписать
	}
	/**
	 * @return array of all speciality names
	 */
	public function giveAllSpecialities(){
		$criteria = new CDbCriteria;
		$criteria -> compare('trigger_id',8);
		$rez = TriggerValues::model() -> findAll($criteria);
		return CHtml::listData($rez, 'id', 'value');
	}
	/**
	 * @return array of speciality names of the current object
	 */
	public function giveSpecialities(){
		$triggers = array_map('trim', explode(";",$this -> triggers));
		$all_spec = $this -> giveAllSpecialities();
		$all_spec_ids = array_keys($all_spec);
		$cur_spec_ids = array_intersect($all_spec_ids, $triggers);
		$rez = array();
		foreach($cur_spec_ids as $id) {
			$rez[$id] = $all_spec[$id];
		}
		return $rez;
	}
	/**
	 * Делает так, что массив объектов $objectClass, который привязан через таблицу
	 * стал равен массиву, айди которого находятся в $ids
	 *
	 * @arg array ids - an ids array of objects to be assigned to the this object
	 * @arg string objectClass - the name of the class of objects which correspond to the linking table record
	 * @arg string propertyName - the name of relational property that contains the array of objects
	 * @arg string PK - the name of the PrimaryKey property for this object
	 * @arg string PK_name - the name of the PrimaryKey in the linking table fo "big" objects
	 * @arg string PK_small - the name of the PrimaryKey property for objects to be saved
	 * @arg string PK_small_name - the name of the PrimaryKey in the linking table for "small" objects
	 */
	public function SavePropertyArrayChanges($ids, $objectClass, $propertyName, $PK, $PK_name, $PK_small, $PK_small_name) {
		//Пполучаем то, что было
		$start_ids = CHtml::giveAttributeArray($this -> $propertyName, $PK_small);
		//находим то, чего нет в конечном массиве.
		$to_del = array_diff($start_ids, $ids);
		//находим то, что нужно добавить
		$to_add = array_diff($ids, $start_ids);
		//print_r($to_add);
		//удаляем ненужное.
		$criteria = new CDbCriteria();
		$criteria -> compare($PK_name, $this -> $PK);
		$criteria -> addInCondition($PK_small_name, $to_del);
		if (!empty($to_del)) {
			$objectClass::model() -> deleteAll($criteria);
		}
		//Добавляем нужное
		foreach($to_add as $id) {
			$model = new $objectClass;
			$model -> $PK_name = $this -> $PK;
			$model -> $PK_small_name = $id;
			//var_dump($model);
			if (!$model -> save()) {
				print_r($model -> getErrors());
			}
			
		}
	}
	public function BeforeSave(){
		
		if (parent::beforeSave()) {
			try {
				if (!$this -> map_coordinates) {
					$adress=urlencode('Санкт-Петербург, '.$this -> address);
					$url="http://geocode-maps.yandex.ru/1.x/?geocode=".$adress;//."&key=".$key;
					//echo $url;
					@$content=file_get_contents($url);
					//echo $content;
					preg_match('/<pos>(.*?)<\/pos>/',$content,$point);
					preg_match('/<found>(.*?)<\/found>/',$content,$found);
					if (trim(next($found)) > 0) {
						$coordinaty=explode(' ',trim(strip_tags($point[1])));
						$this -> map_coordinates = $coordinaty[1].', '.$coordinaty[0];
					} else {
						new CustomFlash('warning','Clinics','coords','Координаты не определены',true);
					}
				}
			} catch (Exception $e) {}
			//Пытаемся найти ближайшее метро.
			try {
				if (($this -> map_coordinates)&&(!$this -> metro_station)) {
					list($shir, $dolg) = explode(', ',$this -> map_coordinates);
					$metros = giveMetroNamesArrayByCoords($shir, $dolg);
					$criteria = new CDbCriteria();
					$criteria -> addInCondition('name',$metros);
					$met = Metro::model() -> findAll($criteria);
					//var_dump(Html::listData($met,'id','id'));
					$this -> metro_station = implode(';',Html::listData($met,'id','id'));
					//echo $this -> metro_station;
				}
			} catch (Exception $e) {}
			return true;
		} else {
			return false;
		}
	}
	public function preparePrices($prices){
		$mrt = array();
		$kt = array();
		$other = array();
		foreach($prices as $price){
			if (stripos($price -> name,'МРТ')!==false){
				$mrt[$price -> name] = $price -> price;
			} elseif (stripos($price -> name,'КТ')!==false){
				$kt[$price -> name] = $price  -> price;
			} else {
				$other[$price -> name] = $price -> price;
			}
		}
		asort($mrt);
		asort($kt);
		asort($other);
		return array_merge($mrt,$kt,$other);
	}
	public function checkTrigger($id) {
		$triggers_array = array_map('trim', explode(';', $this->triggers));
		$trigger = Triggers::model() -> findByPk($id);
		$arr = $trigger -> trigger_values;
		$arr = array_filter($arr, function ($tr) use ($triggers_array) {
			return in_array($tr -> id, $triggers_array);
		});
		return CHtml::giveStringFromArray($arr, ', ','value');
		//return CHtml::giveStringFromArray(array_intersect($trigger -> trigger_values, $triggers_array), ', ', 'value');
	}
	public function giveTriggerValuesObjects() {
		$triggers_array = array_map('trim', explode(';', $this->triggers));
		$criteria = new CDbCriteria; 
		$criteria -> addInCondition('id', $triggers_array);
		return TriggerValues::model() -> findAll($criteria);
	}//*/
	public function giveMrtPrices() {
		return array_filter($this -> prices, function($pr) {
			//echo $pr -> name. ' - ' .strpos($pr -> name, 'МРТ').'<br/>';
			return (strpos($pr -> name, 'МРТ') !== false);
		});
	}
	public function giveKtPrices() {
		return array_filter($this -> prices, function($pr) {
			return (strpos($pr -> name, 'КТ') !== false);
		});
	}
	public function giveMinMrtPrice() {
		$obj = false;
		foreach ($this -> giveMrtPrices() as $pr) {
			
			if (($pr -> price < $min) || (!$obj)) {
				$min = $pr -> price;
				$obj = $pr;
			}
		}
		return $obj;
	}
	public function giveMinKtPrice() {
		$obj = false;
		foreach ($this -> giveKtPrices() as $pr) {
			
			if (($pr -> price < $min) || (!$obj)) {
				$min = $pr -> price;
				$obj = $pr;
			}
		}
		return $obj;
	}

	/**
	 * @var BaseGoogleDocApiHelper $api - api to get data from.
	 * @return bool - whether the import was successful.
	 */
	public static function importFromGoogleDoc(GoogleDocApiHelper $api){
		if ($api -> success) {
			$entries = $api -> giveData() -> getEntries();
			//echo get_class(current($entries));
			$count = 0;
			$num = 0;
			$total = count($entries);
			foreach($entries as $entry){
				if (!is_a($entry,'Google\Spreadsheet\ListEntry')) {
					continue;
					$count ++;
				}

				$clinicLine = $entry -> getValues();
				if ($clinicLine['название'] == 'comment') {
					continue;
				}

				if (!$clinicLine['рейтинг']) {
					$clinicLine['рейтинг'] = $total - $num;
				}
				$num ++;
				//Получаем клинику из строки, с уже заданными параметрами.
				$clinic = $api -> clinicFromLine($clinicLine);
			}
			return true;
		} else {
			return false;
		}
	}
}
?>