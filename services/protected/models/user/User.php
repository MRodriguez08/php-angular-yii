<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property string $nick
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $surname
 * @property string $last_login
 * @property integer $enabled
 */
class User extends CActiveRecord {

    /**
     * Attribute to store the new photo on edit mode. Needed to validate file size
     */
    public $newPhotoData = null;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nick, email, password', 'required', 'message' => Yii::app()->params["emptyValueErrorMessage"]),
            array('nick', 'duplicatedUserName', 'message' => Yii::app()->params["templateDuplicatedValueErrorMessage"]),
            array('email', 'duplicatedUserEmal', 'message' => Yii::app()->params["templateDuplicatedValueErrorMessage"]),
            array('email', 'validateEmailFormat', 'message' => Yii::app()->params["invalidEmailFormatMessage"]),
            array('newPhotoData', 'validatePhotoSize', 'message' => Yii::app()->params["userPhotoFileSizeExceeded"]),
            array('enabled', 'numerical', 'integerOnly' => true),
            array('nick, email, password', 'length', 'max' => 64),
            array('name, surname', 'length', 'max' => 100),
            array('role', 'length', 'max' => 50),
            array('last_login', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('nick, email, name, surname, enabled', 'safe', 'on' => 'search'),
        );
    }

    public function duplicatedUserName($attribute, $params) {
        if ($this->isNewRecord) {
            if (count(User::model()->findALl('nick=:nick', array("nick" => $this->nick))) > 0)
                $this->addError($attribute, str_replace("{attribute}", $attribute, Yii::app()->params["templateDuplicatedValueErrorMessage"]));
        }
    }

    public function validatePhotoSize($attribute, $params) {
        if ($this->newPhotoData !== null) {
            if ((int) $this->newPhotoData['size'] > (int) Yii::app()->params['maxUserPhotoSize']) {
                $this->addError('photo', Yii::app()->params["userPhotoFileSizeExceeded"]);
            } else {
                $this->photo = file_get_contents($this->newPhotoData['tmp_name']);
            }
        }
    }

    public function duplicatedUserEmal($attribute, $params) {
        if ($this->isNewRecord) {
            if (count(User::model()->findALl('email=:email', array("email" => $this->email))) > 0)
                $this->addError($attribute, str_replace("{attribute}", $attribute, Yii::app()->params["templateDuplicatedValueErrorMessage"]));
        } else {
            if (count(User::model()->findALl('email=:email and nick <> :nick', array("email" => $this->email, "nick" => $this->nick))) > 0)
                $this->addError($attribute, str_replace("{attribute}", $attribute, Yii::app()->params["templateDuplicatedValueErrorMessage"]));
        }
    }

    public function validateEmailFormat($attribute, $params) {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->addError($attribute, Yii::app()->params["invalidEmailFormatMessage"]);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'nick' => 'Usuario',
            'email' => 'Email',
            'password' => 'Contrase&ntilde;a',
            'name' => 'Nombre',
            'surname' => 'Apellido',
            'last_login' => 'Ultimo Ingreso',
            'enabled' => 'Habilitado',
            'role' => 'Rol',
            'photo' => 'Imagen',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('nick', $this->nick, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('last_login', $this->last_login, true);
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function resetPassword() {
        $defPassword = Sysparam::model()->findByPk(AppConstants::PARAMETRO_CONTRASENIA_REINICIO);
        $this->password = crypt($defPassword->value);
    }

}
