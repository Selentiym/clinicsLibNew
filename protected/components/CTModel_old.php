<?php
 class CTModel extends CActiveRecord {
    
    // reset autoincrement     
    protected function afterDelete() {
        parent::afterDelete();   
        resetId($this);
    }
	public function showImage($name, $class = '')
	{
		echo CHtml::image($this -> giveImageFolderRelativeUrl() . $name, $name, array('class' => $class ));
	}
	public function giveFileFolderAbsoluteUrl($seed = NULL, $fileClass = NULL)
	{
		return Yii::getPathOfAlias('webroot') . $this -> giveFileFolderRelativeUrl($seed, $fileClass);
	}
	public function giveFileFolderRelativeUrl($seed = NULL, $fileClass = NULL)
	{
		if ((isset($fileClass))&&(strlen($fileClass)>0))
		{
			$d = '/';
			//$d = DIRECTORY_SEPARATOR;
			if (!isset($seed))
			{
				$attr_name = $this -> FolderKey();
				if (isset($this -> $attr_name))
				{
					//return $d.'..'.$d. $fileClass .$d. get_class($this) .$d . $this -> $attr_name . $d;
					//return Yii::app() -> baseUrl . $d . $fileClass .$d. get_class($this) .$d . $this -> $attr_name . $d;
					return $d . $fileClass .$d. get_class($this) .$d . $this -> $attr_name . $d;
				} else {
					return false;
				}
			} else {
				return $d . $fileClass .$d. get_class($this) .$d . $seed . $d;
				//return realpath(Yii::app() -> basePath.'/../').$d.'images'.$d. get_class($this) .$d . $seed . $d;
			}
		} else return false;
	}
	//Функция, которая создает название папки, в которую сохраняются картинки для конкретной модели
	public function giveImageFolderAbsoluteUrl($seed = NULL)
	{
		return $this -> giveFileFolderAbsoluteUrl($seed, 'images');
	}
	public function giveImageFolderRelativeUrl($seed = NULL)
	{
		return $this -> giveFileFolderRelativeUrl($seed, 'images');
	}
	/*public function giveImageFolderRelativeUrl($seed = NULL)
	{
		$d = DIRECTORY_SEPARATOR;
		if (!isset($seed))
		{
			$attr_name = $this -> FolderKey();
			if (isset($this -> $attr_name))
			{
				return $d.'..'.$d.'images'.$d. get_class($this) .$d . $this -> $attr_name . $d;
				//return realpath(Yii::app() -> basePath.'/../').$d.'images'.$d. get_class($this) .$d . $this -> $attr_name . $d;
			} else {
				return false;
			}
		} else {
			return Yii::getPathOfAlias('webroot').'images'. $d . get_class($this) . $d . $seed . $d;
			//return realpath(Yii::app() -> basePath.'/../').$d.'images'.$d. get_class($this) .$d . $seed . $d;

		}
	}*/
	//определяет какой атрибут является названием папки. Необходимо, чтобы он не повторялся, иначе плохо.
	//Переопределить в дочерних классах.
	public function FolderKey()
	{
		return 'id';
	}
	//Удаляем все изображения и другие файлы, связанные с этой моделью, прямо перед удалением записи в БД.
	protected function beforeDelete(){
		if (parent::beforeDelete()) {
			$image_folder = $this -> giveImageFolderAbsoluteUrl();
			if (file_exists($image_folder))
			{
				DirRemover::removeDirectory($image_folder);
			}
			$file_folder = $this -> giveFileFolderAbsoluteUrl(NULL, 'file');
			if (file_exists($file_folder))
			{
				DirRemover::removeDirectory($file_folder);
			}
			return true;
		} else return false;
	}
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			//Хочется переименовать папку с файлами, если изменяется атрибут, который является ключом для названия папок. 
			//(он определен в каждом наследнике этого класса в методе FolderKey())
			//new CustomFlash('warning',get_class($this),'RenameFolder', 'check', true);
			if (!$this -> isNewRecord)
			{
				$old_model = $this -> model() -> findByPk($this -> id);//Вместо id хотелось бы поставить что-то, что автоматически выдает название PK.
				$attr = $this -> FolderKey();
				//echo $this -> $attr."<br/>".$old_model -> $attr;
				//new CustomFlash('warning',get_class($this),'RenameFolder', $this -> $attr."<br/>".$old_model -> $attr, true);
				if ($this -> $attr != $old_model -> $attr)
				{
					$image_folder_new = $this -> giveImageFolderAbsoluteUrl();
					$image_folder_old = $old_model -> giveImageFolderAbsoluteUrl();
					$file_folder_new = $this -> giveFileFolderAbsoluteUrl(NULL, 'file');
					$file_folder_old = $old_model -> giveFileFolderAbsoluteUrl(NULL, 'file');
					$img_check = true;
					$file_check = true;
					if (file_exists($image_folder_old))
						$img_check = rename($image_folder_old, $image_folder_new);
					if (file_exists($file_folder_old))
						$file_check = rename($file_folder_old, $file_folder_new);
					return $img_check && $file_check;
				//return ((rename($image_folder_old, $image_folder_new))&&(rename($file_folder_old, $file_folder_new)));
				}
			}
			return true;
		} else {
			return false;
		}
	}
 } 