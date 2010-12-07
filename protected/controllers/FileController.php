<?php

class FileController extends Controller
{
	public $layout='//layouts/column1';

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
                'actions'=>array('view'),
                'users'=>array('*'),
            ),
			array('allow', // allow authenticated user to perform these actions
				'actions'=>array('create','update','delete','shares'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionShares($id)
    {
        // fetch file model from database.
        $model = $this->loadModel($id);

        // fetch all shares for the current file
        $shares = FileShare::model()->FindAll('file_id = :fid',array(':fid'=>$id));
        
        $this->render('shares',array(
			'model'=>$model,
            'shares'=>$shares,
		));
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        // fetch the folder model for the file model data.
        $folder = Folder::model()->findByPk($model->folder_id);
        // fetch the owner (user) model for the file model data.
        $owner = User::model()->findByPk($model->owner_id);
        // fetch users that the file is shared with.
        $shared = FileShare::model()->FindAll('file_id = :fid',array(':fid'=>$id));

        //render the view with the fetched data.
        $this->render('view',array(
			'model'=>$model,
            'folder'=>$folder,
            'owner'=>$owner,
            'shared'=>$shared,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($folderid = null, $public = 0)
	{
		$model=new File;
        $model->public = $public;
        // fetch all the users folders for the drop down list.
        $folders=Folder::model()->findAll('owner_id = :owner_id',array(':owner_id'=>Yii::app()->user->id));

        // if a folder id is supplied the preset the folder_id on the model.
        if (isset($folderid))
           $model->folder_id = $folderid;

        $model->file_size = 99999999999999999;

        // check if the request is a POST (meaning the form has been submitted).
        if(isset($_POST['File']))
		{
            // populate the model properties from the form data.
			$model->attributes=$_POST['File'];

            // get the uploaded file (stored in a temporary server folder)
			$file = CUploadedFile::getInstance($model, 'file_name');

            // set model properties corresponding to the uploaded file
			$model->file_name = $file;
            $model->owner_id = Yii::app()->user->id;
            $model->folder_id = $_POST['File']['folder_id'];
			$path = Yii::app()->params['filesPath'].'/'.Yii::app()->user->id.'/';
            
            // check if the file sieze is within the limit
            if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > Yii::app()->params['maxFileSize']) {
                $model->file_size = $_SERVER['CONTENT_LENGTH'];
            } else if (isset($file->size)) {
                $model->file_size = $file->size;
            }
            
            // save the model and save the actual file into the users folder.
            if($model->save()) {
                $model->created = time();
                $model->save();
                $file->saveAs($path.$model->file_name);
                $this->redirect(array('view','id'=>$model->id));
            }
		}

        // if the request is not a POST, then render the update view containing the form.
        // the supplied data are the file model, and the folders fetched earlier.
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
        // load the folder model for the supplied id.
		$model=$this->loadModel($id);

        // display an error page if a user tries to update another users file.
        if ($model->owner_id != Yii::app()->user->id)
            throw new CHttpException(403,'You cannot edit other users\' files.');

        // fetch all the users folders for the drop down list.
        $folders=Folder::model()->findAll('owner_id = :owner_id',array(':owner_id'=>Yii::app()->user->id));

        // check if the request is a POST (meaning the form has been submitted).
		if(isset($_POST['File']))
		{
            // store the old file name in case it gets renamed.
            $oldFileName = $model->file_name;
			$model->attributes=$_POST['File'];
            $model->last_edit = time();

			if($model->save()) {

                // rename file on disk using the old file name to find the file.
                if($oldFileName != $model->file_name) {
                    // set the file path.
                    $path = Yii::app()->params['filesPath'].$model->owner_id.'/';
                    // rename the file: rename(old filename, new filename)
                    rename($path.$oldFileName, $path.$model->file_name);
                }
                // redirect to view the updated file
                $this->redirect(array('view','id'=>$model->id));
            }
		}

        // if the request is not a POST, then render the update view containing the form.
        // the supplied data are the file model, and the folders fetched earlier.
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
        // chech if the request is a POST request
        // we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
            // fetch the model to be deleted.
			$file = $this->loadModel($id);
            // store the folder id. Used for the redirection to the folder when file has been deleted.
			$folder_id = $file->folder_id;
            // full path to the file on disk.
            $file_on_disk = Yii::app()->params['filesPath'].Yii::app()->user->id.'/'.$file->file_name;
            // delete the model in the database
            $file->delete();
            // if the file exists on disk then delete it.
            if(file_exists($file_on_disk))
                unlink ($file_on_disk);

            // redirect to the folder in which the deleted file was stored.
			$this->redirect($this->createUrl('folder/view',array('id'=>$folder_id)));

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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

    /* Checks wether a file ends with a known image extension */
    public function isImage($file){
        // get the file extension.
        $extension = explode('.', $file->file_name);
        $extension = strtolower($extension[sizeof($extension)-1]);

        // check if the extension is of a known image file type.
        if(in_array($extension, array('jpg','jpeg','png','gif','bmp'))) {
            return true;
        } else {
            return false;
        }
    }
}
