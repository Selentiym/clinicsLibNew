<?php

/**
 * This is the model class for table "{{clinics_fields}}" - it describes a standard one additional Field for Clinic
 *
 * The followings are the available columns in table '{{clinics_fields}}':
 * @property integer $id
 * @property integer $object_id
 * @property integer $field_id
 * @property string $value
 */
 
class FieldsValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fields_values}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('object_id, field_id', 'required'),
			array('object_id, field_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),
			array('id, object_id, field_id, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'clinic' => array(self::BELONGS_TO, 'clinics',  'object_id'),
            'doctor' => array(self::BELONGS_TO, 'doctors',  'object_id'),
            'field' => array(self::BELONGS_TO, 'Fields',  'field_id', 'together' => true)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'object_id' => CHtml::encode('Клиника/Врач'),
			'field_id' => CHtml::encode('Поле'),
			'value' => CHtml::encode('Значение'),
		);
	}

    public function beforeSave()
    {   
        $criteria=new CDbCriteria;
        
        // prevent app from adding a duplicate field to the clinic
        if (!$this->isNewRecord) {
            $criteria->condition='id <> :id';
            $criteria->params = array(':id' => $this->id);             
        }
        
        // check for duplicates by combination field_id-object_id
        $dups = self::model()->findByAttributes(array('object_id' => $this->object_id, 'field_id' => $this->field_id), $criteria);        
        
        if ($dups) {
            Yii::app()->user->setFlash('duplicateObjectsField', CHtml::encode('Такое поле у объекта уже есть'));
            return false;                
        }              

        return parent::beforeSave();
    }
    public function search2($modelName)
	{
		$criteria = new CDbCriteria;
		$critetia -> with = 'field';
		$criteria->compare('id',$this->id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('value',$this->value,true);
		$array = FieldsValue::model() -> findAll($criteria);
		$rez = array();
		foreach ($array as $fv)
		{
			if ($fv -> field -> object_type == Objects::model()->getNumber($modelName)) {
				$rez[] = $fv;
			}
		}
		return new CArrayDataProvider($rez);
		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
		//FieldsValue::model() -> findAllBySql('SELECT * FROM `{{fields_values}}` `fv`,`{{fields}}` `f` WHERE `fv`.`object_id`=\''.$this -> object_id.'\' AND `fv`.`field_id`');
		
	}
    // standard searcf function (not in use)
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('value',$this->value,true);
        
        //$criteria->compare('clinic.id', $this->object_id, true);
        //$criteria->compare('clinic.name', $this->object_id, true);

        //$criteria->compare('field.id', $this->field_id, true);
        //$criteria->compare('field.name', $this->field_id, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    // this is standard function for searching
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
