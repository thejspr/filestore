<?php

/**
 * This is the model class for table "tbl_folder".
 *
 * The followings are the available columns in table 'tbl_folder':
 * @property integer $id
 * @property integer $owner_id
 * @property string $folder_name
 * @property integer $public
 *
 * The followings are the available model relations:
 */
class Folder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Folder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_folder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, folder_name', 'required'),
			array('owner_id, public', 'numerical', 'integerOnly'=>true),
			array('folder_name', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, owner_id, folder_name, public', 'safe', 'on'=>'search'),
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
			'owner_id' => 'Owner',
			'folder_name' => 'Folder Name',
			'public' => 'Public',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('folder_name',$this->folder_name,true);
		$criteria->compare('public',$this->public);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

    public function deleteOnDisk()
    {
        if($this->owner_id == Yii::app()->user->id) {

            // set directory path
            $directory_path = Yii::app()->params['filesPath'].'/'.Yii::app()->user->id;

            // get files in folder
            $files_in_folder = File::model()->findAll('folder_id = :fid', array(':fid'=>$this->id));

            // delete each of those files both in database and on disk
            foreach ($files_in_folder as $file) {
                $file_path = $directory_path.'/'.$file->file_name;
                if (is_file($file_path))
                    unlink($file_path);
                $file->delete();
            }
        } else {
            throw new CHttpException(403,'You may not delete other users folders!');
        }

    }
}