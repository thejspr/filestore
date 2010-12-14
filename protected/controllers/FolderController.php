<?php

class FolderController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('view','public','rss'),
                'users'=>array('*'),
            ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete','files'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    public function actionRss()
    {
        // import Zend Feed class and Zend Autoloader
        Yii::import('application.vendors.*');
        require_once 'Zend/Loader/Autoloader.php';
        spl_autoload_unregister(array('YiiBase','autoload')); 
        spl_autoload_register(array('Zend_Loader_Autoloader','autoload')); 
        spl_autoload_register(array('YiiBase','autoload'));
        
        // fetch all public files and files in public folders
        $files = File::model()->FindAll('public = 1 order by created DESC');   
        $folders = Folder::model()->FindAll('public = 1');
        
        foreach ($folders as $folder) {
            $files[] = File::model()->Find('folder_id = :fid', array(':fid'=>$folder->id));
        }
        
        // remove duplicates (public files inside a public folder).
        $files = array_unique($files, SORT_REGULAR);
        
        $entries = array();
        foreach ($files as $file) {
            $user = User::model()->findByPk($file->owner_id);
            $entries[] = array(
                'title'=>$file->file_name,
                'link'=>urlencode($this->createUrl('file/view',array('id'=>$file->id))),
                'description'=>"Filename: ".$file->file_name." - Size: ".$file->file_size." bytes - Uploaded by: ".$user->username,
                'lastUpdate'=>$file->last_edit == 0 ? $file->created : $file->last_edit,
            );
        }
        
        // generate and render RSS feed
        $feed=Zend_Feed::importArray(array(
            'title'   => 'FileStorage Public Files RSS Feed',
            'link'    => $this->createAbsoluteUrl('folder/public'),
            'charset' => 'UTF-8',
            'entries' => $entries      
        ), 'rss');
        
        $feed->send();
             
    }

    public function actionPublic() {
        $folders = Folder::model()->FindAll('public = 1');
        $files = File::model()->FindAll('public = 1');

        $this->render('public',array(
            'folders'=>$folders,
            'files'=>$files,
        ));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        // register yii jquery plugin used for file/folder deletion
        Yii::app()->getClientScript()->registerCoreScript('yii');
        $folder = $this->loadModel($id);

        if($folder->owner_id == Yii::app()->user->id || $folder->public == 1) {
            $files = $this->getFiles($id);

            $this->render('view',array(
                'model'=>$this->loadModel($id),
                'files'=>$files
            ));
        } else {
            throw new CHttpException(403,'You cannot access other users files unless they share them with you or make them public.');
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($public = 0)
	{
		$model=new Folder;
        $model->public = $public;

		if(isset($_POST['Folder']))
		{
			$model->attributes=$_POST['Folder'];
			$model->owner_id = Yii::app()->user->id;
			
			if($model->save()) {
                Yii::app()->user->setFlash('success', 'Folder successfully created');
				$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Folder']))
		{
			$model->attributes=$_POST['Folder'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', 'Folder successfully updated');
				$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$folder = $this->loadModel($id);
            // delete folder and containging files
            $folder->deleteOnDisk();
            // remove model from database
            $folder->delete();
			Yii::app()->user->setFlash('success', 'Folder successfully deleted');
			$this->redirect($this->createUrl('folder/'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $uid = Yii::app()->user->id;
        // get all users folders
		$folders = Folder::model()->findAll('owner_id = :owner_id AND folder_name != "root"',
                array(':owner_id'=>$uid));
		// get his specific root folder
        $root_folder = Folder::model()->find('owner_id = :owner_id AND folder_name = "root"',
                array(':owner_id'=>$uid));
        // get the files inside the root folder
        $root_files = File::model()->findAll('owner_id = :owner_id AND folder_id = :folder_id',
                array(':folder_id'=>$root_folder->id,':owner_id'=>$uid));

        // get files shared with user
        $shared = FileShare::model()->FindAll('user_id = :uid',array(':uid'=>Yii::app()->user->id));
        $sharedFiles = array();
        foreach ($shared as $share) {
            $sharedFiles[] = File::model()->findByPk($share->file_id);
        }

        $this->render('index',array(
			'folders'=>$folders,
            'root_folder'=>$root_folder,
            'root_files'=>$root_files,
            'shared_files'=>$sharedFiles,
		));
	}

    public function actionFiles($id)
    {
        $files = File::model()->findAll('folder_id = :folder_id',array(':folder_id'=>$id));
        
        $this->renderPartial('files',array(
            'files'=>$files,
		));
    }

    private function getFiles($folder_id)
    {
        $files = File::model()->findAll('folder_id = :folder_id',
                array(':folder_id'=>$folder_id));
        return $files;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Folder::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='folder-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
