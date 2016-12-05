<?php

/**
 * This is the model class for table "{{right_text}}".
 *
 * The followings are the available columns in table '{{right_text}}':
 * @property integer $id
 * @property string $image
 * @property string $text
 * @property string $url
 * @property integer $position
 */
class RightText extends CTModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{right_text}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('image', 'length', 'max'=>512),
			array('url', 'length', 'max'=>1024),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, text, url, position', 'safe'),
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
			'image' => 'Картинка',
			'text' => 'Текст объекта',
			'url' => 'Ссылка на объекте',
			'position' => 'Положение (чем больше, тем дальше от начала)'
		);
	}
	public function giveShortDescr()
	{
		return substr(strip_tags(substr($this -> text, 0, 50)), 0, 10);
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function FolderKey()
	{
		return 'id';
	}
	public function FileOperations($model, $files_arr) 
	{
		if ($model -> FolderKey() == 'id') {
			if (!$model -> id) {
				unset($model -> image);
				$model -> save();
			}
		}
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		if (!file_exists($images_filePath))
		{
			mkdir($images_filePath);
		}
		if(!empty($files_arr[get_class($model)]['name']['image'])){
			$image_old = $model->image;
			$model->image = CUploadedFile::getInstance($model,'image');
			$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->image->extensionName;
			$fileName = $images_filePath . $image_unique_id;
			//echo $fileName;
			if ($model->validate()) {
				$model->image->saveAs($fileName);
				$model->image = $image_unique_id;
				if (strlen($image_old) > 0) @unlink ($images_filePath. DIRECTORY_SEPARATOR .$image_old);
			}
			else
				$model->image = $image_old;
		}
	}
	/**
	 * @return array - view array for rightText
	 */
	public function giveViewInfo()
	{
		$view['image_url'] = $this -> giveImageFolderRelativeUrl().'/'.$this -> image;
		$view['url'] = str_replace('baseUrl', Yii::app() -> baseUrl, $this -> url);
		$view['text'] =  $this -> text;
		return $view;
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RightText the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
