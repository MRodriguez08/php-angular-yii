<?php

/**
 * This is the model class for table "audit".
 *
 * The followings are the available columns in table 'auditoria':
 * @property string $id
 * @property string $date_time
 * @property string $object
 * @property string $operation
 * @property string $description
 */
class Audit extends CActiveRecord {

    public $dateTimeFrom;
    public $dateTimeTo;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'audit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('date_time, object, operation, user', 'required'),
            array('object, operation', 'length', 'max' => 100),
            array('description', 'length', 'max' => 512),
            array('user', 'length', 'max' => 50),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('user, date_time, object, operation', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date_time' => 'Fecha',
            'object' => 'Objeto',
            'operation' => 'Operaci&oacute;n',
            'description' => 'Descripci&oacute;n',
            'user' => 'Usuario',
            'dateTimeFrom' => 'Desde',
            'dateTimeTo' => 'Hasta',
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
        if (isset($_GET["Audit"])) {
            $dH = new DateTimeHelper;
            $dtFrom = $dH->getDateTimeFromUI($_GET["Audit"]["dateTimeFrom"]);
            $dtTo = $dH->getDateTimeFromUI($_GET["Audit"]["dateTimeTo"]);
            if ($desde !== false) {
                $criteria->addCondition('date_time >= ' . $dtFrom->getTimestamp());
            } else {
                $criteria->addCondition('date_time >= ' . $dH->getDefaultStartRangeFilter("")->getTimestamp());
            }
            if ($hasta !== false) {
                $criteria->addCondition('date_time <= ' . $dtTo->getTimestamp());
            } else {
                $criteria->addCondition('date_time <= ' . $dH->getDefaultEndRangeFilter("audit")->getTimestamp());
            }
        }
        $criteria->compare('object', $this->object, true);
        $criteria->compare('operation', $this->operation, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('user', $this->user, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Audit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Description: logs an audit on the database, 
     * ¡¡ assumes that there is an active transaction !!
     * @param type $user
     * @param type $dateTime
     * @param type $object
     * @param type $operation
     * @param type $description
     * @throws \Exception
     */
    public function logAudit($user, $dateTime, $object, $operation, $description) {
        $a = new Audit;

        $a->description = $description;
        $a->date_time = $dateTime->getTimestamp();
        $a->user = $user;
        $a->object = $object;
        $a->operation = $operation;

        if (!$a->save())
            throw new \Exception("Error logging audit: " + CJSON::encode($a->getErrors()));
    }

}
