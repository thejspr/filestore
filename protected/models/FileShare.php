<?php

/**
 * This is the model class for table "tbl_file_shares".
 *
 * The followings are the available columns in table 'tbl_file_shares':
 * @property integer $id
 * @property integer $file_id
 * @property integer $user_id
 */
class FileShare extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FileShare the static model class
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
		return 'tbl_file_shares';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_id, user_id', 'required'),
			array('file_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, file_id, user_id', 'safe', 'on'=>'search'),
		);
	}
    
    public function afterSave()
    {
        // add log message
        LogEntry::createEntry(Yii::app()->user->id, $this->file_id, "shared", $this->user_id);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'file_id' => 'File',
			'user_id' => 'User',
		);
	}
    
    public function afterDelete()
    {
        $log_entries = LogEntry::model()->findAll('item_id = :fid AND message = "shared" AND isFolder = 0', array(':fid'=>$this->file_id));
        foreach ($log_entries as $entry) {
            $entry->delete();
        }
    }

}