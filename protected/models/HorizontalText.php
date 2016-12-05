<?php

/**
 * This is the model class for table "{{horizontal_text}}".
 *
 * The followings are the available columns in table '{{horizontal_text}}':
 * @property integer $id
 * @property string $image
 * @property string $text
 * @property string $url
 * @property integer $position
 */
class HorizontalText extends RightText
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{horizontal_text}}';
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}