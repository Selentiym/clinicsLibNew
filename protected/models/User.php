<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $active
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $speciality
 * @property string $institution
 * @property integer $invite_code
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, password', 'required', 'message' => CHtml::encode('<{attribute}> не может быть пустым.')),
            array('username',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в имени'),
            ),
            array('active, clinic_id', 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			array('username', 'length', 'max'=>50),
			array('password', 'length', 'max'=>128),
			array('email', 'length', 'max'=>100),
			array('id, username, email', 'safe', 'on'=>'search'),
		);
	}

    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'clinic' => array(self::BELONGS_TO, 'clinics',  'clinic_id', 'select' => '*')
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => CHtml::encode('Имя пользователя'),
			'password' => CHtml::encode('Пароль'),
            'clinic_id' => CHtml::encode('Клиника'),
			'email' => CHtml::encode('Email'),
			'active' => CHtml::encode('Статус'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
        $criteria->compare('clinic',$this->clinic_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {   
        $criteria=new CDbCriteria;
        
        if (!$this->isNewRecord) {
            $criteria->condition='id <> :id';
            $criteria->params = array(':id' => $this->id);             
        }
       
        $dups = self::model()->findByAttributes(array('username' => $this->username), $criteria);        

        if ($dups) {
            Yii::app()->user->setFlash('duplicateUser', CHtml::encode('Пользователь с таким именем уже существует'));
            return false;                
        }
        
        // hash password for database.
        if ($this->isNewRecord) {
          $pass = md5($this->password);
          $this->password = $pass;
        }  
        return parent::beforeSave();
    }    

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
