<?php

/**
 * This is the model class for table "clnc_rules".
 *
 * The followings are the available columns in table 'clnc_rules':
 * @property integer $id
 * @property string $word
 * @property integer $id_type
 * @property integer $id_obj
 * @property integer $prior
 */
class ClinicRule extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clnc_rules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('word, id_obj', 'required'),
			array('id_type, id_obj', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, word, id_type, id_obj', 'safe', 'on'=>'search'),
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
			'word' => 'Word',
			'id_type' => 'Id Type',
			'id_obj' => 'Id Obj',
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
		$criteria->compare('word',$this->word,true);
		$criteria->compare('id_type',$this->id_type);
		$criteria->compare('id_obj',$this->id_obj);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClinicRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @arg string $string - a string that may or may not subject to this rule
	 * @return bool whether the string corresponds to the rule.
	 */
	public function check($string){
		return preg_match('/'.$this -> word.'/iu',$string);
	}

	/**
	 * @param string $term
	 * @return clinics|null
	 */
	public static function selectClinic($term = '') {
		foreach (self::getRules() as $rule) {
			if ($rule -> check($term)) {
				$r = clinics::model() -> findByPk($rule -> id_obj);
				if ($r) {
					return $r;
				}
			}
		}
		return null;
	}

	/**
	 * @param CDbCriteria $cond
	 * @return ClinicRule[]
	 */
	public static function getRules(CDbCriteria $cond = null) {
		if (!$cond) {
			$cond = new CDbCriteria();
		}
		return ClinicRule::model() -> findAll($cond);
	}
}
