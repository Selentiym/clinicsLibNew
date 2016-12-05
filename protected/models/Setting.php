<?php

/**
 * This is the model class for table "{{settings}}" - it describes a standard Article
 *
 * The followings are the available columns in table '{{settings}}':
 * @property integer $id
 * @property boolean $show_objects
 * @property string $main_text
 * @property string $footer_text
 */
 
class Setting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('show_objects', 'required'),
			array('show_objects', 'numerical', 'integerOnly'=>true),
			array('show_objects, main_text, footer_text', 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'show_objects' => 'Показывать ли под статьей карточки клиник',
			'main_text' => 'Текстовое поле на главной странице',
			'footer_text' => 'Текстовое в подваля страницы'
		);
	}
    // this is standard function for getting a model of the current class
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
