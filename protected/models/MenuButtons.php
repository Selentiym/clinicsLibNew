<?php

/**
 * This is the model class for table "{{menu_buttons}}".
 *
 * The followings are the available columns in table '{{menu_buttons}}':
 * @property integer $id
 * @property integer $position
 * @property integer $level
 * @property integer $parent_id
 * @property string $name
 * @property string $url
 */
class MenuButtons extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_buttons}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, level, parent_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('url', 'length', 'max'=>255),
            /*array('url',
                'match', 'pattern' => '/^((https?|ftp)\:\/\/)?([a-z0-9]{1})((\.[a-z0-9-])|([a-z0-9-]))*\.([a-z]{2,6})(\/?)$/',
                'message' => CHtml::encode('Запрещенные символы в url'),
            ),*/
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, url, parent_id, position', 'safe'),
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
           // 'clinics' => array(self::MANY_MANY, 'clinics', 'tbl_clinics_fields(field_id, clinic_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Отображаемый текст',
			'url' => 'Адрес (baseUrl заменится на путь до главной страницы)',
			'parent_id' => 'ID родительского элемента',
			'level' => 'Уровень вложенности',
			'position' => 'Положение в меню (чем больше, тем дальше от начала)'
		);
	}
	/**
	 * @arg CDbCriteria criteria - criteria object for the menuButtons
	 * @return array - an array of items with structure 'text' => text to be displayed
	 * 'url' => url of the menu item
	 */
	public function PrepareFooterMenu($criteria = NULL) 
	{
		if (!is_a($criteria, 'CDbCriteria')) {
			$criteria = new CDbCriteria;
		}
		$models = $this -> findAll($criteria);
		$array = array();
		foreach ($models as $model)
		{
			if (!($model -> url)){
				continue;
			}
			$item['url'] = str_replace('baseUrl', Yii::app() -> baseUrl, $model -> url);
			$item['text'] = $model -> name;
			$array[] = $item;
		}
		return $array;
	}
    /*public function beforeSave()
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
    } */   
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
		$criteria->compare('url',$this->url);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * @return array of levels for menu objects (max existing level + 1)
	 */
	public function getLevelArray()
	{
		$command = Yii::app()->db->createCommand('SELECT MAX(`level`) FROM '.$this -> tableName());
		$max_level = $command -> queryScalar();
		$levelArray[0] = 'Корневой пункт меню';
		for ($i = 1; $i <= $max_level + 1; $i++)
		{
			$levelArray[$i] = $i;
		}
		return $levelArray;
	}
	
	/**
	 * @return an array that is suitable for tbnavbar bootstrap widget (see views/home/_top_menu.php)
	 */
	//generates JSON object with article ids of given level
	public function GenerateParentList($level)
	{
		if ($level==-1)
		{
			return CJSON::encode(array(  
				'no'=>true,
			)); 
		} else {
			$criteria = new CDbCriteria;
			
			$criteria -> select = 'id, name';
			$criteria -> condition = 'level=:lev';
			$criteria -> order = 'parent_id ASC';
			$criteria -> params = array(':lev' => $level);
			$parentList = CHtml::listData($this->findAll($criteria),'id','name');
			//$parentList = Articles::model()->findAll($criteria);
			$ret = '';
			foreach ($parentList as $id => $name)
			{
				$ret .= CHtml::tag('option', array('value' => $id), CHtml::encode($name));
			}
			return CJSON::encode(array('parentList' => $ret));
		}
	}
	/**
	 * @return an array that is suitable for tbnavbar bootstrap widget (see views/home/_top_menu.php)
	 */
	 
	public function DisplayArray()
	{
		$display_arr = array('label' => $this -> name);
		if ($this -> url) {
			$display_arr['url'] = str_replace('baseUrl', Yii::app() -> baseUrl, $this -> url);
		}
		$criteria=new CDbCriteria;
		$criteria -> compare('parent_id', $this -> id);
		$criteria -> order = 'position ASC';
		$children = $this -> findAll($criteria);
		if ($children) {
			$items = array();
			foreach ($children as $child) {
				$items[] = $child -> DisplayArray();
			}
			$display_arr['items'] = $items;
		}
		return $display_arr;
	}
	public function giveMenu()
	{
		$criteria = new CDbCriteria;
		$criteria -> compare('level', 0);
		$criteria -> compare('parent_id', 0);
		$criteria -> order = 'position ASC';
		$top_items = $this -> findAll($criteria);
		$menu = array();
		foreach ($top_items as $item)
		{
			$menu[] = $item -> DisplayArray();
		}
		return $menu;
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
