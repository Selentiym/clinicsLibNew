<?php

/**
 * This is the model class for table "exp_experiments".
 *
 * The followings are the available columns in table 'exp_experiments':
 * @property integer $id
 * @property integer $id_enter
 * @property double $price
 * @property string $theme
 * @property bool $isMobile
 * @property string $date
 */
class GlobalExperiment extends CActiveRecord implements iExperiment {
	//public $phone;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'exp_experiments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_enter', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_enter, price, date', 'safe', 'on'=>'search'),
			array('price, theme, isMobile', 'safe'),
			array('*','unsafe','on' => 'exportParams'),
			array('price, theme, isMobile','safe','on' => 'exportParams')
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
			'enter' => array(self::BELONGS_TO, 'Enter','id_enter')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_enter' => 'Id Enter',
			'price' => 'Price',
			'date' => 'Date',
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
		$criteria->compare('id_enter',$this->id_enter);
		$criteria->compare('price',$this->price);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GlobalExperiment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @param aEnter $enter
	 */
	public function initialize(aEnter $enter = null) {
		if ($this -> getIsNewRecord()) {
			//$prices = [0.8, 0.9, 1.0];
			$prices = [1.0];
			$themes = ['mobile', ''];
			$res = browserInfoHolder::getInstance();
			$isMobile = 0;
			if ($res) {
				if ($res->isMobile()) {
					$isMobile = 1;
				}
			}
			$params = [
				'price' => $prices[array_rand($prices)],
				'theme' => $themes[array_rand($themes)],
				'isMobile' => $isMobile
				//'phone' => $enter -> getNumber() -> getShortNumberString()
			];
			$this -> attributes = $params;
			if (is_a($enter, 'aEnter')) {
				$this->id_enter = $enter->id;
			}

		}
	}
	public function getParams() {
		return $this -> getAttributes(['price','id_enter','theme','isMobile']);
	}
	public function getProperty($property) {
		return $this -> getAttributes()[$property];
	}
	public function beforeSave() {
		//Предотвращаем создание дубликатов
		if ($rec = $this -> findByAttributes(['id_enter' => $this -> id_enter])) {
			if ($rec -> id != $this -> id) {
				return false;
			}
		}
		return parent::beforeSave();
	}
}
