<?php

class RequireLogin extends CBehavior
{
    public function onBegin($action)
    { var_dump(Yii::app()->user->isGuest);
        if (Yii::app()->user->isGuest && $action != 'login')  //  && strpos($_SERVER['REQUEST_URI'], '/admin') && !strpos($_SERVER['REQUEST_URI'], 'admin/login')
            Yii::app()->request->redirect('login');
        else
            return;
        //if (!Yii::app()->user->isGuest && strpos($_SERVER['REQUEST_URI'], '/admin')) 
          //  Yii::app()->request->render('index');
    }

}