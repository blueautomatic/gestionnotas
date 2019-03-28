<?php

/**
 * This is the model class for table "usuarios_areas".
 *
 * The followings are the available columns in table 'usuarios_areas':
 * @property integer $id
 * @property integer $idusuario
 * @property integer $idarea
 *
 * The followings are the available model relations:
 * @property Usuarios $idusuario0
 * @property Areas $idarea0
 */
class UsuariosAreas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios_areas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idusuario, idarea', 'required', 'on'=>'crearNuevaArea','message'=>'Debe completar el campo {attribute}.'),
			array('idusuario, idarea', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idusuario, idarea', 'safe', 'on'=>'search'),
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
			'idusuario0' => array(self::BELONGS_TO, 'Usuarios', 'idusuario'),
			'idarea0' => array(self::BELONGS_TO, 'Areas', 'idarea'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idusuario' => 'ID de usuario',
			'idarea' => 'Área a la cual pertenece',
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
		$criteria->compare('idusuario',$this->idusuario);
		$criteria->compare('idarea',$this->idarea);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAreaDeUsuario($idUsuario)
	{
		$area = $this->findAll('idusuario = ' . $idUsuario);
		return $area;
	}
	
	//Devuelve un array con una lista clave-valor de áreas (clave=idarea, valor=nombre)
	//Es llamada en nota/crearNota, usuario/create
	public function getListaDeAreas()
	{
		return CHtml::listData(Areas::model()->findAll(array('order'=>"`nombre` ASC")),"id","nombre");
	}
	
	public function getNombrearea()
	{
		return $this->idarea0->nombre;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsuariosAreas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}