<?php

class FileController extends Controller
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
				'actions'=>array('index','view', 'create','update','delete'),
				'users'=>array('@'),
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
        $model = $this->loadModel($id);
        $folder = Folder::model()->findByPk($model->folder_id);
        $owner = User::model()->findByPk($model->owner_id);

        $this->render('view',array(
			'model'=>$model,
            'folder'=>$folder,
            'owner'=>$owner,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($folderid = null)
	{
		$model=new File;
        $folders=Folder::model()->findAll('owner_id = :owner_id',array(':owner_id'=>Yii::app()->user->id));
                                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        if (isset($folderid))
           $model->folder_id = $folderid;

        if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];

			$file = CUploadedFile::getInstance($model, 'file_name');

			$model->file_name = $file;
            $model->owner_id = Yii::app()->user->id;
			$model->created = time();
            $model->folder_id = $_POST['File']['folder_id'];
			$path = Yii::app()->params['filesPath'].$model->folder_id.'/';

			if($model->save()) {
				$file->saveAs($path.$model->file_name);
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
            'folders'=>$folders,
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
        $folders=Folder::model()->findAll('owner_id = :owner_id',array(':owner_id'=>Yii::app()->user->id));

		if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
            'folders'=>$folders,
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
			$folder_id=$this->loadModel($id)->folder_id;
			$this->loadModel($id)->delete();

			$this->redirect($this->createUrl('folder/'.$folder_id));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('File');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new File('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['File']))
			$model->attributes=$_GET['File'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=File::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function isImage($file){
        $extension = explode('.', $file->file_name);
        $extension = strtolower($extension[sizeof($extension)-1]);

        if(in_array($extension, array('jpg','jpeg','png','gif','bmp'))) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
