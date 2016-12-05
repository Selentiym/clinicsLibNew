<?php

/**
 * This is the model class for table "{{articles}}" - it describes a standard Article
 *
 * The followings are the available columns in table '{{articles}}':
 * @property integer $id
 * @property string $name
 * @property string $verbiage
 * @property integer $category
 * @property string $text
 */
 
class Articles extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{articles}}';
	}

    public function afterDelete()
	{
		parent::afterDelete();
	}
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, verbiage, category, text', 'required'),
            array('verbiage',
                'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_-]/',
                'message' => CHtml::encode('Запрещенные символы в поле <{attribute}>'),
            ),
			array('category', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('verbiage, clinic_card', 'length', 'max'=>20),
            array('menu_sublevel, title', 'length', 'max'=>255),
            array('keywords, description', 'length', 'max'=>2000),
			array('id, name, verbiage, category, menu_sublevel, text, clinic_card, title, keywords, description', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'category_' => array(self::BELONGS_TO, 'Menus',  'category', 'together' => true)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => CHtml::encode('Название'),
			'verbiage' => CHtml::encode('Человекопонятный URL'),
			'category' => CHtml::encode('Категория (пункт бокового меню)'),
            'menu_sublevel' => CHtml::encode('Уровень подменю (боковое)'),
			'text' => CHtml::encode('Текст'),
            'clinic_card' => CHtml::encode('Визитка клиники'),
            'title' => CHtml::encode('Title'),
			'keywords' => CHtml::encode('Keywords'),
			'description' => CHtml::encode('Description')            
		);
	}

    public function beforeSave()
    {   
        $criteria=new CDbCriteria;
        
        // prevent app from saving an article with existing URL
        if (!$this->isNewRecord) {
            $criteria->condition='id <> :id';
            $criteria->params = array(':id' => $this->id);             
        }
        
        // check for duplicates by URL
        $dups = self::model()->findByAttributes(array('verbiage' => $this->verbiage), $criteria);        
        
        if ($dups) {
            Yii::app()->user->setFlash('duplicateArticle', CHtml::encode('Статья с таким URL уже существует'));
            return false;                
        }              

        return parent::beforeSave();
    }
    
    // this is standard function for searching
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('verbiage',$this->verbiage,true);
		$criteria->compare('category',$this->category, true);
		$criteria->compare('text',$this->text,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('clinic_card',$this->clinic_card,true);
        $criteria->compare('keywords',$this->keywords,true);
        $criteria->compare('description',$this->description,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    // this is standard function for getting a model of the current class
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
