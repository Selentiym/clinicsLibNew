<?php

/**
 * This is the model class for table "{{triggers}}".
 *
 * The followings are the available columns in table '{{triggers}}':
 * @property integer $id
 * @property string $name
 * @property string $logo
 */
class Triggers extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{triggers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, verbiage', 'required'),
			array('name, verbiage', 'length', 'max'=>255),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('logo', 'file', 'types'=>'jpg, jpeg, gif, png', 'maxSize' => 1048576, 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, verbiage', 'safe', 'on'=>'search'),
		);
	}
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this -> isNewRecord)
			{
				if (Triggers::model() -> exists('verbiage=:verb',array(':verb' => $this -> verbiage)))
				{
					new CustomFlash('warning','Triggers','VerbiageExists','Триггер с таким латинским наименованием уже существует.', true);
					return false;
				}
				return true;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'trigger_values' => array(self::HAS_MANY, 'TriggerValues', array('trigger_id' => 'id'), 'select' => '*'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => CHtml::encode('ID'),
			'name' => CHtml::encode('Название'),
            'verbiage' => CHtml::encode('Обозначение (латинскими буквами)'),
			'logo' => CHtml::encode('Логотип'),
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
		$criteria->compare('name',$this->name,true);
        $criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('logo',$this->logo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Triggers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/* CUSTOM FUNCTIONS*/
	public function FolderKey()
	{
		return 'verbiage';
	}
	public function showValues($empty = false, $formName = 'clinicsSearchForm', $selected = false) {
		if ($empty) {
			echo "<option value=''>";
			echo $this -> name;
			echo "</option>";
		}
		foreach ($this -> trigger_values as $val) {
			$sel = '';
			if ($selected == $val -> id) {
				$sel = 'selected = "selected"';
			}
			echo "<option {$sel} value='{$val -> id}'>{$val -> value}</option>";
		} 
		Yii::app() -> getClientScript() -> registerScript("select".$this -> verbiage,"
			$('#".$this -> verbiage."Select option[value=\'".$_POST[$formName][$this -> verbiage]."\']').attr('selected','selected');
		",CClientScript::POS_END);
	}
	public function showBinary($fromPage = array(), $htmlOptions = array(), $modelName = 'clinics', $formName='SearchForm'){
		$htmlOptions['type'] = 'checkbox';
		if (!$htmlOptions['name']) {
			$htmlOptions['name'] = $modelName.$formName.'['.$this -> verbiage.']';
		}
		if (!$htmlOptions['id']) {
			$htmlOptions['id'] = $modelName.$formName.'['.$this -> verbiage.']';
		}
		$val = current($this -> trigger_values);
		if ($val) {
			if ($fromPage[$this -> verbiage] == $val -> id) {
				$htmlOptions['checked'] = 'checked';
			}
			$htmlOptions['value'] = $val -> id;
			echo CHtml::tag('input',$htmlOptions);
			echo $val -> value;
		}
	}
	/*public function generateImageFolderUrl($seed = NULL)
	{
		if (!isset($seed))
		{
			if (isset($this -> verbiage))
			{
				return Yii::app()->basePath.'/../images/triggers/' . $this -> verbiage . '/';
			} else {
				return false;
			}
		} else {
			return Yii::app()->basePath.'/../images/triggers/' . $seed . '/';
		}
	}*/
}
