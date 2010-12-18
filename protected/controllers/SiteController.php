<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    
    /**
     * Performs a search query on files and folders.
     */
    public function actionSearch($query) 
    {
        // if the user is not authenticated, only search public files and folders
        if (Yii::app()->user->isGuest) {
            $files = File::model()->findAll('public = 1 AND file_name LIKE :query', array(':query'=>"%".$query."%"));
            $folders = Folder::model()->findAll('public = 1 AND folder_name LIKE :query', array(':query'=>"%".$query."%"));
        } else {
            $files = File::model()->findAll(
                    '(owner_id = :oid OR public = 1) AND file_name LIKE :query',
                    array(':query'=>'%'.$query.'%',':oid'=>Yii::app()->user->id)
                    );

            $folders = Folder::model()->findAll(
                    '(owner_id = :oid OR public = 1) AND folder_name LIKE :query',
                    array(':query'=>'%'.$query.'%',':oid'=>Yii::app()->user->id));
        }
        
        // return view with search results.
        $this->render('search', array(
            'files'=>$files,
            'folders'=>$folders,
            'query'=>$query,
        ));
    }

    public function actionLog() {
        $this->render('log');
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $this->pageTitle = "FileStorage - Welcome";

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

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
			if($model->validate() && $model->login())
				$this->redirect($this->createUrl('folder/'));
		}

		// display the login form
		$this->render('login',array('model'=>$model));
	}

    /**
     * Performs the facebook login and/or registration
     */
    public function actionFbLogin()
    {
        // check if the facebook js is initiated.
        if (!isset(Yii::app()->params['uid']))
            throw new CHttpException(400,'An error occured during Facebook authentication. Not initialized.');
        
        // check if there exists a model with the corresponding facebook id.
        $user = User::model()->find('fb_id = :uid',array(':uid'=>Yii::app()->params['uid']));
        
        $password = "aosdmv394inv";
        
        // register a new user model if no model was found
        if ($user === null) {
            // gets facebook information on the given facebook user.
            $fb_user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.Yii::app()->params['access_token']));
            
            $user = new User;
            $user->scenario = 'register';
            $user->fb_id = Yii::app()->params['uid'];
            $user->username = $fb_user->name;
            $user->password = $password;
            $user->password_confirmation = $password;
            $user->email = $fb_user->email;
            $user->created = time();
            $user->save();
        } else {
            $user->saveAttributes(array('last_login' => time(), 'login_count' => $user->login_count + 1));
        }
        
        // used to authenticate the user.
        $model=new LoginForm;
        $model->username = $user->username;
        $model->password = $user->password;
        $model->rememberMe = 0;
        
        if ($model->login()) {
            Yii::app()->user->setFlash('success', 'You have successfully logged in with Facebook.');
            $this->redirect($this->createUrl('folder/index'));
        } else {
            throw new CHttpException(400,'An error occured during Facebook authentication.');
        }
    }

	/**
	 * Logs out the current user.
	 */
	public function actionLogout()
	{

		Yii::app()->user->logout();
		
		$this->render('logout');
	}
}