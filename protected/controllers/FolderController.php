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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'view', 'create','update','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $folder = $this->loadModel($id);

        if($folder->owner_id == Yii::app()->user->id || $folder->public == 1) {
            $files = $this->getFiles($id);

            $this->render('view',array(
                'model'=>$this->loadModel($id),
                'files'=>$files
            ));
        } else {
            throw new CHttpException(403,'You cannot access other users files unless they share them with you.');
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Folder;

		if(isset($_POST['Folder']))
		{
			$model->attributes=$_POST['Folder'];
			$model->owner_id = Yii::app()->user->id;
			
			if($model->save())
                mkdir(Yii::app()->params['filesPath'].$model->id);
				$this->redirect(array('view','id'=>$model->id));
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
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
            $this->deleteFolder($folder);
            // remove model from database
            $folder->delete();
			
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
		$models = Folder::model()->findAll('owner_id = :owner_id', array(':owner_id'=>Yii::app()->user->id));
		$this->render('index',array(
			'models'=>$models,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Folder('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Folder']))
			$model->attributes=$_GET['Folder'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
    
    private function getFiles($folder_id)
    {
        $files = File::model()->findAll('folder_id = :folder_id',array(':folder_id'=>$folder_id));
        return $files;
    }

    private function deleteFolder($folder)
    {
        if($folder->owner_id == Yii::app()->user->id) {
            $directory_path = Yii::app()->params['filesPath'].$folder->id;
            // get files in folder
            $files_in_folder = File::model()->findAll('folder_id = :fid',array(':fid'=>$folder->id));
            // delete each of those files both in database and on disk
            foreach ($files_in_folder as $file) {
                $file->delete();
                $file_path = $directory_path.DIRECTORY_SEPARATOR.$file->file_name;
                if (is_file($file_path))
                    unlink($file_path);
            }
            // remove directory once it is emtpy
            if (is_dir($directory_path))
                rmdir($directory_path);
        } else {
            throw new CHttpException(403,'You may not delete other users folders!');
        }

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
