<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 *
 * The followings are the available model relations:
 */
class User extends CActiveRecord
{
	public $password_confirmation;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email', 'required', 'on'=>'register, update'),
			//array('username, email', 'unique'),
			array('username', 'length', 'max'=>20, 'min'=>1),
			array('email','email'),
			array('password', 'required', 'on'=>'register, login'),
			array('password', 'length', 'max'=>30, 'min'=>1),
			array('password_confirmation', 'required', 'on'=>'register'),
			array('password_confirmation', 'safe'),
			array('password', 'compare', 'compareAttribute'=>'password_confirmation', 'on'=>'register, update'),
			array('password, password_confirmation, email', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('username, email', 'safe', 'on'=>'search'),
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
			'fb_id' => 'Facebook ID',
			'username' => 'Username',
			'password' => 'Password',
			'password_confirmation' => 'Password confirmation',
			'email' => 'Email',
			'created' => 'Joined',
			'updated' => 'Last edit',
			'last_login' => 'Last login',
			'login_count' => 'Login count',
			'failed_login_attempts' => 'Failed login attempts',
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

		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function validate_password($password)
    {
        return $this->hash_password($password)===$this->password;
    }
 
    public function hash_password($password)
    {
        return md5($this->salt.$password);
    }

	public function generate_salt()
	{
	    return uniqid('',true);
	}

	public function beforeSave() {
	           
		$currently_saved_user = User::model()->findByPk((int)$this->id);

		if ($this->scenario == "update")
			$this->updated = time();

		if (empty($this->salt))
			$this->salt = $this->generate_salt();

		if($this->password == '' || ($currently_saved_user != null && $this->hash_password($this->password) === $currently_saved_user->password))
			$this->password = $currently_saved_user->password;
		else {
			$this->password = $this->hash_password($this->password);
		}

		return true;
 	}

    public function afterSave() 
    {
        // if the record is new, then send a welcome email.
        if($this->isNewRecord) {
            
            $message = new YiiMailMessage;
            $message->view = 'email';
            $message->setBody(array('model'=>$this), 'text/html');                 
            $message->addTo($this->email);
            $message->from = Yii::app()->params['admin_email'];
            $message->subject = 'Hello '.$this->username.', welcome to FileStorage.';
            
            Yii::app()->mail->send($message);
        }
            
        if(!file_exists(Yii::app()->params['filesPath'].'/'.$this->id)) {
            // make folder in database.
            $folder = new Folder;
            $folder->folder_name = 'root';
            $folder->is_root = 1;
            $folder->owner_id = $this->id;
            $folder->save();
            // create folder on disk
            mkdir(Yii::app()->params['filesPath'].'/'.$this->id);
        }
    }
}