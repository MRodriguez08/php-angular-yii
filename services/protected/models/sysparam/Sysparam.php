<?php

/**
 * This is the model class for table "parametros".
 *
 * The followings are the available columns in table 'parametros':
 * @property string $name
 * @property string $description
 * @property string $value
 */
class Sysparam extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sysparams';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, value, description', 'required', "message" => Yii::app()->params["emptyValueErrorMessage"]),
            array('value', 'validateParameter', 'message' => Yii::app()->params["invalidEmailFormatMessage"]),
            array('name', 'length', 'max' => 64),
            array('description', 'length', 'max' => 1024),
            array('value', 'length', 'max' => 512),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, description, value', 'safe', 'on' => 'search'),
        );
    }
    
    public function validateParameter($attribute, $params) {
        
        //Valido segun type de parametro
        if ((strcmp($this->type,  AppConstants::TIPO_PARAMETRO_INTEGER) == 0) && !ctype_digit(strval($this->value))){
            $this->addError($attribute, "Este parametro es de type entero");
            return;
        }            
        
        if ((strcmp($this->name,  AppConstants::PARAMETRO_DESV_LATITUD) == 0)){
            if ((int)$this->value > 150){
                $this->addError($attribute, "No se recomienda que la desviacion de latitud supere los 150 puntos");
                return;
            }
        } else if ((strcmp($this->name,  AppConstants::PARAMETRO_DESV_LONGITUD) == 0)){
            if ((int)$this->value > 150){
                $this->addError($attribute, "No se recomienda que la desviacion de longitud supere los 150 puntos");
                return;
            }
        } else if ((strcmp($this->name,  AppConstants::PARAMETRO_EMAIL_ADMINISTRADOR) == 0)){
            if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)){
                $this->addError($attribute, "Este parametro debe ser un email valido (ej. juan@gmail.com)");
                return;
            }
        }
        
        
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
            'name' => 'Nombre',
            'description' => 'Descripci&oacute;n',
            'value' => 'Valor',
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

        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Parametro the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
