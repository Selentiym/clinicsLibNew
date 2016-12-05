<?php

/**
 * This is the model class for table "{{descriptions}}".
 *
 * The followings are the available columns in table '{{descriptions}}':
 * @property integer $id
 * @property integer $object_type
 * @property string $trigger_values
 * @property string $text
 */
class Description extends CTModel
{
	/**
	 * @var string searchId - used in search operations.
	 */
	public $searchId = '';
	/**
	 * @var string PerfoemCheck - whether to check for duplicate records while saving.
	 */
	public $PerformCheck = true;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{descriptions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_type, text', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
            array('object_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_type, trigger_values, text', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'object_type' => 'Тип объекта',
			'trigger_values' => 'Значения триггеров',
			'text' => 'Текст комментария',
		);
	}
	public function giveTriggerValues(){
		$criteria = new CDbCriteria;
		$trigger_values_ids = array_filter(array_map('trim',explode(';', $this -> trigger_values)));
		$criteria -> addInCondition('id', $trigger_values_ids);
		$trigger_values = TriggerValues::model() -> findAll($criteria);
		return $trigger_values;
	}
	public function giveTriggerString()
	{
		$triggers = $this -> giveTriggerValues();
		$triggerString = '';
		foreach ($triggers as $trigger)
		{
			$triggerString .= $trigger -> value.', ';
		}
		$triggerString = substr($triggerString, 0, strripos($triggerString, ','));
		return $triggerString;
	}
	public function giveModelByTriggerArray($triggers, $modelName)
	{
		asort($triggers);
		$string = implode(';', $triggers);
		return Description::model() -> findByAttributes(array('trigger_values' => $string, 'object_type' => Objects::model() -> getNumber($modelName)));
	}
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$criteria = new CDbCriteria;
			$criteria->compare('object_type',$this->object_type);
			$criteria->compare('trigger_values',$this->trigger_values);
			if (!$this -> isNewRecord) {
				$criteria -> condition = 'id <> '.$this -> id;
			}
			$dups = Description::model() -> find($criteria);
			if (($dups)&&($this -> PerformCheck)) {
				new CustomFlash('warning', 'Filters', 'DuplicateFilter', 'Для данного набора триггеров уже задан комментарий. Запись была произведена в него.', true);
				$dups -> text = $this -> text;
				$dups -> PerformCheck = false;
				$dups -> save();
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('object_type',$this->object_type);
		//Получили массив крл триггера => айди значения триггера.
		$trigger_values_array = TriggerValues::decodeSearchId($this -> searchId);
		//Нас интересуют только айди значений триггера.
		$data = array_values($trigger_values_array);
		//Сортируем значения по возорастанию, тк в базу всегда пишутся айдишки по возрастанию, 
		//иначе одному набору будет соответствовать n! вариантов строки, где n кол-во знчений триггеров
		asort($data);
		//Делаем строку из айдишек
		$string = implode(';', $data);
		$criteria->compare('trigger_values', $string, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Filters the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
