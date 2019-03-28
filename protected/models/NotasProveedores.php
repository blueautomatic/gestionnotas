<?php

/**
 * This is the model class for table "notas_proveedores".
 *
 * The followings are the available columns in table 'notas_proveedores':
 * @property integer $id
 * @property integer $idnota
 * @property integer $idproveedor
 * @property integer $importe
 *
 * The followings are the available model relations:
 * @property Notas $idnota0
 * @property Proveedores $idproveedor0
 */
class NotasProveedores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notas_proveedores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idnota', 'required', 'on'=>'update', 'message'=>'Debe completar el campo {attribute}.'),
			array('idnota, idproveedor', 'numerical', 'integerOnly'=>true, 'message'=>"Este campo debe ser un número."),
			array('importe', 'required', 'on'=>'importeObligatorio', 'message'=>'Si asocia un proveedor a la nota, debe ingresar un importe.'),
			array('importe', 'match', 'pattern'=>'/^(\d*\,?\d*[0-9]+\d*$)|(^[0-9]+\d*\,\d*)|(\d*\.?\d*[0-9]+\d*$)|(^[0-9]+\d*\.\d*)$/', 'message'=>"Sólo se permiten números."),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idnota, idproveedor, importe', 'safe', 'on'=>'search'),
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
			'idproveedor0' => array(self::BELONGS_TO, 'Proveedores', 'idproveedor'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idnota' => 'Idnota',
			'idproveedor' => 'Proveedor',
			'importe' => 'Importe',
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
		$criteria->compare('idnota',$this->idnota);
		$criteria->compare('idproveedor',$this->idproveedor);
		$criteria->compare('importe',$this->importe);

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
	
	public function getNombreProveedor()
	{
		return CHtml::listData(Proveedores::model()->findAll(),'id','nombre');
	}
	
	public function cambiarPuntoPorComa($importe)
	{
		$importe = str_replace('.',',',$importe);
		return $importe;
	}
	
	public function guardarProveedor($term)
	{
		$prov = new Proveedores;
		$prov->nombre = $_GET['term'];
		$prov->save();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotasProveedores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}