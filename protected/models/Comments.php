<?php
require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
/**
 * This is the model class for table "{{comments}}".
 *
 * The followings are the available columns in table '{{comments}}':
 * @property string $id
 * @property integer $object_id
 * @property string $text
 * @property integer $approved
 * @property string $create_at
 */
class Comments extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, user_first_name, object_type', 'required', 'message' => CHtml::encode('Поле <{attribute}> не может быть пустым.')),
            array('user_first_name', 'length', 'max'=>255),
            //array('user_first_name', 'match', 'pattern' => '/^[А-Яа-я_a-zA-Z]+$/u', 'message' => CHtml::encode('Поле <{attribute}> содержит недопустимые символы')),
			array('object_id, approved, object_type', 'numerical', 'integerOnly'=>true),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('text, vk_id', 'safe'),
			array('id, approved, text', 'safe', 'on'=>'search'),
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
			'VkAccount' => array(self::BELONGS_TO, 'VkAccount', 'vk_id'),
		);
	}

    public function scopes() {
        return array(
            'approved'=>array('condition'=>"approved=1"),
            'pendiing_approval'=>array('condition'=>"approved=0"),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'object_id' => 'Клиника/Врач',
			'text' => 'Текст',
            'user_first_name' => 'Имя',
			'approved' => 'Одобрен/Отклонен',
			'create_at' => 'Создан',
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
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('text',$this->text,true);
        $criteria->compare('user_first_name',$this->user_first_name,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('create_at',$this->create_at,true);
        $criteria->order = 'approved DESC, create_at ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return VkAccount
	 */
	public function getVkAccount(){
		$rez = $this -> VkAccount;
		if (!$rez) {
			$rez = $this -> addNewVkAccount();
		}
		return $rez;
	}
	public function addNewVkAccount() {
		return new VkAccount();
	}
}
