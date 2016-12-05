<?php

/**
 * This is the model class for table "{{vk_account}}".
 *
 * The followings are the available columns in table '{{vk_account}}':
 * @property integer $id
 * @property integer $vk_id
 * @property string $first_name
 * @property string $last_name
 * @property string $photo
 * @property string $domain
 * @property integer $occupied
 */
class VkAccount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vk_account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vk_id, first_name, last_name, photo', 'required'),
			array('vk_id, occupied', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vk_id, first_name, last_name, photo, occupied', 'safe', 'on'=>'search'),
			array('*', 'safe'),
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
			'vk_id' => 'Vk',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'photo' => 'Photo',
			'occupied' => 'Occupied',
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
		$criteria->compare('vk_id',$this->vk_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('occupied',$this->occupied);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VkAccount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function showRandom(){
		require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
		$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5');
		return $vk->request('users.get', [
				'user_ids' => [rand(1000000,1000000*100)],
				"fields" => "photo_50, domain"
		])->getResponse();
	}

	/**
	 * @return string
	 */
	public function genUrl(){
		return 'https://vk.com/'.$this->domain;
	}

	/**
	 * @param $id
	 * @return VkAccount
	 */
	public static function createByVkId ($id) {
		require_once(Yii::getPathOfAlias('webroot.vendor') . DIRECTORY_SEPARATOR . 'autoload.php');
		$vk = getjump\Vk\Core::getInstance()->apiVersion('5.5');
		$obj = current($vk->request('users.get', [
				'user_ids' => $id,
				"fields" => "photo_50, domain"
		])->getResponse());
		$vkAccount = new self;
		$vkAccount -> vk_id = $id;
		$vkAccount -> domain = $obj -> domain;
		$vkAccount -> first_name = $obj -> first_name;
		$vkAccount -> last_name = $obj -> last_name;
		$vkAccount -> photo = $obj -> photo_50;
		if (!$vkAccount -> save()) {
			$err = $vkAccount -> getErrors();
		}
		return $vkAccount;
	}
}
