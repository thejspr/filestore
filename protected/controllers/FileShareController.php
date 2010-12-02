<?php

class FileShareController extends Controller
{
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
				'actions'=>array('getForm','create','update','delete'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

    public function actionGetForm($id, $unique_id) {
        // create fileShare object
        $model = new FileShare();
        $model->file_id = $id;

        // fetch users from database
        $users = User::model()->FindAll('id != :id',array(':id'=> Yii::app()->user->id));

        // current shares
        $shares = FileShare::model()->FindAll('file_id = :fid',array(':fid'=>$id));

        // remove users with whom the file is already shared
        foreach ($shares as $share) {
            for ($i = 0; $i < count($users); $i++) {
                if ($share->user_id == $users[$i]->id)
                        unset($users[$i]);
            }
        }
        
        $this->renderPartial('_form',array(
            'unique_id'=>$unique_id,
			'model'=>$model,
            'users'=>$users,
		));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($file_id,$user_id)
	{
		$model=new FileShare;

        // insert date into model.
        $model->file_id = $file_id;
        $model->user_id = $user_id;

        if($model->save()) {
            $this->renderPartial('create',array(
                'model'=>$model,
            ));
        }
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

		if(isset($_POST['FileShare']))
		{
			$model->attributes=$_POST['FileShare'];
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
		if(Yii::app()->request->isAjaxRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('FileShare');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new FileShare('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FileShare']))
			$model->attributes=$_GET['FileShare'];

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
		$model=FileShare::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-share-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
