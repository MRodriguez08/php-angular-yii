<?php

/**
 * This is the model class for table "brands".
 *
 * The followings are the available columns in table 'brands':
 * @property integer $id
 * @property string $name
 * @property string $nationality
 * @property string $location
 * @property string $founder
 * @property string $foundation_year
 * @property string $ceo
 * @property string $webpage
 * @property string $facebook
 * @property string $linkedin
 * @property string $googleplus
 * @property string $tweeter
 * @property string $instagram
 */
class Brand extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'brands';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, nationality', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('name, nationality, founder, ceo', 'length', 'max'=>50),
			array('location', 'length', 'max'=>1024),
			array('foundation_year', 'length', 'max'=>10),
			array('webpage, facebook, linkedin, googleplus, tweeter, instagram', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, nationality, location, founder, foundation_year, ceo, webpage, facebook, linkedin, googleplus, tweeter, instagram', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'nationality' => 'Nationality',
			'location' => 'Location',
			'founder' => 'Founder',
			'foundation_year' => 'Foundation Year',
			'ceo' => 'Ceo',
			'webpage' => 'Webpage',
			'facebook' => 'Facebook',
			'linkedin' => 'Linkedin',
			'googleplus' => 'Googleplus',
			'tweeter' => 'Tweeter',
			'instagram' => 'Instagram',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('founder',$this->founder,true);
		$criteria->compare('foundation_year',$this->foundation_year,true);
		$criteria->compare('ceo',$this->ceo,true);
		$criteria->compare('webpage',$this->webpage,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('linkedin',$this->linkedin,true);
		$criteria->compare('googleplus',$this->googleplus,true);
		$criteria->compare('tweeter',$this->tweeter,true);
		$criteria->compare('instagram',$this->instagram,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Brand the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
