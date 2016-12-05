<?php

/**
 * This is the model class for table "ct_tCall".
 *
 * The followings are the available columns in table 'ct_tCall':
 * @property integer $id
 * @property string $number
 * @property integer $id_num
 * @property integer $id_enter
 *
 * время поступления звонка
 * @property string $called
 * @property integer $status
 * @property string $CallID
 * @property string $CallerIDNum
 * @property string $CallAPIID
 * @property string $_error
 *
 *
 * The followings are the available model relations:
 * @property Enter $idEnter
 * @property phNumber $idNum
 */
class TCall extends aApiCall
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ct_tCall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_num, id_enter, status', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, id_num, id_enter, called, status', 'safe', 'on'=>'search'),
			array('CallAPIID, CallerIDNum, CallID', 'safe', 'on'=>'setData'),
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
			'enter' => array(self::BELONGS_TO, 'Enter', 'id_enter'),
			'number' => array(self::BELONGS_TO, 'phNumber', 'id_num'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'number' => 'phNumber',
			'id_num' => 'Id Num',
			'id_enter' => 'Id Enter',
			'called' => 'Called',
			'status' => 'Status',
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
		$criteria->compare('number',$this->number,true);
		$criteria->compare('id_num',$this->id_num);
		$criteria->compare('id_enter',$this->id_enter);
		$criteria->compare('called',$this->called,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TCall the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function setData($data){
		$rez = $this;
		if ($data['CallFlow']=='in') {
			$this->setScenario('setData');
			$this->attributes = $data;
			//Заменяем все не числа нафиг на пустоту
			$this -> number = preg_replace('/[^\d]/','',$data['CalledDID']);
			if (strlen($this -> number < 7)) {
				$this -> error ('Number is too short');
			}
		} else {
			$this -> error ('destination != "in"');
		}
		/*
		 * CallID
		 * CallerIDNum
		 * CalledDID <=> number
		 * CallAPIID
		array(9) {
			["CallID"]=>
			  string(18) "1479144949.4665265"
			  ["CallerIDNum"]=>
			  string(12) "+79523660187"
			  ["CallerIDName"]=>
			  string(11) "79523660187"
			  ["CalledDID"]=>
			  string(11) "78126271521"
			  ["CalledExtension"]=>
			  string(9) "13298*001"
			  ["CallStatus"]=>
			  string(7) "CALLING"
			  ["CallFlow"]=>
			  string(2) "in"
			  ["CallerExtension"]=>
			  string(0) ""
			  ["CallAPIID"]=>
			  string(20) "ystbaxji6g4vnts3wted"
			}
		*/
		return $rez;
	}

	/**
	 * @return aEnter|null
	 */
	public function lookForEnter() {

		//Ищем номер
		$shortNumber = substr($this -> number, -7);
		$number = false;
		if (strlen($shortNumber) > 0) {
			$number = phNumber::model()->findByAttributes(['short_number' => $shortNumber]);
		}
		$enter = null;
		//Если номер нашелся, запоминаем это и ищем заход
		if (is_a($number, 'phNumber')) {
			/**
			 * @type phNumber $number
			 */
			$this->id_num = $number->id;
			$enter = $number->lastActiveNotCalledEnter;
			if (!is_a($enter, 'aEnter')) {
				$enter = null;
				$this -> error('No active NOT CALLED enter object found');
			}
			//Если не нашелся пока заход, то ищем его также среди уже обзвоненных
			//Просто ради интереса
			if (!is_a($enter, 'aEnter')) {
				$enter = $number -> lastActiveEnter;
				if (!is_a($enter, 'aEnter')) {
					$enter = null;
					$this -> error('No active enter object found');
				}
			}
			if ($enter -> called) {
				$this -> error('Found enter has been called');
			}
		} else {
			$this -> error('phNumber model not found by shortNumber '.$shortNumber.'.');
		}
		return $enter;
	}

	/**
	 * @param string $text
	 */
	public function error($text) {
		$this -> _error .= $text.'<br/>'.PHP_EOL;
	}

	/**
	 * @param aEnter $enter
	 */
	public function linkEnter(aEnter $enter) {
		$this -> id_enter = $enter -> getPrimaryKey();
		if (!$this -> save()) {
			$err = $this -> getErrors();
		}
	}
	public function beforeSave() {
		//Сохраняем время поступления звонка, специально так,
		// чтобы время всегда было серверное
		if ($this -> getIsNewRecord()) {
			$this -> called = date('Y-m-d H:i:s',time());
		}
		return parent::beforeSave();
	}
}
