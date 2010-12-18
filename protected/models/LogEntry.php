<?php

/**
 * This is the model class for table "tbl_log_entries".
 *
 * The followings are the available columns in table 'tbl_log_entries':
 * @property integer $id
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $time
 * @property string $message
 * @property integer $public
 */
class LogEntry extends CActiveRecord
{
    public static function createEntry($user_id, $item_id, $message, $reciever = 0, $isFolder = false)
    {
        $model = new LogEntry;
        $model->user_id = $user_id;
        $model->item_id = $item_id;
        $model->reciever = $reciever;
        $model->message = $message;
        $model->isFolder = $isFolder;
        $model->time = time();
        
        return $model->save();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogEntry the static model class
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
		return 'tbl_log_entries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, user_id, message', 'required'),
			array('item_id, user_id, time, reciever', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, user_id, time, message, reciever', 'safe', 'on'=>'search'),
		);
	}
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'user_id' => 'User',
			'time' => 'Time',
			'message' => 'Message',
			'reciever' => 'Reciever',
			'isFolder' => 'Folder?'
		);
	}
}