<?php

/**
 * This is the model class for table "ct_number".
 *
 * The followings are the available columns in table 'ct_number':
 * @property integer $id
 * @property string $number
 * @property string $short_number
 * @property integer $reserved
 *
 * The followings are the available model relations:
 * @property Enter[] $enters
 * @property Enter $lastActiveNotCalledEnter
 * @property Enter $lastActiveEnter
 * @property TCall[] $tCalls
 */
class phNumber extends aNumber
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ct_number';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, number, short_number, reserved', 'required'),
			array('id, reserved', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, short_number, reserved', 'safe', 'on'=>'search'),
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
			'enters' => array(self::HAS_MANY, 'Enter', 'id_num'),
			'lastActiveNotCalledEnter' => array(self::HAS_ONE, 'Enter', 'id_num','condition' => 'active = 1 AND called = 0','order' => 'created DESC'),
			'lastActiveEnter' => array(self::HAS_ONE, 'Enter', 'id_num','condition' => 'active = 1','order' => 'created DESC'),
			'occupied' => array(self::STAT, 'Enter', 'id_num','condition' => 'active = 0'),
			'tCalls' => array(self::HAS_MANY, 'TCall', 'id_num'),
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
			'short_number' => 'Short Number',
			'reserved' => 'Reserved',
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
		$criteria->compare('short_number',$this->short_number,true);
		$criteria->compare('reserved',$this->reserved);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return phNumber the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return phNumber[] номера, на которые записаны в настоящий момент меньше всего человек.
	 * Визит считается завершенным, если called = 1 или active = 0
     */
	public static function freestNumbers() {
		//Сначала ищем истинно свободные номера, тк для них не работает дальнейший скрипт
		//TODO: find free numbers
		$freestSql =
				"
				SELECT
					`id`
				FROM
					`ct_number` as `n`
				WHERE
					(SELECT
						`id`
					FROM
						`ct_enter` as `e`
					WHERE
						`e`.`id_num`=`n`.`id`
						AND `e`.`active` = '1'
					LIMIT 1
					) IS NULL
					AND `n`.`reserved` = '0'
				";
		$ids = Yii::app() -> db -> createCommand($freestSql) -> queryColumn();
		if (count($ids) == 0) {
			//Пришлось сделать вот так вот криво, потому что как ни крути, а придется в mysql
			//два раза эту таблицу получать. Но ведь возможны изменения, поэтому чтобы их два раза
			//не вносить, вытащил сюда.
			$ctDefinition = "
			SELECT
				`n`.`id` AS `id`,
				COUNT(`e`.`id`) AS `c`
			FROM
				`ct_number` AS `n`,
				`ct_enter` AS `e`
			WHERE
				`e`.`id_num` = `n`.`id`
				AND `e`.`active` = 1
				AND `e`.`called` = 0
				AND `n`.`reserved` <> 1
			GROUP BY `n`.`id`
			";
			$ctDefinition = "(" . $ctDefinition . ") as `ct`";
			$sql = "
			Select
				*
			FROM
				$ctDefinition
			WHERE
				`ct`.`c` = (
					SELECT
						MIN(`ct`.`c`)
					FROM
						$ctDefinition
				)
				OR `ct`.`c` IS NULL
			";
			$rez = Yii::app()->db->createCommand($sql)->queryColumn();
			$ids = array_map(function ($r) {
				return $r[0];
			}, $rez);
		}
		//var_dump($ids);
		$numbers = phNumber::model() -> findAllByPk($ids);
		return $numbers;
	}

	public function getNumberString() {
		return $this -> number;
	}
	public function getShortNumberString() {
		return $this -> short_number;
	}

	/**
	 * @param CDbCriteria|NULL $criteria
	 * @return Enter last user entry
	 */
	public function lastEnter(CDbCriteria $criteria = NULL) {
		if (!$criteria) {
			$criteria = new CDbCriteria();
			$criteria -> compare('active', '1');
			$criteria -> compare('called', '0');
		}
		$criteria -> compare('id_num', $this -> id);
		$criteria -> addCondition('`created` = (SELECT MAX(`created`) FROM '.$this -> tableName().')');
		return Enter::model() -> find();
	}

	/**
	 * @param self[] $numbers
	 * @return phNumber|null
	 */
	public static function selectLongest(array $numbers) {
		$best = NULL;
		if (count($numbers)) {
			$best = array_reduce($numbers, function($carry, $i) {
				$enter = $i -> lastEnter();
				$time = 0;
				if (is_a($enter, 'Enter')) {
					$time = strtotime($enter -> created);
				}
				if ((!$carry['obj'])||(($time < $carry['time']))) {
					return ['obj' => $i, 'time' => $time];
				}
				return $carry;
			}, [])['obj'];
		}
		return $best;
	}

	/**
	 * @return self[]
	 */
	public static function getReserved() {
		return self::model() -> reserved() -> findAll();
	}

	public static function Sum($a, $b){
		return $a + $b;
	}
	public function scopes() {
	return  [
		'reserved' => [
			'condition' => 'reserved = 1'
		]
	];
	}
}
