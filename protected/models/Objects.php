<?php

/**
 * This is the model class for table "{{objects}}".
 *
 * The followings are the available columns in table '{{objects}}':
 * @property integer $id
 * @property string $name
 */
class Objects extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{objects}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => CHtml::encode('Тип объекта'),
			'name' => CHtml::encode('Название объекта'),
		);
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
		$criteria->compare('name',$this->name);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returnes the number corresponding to the given modelName
	 * @arg string modelName - class name of a model which interests us
	 * @return integer
	 */
	public function getNumber($modelName)
	{
		$criteria = new CDbCriteria;
		$criteria -> compare('name', strtolower($modelName));
		if ($obj = Objects::model() -> find($criteria)) {
			return $obj -> id;
		} else {
			return false;
		}
	}
	/**
	 * Returnes the name corresponding to the given id of the object type
	 * @arg integer number - id of an object type
	 * @return string - corresponding modelName
	 */
	public function getName($number)
	{
		$criteria = new CDbCriteria;
		$criteria -> compare('id', $number);
		if ($obj = Objects::model() -> find($criteria)) {
			return $obj -> name;
		} else {
			return false;
		}
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TriggerValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
