<?php

/**
 * This is the model class for table "areas".
 *
 * The followings are the available columns in table 'areas':
 * @property integer $id
 * @property string $nombre
 * @property integer $contador
 *
 * The followings are the available model relations:
 * @property UsuariosAreas[] $usuariosAreases
 */
class Areas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'areas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, contador', 'required', 'on'=>'crearnueva', 'message'=>'Debe completar el campo {attribute}'),
			array('contador', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, contador', 'safe', 'on'=>'search'),
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
			'usuariosAreas' => array(self::HAS_MANY, 'UsuariosAreas', 'idarea'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'contador' => 'Contador',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('contador',$this->contador);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function reiniciarContadores()
	{
		$totalAreas = Areas::model()->findAll();
		$max = count($totalAreas);
		for($i = 1; $i < $max; $i++) 
		{
			$area = Areas::model()->findByPk($i); //se busca cada área existente
			$area->contador = 0; //se reinicia el contador
			$area->save(); //se guardan los cambios
		}
	}
	
	public function actualizarContador($idarea, $area)
	{
		//se seleciona el contador correspondiente al área a la cual pertenece el usuario actual
		$query = Yii::app()->db->createCommand('SELECT contador AS c FROM areas WHERE id = ' . $idarea . ';')->queryRow();
		$this->contador = $query['c'] + 1;
	}

	public function getUsuarios($id, $nombre)
	{
		$ua = new UsuariosAreas;
		$u = $ua->findAllBySql('SELECT idusuario FROM usuarios_areas WHERE idarea =?',array($id));
		$lista = '';
		if(empty($u))
		{
			return '<span style="color: Coral;">No tiene usuarios asociados</span>';
		}
		else
		{
			foreach($u as $u)
			{
				$usuario = Usuarios::model()->findByAttributes(array('id'=>intval($u['idusuario'])));
				if($usuario != null)
				{
					$lista = $lista . $usuario->nombre . ' ' . $usuario->apellido . ' ' . CHtml::link('<i class="fa fa-times" aria-hidden="true"></i>',array('usuariosareas/eliminar', 'nombre'=>$nombre, 'usuario'=>$u->idusuario), array('style'=>'color: #f00','title'=>'Eliminar')) . '<br></br>';
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
	 * @return Areas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}