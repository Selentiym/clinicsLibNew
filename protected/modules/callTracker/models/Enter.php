<?php

/**
 * This is the model class for table "ct_enter".
 *
 * The followings are the available columns in table 'ct_enter':
 * @property integer $id
 * @property integer $id_num
 * @property string $utm_term
 * @property string $created
 * @property integer $last_request
 * @property integer $active
 * @property integer $called
 * @property integer $linked
 *
 * The followings are the available model relations:
 * @property phNumber $number
 * @property TCall[] $tCalls
 */
class Enter extends aEnter
{
	/**
	 * @var phNumber|null
	 */
	private $_cachedNumber;
	const NUMBER_CLASS = 'phNumber';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ct_enter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_num', 'required'),
			array('id, id_num, last_request, active', 'numerical', 'integerOnly'=>true),
			array('*', 'unsafe'),
			array('utm_term', 'safe', 'on'=>'fromRequest'),
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
			'number' => array(self::BELONGS_TO, self::NUMBER_CLASS, 'id_num'),
			'tCalls' => array(self::HAS_MANY, 'TCall', 'id_enter'),
			'experiment' => array(self::HAS_ONE, 'GlobalExperiment','id_enter')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_num' => 'Id Num',
			'utm_term' => 'Utm Term',
			'created' => 'Created',
			'last_request' => 'Last Request',
			'active' => 'Active',
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
		$criteria->compare('id_num',$this->id_num);
		$criteria->compare('utm_term',$this->utm_term,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_request',$this->last_request);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Enter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function scopes() {
		return [
			'reserved' => [
				'condition' => 'reserved = 1'
			]
		];
	}

	protected function beforeSave() {
		//Ради того, чтобы всегда в базе хранилось php-шное время!
		if ($this -> getIsNewRecord()) {
			$this -> created = date('Y-m-d H:i:s',time());
		}
		//Сохраняем новый номер
		if (is_a($this -> _cachedNumber, self::NUMBER_CLASS)) {
			$this -> id_num = $this -> _cachedNumber -> id;
			if (!$this -> _cachedNumber) {
				$this -> id_num = new CDbExpression('null');
			}
		}

		//Запомнаем время последнего взаимодействия
		$this -> last_request = time();

		return parent::beforeSave();
	}

	/**
	 * //В общем случае будет self::NUMBER_CLASS
	 * @return aNumber
	 */
	public function obtainNumber() {

		if (!$this -> needsNumber()) {
			return $this -> getNumber();
		}

		$numModel = call_user_func([self::NUMBER_CLASS, 'model']);
		//Выбрали самые свободные номера
		$candidates = call_user_func([self::NUMBER_CLASS, 'freestNumbers']);
		//Из них берем самый долго лежащий без дела.
		$rez = call_user_func([self::NUMBER_CLASS, 'selectLongest'],$candidates);
		//Если не нашлось, выбираем из резервных
		if (!(is_a($rez, self::NUMBER_CLASS))) {
			$rez = call_user_func([self::NUMBER_CLASS, 'selectLongest'],$numModel -> getReserved());
		}
		if (is_a($rez, self::NUMBER_CLASS)) {
			$this->id_num = $rez->id;

			$this->setNumber($rez);
		}

		return $rez;
	}

	/**
	 * @return bool
	 */
	private function needsNumber() {
		//Чтобы корректно обрабатывался случай unset number.
		if (is_a($this -> getNumber(), self::NUMBER_CLASS)) {
			return !$this -> id;
		}
		return true;
	}

	/**
	 * Устанавливаем значения атрибутов в соответствии с адресом.
	 * @return aEnter
	 */
	public function collectDataFromRequest() {
		$temp = parent::collectDataFromRequest();
		$temp -> setScenario('fromRequest');
		if (!strlen($_REQUEST['utm_term'])) {
			unset ($_REQUEST['utm_term']);
		}
		//Насколько я помню, от присовения request я ушел, тк там передавалась левая информация,
		//которая мешала работе. Поэтому оба глобальных массива юзаю. Реально присвоятся только
		//те ключи, когда задан элемент.
		$term = $_GET["utm_term"];
		if ($term) {
			$temp->utm_term = $term;
		}
		//Можно даже так
		//$temp -> attributes = $_GET;
		return $temp;
	}
	public function getNumber() {
		if (is_a($this -> _cachedNumber, self::NUMBER_CLASS)) {
			return $this -> _cachedNumber;
		}
		return $this -> number;
	}
	public function setNumber(aNumber $val) {
		if (is_a($val, self::NUMBER_CLASS)) {
			$this->_cachedNumber = $val;
		}
	}

	public function unsetNumber() {
		$this -> setNumber(new phNumber);
	}
	public function endOneself() {
		//Меняем статус захода.
		$this -> active = 0;
		echo "Ended: $this->id<br/>";
		return $this -> save();
	}
	public function giveUnfinished() {
		$crit = new CDbCriteria();
		$crit -> compare('active', '1');
		return static::model() -> findAll($crit);
	}
	public function checkTimeValidity() {
		$delta = time() - $this -> last_request;
		return !((($delta) > CallTrackerModule::requestDelay / 1000 * CallTrackerModule::delayTimesTillGarbage)&&($this -> last_request > 10));
	}
	public function linkApiCall(iApiCall $apiCall) {
		$this -> markAsSuccessful();
		$this -> save();
	}
	public function markAsSuccessful() {
		$this -> called = 1;
	}

	/**
	 * Возвращаем объект, который содержит в себе данные по экспериментам.
	 * @return iExperiment|null
	 */
	public function getExperiment() {
		return ExperimentFactory::getInstance() -> build($this);
	}
}
