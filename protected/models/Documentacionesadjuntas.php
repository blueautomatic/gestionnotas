<?php

/**
 * This is the model class for table "documentacionesadjuntas".
 *
 * The followings are the available columns in table 'documentacionesadjuntas':
 * @property integer $id
 * @property string $tipo
 * @property string $descripcion
 * @property integer $idnota
 *
 * The followings are the available model relations:
 * @property Notas $idnota0
 */
class Documentacionesadjuntas extends CActiveRecord
{
	public $tipo_documentacion;
	public $array_tipo_documentacion = array(0=>'Historia clínica',1=>'Factura',2=>'Otra');
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'documentacionesadjuntas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			#array('tipo, descripcion, idnota', 'required'),
			array('idnota', 'required'),
			array('idnota', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>450),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tipo, descripcion, idnota', 'safe', 'on'=>'search'),
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
			'idnota0' => array(self::BELONGS_TO, 'Notas', 'idnota'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo' => 'Documentación adjunta',
			'descripcion' => 'Descripción',
			'idnota' => 'Idnota',
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
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('idnota',$this->idnota);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function search2($idnota)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idnota',$idnota);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Documentacionesadjuntas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
