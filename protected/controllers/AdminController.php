<?php

class AdminController extends Controller
{
	public $defaultAction = 'login';
	public $layout='//layouts/admin';
    public $pageTitle;
	//list of prices to export
	public $clinicsPrices = array(
		'price' => 'Цена',
		'price2' => 'Цена1'
	);
	//list of prices to export
	public $doctorsPrices = array(
		
	);
	//Базовые поля для экспорта.
	public $clinicsFields = Array(
			'name' => 'Название',
			'site' => 'Сайт',
			'verbiage' => 'Урл',
			'logo' => 'Логотип',
			'city' => 'Город',
			'address' => 'Адрес',
			'district' => 'Район',
			'metro_station' => 'Метро',
			'phone' => 'Телефон',
			'phone_extra' => 'Дополнительный телефон',
			'email' => 'Электронная почта',
			'working_hours' => 'Часы работы',
			'triggers' => 'Триггеры',
			'description' => 'мета-тег description',
			'keywords' => 'мета-тег keywords'
	);
	//Базовые поля для экспорта.
	public $doctorsFields = Array(
			'name' => 'Название',
			'site' => 'Сайт',
			'verbiage' => 'Урл',
			'logo' => 'Логотип',
			'city' => 'Город',
			'address' => 'Адрес',
			'district' => 'Район',
			'metro_station' => 'Метро',
			'phone' => 'Телефон',
			'phone_extra' => 'Дополнительный телефон',
			'email' => 'Электронная почта',
			'working_hours' => 'Часы работы',
			'triggers' => 'Триггеры',
			'description' => 'мета-тег description',
			'keywords' => 'мета-тег keywords'
	);
	
	private $_model;
     
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    
    
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                  'actions'=>array('login'),
                  'users'=> array('*')
			),
            array('allow',
                      //'actions'=>array('index', 'view', 'clinics', 'triggers', 'banners', 'articles', 'comments', 'menus', 'logout'),
                      'expression'=> 'Yii::app()->controller->isSuperAdmin()',
                      //'users'=> array('*')
            ),
            array('allow',
                    'actions' => array('logout', 'clinicUpdate'),
                    'expression'=>'Yii::app()->controller->isClinicAdmin()',
                    //'users' => array('*')
            ),            
            array('deny',  // deny all users
                  'users'=>array('*'),
            ),
            
        );

	}   

    public function isSuperAdmin()
    {
        $user = User::model()->findbyPk(Yii::app()->user->id);
         
        if ($user) {
            if ($user->superuser != 1)
                return false;
            else
                return true;                        
        }
        return false;        
    }

    public function isClinicAdmin()
    {
        $user = User::model()->findbyPk(Yii::app()->user->id); //var_dump($user->clinic_id); die();
        if ($user) {
            if ($user->clinic_id)
                return $user->clinic_id;
            else
                return false;
        }
        return false;    
    }
    
    /**
     * Displays Login page.
     */
    public function actionLogin()
    {  
        if ($this->isSuperAdmin())
            $this->redirectHome();

        if ($this->isClinicAdmin())
            $this->redirect(array('admin/clinicUpdate/'. $this->isClinicAdmin()));
            
        $this->layout='admin_login';
        $this->pageTitle = Yii::app()->name . ' - Админка Логин';
        
        $model=new LoginForm;

        //print (Yii::app()->controller->isAdmin());
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()) {           
                if ($this->isSuperAdmin())
                    $this->redirectHome();

                if ($this->isClinicAdmin())
                    $this->redirect(array('admin/clinicUpdate/'. $this->isClinicAdmin()));
                
           }            
        }

        $this->render('login',array('model'=>$model));

    }
	public function actionImageUpload() {
		/*******************************************************
		* Only these origins will be allowed to upload images *
		******************************************************/
		$accepted_origins = array("http://localhost", "http://192.168.1.1", "http://cq97848.tmweb.ru");

		/*********************************************
		* Change this line to set the upload folder *
		*********************************************/
		$imageFolder = "http://localhost/test/public_html/files/tinymce/source/";

		reset ($_FILES);
		$temp = current($_FILES);
		if (is_uploaded_file($temp['tmp_name'])){
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// same-origin requests won't set an origin. If the origin is set, it must be valid.
				if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
					header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
				} else {
					header("HTTP/1.0 403 Origin Denied");
					return;
				}
			}
				
			/*
				If your script needs to receive cookies, set images_upload_credentials : true in
				the configuration and enable the following two headers.
			*/
			// header('Access-Control-Allow-Credentials: true');
			// header('P3P: CP="There is no P3P policy."');

			// Sanitize input
			if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
				header("HTTP/1.0 500 Invalid file name.");
				return;
			}

			// Verify extension
			if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
				header("HTTP/1.0 500 Invalid extension.");
				return;
			}

			// Accept upload if there was no origin, or if it is an accepted origin
			$filetowrite = $imageFolder . $temp['name'];
			move_uploaded_file($temp['tmp_name'], $filetowrite);

			// Respond to the successful upload with JSON.
			// Use a location key to specify the path to the saved image resource.
			// { location : '/your/uploaded/image/file'}
			echo json_encode(array('location' => $filetowrite));
		} else {
			// Notify editor that the upload failed
			header("HTTP/1.0 500 Server Error");
		}
	}
    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createUrl('admin'));
    }
	public function actionSettings(){
		$model = Setting::model() -> find();
		if (isset($_POST["Setting"])) {
			$model -> attributes = $_POST["Setting"];
			if ($model -> save()){
				new CustomFlash('success', 'Setting','Saved','Изменения успешно сохранены!',true);
			}
		}
		$crit = new CDbCriteria();
		$crit -> order = 'position ASC';
		$texts = RightText::model() -> findAll($crit);
		$horTexts = HorizontalText::model() -> findAll($crit);
		
		$this -> render('settings', array(
			'model' => $model,
			'texts' => CHtml::listData($texts, 'id', function ($text) { return $text -> giveShortDescr(); }),
			'horTexts' => CHtml::listData($horTexts, 'id', function ($text) { return $text -> giveShortDescr(); })
		));
	}
	
	/**
	 * RightText Block. action to create, update and delete RightText Objects.
	 */
	 
	public function actionRightTextsCreate()
	{
		$this -> TextsCreate('RightText');
	}
	public function actionHorizontalTextsCreate()
	{
		$this -> TextsCreate('HorizontalText');
	}
	public function TextsCreate($modelName)
	{
		$model=new $modelName('search');
		//print_r($_FILES);
		if(isset($_POST[$modelName]))
		{
			$model->attributes=$_POST[$modelName];
			//Обрабатываем картинку.
			$model -> FileOperations($model, $_FILES);
			
			if($model->validate())
			{
				$model -> save();
				$this->redirect(array('/admin/settings'));
			}
		}
		$this->render('//admin/Texts/_form',array('model'=>$model));
	}
	public function actionRightTextsUpdate($id)
	{
		$this -> TextsUpdate($id, 'RightText');
	}
	public function actionHorizontalTextsUpdate($id)
	{
		$this -> TextsUpdate($id, 'HorizontalText');
	}
	public function TextsUpdate($id, $modelName)
	{
		$model=$modelName::model() -> findByPk($id);

		if(isset($_POST[$modelName]))
		{
			$model->attributes=$_POST[$modelName];
			//print_r($_FILES);
			$model -> FileOperations($model, $_FILES);
			if($model->validate())
			{
				$model -> save();
				$this->redirect(array('/admin/settings'));
			}
		}
		$this->render('//admin/Texts/_form',array('model'=>$model));
	}
	public function actionRightTextsDelete($id)
	{
		$this -> TextsDelete($id, 'RightText');
	}
	public function actionHorizontalTextsDelete($id)
	{
		$this -> TextsDelete($id, 'HorizontalText');
	}
	public function TextsDelete($id, $modelName)
	{
		$model=$modelName::model() -> findByPk($id);
		$model -> delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin/settings'));
		$this->render('//admin/Texts/_form',array('model'=>$model));
	}
    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        //if (Yii::app()->controller->isAdmin()) print 'yes'; else print 'no';
        //var_dump(Yii::app()->controller->isAdmin()); //die();
        //$model = $this->loadModel();
        $this->render('view', array(
            //'model'=>$model,
        ));
    }

    public function actionBanners()
    {   
        // top banner
      
        $top_banner = Options::model()->findByAttributes(array('name' => 'top_banner'));
        $side_banner = Options::model()->findByAttributes(array('name' => 'side_banner'));

                $end = function($c) use($top_banner, $side_banner) {$c->render('banners',array(
                   'top_banner'=> $top_banner,
                   'side_banner'=> $side_banner)
               );};
    
        $allowed =  array('gif','png','jpg', 'jpeg');

        if (isset($_FILES['top_banner'])){ 
            if (trim($_FILES['top_banner']['name']) != '') {
                $top_banner_old = $top_banner->value;
                $filename = $_FILES['top_banner']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);   
                if(!in_array($ext,$allowed) ) {
                    Yii::app()->user->setFlash('errorUploadTop', 'Недопустимый формат файла для верхнего баннера');
                    $end($this);
                    return;
                }  
                      
                $top_banner_filePath = Yii::app()->basePath . '/../images/banners/' . basename($_FILES['top_banner']['name']);
        
                if (move_uploaded_file($_FILES['top_banner']['tmp_name'], $top_banner_filePath)) {
                    $top_banner->value = $_FILES['top_banner']['name'];
                    if ($top_banner->save())
                        Yii::app()->user->setFlash('successfullUploadTop', 'Файл для верхнего баннера успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUploadTop', 'При загрузке файла для верхнего баннера произошла ошибка');
                }
        
                if (!file_exists($top_banner_filePath)) {
                    Yii::app()->user->setFlash('nothingToUploadTop', 'Файл для загрузки не найден (верхний баннер)');
                    $end($this);
                    return;
                }
            }      
        }
                
        if (isset($_FILES['side_banner'])){ 
            if (trim($_FILES['side_banner']['name']) != '') {

                $filename = $_FILES['side_banner']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!in_array($ext,$allowed) ) {
                    Yii::app()->user->setFlash('errorUploadSide', 'Недопустимый формат файла для бокового баннера');
                    $end($this);
                    return;
                }  
                      
                $side_banner_filePath = Yii::app()->basePath.'/../images/banners/' . basename($_FILES['side_banner']['name']);

                if (move_uploaded_file($_FILES['side_banner']['tmp_name'], $side_banner_filePath)) {
                    $side_banner->value = $_FILES['side_banner']['name'];
                    if ($side_banner->save())
                        Yii::app()->user->setFlash('successfullUploadSide', 'Файл для бокового баннера успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUploadSide', 'При загрузке файла для бокового баннера произошла ошибка');
                }
        
                if (!file_exists($side_banner_filePath)) {
                    Yii::app()->user->setFlash('nothingToUploadSide', 'Файл для загрузки не найден (боковой баннер)');
                    $end;
                    return;
                }  
            }    
        }                
       
       $end($this);
    }

    public function actionMenus() 
    {   
        $model = new Menus;

        $this->render('menus_list',
                array('model' => $model)
        );
    }

    public function actionmenuCreate()
    {
        $model = new Menus;
        
        if(isset($_POST['Menus']))
        {
            $model->attributes=$_POST['Menus'];
            if($model->save())
                $this->redirect(array('/admin/menus'));
        }

        $this->render('//menus/create',array(
            'model'=>$model,
        ));
    }

    public function actionmenuUpdate($id)
    {
        $model = Menus::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        if(isset($_POST['Menus']))
        {
            $model->attributes=$_POST['Menus'];
            if($model->save())
                $this->redirect(array('/admin/menus','id'=>$model->id));
        }
        $this->render('//menus/update',array(
            'model'=>$model,

        ));
    }

    public function actionmenuDelete($id)
    {
        $model = Menus::model()->findByPk($id);
        $model->delete();
        
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
        
    public function actionModels($modelName)
	{
		$model = new $modelName('search');
		$model->unsetAttributes();
        if(isset($_GET[ucfirst(strtolower($modelName))]))
            $model->attributes = $_GET[ucfirst(strtolower($modelName))];

        $this->render($modelName.'_list',array(
            'model'=>$model,
        ));
	}
    /*public function actionClinics()
    {
        $model = new clinics('search'); 
        $model->unsetAttributes();
        if(isset($_GET['clinics']))
            $model->attributes = $_GET['clinics'];

        $this->render('clinics_list',array(
            'model'=>$model,
        ));
    }*/
	
	protected function objectInit($model)
	{
		$modelName = get_class($model);
		if (isset($_POST[$modelName]))
		{
			$model -> FillFieldsFromArray($model, $_POST);
			//Если ключом для сохранения файлов является id, и модель новая, то сохраняем модель, чтобы его получить
			if (($model -> FolderKey() === 'id')&&($model -> isNewRecord))
				$model -> save();
			//Делаем с файлами все, что нужно.
			if (isset($_FILES))
				$model -> FilesOperationsFromArray($model, $_FILES);
			//Сохраняем все изменения и редиректим куда нужно.
			if ($model -> save())
			{
				if ($this->isSuperAdmin())
					$this->redirect(array(strtolower($modelName)));
				else {
					Yii::app()->user->setFlash('successfullSave', CHtml::encode('Изменения сохранены'));
					return; 
				}
			} else {
				return false;
			}
		}
	}
	/*protected function clinicInit($model)
	{
		if (isset($_POST['clinics']))
		{
			$model -> FillClinicFieldsFromArray($model, $_POST);
			//Если ключом для сохранения файлов является id, и модель новая, то сохраняем модель, чтобы его получить
			if (($model -> FolderKey() === 'id')&&($model -> isNewRecord))
				$model -> save();
			//Делаем с файлами все, что нужно.
			if (isset($_FILES))
				$model -> ClinicFilesOperationsFromArray($model, $_FILES);
			//Сохраняем все изменения и редиректим куда нужно.
			if ($model -> save())
			{
				if ($this->isSuperAdmin())
					$this->redirect(array('clinics'));
				else {
					Yii::app()->user->setFlash('successfullSave', CHtml::encode('Изменения сохранены'));
					return; 
				}
			} else {
				return false;
			}
		}
	}*/

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionObjectCreate($modelName)
    {
        $model = new $modelName();

        $this->objectInit($model);

        $this->render($modelName.'_create',array(
            'model'=>$model
        ));
    }

    public function actionDoctorUpdate($id)
    {
        if (!$this->isSuperAdmin())
            if ((int)$id != (int)$this->isDoctor()) {
                new CustomFlash('warning','Admin','AccessDenied','У вас недостаточно прав для просмотра данной страницы. Скорее всего, Вы опечатались при наборе своего id в базе.',true);
                return false;
			}

        $model = doctors::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        $this->objectInit($model);

        $this->render('doctors_update',array(
            'model'=>$model,
        ));
    }
	public function actionClinicUpdate($id)
    {
        if (!$this->isSuperAdmin())
            if ((int)$id != (int)$this->isClinicAdmin()) {
                new CustomFlash('warning','Admin','AccessDenied','У вас недостаточно прав для просмотра данной страницы. Скорее всего, Вы опечатались при наборе id своей клиинки в базе.',true);
                return false;
			}

        $model = clinics::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        $this->objectInit($model);

        $this->render('clinics_update',array(
            'model'=>$model,
        ));
    }

    //public function actionclinicDelete($id)
    public function actionObjectDelete($id, $modelName)
    {
        $model = $modelName::model()->findByPk($id); //print $model->primaryKey; die();
        $model->delete();
        
        // reset autoincrement     
        //resetId($model);
        
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionpropDelete($id = NULL)
    {	
        switch ($_POST['model']) {
            case 'clinic': $model = clinics::model()->findByPk($id);
                       break;
            case 'trigger': $model = Triggers::model()->findByAttributes(array('name' => $_POST['prop']));    
                       break;                    
			case 'RightText': $model = RightText::model() -> findByPk($id);
						break;
			case 'HorizontalText': $model = HorizontalText::model() -> findByPk($id);
						break;
		}
        
		//$model = clinics::model()->findByPk($id);
        switch ($_POST['prop']) {
				case 'image': $model -> image = NULL; //for righttext
							break;
                case 'logo':        $model->logo = NULL;   
                                    //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                    break;
                case 'img':         if (isset($_POST['prop_value'])) {                                
                                        $images_old = explode(';', $model->pictures);
                                        $img = $_POST['prop_value'];   
                                        if(($key = array_search($img, $images_old)) !== false) {
                                            unset($images_old[$key]);
                                            $images = implode(';' , $images_old); 
                                        }                         
                                        //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                        $model->pictures = $images;                       
                                    }
                                    break;
                case 'top_banner':            
                case 'side_banner': $model->value = NULL;   
                                    break;         
                case 'audio':       $model->audio = NULL;   
                                    //unlink(Yii::app()->basePath.'/../images/clinics/'. $id . $img);     
                                    break;
                                                                   
        }
        
        if (!$model->save())
            echo CHtml::encode('Файл не может быть удален');
           
        Yii::app()->end();
                           
    }
    /**
     * Displays a particular Pricelist.
     */
    public function actionClinicsPricelists($id)
	{
		$this -> Pricelists($id, 'clinics');
	}
	public function actionDoctorsPricelists($id)
	{
		$this -> Pricelists($id, 'doctors');
	}
    public function Pricelists($id, $modelName)
    {

        $model = new PriceList('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->object_id = $id;
        $model->object_type = Objects::model()->getNumber($modelName);
        $object = $modelName::model()->findByPk($id);

        $this->render('//pricelist/admin',array(
            'model'=>$model,
            'object_id'=>$id,
            'object'=>$object
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionClinicsPricelistsCreate($id)
	{
		$this -> PricelistCreate($id, 'clinics');
	}
	public function actionDoctorsPricelistsCreate($id)
	{
		$this -> PricelistCreate($id, 'doctors');
	}
	public function PricelistCreate($id, $modelName)
	{
		$model = new PriceList;
		$model->object_type = Objects::model() -> getNumber($modelName);
		$object = $modelName::model() -> findByPk($id);
		$object_id = $id;
		
		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			$model->object_id = $object_id;
			if($model->save())
				$this->redirect(array('/admin/'.$modelName.'Pricelists', 'id' => $object_id));
		}
		
		$this->render('//pricelist/create',array(
			'model'=>$model,
			'object' => $object,
			'object_id' => $id
		));
	}
	public function actionPricelistUpdate($id)
	{
		$model=PriceList::model()->findByPk($id);

		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_POST['PriceList']))
		{
			$model->attributes=$_POST['PriceList'];
			if($model->save())
				$this->redirect(array('/admin/'.Objects::model() -> getName($model -> object_type)));
		}
		$this->render('//pricelist/update',array(
			'model'=>$model,
		));
	}

    public function actionPricelistDelete($id)
    {
        $model = PriceList::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    /**
     * Displays a particular Service.
     */
	public function actionClinicsServices($id)
	{
		$this -> Services($id, 'clinics');
	}
	public function actionDoctorsServices($id)
	{
		$this -> Services($id, 'doctors');
	}
    public function Services($id, $modelName)
    {
        $model = new Services('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->attributes=array('object_id'=>$id, 'object_type' => Objects::model() -> getNumber($modelName));
        $object = $modelName::model()->findByPk($id);

        $this->render('//services/admin',array(
            'model'=>$model,
            'object_id'=>$id,
            'object'=>$object
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actionClinicsServiceCreate($id){
		$this -> ServiceCreate($id, 'clinics');
	}
	public function actionDoctorsServiceCreate($id){
		$this -> ServiceCreate($id, 'doctors');
	}
    public function ServiceCreate($id, $modelName)
    {
        $model = new Services;
        $object_id = $id;
        //$clinic = clinics::model()->findByPk($id);
		$object = $modelName::model() -> findByPk($id);
        if(isset($_POST['Services']))
        {
            $model->attributes=$_POST['Services'];
            $model->object_id = $object_id;
			$model -> object_type = Objects::model()->getNumber($modelName);
            if($model->save())
                //$this->redirect(array('/admin/'.$modelName,'id'=>$model->object_id));
                $this->redirect(array('/admin/'.$modelName));
        }

        $this->render('//services/create',array(
            'model'=>$model,
			'object' => $object,
            'object_id' => $id
        ));
    }

    public function actionClinicsServiceUpdate($id){
		$this -> ServiceUpdate($id, 'clinics');
	}
	public function actionDoctorsServiceUpdate($id){
		$this -> ServiceUpdate($id, 'doctors');
	}
    public function ServiceUpdate($id, $modelName)
    {
        $model=Services::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        if(isset($_POST['Services']))
        {
            $model->attributes=$_POST['Services'];
            if($model->save())
                $this->redirect(array('/admin/'.$modelName.'Services','id'=>$model->object_id));
        }
        $this->render('//services/update',array(
            'model'=>$model
        ));
    }

    public function actionserviceDelete($id)
    {
        $model = Services::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Displays a particular Service.
     */
	public function actionClinicsFields($id)
	{

		$model = new FieldsValue('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
		$model->attributes=array('object_id'=>$id,'object_type' => Objects::model() -> getNumber('clinics'));        
		$clinic = clinics::model()->findByPk($id);

		$this->render('//clinicsfields/admin',array(
			'model'=>$model,
			'clinic_id'=>$id,
			'clinic'=>$clinic
		));
			
	}
	public function actionDoctorsFields($id)
	{

		$model = new FieldsValue('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
		$model->attributes=array('object_id'=>$id,'field.object_type' => Objects::model() -> getNumber('doctors'));        
		$doctor = doctors::model()->findByPk($id);

		$this->render('//doctorsfields/admin',array(
			'model'=>$model,
			'doctor_id'=>$id,
			'doctor'=>$doctor
		));
			
	}


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actionClinicsfieldsCreate($id)
	{
		$this -> FieldsCreate($id, 'clinics');
	}
	public function actionDoctorsfieldsCreate($id)
	{
		$this -> FieldsCreate($id, 'doctors');
	}
    public function FieldsCreate($id, $modelName)
    {
        $model = new FieldsValue;
        $object = $modelName::model()->findByPk($id);
		$model->object_id = $id;
        if(isset($_POST['FieldsValue']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['FieldsValue'];
			//$model->object_type = Objects::model() -> getNumber($modelName);
            if($model->save())
                $this->redirect(array('admin/'.$modelName.'Fields', 'id'=>$id));
        }

        $this->render('//'.$modelName.'fields/create',array(
            'model'=>$model,
			'object' => $object,
            'id' => $id
        ));
    }

    public function actionClinicsFieldsUpdate($id)
	{
		$this -> FieldsUpdate($id, 'clinics');
	}
	public function actionDoctorsFieldsUpdate($id)
	{
		$this -> FieldsUpdate($id, 'doctors');
	}
    public function FieldsUpdate($id, $modelName)
    {
        $model = FieldsValue::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        //if(isset($_POST[ucfirst(strtolower($modelName)).'Fields']))
        if(isset($_POST['FieldsValue']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['FieldsValue'];
            if($model->save())
                $this->redirect(array('admin/'.$modelName.'Fields', 'id'=>$model->object_id));
			else
				print_r($model->getErrors());
        }
        $this->render('//'.$modelName.'fields/update',array(
            'model'=>$model,
        ));
    }
    
    public function actionClinicsFieldsDelete($id)
	{
		$this -> FieldsDelete($id);
	}
    public function actionDoctorsFieldsDelete($id)
	{
		$this -> FieldsDelete($id);
	}
    public function FieldsDelete($id)
    {
        $model = FieldsValue::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
	
	/**
     * Displays a list of all menuButtons
     */
	public function actionMenuButtons()
	{
		
		$model = new MenuButtons('search');
		$model->unsetAttributes();
        if(isset($_GET['MenuButtons']))
            $model->attributes = $_GET['MenuButtons'];
        $this->render('//admin/menuButtons/buttonsList',array(
            'model'=>$model
        ));
	}
	public function actionMenuButtonsUpdate($id)
    {
        $model = MenuButtons::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        //if(isset($_POST[ucfirst(strtolower($modelName)).'Fields']))
			//print_r($_POST['MenuButtons']);
        if(isset($_POST['MenuButtons']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['MenuButtons'];
            if($model->save())
                $this->redirect(array('admin/MenuButtons'));
			else
				print_r($model->getErrors());
        }
        $this->render('//admin/menuButtons/update',array(
            'model'=>$model,
        ));
    }
	public function actionMenuButtonsCreate()
    {
        $model = new MenuButtons;
        if(isset($_POST['MenuButtons']))
        {
            //$model->attributes=$_POST[ucfirst(strtolower($modelName)).'Fields'];
            $model->attributes=$_POST['MenuButtons'];
			//$model->object_type = Objects::model() -> getNumber($modelName);
            if($model->save())
                $this->redirect(array('admin/MenuButtons'));
        }

        $this->render('//admin/menuButtons/create',array(
            'model'=>$model,
        ));
    }
	/**
	 * Delete the menu item
	 * @arg integer id - id of the item to be deleted
	 */
	public function actionMenuButtonsDelete($id)
    {
        $model = MenuButtons::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    /**
     * Displays a list of all articles
     */
    public function actionArticles()
    {
        $model = new Articles('search');
		//$model->attributes = $_POST['Articles'];
		$model->unsetAttributes();
        if(isset($_GET['Articles']))
            $model->attributes = $_GET['Articles'];
        $this->render('//articles/admin',array(
            'model'=>$model
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionarticleCreate()
    {
        $model = new Articles;
        $menuLevel = 0;
        
        if(isset($_POST['Articles']))
        {   
            $model->attributes = $_POST['Articles'];
			if ((!isset($_POST["Articles"]["parent_id"]))&&($_POST["level"]==0))
			{
				$model -> parent_id = 0;
			}
			if (isset($_POST["triggers_array"]))
			{
				$model -> trigger_value_id = implode(';',$_POST["triggers_array"]);
			} else {
				$model -> trigger_value_id = 0;
			}
			//print_r($_POST["triggers_array"]);
			//print_r($_POST);
			//echo "<br/>asda";
			//print_r($_POST["Articles"]);
            /*if (isset($_POST['menuLevel'])) {
                if ((int)$_POST['menuLevel'] == 0)
                    $model->category = 0;
                $menuLevel = $_POST['menuLevel'];       
            }*/
            if($model->save()) {
                new CustomFlash('success','Article','save','Изменения успешно сохранены!', true);
				$this->redirect(array('//admin/articles'));
			} else {
				new CustomFlash('error','Article','save','Ошибка при сохранении. Список ошибок ниже указан в массиве.', true);
				print_r($model -> getErrors());
			}
        }

        $this->render('//articles/create',array(
            'model'=>$model,
            'menuLevel'=>$menuLevel
        ));
    }
    public function actionarticleUpdate($id)
    {
        $model=Articles::model()->findByPk($id);
        
        if ($model->category == 0) 
            $menuLevel = 0;
        else
            $menuLevel = 1;    
        
        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

        if(isset($_POST['Articles']))
        {
            $model->attributes=$_POST['Articles'];
            /*if (isset($_POST['menuLevel'])) {
                if ((int)$_POST['menuLevel'] == 0)
                    $model->category = 0;
                $menuLevel = $_POST['menuLevel'];       
            }*/
			if (isset($_POST['triggers_array']))
			{
				$model -> trigger_value_id = implode(';',$_POST['triggers_array']);
			} else {
				$model -> trigger_value_id = 0;
			}
            if($model->save())
                $this->redirect(array('//admin/articles'));
        }
        $this->render('//articles/update',array(
            'model'=>$model,
            'menuLevel'=>$menuLevel
        ));
    }

    public function actionarticleDelete($id)
    {
        $model = Articles::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Displays Trigger list
     */
     
    public function actionTriggers()
    {
        $model = new Triggers('search'); 
        $model->unsetAttributes();
        if(isset($_GET['Triggers']))
            $model->attributes = $_GET['Triggers'];

        $this->render('triggers_list',array(
            'model'=>$model,
        ));
    }

    public function actiontriggerCreate()
    {
        $model = new Triggers();
            
        if(isset($_POST['Triggers']))
        {
            $model->attributes=$_POST['Triggers'];
            if($model->save()) {
				$images_filePath = $model -> giveImageFolderAbsoluteUrl();
				//echo $images_filePath;
				if (strlen($images_filePath) > 0)
				{
					if (!file_exists($images_filePath))
					{
						mkdir($images_filePath);
					}

					if(isset($_FILES['Triggers'])) { // logo
					
						if(!empty($_FILES['Triggers']['name']['logo'])){
							$model->logo = CUploadedFile::getInstance($model,'logo');
							$image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
							$fileName = $images_filePath . DIRECTORY_SEPARATOR . $image_unique_id;
		
							if ($model->validate()) {
								$model->logo->saveAs($fileName);
								$model->logo = $image_unique_id;
								$model->save();
							}
						}
					}
					$this->redirect(array('/admin/triggers','id'=>$model->id));
				} else {
					new CustomFlash("error", 'Triggers', 'CreateFilepath', 'Не удалось сгенерировать каталог для изображений.', true) ;
				}
            } 
        }

        $this->render('//triggers/create',array(
            'model'=>$model
        ));
    }
    
    public function actiontriggerUpdate($id)
    {
        $model = Triggers::model()->findByPk($id);
		
		if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
		
		$images_filePath = $model -> giveImageFolderAbsoluteUrl();
		
        if (!file_exists($images_filePath))
            mkdir($images_filePath);

        if(isset($_POST['Triggers']))
        {
            $model->attributes=$_POST['Triggers'];
            if(isset($_FILES['Triggers'])) { // logo
                if(!empty($_FILES['Triggers']['name']['logo'])){
                    $logo_old = $model->logo;
                    $model->logo = CUploadedFile::getInstance($model,'logo');
                    $image_unique_id = substr(md5(uniqid(mt_rand(), true)), 0, 5) . '.' .$model->logo->extensionName;
                    $fileName = $images_filePath . '/' . $image_unique_id;

                    if ($model->validate()) {
                        $model->logo->saveAs($fileName);
                        $model->logo = $image_unique_id;
						@unlink($images_filePath.'/'.$logo_old);
                    }
                    else
                        $model->logo = $logo_old;
                }
            }    
                      
            if($model->save())
                $this->redirect(array('/admin/triggers','id'=>$model->id));
        }
        $this->render('//triggers/update',array(
            'model'=>$model,
        ));
    }

    public function actiontriggerDelete($id)
    {
        $model = Triggers::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actiontriggerValues($id)
    {
        $model = new TriggerValues('search'); //Pricelist::model()->findAllByAttributes(array('clinic_id' => $id ));
        $model->attributes=array('trigger_id'=>$id);
        $trigger = Triggers::model()->findByPk($id);

        $this->render('//triggervalues/admin',array(
            'model' => $model,
            'trigger_id' => $id,
            'trigger' => $trigger
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
	public function actiontriggerValueCreate($id)
	{
		$model = new TriggerValues();
		$trigger_id = $id;

		if(isset($_POST['TriggerValues']))
		{
			$model->attributes=$_POST['TriggerValues'];
			$model->trigger_id = $trigger_id;
			if($model->save())
				$this->redirect(array('admin/triggerValues', 'id'=>$trigger_id));
		}

		$this->render('//triggervalues/create',array(
			'model'=>$model,
			'trigger_id' => $id
		));
	}

	public function actiontriggerValueUpdate($id)
	{
		$model = TriggerValues::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_POST['TriggerValues']))
		{
			$model->attributes=$_POST['TriggerValues'];
			if($model->save())
				$this->redirect(array('admin/triggerValues', 'id'=>$model->trigger_id));
		}
		$this->render('//triggervalues/update',array(
			'model'=>$model,

		));
	}

    public function actiontriggerValueDelete($id)
    {
        $model = TriggerValues::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }     
    public function actionDescriptions()
	{
		$model = new Description();
		$model -> unsetAttributes();
		if (isset($_GET['Description']))
		{
			$model->attributes = $_GET['Description'];
			$model -> searchId = $_GET['Description']['searchId'];
		}
		$this -> render ( '//descriptions/admin', array(
			'model' => $model
		));
	}
	public function actionDescriptionCreate()
	{
		$model = new Description('search');
		$model->attributes=$_POST['Description'];
		if(isset($_POST['Description']))
		{
			$values_array = $_POST['triggers_array'];
			asort($values_array);
			$model -> trigger_values = implode(';', $values_array);
			if($model->save())
				$this->redirect(array('admin/Descriptions', 'id'=>$trigger_id));
		} else {
			$model -> trigger_values = $_POST['triggers_array'];
		}

		$this->render('//descriptions/create',array(
			'model'=>$model
		));
	}

	public function actionDescriptionUpdate($id)
	{
		$model = Description::model()->findByPk($id);
		
		if($model===null)
			throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));

		if(isset($_GET['Description']))
		{
			$model->attributes=$_POST['Description'];
			if($model->save())
				$this->redirect(array('admin/Descriptions'));
		}
		$this->render('//descriptions/update',array(
			'model'=>$model,

		));
	}
	public function actionDescriptionDelete($id)
    {
        $model = Description::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Displays Comments list
     */
    public function actionComments()
    {
        $model = new Comments('search');
        $model->unsetAttributes();
        if(isset($_GET['Comments']))
            $model->attributes = $_GET['Comments'];

        $this->render('comments_list',array(
            'model'=>$model,
        ));
    }

    public function actioncommentToggle()
    {   
        $comment = Comments::model()->findByPk($_POST['id']);
        
        if ($comment->user_first_name == "")
            $comment->user_first_name =  CHtml::encode("Неизвестно");
        if ($comment->user_last_name == "")
            $comment->user_last_name =  CHtml::encode("Неизвестно");
            
        if ($comment->approved == 1)
           $comment->approved = 0;
        else
           $comment->approved = 1;

        if ($comment->save()) {
            if ($comment->approved == 1)
                $data = array('id' => $_POST['id'], 'class' => 'btn btn-success', 'text' => CHtml::encode('Отклонить'));
            else
                $data = array('id' => $_POST['id'], 'class' => 'btn btn-danger', 'text' => CHtml::encode('Одобрить'));
        } else {
                $data = array('id' => $_POST['id'], 'class' => 'btn btn-info', 'text' => CHtml::encode('Ошибка'), 'errors' => $comment->getErrors());
        }

        echo CJSON::encode($data);
    }

    public function actioncommentDelete($id)
    {
        $model = Comments::model()->findByPk($id); //print $model->primaryKey; die();
        $model->delete();
              
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('comments'));
    }

    /**
     * Displays Users list
     */
    public function actionUsers()
    {
        $model = new User('search');
        $model->unsetAttributes();
        if(isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('users_list',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionuserCreate()
    {
        $model = new User;

        if(isset($_POST['User']))
        {   
            $model->attributes=$_POST['User'];

            if($model->save())
                $this->redirect(array('/admin/users','id'=>$model->id));
        }

        $this->render('//user/create',array(
            'model'=>$model
        ));
    }

    public function actionuserUpdate($id)
    {
        $model = User::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
        
        $oldPassword = $model->password;
        
        if(isset($_POST['User']))
        {
            $model->attributes = $_POST['User'];
            $model->password = $oldPassword;
            if($model->save())
                $this->redirect(array('/admin/users','id'=>$model->id));
        }
        $this->render('//user/update',array(
            'model'=>$model,

        ));
    }

    public function actionuserDelete($id)
    {
        $model = User::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Displays Users list
     */
    //public function actionFields()
    public function actionFieldsGlobal($modelName)
    {
        $model = new Fields('search');
        $model->unsetAttributes();
		$model->object_type = Objects::model() -> getNumber($modelName);
        if(isset($_GET['Fields'])) {
            $model->attributes = $_GET['Fields'];
		}
		
        $this->render('fields_list',array(
            'model'=>$model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionFieldCreateGlobal($modelName)
    {
        $model = new Fields;

        if(isset($_POST['Fields']))
        {
            $model->attributes=$_POST['Fields'];
			$model->object_type = Objects::model() -> getNumber($modelName);
            if($model->save())
                $this->redirect(array('/admin/'.$modelName.'FieldsGlobal'));//,'id'=>$model->id));
        }

        $this->render('//fields/create',array(
            'model'=>$model
        ));
    }

    public function actionFieldUpdateGlobal($id)
    {
        $model = Fields::model()->findByPk($id);

        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
        
        if(isset($_POST['Fields']))
        {
            $model->attributes = $_POST['Fields'];
            if($model->save())
                $this->redirect(array('/admin/'.Objects::model() -> getName($model -> object_type).'FieldsGlobal'));//,'id'=>$model->id));
        }
        $this->render('//fields/update',array(
            'model'=>$model,
        ));
    }

    public function actionFieldDeleteGlobal($id)
    {
        $model = Fields::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Displays Users list
     */
    public function actionFilters($modelName)
    {
        $model = new Filters('search');
        $model->unsetAttributes();
		$model->object_type = Objects::model() -> getNumber($modelName);
        if(isset($_GET['Filters']))
            $model->attributes = $_GET['Fields'];

        $this->render('filters_list',array(
            'model'=>$model,
        ));
    }
    
    /**
     * Creates a Speciality.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionFilterCreate($modelName)
    {
        $model = new Filters;
		$model -> object_type = Objects::model() -> getNumber($modelName);
        if(isset($_POST['Filters']))
        { 
            $model->attributes=$_POST['Filters'];

            //triggers-fields
            if (!empty($_POST['triggers_array'])) {
                $triggers = implode(';', $_POST['triggers_array']);
                $model->fields = $triggers;
            }
            
            if($model->save())
                $this->redirect(array('/admin/'.$modelName.'Filters'));
        }

        $this->render('//filters/create',array(
            'model'=>$model
        ));
    }

    public function actionfilterUpdate($id)
    {
        $model = Filters::model()->findByPk($id);
		$modelName = Objects::model() -> getName($model->object_type);
        if($model===null)
            throw new CHttpException(404, СHtml::encode('Запрошенная страница не существует'));
        
        if(isset($_POST['Filters']))
        {
            $model->attributes = $_POST['Filters'];
            //triggers-fields
            if (!empty($_POST['triggers_array'])) {
                $triggers = implode(';', $_POST['triggers_array']);
                $model->fields = $triggers;
            }            
            if($model->save())
                $this->redirect(array('/admin/'.$modelName.'Filters'));
        }
        $this->render('//filters/update',array(
            'model'=>$model,

        ));
    }

	public function actionAjaxGetParents() 
	{
		$level = (int) $_POST['Articles']['level'];
		echo Articles::model() -> GenerateParentList($level - 1);
	}
	public function actionAjaxGetParentsMenuButtons() 
	{
		$level = (int) $_POST['MenuButtons']['level'];
		print_r(MenuButtons::model() -> GenerateParentList($level - 1));
		//echo MenuButtons::model() -> GenerateParentList($level - 1);
	}
    public function actionfilterDelete($id)
    {
        $model = Filters::model()->findByPk($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /* DEFAULT ACTIONS */
    public function actionIndex()
    {
        $this->render('view');
    }

    public function actionfileUpload()
    { 
        //$this->layout='';
        //header('Content-type: application/json');
        if ($_FILES)
        {
            if(!empty($_FILES['fileUploded'])){
                $filePath = Yii::app()->basePath.'/../images/' . basename($_FILES['fileUploaded']['name']);
        
                if (move_uploaded_file($_FILES['fileUploaded']['tmp_name'], $filePath)) {
                    Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен');
                } else {
                    Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
                    return false;
                }
            }
        }
            
        else            
            echo '<form method="post" id="fileUpload" enctype="multipart/form-data">
                  <input type="file" name="fileUploaded" id="fileUploaded"> <br/>
                  <input type="submit" id="submitUpload">
                  </form>
                     
                  ';
         return true;
    }
	
	public function actionImportCsv($modelName) {
		//Задаем имя файлу на сервере
		$csv_filePath = Yii::app()->basePath.'/../files/'.$modelName.'.csv' ;
		//Пытаемся вытащить из временных загруженный файл
		if (move_uploaded_file($_FILES[$modelName.'_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		$reader = new CsvReader($csv_filePath);
		//Создаем csv-reader
		if ($reader -> file) {
			//Задаем параметры ридера
			$reader -> separator = ';';
			$reader -> exportFileEncoding = 'utf-8';
			//Если открытие файла удачно, то сохраняем заголовок и продолжаем.
			$header = $reader -> saveHeader();
			//print_r($header);
			while($line = $reader -> line()) {
				$modelName::model() -> modelFromImportArray($line, $header);
				/*if ($count > 1) {
					break;
				}
				$count ++;
				echo "<br/><br/><br/>";*/
			}
			Yii::app() -> end();
		}
		
		
	}
	/*public function actionImportCsv($modelName)
	{
		$csv_filePath = Yii::app()->basePath.'/../files/'.$modelName.'.csv' ;
        
        if (move_uploaded_file($_FILES[$modelName.'_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		
		$handle=fopen($csv_filePath, "r");
		
		if ($handle)
		{
			$attrName = $modelName.'Fields';
			$attrName2 = $modelName.'Prices';
			$modelName::model() -> ImportCsv($handle, $this -> $attrName, $this -> $attrName2);
			fclose($handle);
		}
		$this->redirect($modelName);
	}*/
	/*public function actionImportCsv($modelName)
	{
		$csv_filePath = Yii::app()->basePath.'/../files/clinics.csv' ;
        
        if (move_uploaded_file($_FILES['clinics_csv']['tmp_name'], $csv_filePath)) {
            Yii::app()->user->setFlash('successfullUpload', 'Файл успешно загружен.');             
        } else {
            Yii::app()->user->setFlash('errorUpload', 'При загрузке файла произошла ошибка');
            return false;
        }
		
		$handle=fopen($csv_filePath, "r");
		
		if ($handle)
		{
			clinics::model() -> ImportCsv($handle, $this -> fields);
			fclose($handle);
		}
		$this->redirect('clinics');
	}*/
	/*
	* Export objects in a csv file.
	* $<modelName>Fields array specifies which fields are to be exported. 
	* Every key of the array equals to the table field, while the value is the text that is to be shown to users in the exported file.
	*/
	public function actionExportCsv($modelName)
	{
		$attrName = $modelName.'Fields';
		$attrName2 = $modelName.'Prices';
		$modelName::model() -> ExportCsv($this -> $attrName, $this -> $attrName2);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->findbyPk($_GET['id']); //notsafe()->
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	public function disableProfilers()
    {
        if (Yii::app()->getComponent('log')) {
            foreach (Yii::app()->getComponent('log')->routes as $route) {
                if (in_array(get_class($route), array('CProfileLogRoute', 'CWebLogRoute', 'YiiDebugToolbarRoute','DbProfileLogRoute'))) {
                    $route->enabled = false;
                }
            }
        }
    }
    public function actionGoogleDoc() {
        $api = new GoogleDocApiHelper();

        if ($api -> success) {
            $api -> setDefaultWorkArea();
            /*var_dump($api -> giveData() -> getEntries());
            echo "good";*/
            clinics::importFromGoogleDoc($api);
            $f = new CustomFlash();
            $html = $f -> showAll();
            if (!$html) {
                $this -> redirect(array('admin/clinics'));
            }
            echo "Обнаружены ошибки. Их список можно увидеть ниже. ".CHtml::link('Перейти к админке', '//admin/clinics');
            echo $html;
        }
    }
    /*public function actionDownloadImages(){
        $xml = file_get_contents('http://o-mri.ru.clinics.s3.amazonaws.com/');
        $obj = new SimpleXMLElement($xml);
        //var_dump($obj);
        $verb = function($str){
            $matches = array();
            $rez = preg_replace('/(\.jpg)|(\.JPG)/','',$str);
            //preg_replace("/.*?\./", '', 'photo.jpg');
            return $rez;
        };

        $download = function ($url, $target) {
            if(!$hfile = fopen($target, "w"))return false;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FILE, $hfile);

            if(!curl_exec($ch)){
                curl_close($ch);
                fclose($hfile);
                unlink($target);
                return false;
            }

            fflush($hfile);
            fclose($hfile);
            curl_close($ch);
            return true;
        };
        $baseUrl = 'http://o-mri.ru.clinics.s3.amazonaws.com';

        //$imageName = '1mrt.jpg';
        //$download($urlbase.$imageName, Yii::getPathOfAlias('webroot.images').'/'.$imageName);
        //Yii::app() -> end();
        foreach ($obj -> Contents as $image) {
            if ($clinic = clinics::model() -> findByAttributes(array('verbiage' => $verb($image -> Key)))) {
                $images_filePath = $clinic -> giveImageFolderAbsoluteUrl();
                if (!file_exists($images_filePath))
                {
                    mkdir($images_filePath);
                }
                $fileName = $images_filePath.'/'.$image -> Key;

                if (file_exists($fileName)) {
                    unlink($fileName);
                    $deleted ++;
                }

                if ($download($baseUrl.'/'.$image -> Key, $images_filePath.'/'.$image -> Key)) {
                //if ($download($baseUrl.'/'.$image -> Key, Yii::getPathOfAlias('webroot.images').'/'.$image -> Key)) {
                    $clinic -> logo = $image -> Key;
                    $clinic -> save();
                    $d ++;
                } else {
                    $nd ++;
                }
            } else {
                $nf ++;
            }

        }
        echo "Uploaded: $d, not uploaded: $nd, not found: $nf, deleted: $deleted";
    }
    public function actionDownloadAllImages(){
        $xml = file_get_contents('http://o-mri.ru.clinics.s3.amazonaws.com/');
        $obj = new SimpleXMLElement($xml);
        $download = function ($url, $target) {
            if(!$hfile = fopen($target, "w"))return false;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FILE, $hfile);

            if(!curl_exec($ch)){
                curl_close($ch);
                fclose($hfile);
                unlink($target);
                return false;
            }

            fflush($hfile);
            fclose($hfile);
            curl_close($ch);
            return true;
        };
        $verb = function($str){
            $matches = array();
            $rez = preg_replace('/(\.jpg)|(\.JPG)/','',$str);
            //preg_replace("/.*?\./", '', 'photo.jpg');
            return $rez;
        };
        $baseUrl = 'http://o-mri.ru.clinics.s3.amazonaws.com';
        foreach ($obj -> Contents as $image) {
            echo $image -> Key;

            echo Yii::getPathOfAlias('webroot.images.allimages').'\\'.$image -> Key;
            if ($download($baseUrl.'/'.$image -> Key, Yii::getPathOfAlias('webroot.images.allimages').'/'.$image -> Key)) {
                $d++;
            } else {
                $nd++;
            }
        }
        echo "downloaded: $d, not downloaded: $nd";
    }*/
}