<?php

/**
 * This is the model class for table "{{fields}}".
 *
 * The followings are the available columns in table '{{fields}}':
 * @property integer $id
 * @property integer $object_type
 * @property string $name
 * @property string $title
 */
class Fields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{fields}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, title, object_type', 'required'),
			array('name, title', 'length', 'max'=>255),
            array('name',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z_-]/',
                'message' => CHtml::encode('Запрещенные символы в имени'),
            ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, title', 'safe', 'on'=>'search'),
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
            'clinics' => array(self::MANY_MANY, 'clinics', 'tbl_clinics_fields(field_id, clinic_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название (внутреннее)',
			'title' => 'Заголовок (для отображения на странице)',
			'object_type' => 'Тип объекта'
		);
	}

    public function beforeSave()
    {   
        $criteria=new CDbCriteria;
        
        if (!$this->isNewRecord) {
            $criteria->condition='id <> :id';
            $criteria->params = array(':id' => $this->id);             
        }
       
        $dups = self::model()->findByAttributes(array('name' => $this->name), $criteria);        

        if ($dups) {
            Yii::app()->user->setFlash('duplicateField', CHtml::encode('Поле с таким названием уже существует'));
            return false;                
        }
 
        return parent::beforeSave();
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Fields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
