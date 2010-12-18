<?php

/**
 * This is the model class for table "tbl_file".
 *
 * The followings are the available columns in table 'tbl_file':
 * @property integer $id
 * @property integer $folder_id
 * @property integer $owner_id
 * @property string $file_name
 * @property integer $public
 * @property integer $created
 * @property integer $last_edit
 *
 * The followings are the available model relations:
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return File the static model class
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
		return 'tbl_file';
	}

    // sets the appropriate path for the file icon based on the files' extension.
    public function getIcon($file_name)
    {
        // get the file extension.
        $extension = explode('.', $file_name);
        $extension = strtolower($extension[sizeof($extension)-1]);
        
        if(file_exists('images/fileicons/'.$extension.'.png'))
            $img_path = 'images/fileicons/'.$extension.'.png';
        elseif(in_array($extension, array('log','ini','conf','js')))
            $img_path = 'images/fileicons/txt.png';
        else
            $img_path = 'images/fileicons/file.png';

        return $img_path;
    }
    
    // check if a file is public or inside a public folder
    public function isPublic($model) {
        if ($model->public == 1)
                return true;

        if (Folder::model()->findByPk($model->folder_id)->public == 1)
                return true;

        return false;
    }
    
    /* from http://php.net/manual/en/function.filesize.php */
    public function format_size($size) {
        $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        if ($size == 0) { return('0'); } else {
            
        return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('owner_id, file_name', 'required'),
			array('owner_id, public, created, last_edit', 'numerical', 'integerOnly'=>true),
            array('file_size', 'numerical', 'max'=>Yii::app()->params['maxFileSize']),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, folder_id, owner_id, file_name, public, file_size, created, last_edit', 'safe', 'on'=>'search'),
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
            'folder_id' => 'Folder ID',
			'owner_id' => 'Owner',
			'file_name' => 'Filename',
			'public' => 'Public',
            'file_size' => 'File Size',
			'created' => 'Created',
			'last_edit' => 'Last Edit',
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

		$criteria->compare('file_name',$this->file_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
    
    public function afterSave()
    {
        // add log message
        if ($this->public == 1)
            $reciever = 0;
        else
            $reciever = Yii::app()->user->id;
        
        if($this->isNewRecord)
            $message = "uploaded";
        else
            $message = "edited";
        
        LogEntry::createEntry(Yii::app()->user->id, $this->id, $message, $reciever);
    }
    
    public function afterDelete()
    {
        $log_entries = LogEntry::model()->findAll('item_id = :fid AND isFolder = 0', array(':fid'=>$this->id));
        foreach ($log_entries as $entry) {
            $entry->delete();
        }
    }
}
