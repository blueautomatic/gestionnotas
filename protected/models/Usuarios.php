<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $usuario
 * @property string $contrasenia
 * @property string $nombre
 * @property string $apellido
 *
 * The followings are the available model relations:
 * @property Notas[] $notases
 * @property UsuariosAreas[] $usuariosAreases
 */
class Usuarios extends CActiveRecord
{
	public $contrasenia_repeat;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, contrasenia, nombre, apellido', 'required', 'on'=>'insert', 'message'=>'Debe completar el campo {attribute}'),
			array('usuario, nombre, apellido', 'length', 'max'=>45),
			array('contrasenia', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, contrasenia, nombre, apellido', 'safe', 'on'=>'search'),
			array('usuario', 'unique', 'on'=>'insert, update', 'message'=>'Este usuario ya existe'),
			array('contrasenia_repeat', 'compare', 'on'=>'insert, update', 'compareAttribute'=>'contrasenia', 'message'=>'Las contraseñas no coinciden'),
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
			'notas' => array(self::HAS_MANY, 'Notas', 'idusuario'),
			'usuariosAreas' => array(self::HAS_MANY, 'UsuariosAreas', 'idusuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'contrasenia' => 'Contraseña',
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'contrasenia_repeat' => 'Repetir contraseña',
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
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('contrasenia',$this->contrasenia,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido',$this->apellido,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//Retorna una cadena de caracteres a layouts/main.php, en el menú de usuario
	public function getLabel($id)
	{
		if(Yii::app()->authManager->checkAccess('administrador', $id))
			return 'Modificar perfil';
		else return 'Modificar contraseña';
	}
	
	public function getAreas($id)
	{
		$ua = new UsuariosAreas;
		$a = $ua->findAllBySql('SELECT idarea FROM usuarios_areas WHERE idusuario =?',array($id));
		$lista = '';
		if(empty($a))
		{
			return '<span style="color: Coral;">No tiene áreas asociadas</span>';
		}
		else
		{
			foreach($a as $a)
			{
				$area = Areas::model()->findByAttributes(array('id'=>intval($a['idarea'])));
				if($area != null)
				{
					$lista = $lista . $area->nombre . ' ' . CHtml::link('<i class="fa fa-times" aria-hidden="true"></i>',array('usuariosareas/eliminar', 'nombre'=>$area->nombre, 'usuario'=>$id), array('style'=>'color: #f00','title'=>'Eliminar')) . '<br></br>';
				}
				else return rtrim($lista, "<br></br>");
			}
			return rtrim($lista, "<br></br>");
		}
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}