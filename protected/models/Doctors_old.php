<?php

/**
 * This is the model class for table "{{doctors}}" - it describes a standard doctor
 *
 * The followings are the available columns in table '{{doctors}}':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $phone_extra
 * @property string $fax
 * @property string $email
 * @property string $address
 * @property string $address_extra
 * @property string $city
 * @property integer $district
 * @property integer $metro_station
 * @property string $working_days
 * @property string $working_hours
 * @property string $services
 * @property double $rating
 * @property string $logo
 * @property string $triggers
 * @property string $pictures
 * @property string $map_coordinates
 * @property string $text
 * @property string $audio
 * @property string $video
 * @property string $keywords
 * @property string $description
 *
 */
 
class doctors extends BaseModel
{
    public $metros_display;
    public $districts_display;
    public $triggers_display;
	public $additional;
    protected $_DistrNames;
    protected $_SubwayNames;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{doctors}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, verbiage', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('rating', 'numerical'),
			array('name', 'length', 'max'=>500),
            array('site', 'length', 'max'=>1000),
            array('logo', 'file', 'types'=>'jpg, gif, png', 'maxSize' => 1048576, 'allowEmpty'=>true),
            array('audio', 'file', 'types'=>'mp3', 'maxSize' => 209715200, 'allowEmpty'=>true),
            array('district, metro_station, phone, fax, triggers, map_coordinates, metros_display, districts_display, triggers_display, keywords, description', 'length', 'max'=>2000),
			array('verbiage, address, working_days, working_hours, video, title', 'length', 'max'=>255),
			array('text', 'safe'),
			array('id, name, verbiage, phone, phone_extra, fax, address, address_extra, site, district, metro_station, working_days, working_hours, services, rating, triggers, map_coordinates, text, audio, video, metros_display, districts_display, triggers_display, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array relational rules.
     */
     //end here //
    public function relations()
    {
        return array(
            //'services' => array(self::HAS_MANY, 'Services', 'object_id'),
            'services' => array(self::HAS_MANY, 'Services', 'object_id', 'condition' => 'services.object_type = '.Objects::model() -> getNumber(get_class($this))),
            'comments' => array(self::HAS_MANY, 'Comments', 'object_id', 'condition' => 'comments.object_type = '.Objects::model() -> getNumber(get_class($this))),
            //'doctorfields' => array(self::HAS_MANY, 'ObjectsFields', 'object_id', 'with' => 'field'),
            'fields' => array(self::HAS_MANY, 'FieldsValue', 'object_id', 'with' => 'field'),
        );
    }


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => CHtml::encode('Имя'),
            'verbiage' => CHtml::encode('Имя в URL'),
			'phone' => CHtml::encode('Телефон'),
			'fax' => CHtml::encode('Факс'),
			'address' => CHtml::encode('Адрес'),
            'site' => CHtml::encode('Сайт'),
            'district' => CHtml::encode('Район'),
			'metro_station' => CHtml::encode('Метро'),
			'working_days' => CHtml::encode('Рабочие дни'),
			'working_hours' => CHtml::encode('Рабочие часы'),
			'rating' => CHtml::encode('Рейтинг'),
			'logo' => CHtml::encode('Логотип'),
			'triggers' => CHtml::encode('Триггеры'),
			'pictures' => CHtml::encode('Изображения'),
			'map_coordinates' => CHtml::encode('Координаты на карте'),
			'text' => CHtml::encode('Описание'),
			'audio' => CHtml::encode('Аудиофайл'),
			'video' => CHtml::encode('Видеофайл'),
            'title' => CHtml::encode('Title'),
			'keywords' => CHtml::encode('Keywords'),
			'description' => CHtml::encode('Description')
		);
	}
    /** This is a standard search function (not in use)
     * 
     */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('address',$this->address,true);
        $criteria->compare('site',$this->site,true);
        $criteria->compare('district',$this->district);
		$criteria->compare('metro_station',$this->metro_station);
		$criteria->compare('working_days',$this->working_days,true);
		$criteria->compare('working_hours',$this->working_hours,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('triggers',$this->triggers,true);
		$criteria->compare('pictures',$this->pictures,true);
		$criteria->compare('map_coordinates',$this->map_coordinates,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('audio',$this->audio,true);
		$criteria->compare('video',$this->video,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('description',$this->description,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}//*/

    // this is standard function for getting a model of the current class
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/** Function to determine which attribute will be used to name file folder.
	*
	*/
	public function FolderKey()
	{
		return 'id';
	}
	
	/**
	*  EVENT HANDLERS
	*/
	
	/**
	* Function to be called after $model -> save() methods succeeds
	*/
	protected function afterSave()
	{
		
		parent::afterSave();
		//Если у модели клиники определены какие-то значения дополнительных полей, то сохраняем их.
		if (isset($this -> additional))
		{
			foreach ($this -> additional as $id => $value)
			{
				$current_field = doctorsFields::model()->findByPk(trim($id));
				$current_field -> value = $value;
				if (!$current_field -> save()) {
					new CustomFlash("error", 'doctorFields', 'SaveField_id_'.$id, 'Не удалось сохранить поле клиники с id '.$id, true) ;
					echo "error_field".$id;
				}
			}
		}
	}
	
	
	/**
	* Getters and Setters
	*/
	
	/**
	* CUSTOM FUNCTIONS
	*/
	
	
	
	public function ReadData(){
		$metros = ''; $districts = ''; $triggers = '';
		$metros_array = array_map('trim', explode(';', $this->metro_station));
		$districts_array = array_map('trim', explode(';', $this->district));
		$triggers_array = array_map('trim', explode(';', $this->triggers));
		
		/* metro stations */
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $metros_array);
		$metros_array = Metro::model()->findAll($criteria);

		if (!empty($metros_array)) {
			foreach ($metros_array as $metro)
				$metros .= $metro->name . ', ';
		}
		$metros = substr($metros, 0, strrpos($metros, ','));
		
		/* districts */
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $districts_array);
		$districts_array = Districts::model()->findAll($criteria);

		if (!empty($districts_array)) {
			foreach ($districts_array as $district)
				$districts .= $district->name . ', ';
		}
		$districts = substr($districts, 0, strrpos($districts, ','));

		/* triggers */
		$criteria = new CDbCriteria();
		$criteria->addInCondition("t.id", $triggers_array);
		$criteria->with = array('trigger');
		$criteria->limit = 5;
		$criteria->together = true;

		$triggers_array = TriggerValues::model()->findAll($criteria);

		if (!empty($triggers_array)) {
			foreach ($triggers_array as $trigger)
				$triggers .= $trigger->trigger->name . ':&nbsp;&nbsp; ' .  $trigger->value . '<br/> ';
		}

		$this->metros_display = $metros;
		$this->districts_display = $districts;
		$this->triggers_display = $triggers_array;
	}
	
	public function filterByTriggerValuesIdString($doctors, $string)
	{
		$ids = array_filter(array_map('trim', explode(';',$string)));
		return doctors::model() -> filterByTriggerValuesIdArray($doctors, $ids);
	}
	public function filterByTriggerValuesIdArray($doctors, $ids)
	{
		$filtered = array();
		$number = count($ids);
		foreach($doctors as $doctor)
		{
			if (count(array_intersect($ids, array_map('trim',explode(';',$doctor -> triggers)))) == $number)
			{
				$filtered[] = $doctor;
			}
		}
		return $filtered;
	}
	//import data function. $handle is a handle to a csv-encoded file to be analized
	public function ImportCsv($handle = false, $fields = Array ())
	{
		if ($handle)
		{
			$firstline = fgetcsv($handle, 2000, ';');
			//Получили массив <название в файле экспорта> => <поле в таблице>
			//$fields = array_flip($this -> fields);
			$fields = array_flip($fields);
			$keys = array_keys($fields);
			//Получили список id-шников нестандартных полей, использованных в файле.
			$customFieldsIds = Array();
			foreach ($firstline as $key )
			{
				if (!in_array($key, $keys))
				{
					$field = Fields::model() -> findByAttributes(array('title' => $key));
					//Сохраняем id-шник, если поняли, что это за поле.
					if ($field) 
					{
						$customFieldsIds[] = $field -> id;
					} else {
						$customFiledsIds[] = -1;
					}
				}
			}
			while(($line = fgetcsv($handle, 2000, ';')) !== false)
			{
				//Пробегаемся по всем стандартным ключам, расположенным в начале.
				//print_r($line);
				reset($line);
				reset($customFieldsIds);
				$customFields = Array();
				foreach ($firstline as $key )
				{
					//Если поле стандартное, тогда добавляем его как атрибут модели клиника. $doctor_arr - массив будущих атрибутов модели клиника
					//echo "<br/>".($key);
					
					if (in_array(trim($key), $keys))
					{
						
						switch ($fields[($key)])
						{
							case 'district':
								$distr_ids = doctors::model() -> giveDistrictIdsByNameString(current($line));
								
								$doctor_arr['district'] = implode(',', $distr_ids);
							break;
							case 'triggers':
								$trigger_ids = doctors::model() -> giveTriggersByNameString(current($line));
								$doctor_arr['triggers'] = implode(';',$trigger_ids);
							break;
							case 'metro_station':
								$metro_ids = $this -> model() -> giveSubwayIdsByNameString(current($line));
								$doctor_arr['metro_station'] = implode(";", $metro_ids);
							break;
							default:
								$doctor_arr[$fields[($key)]] = current($line);
								//echo "<br/>".$fields[($key)];
								
						}
						if(next($line)===false)
						{
							break;
						}
					} else {//Если же поле не стандартное, то сохраняем его значение в массив, где ключ - id-шник поля.
						$id = current($customFieldsIds);
						if ($id != -1)
						{
							$customFields[$id] = current($line);
						}
						next($customFieldsIds);
						if(next($line)===false)
						{
							break;
						}
					}
				}
				//Обработка кастомных полей
				/*$customFields = CHtml::listData(Fields::model()->findAll(), 'title','id');
				if (!$empty)
				{
					foreach ($customFields as $title => $id)
					{
						$insertCustomFields[$id] = current($line);
						if(next($line)===false)
						{
							break;
						}
					}
				} else {
					$insertCustomFields = Array();
				}*/
				//print_r($insertCustomFields);
				//Заносим данные в базу.
				//Если не существует клиники с таким verbiage
				if (!doctors::model() -> findByAttributes(array('verbiage' => $doctor_arr['verbiage'])))
				{
					$doctor = new doctors();
					$doctor -> attributes = $doctor_arr;
					//Сохраняем клинику
					if ($doctor -> save())
					{
						//echo $doctor -> id;
						$id = $doctor -> id;
						//Устанавливаем значения кастомных полей.
						foreach($customFields as $fid => $value)
						{
							$fields_assign = new doctorsFields();
							$fields_assign -> doctor_id = $id;
							$fields_assign -> field_id = $fid;
							$fields_assign -> value = $value;
							if (!$fields_assign -> save())
							{
								echo "not saved";
							}
						}
					} else {
						$errors[$doctor -> name] = $doctor -> getErrors();
					}
				} else {
					$exist[] = $doctor_arr['verbiage'];
					//echo "exists";
				}
				//break;
			}
			//fclose($handle);
			if (!empty($exist))
			{
				Yii::app() -> user -> setFlash('doctorExists', 'Клиники с адресами:<br/>'.implode("<br/>",$exist)." - уже есть в базе данных.");
			}
			if (!empty($errors))
			{
				$string = CHtml::encode("При импорте клиник возникли следующие ошибки:")."<br/>";
				foreach ($errors as $name => $errors)
				{
					$string .= CHtml::encode("Клиника с названием ".$name.":")."<br/>";
					$content = "";
					foreach($errors as $field => $error)
					{
						$content .= CHtml::tag('li', array() ,"Поле: ".$field.", ошибка: ".implode(", ",$error));
					}
					$string .= CHtml::tag('ol',array(),$content);
				}//*/
				Yii::app() -> user -> setFlash('errorsWhileImporting',$string);
			}else {
				Yii::app()->user->setFlash('successfulldoctorsImport', 'Список клиник успешно импортирован.');
			}
		}
		return true;
	}
	//Export database function
	public function ExportCsv($fields)
	{
		header('Content-type: text/csv');
		//$filename = 'ftp://'.substr(Yii::app()->createAbsoluteUrl('files'),7)."/doctors-export-" . date('YmdHi') .".csv";
		$filename = "php://output";
		//echo $filename;
		header('Content-Disposition: attachment; filename="doctors-export-' . date('YmdHi') .'.csv"');//*/
		$doctors = doctors::model()->findAll();
		//Базовые поля.
		//$fields = $this -> fields;
		
		$doctors = doctors::model()->findAll();
		//Поля, добавленные через админку.
		$customFields = CHtml::listData(Fields::model()->findAll(), 'id','title');
		//Названия всех экспортируемых полей.
		if ((is_array($customFields))&&(is_array($fields))) {
			$names = array_merge(array_values($fields), array_values($customFields));
		} elseif(is_array($fields)) {
			$names = array_values($fields);
		} else {
			$names = Array();
		}
		if ($file = fopen($filename, 'w'))
		{
			fputcsv($file, $names,";");
			foreach($doctors as $doctor)
			{
				$current_doctor_array = Array();
				foreach($fields as $key => $v)
				{
					switch($key)
					{
						case 'district':
							$distr_arr = $doctor -> giveDistrNames();
							$current_doctor_array[] = implode(",", $distr_arr);
						break;
						case 'triggers':
							$trigger_arr = $doctor -> giveTriggerValues();
							$current_doctor_array[] = implode(",", $trigger_arr);
						break;
						case 'metro_station':
							$metro_arr = $doctor -> giveSubwayNames();
							$current_doctor_array[] = implode(",", $metro_arr);
						break;
						default:
						$current_doctor_array[] = $doctor -> $key;
					}
				}
				fputcsv($file, $current_doctor_array, ";");
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
	
	public function FillFieldsFromArray($model, $post_arr)
	{
		$model->attributes=$post_arr['doctors'];

		//metro
		if (!empty($post_arr['metro_station_array'])) {
			$metro = implode(';', $post_arr['metro_station_array']);
			$model->metro_station = $metro; //substr($metro, 0, strrpos($metro, ';'));
		} else {
			$model -> metro_station = '';
		}

		//districts
		if (!empty($post_arr['district_array'])) {
			$district = implode(';', $post_arr['district_array']);
			$model->district = $district;//substr($district, 0, strrpos($district, ';'));
		} else {
			$model -> district = '';
		}

		//triggers
		if (!empty($post_arr['triggers_array'])) {
			$triggers = implode(';', $post_arr['triggers_array']);
			$model->triggers = $triggers;//substr($triggers, 0, strrpos($triggers, ';'));
		} else {
			$model -> triggers = '';
		}
		//additional fields
		if (isset($post_arr['doctors']['Additional']) && !empty($post_arr['doctors']['Additional'])) {
			$model -> additional = $post_arr['doctors']['Additional'];
		}
	}
	/** Function that saves files to corresponding folders and updates model's file data.
	* it also tries to delete previous files if they exist.
	*/
	public function FilesOperationsFromArray($model, $files_arr) 
	{
		// logo and audio
		
		$files_filePath = $model -> giveFileFolderAbsoluteUrl(NULL, 'files');
		if (!file_exists($files_filePath))
		{
			mkdir($files_filePath);
		}
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		if (!file_exists($images_filePath))
		{
			mkdir($images_filePath);
		}
		if(!empty($files_arr['doctors']['name']['logo'])){
			$logo_old = $model->logo;
			$model->logo = CUploadedFile::getInstance($model,'logo');
			$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
			$fileName = $images_filePath . DIRECTORY_SEPARATOR . $image_unique_id;

			if ($model->validate()) {
				$model->logo->saveAs($fileName);
				$model->logo = $image_unique_id;
				if (strlen($logo_old) > 0) @unlink ($images_filePath. DIRECTORY_SEPARATOR .$logo_old);
			}
			else
				$model->logo = $logo_old;
		}

		if(!empty($files_arr['doctors']['name']['audio'])) {
			$audio_old = $model->audio;
			$model->audio = CUploadedFile::getInstance($model,'audio');
			//$fileName = Yii::app()->basePath.'/../files/doctors/'.$model->id . '/' . $model->audio;
			$fileName = $files_filePath . $model->audio;
			if ($model->validate())
				$model->audio->saveAs($fileName);
			if (strlen($audio_old) > 0) @unlink ($files_filePath. DIRECTORY_SEPARATOR .$audio_old);
			else
				$model->audio = $audio_old;

		} 
		if(!empty($files_arr['images'])){
			$images_old = (trim($model->pictures) == '')? '': $model->pictures . ';'; 
			
			$pictures = '';
			$images = CUploadedFile::getInstancesByName('images');
			if ($model->validate()){
				foreach($images as $image) {
					$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$image->extensionName;
					$fileName = $images_filePath . $image_unique_id;
					$image->saveAs($fileName);
					$pictures .= $image_unique_id . ';';
				}                     
				$pictures_all = $images_old . $pictures;   
				$model->pictures = substr($pictures_all, 0, strrpos($pictures_all, ';'));
			} else {
				$model->pictures = $images_old;
			}
		}
	}
    public function doctorInit($model, $post_arr = NULL , $files_arr = NULL)
    {   //var_dump($post_arr['doctors']['Additional']); die();
        if (!$post_arr)
		{
			return false;
		}
		if (!$files_arr)
		{
			return false;
		}
		if(isset($post_arr['doctors']))
        {
			$this -> FilldoctorFieldsFromArray($model, $post_arr);

			if($model->save()) {
				if(isset($files_arr['doctors'])) {
					$this -> doctorFilesOperationsFromArray($model, $files_array);
				}
				//Повторное сохранение, уже с изменениями в файлах.
				if ($model->save()){
					if ($this->isSuperAdmin())
						$this->redirect(array('doctors'));
					else {
						Yii::app()->user->setFlash('successfullSave', CHtml::encode('Изменения сохранены'));
						return; 
					}
				} else {
					return false;
				}
			 }
			 else
				return false;
        }
        return;
    }

	
	/*
	* Data transform functions ids <-> names
	*/
	public function getDistrNames()
	{
		if (!isset($this -> _DistrNames))
		{
			$this -> _DistrNames = $this -> giveDistrNames();
		}
		return $this -> _DistrNames;
	}
	public function getSubwayNames()
	{
		if (!isset($this -> _SubwayNames))
		{
			$this -> _SubwayNames = $this -> giveSubwayNames();
		}
		return $this -> _SubwayNames;
	}
	public function giveSubwayNames($data = '')
	{
		if (strlen($data) == 0)
		{
			$data = $this -> metro_station;
		}
		$subway_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $subway_ids);
		return array_values(CHtml::listData(Metro::model()->findAll($criteria), 'id','name'));//костыль. переписать

	}
	public function giveDistrNames($data = '')
	{
		if (strlen($data == 0))
		{
			$data = $this -> district;
		}
		$distr_ids = array_map('trim', explode(";",$data));
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $distr_ids);
		return array_values(CHtml::listData(Districts::model()->findAll($criteria), 'id','name'));//костыль. переписать
	}
	public function giveTriggerValues($data = '')
	{
		if (strlen($data == 0))
		{
			$data = $this -> triggers;
		}
		$trigger_ids = array_map('trim', explode(";",$data));
		
		$criteria = new CDbCriteria();
		$criteria->addInCondition("id", $trigger_ids);
		return array_values(CHtml::listData(TriggerValues::model()->findAll($criteria), 'id','value'));//костыль. переписать
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
}
