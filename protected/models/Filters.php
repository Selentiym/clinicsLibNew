<?php

/**
 * This is the model class for table "{{filters}}".
 *
 * The followings are the available columns in table '{{filters}}':
 * @property integer $id
 * @property integer $speciality_id
 * @property integer $object_type
 * @property string $fields
 */
class Filters extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{filters}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('speciality_id', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
            array('speciality_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, speciality', 'safe', 'on'=>'search'),
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
            'speciality' => array(self::BELONGS_TO, 'TriggerValues', 'speciality_id', 'together' => true),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'speciality_id' => 'Специализация',
			'fields' => 'Поля',
		);
	}
	public function giveTriggers(){
		$criteria = new CDbCriteria;
		$triggers_ids = array_filter(array_map('trim',explode(';', $this -> fields)));
		$criteria -> addInCondition('id', $triggers_ids);
		$triggers = Triggers::model() -> findAll($criteria);
		return $triggers;
	}
	public function FilterSearchCriteria($search, $modelName)
	{
		//считываем данные по специальности
		if (isset($search['speciality'])) {
			$speciality = $search['speciality'];
		} else {
			//echo "failed to filter search criteria";
			return $search;
		}
		$criteria = new CDbCriteria;
		//$criteria -> with = array('speciality'=>array('condition' => 'id = :id', 'params' => array(':id' => $speciality)));
		$criteria -> compare('object_type', Objects::model() -> getNumber($modelName));
		$criteria -> compare('speciality_id', $speciality);
		$filter = Filters::model() -> find($criteria);
		if (!$filter) {
			return $search;
		}
		$triggers = $filter -> giveTriggers();
		$rez = array();
		foreach ($triggers as $trigger) {
			$rez[$trigger -> verbiage] = $search[$trigger -> verbiage];
		}
		$rez['speciality'] = $speciality;
		$rez['district'] = $search['district'];
		$rez['metro'] = $search['metro'];
		return $rez;
	}
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$criteria = new CDbCriteria;
			$criteria->compare('object_type',$this->object_type);
			$criteria->compare('speciality_id',$this->speciality_id);
			$validNumber = $this -> isNewRecord ? 0 : 1;
			$number = Filters::model() -> count($criteria);
			if ($number > $validNumber){
				new CustomFlash('warning', 'Filters', 'DuplicateFilter', 'Для данной специальности уже задан другой набор триггеров.', true);
				return false;
			} elseif ($number == $validNumber) {
				return true;
			} else {
				new CustomFlash('error', 'Filters', 'MissingRecord', 'Возможно, произошла потеря данных по данной специальности, обратитесь к администратору.', true);
				return true;
			}
			if ($dups) {
				
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
		$criteria->compare('speciality',$this->speciality_id);
		$criteria->compare('fields',$this->fields,true);

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
	/*
	 * @return array of specialities available
	 * single speciality is represented by an array( <speciality_id> => <speciality_value>)
	 */
	public function giveSpecialities() {
		$forms = Filters::model()->findAll();
        $specialitiesCloud = array();
        foreach ($forms as $form) { 
             $specialitiesCloud[$form->speciality->id] = $form->speciality->value;
        }
		return $specialitiesCloud;
	}
}
