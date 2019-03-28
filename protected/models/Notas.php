<?php

/**
 * This is the model class for table "notas".
 *
 * The followings are the available columns in table 'notas':
 * @property integer $id
 * @property integer $nronota
 * @property string $fecharealizacion
 * @property string $fechaenvio
 * @property integer $origen
 * @property integer $destino
 * @property string $descripcion
 * @property string $observaciones
 * @property integer $idusuario
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Documentacionesadjuntas[] $documentacionesadjuntases
 * @property Areas $origen0
 * @property Areas $destino0
 * @property Usuarios $idusuario0
 * @property NotasProveedores[] $notasProveedores
 * @property Seguimientos[] $seguimientoses
 */
class Notas extends CActiveRecord
{
	public $mostrar_origen;
	public $mostrar_destino;
	public $mostrar_nombreusuario;
	public $mostrar_nronota;
	public $mostrar_nro;
	public $mostrar_anio;
	public $mostrar_fecharealizacion;
	public $mostrar_fechaenvio;
	public $fakefecha;
	public $ver_botones_answer;
	public $fecha_desde;
	public $fecha_hasta;
	public $date_first; //Agregar esta variable
	public $date_last; //Agregar esta variable
	public $prov;
	public $destinoCustom;
	public $importeA;
	public $importeB;
	public $name_prov;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nronota, fecharealizacion, origen, destino, descripcion, idusuario, status', 'required', 'message'=>'Debe completar el campo {attribute}.'),
			array('nronota, origen, destino, idusuario, status', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>10000),
			array('observaciones', 'length', 'max'=>5000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('importeA, importeB, destinoCustom, prov, date_first, date_last,id, nronota, fecharealizacion, fechaenvio, origen, destino, descripcion, observaciones, idusuario, status', 'safe', 'on'=>'search'),
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
			'documentacionesadjuntas' => array(self::HAS_MANY, 'Documentacionesadjuntas', 'idnota'),
			'origen0' => array(self::BELONGS_TO, 'Areas', 'origen'),
			'destino0' => array(self::BELONGS_TO, 'Areas', 'destino'),
			'idusuario0' => array(self::BELONGS_TO, 'Usuarios', 'idusuario'),
			'notasProveedores' => array(self::HAS_MANY, 'NotasProveedores', 'idnota'),
			'seguimiento' => array(self::HAS_MANY, 'Seguimientos', 'idnota'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nronota' => 'N° de nota',
			'fecharealizacion' => 'Fecha de realización',
			'fechaenvio' => 'Fecha de envío',
			'origen' => 'Origen',
			'destino' => 'Destino',
			'descripcion' => 'Detalle',
			'observaciones' => 'Observaciones',
			'idusuario' => 'ID usuario',
			'status' => 'Status',
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
		$criteria->compare('nronota',$this->nronota);
		$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
		$criteria->compare('fechaenvio',$this->fechaenvio,true);
		$criteria->compare('origen',$this->origen);
		$criteria->compare('destino',$this->destino);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('idusuario',$this->idusuario);
		$criteria->compare('status',$this->status);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'defaultOrder'=>'username ASC',
			),*/
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
	}
	
	/*
	* Carga la bandeja de entrada.
	*/
	public function search2()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
	
		if(Yii::app()->user->checkAccess('administrador'))
		{
			$criteria->compare('id',$this->id);
			$criteria->compare('nronota',$this->nronota);
			$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
			$criteria->compare('fechaenvio',$this->fechaenvio,true);
			$criteria->compare('origen',$this->origen);
			$criteria->compare('destino',$this->destino);
			$criteria->compare('descripcion',$this->descripcion,true);
			$criteria->compare('observaciones',$this->observaciones,true);
			$criteria->compare('idusuario',$this->idusuario);
			$criteria->compare('status',$this->status);
		}
		else
		{
			$areaUsuario = $this->getAreaUsuario();
			if(gettype($areaUsuario) == "string")
			{
				$criteria->compare('destino',$areaUsuario);
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('origen',$this->origen);
				$criteria->addCondition('fechaenvio IS NOT NULL');
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
			}
			else
			{
				for($i = 0; $i < count($areaUsuario); $i++)
					$criteria->compare('destino',$areaUsuario[$i]->idarea, false, 'OR');
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('origen',$this->origen);
				$criteria->addCondition('fechaenvio IS NOT NULL');
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
				
			}
		}
		
		$criteria->order = 'status, fecharealizacion DESC';
	
		if((isset($this->date_first) && trim($this->date_first) != "") && (isset($this->date_last) && trim($this->date_last) != ""))
			$criteria->addBetweenCondition('fechaenvio', ''.$this->date_first.'', ''.$this->date_last.'');
		$criteria->with = array('notasProveedores');
		$criteria->together = true;
		$criteria->compare('notasProveedores.idproveedor',$this->prov->idproveedor);
		if((isset($this->importeA) && trim(strval($this->importeA)) != "") && (isset($this->importeB) && trim(strval($this->importeB)) != ""))
			$criteria->addBetweenCondition('notasProveedores.importe', $this->importeA, $this->importeB);
		
		if(isset($this->destinoCustom))
			$criteria->compare('destino',$this->destinoCustom);

		$_SESSION['datos_filtrados'] = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'attributes'=>array('asc' => 'destino'),
			),*/
			'pagination'=>false,
		));
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'attributes'=>array('asc' => 'destino'),
			),*/
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
	}
	
	/*
	* Carga la bandeja de salida.
	*/
	public function search3()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(Yii::app()->user->checkAccess('administrador'))
		{
			$criteria->compare('id',$this->id);
			$criteria->compare('nronota',$this->nronota);
			$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
			$criteria->compare('fechaenvio',$this->fechaenvio,true);
			$criteria->compare('origen',$this->origen);
			$criteria->compare('destino',$this->destino);
			$criteria->compare('descripcion',$this->descripcion,true);
			$criteria->compare('observaciones',$this->observaciones,true);
			$criteria->compare('idusuario',$this->idusuario);
			$criteria->compare('status',$this->status);
		}
		else
		{
			$areaUsuario = $this->getAreaUsuario();
			if(gettype($areaUsuario) == "string")
			{
				$criteria->compare('origen',$areaUsuario);
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('destino',$this->destino);
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->addCondition('fechaenvio IS NOT NULL');
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
			}
			else
			{
				for($i = 0; $i < count($areaUsuario); $i++)
					$criteria->compare('origen',$areaUsuario[$i]->idarea, false, 'OR');
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('destino',$this->destino);
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->addCondition('fechaenvio IS NOT NULL');
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
			}
		}

		$criteria->order = 'status, fechaenvio DESC';
		if((isset($this->date_first) && trim($this->date_first) != "") && (isset($this->date_last) && trim($this->date_last) != ""))
			$criteria->addBetweenCondition('fechaenvio', ''.$this->date_first.'', ''.$this->date_last.'');
		$criteria->with = array('notasProveedores');
		$criteria->together = true;
		$criteria->compare('notasProveedores.idproveedor',$this->prov->idproveedor);
		if((isset($this->importeA) && trim($this->importeA) != "") && (isset($this->importeB) && trim($this->importeB) != ""))
			$criteria->addBetweenCondition('notasProveedores.importe', $this->importeA, $this->importeB);

		if(isset($this->destinoCustom))
			$criteria->compare('origen',$this->destinoCustom);

		$_SESSION['datos_filtrados'] = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'attributes'=>array('asc' => 'destino'),
			),*/
			'pagination'=>false,
		));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'defaultOrder'=>'username ASC',
			),*/
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
	}
	
	/*
	* Carga la bandeja de notas pendientes de envío.
	*/
	public function search4()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(Yii::app()->user->checkAccess('administrador'))
		{
			$criteria->compare('id',$this->id);
			$criteria->compare('nronota',$this->nronota);
			$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
			$criteria->addCondition('fechaenvio IS NULL');
			$criteria->compare('origen',$this->origen);
			$criteria->compare('destino',$this->destino);
			$criteria->compare('descripcion',$this->descripcion,true);
			$criteria->compare('observaciones',$this->observaciones,true);
			$criteria->compare('idusuario',$this->idusuario);
			$criteria->compare('status',$this->status);
		}
		else
		{
			$areaUsuario = $this->getAreaUsuario();
			if(gettype($areaUsuario) == "string")
			{
				#$this->defineDateCriteria($this->fechaenvio,$criteria);
				$criteria->compare('origen',$areaUsuario);
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('destino',$this->destino);
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->addCondition('fechaenvio IS NULL');
				#$criteria->compare('fechaenvio','0000-00-00 00:00:00',true);
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
			}
			else
			{
				#$this->defineDateCriteria($this->fechaenvio,$criteria);
				for($i = 0; $i < count($areaUsuario); $i++)
					$criteria->compare('origen',$areaUsuario[$i]->idarea, false, 'OR');
				$criteria->compare('id',$this->id);
				$criteria->compare('nronota',$this->nronota);
				$criteria->compare('destino',$this->destino);
				$criteria->compare('fecharealizacion',$this->fecharealizacion,true);
				$criteria->addCondition('fechaenvio IS NULL');
				#$criteria->compare('fechaenvio','0000-00-00 00:00:00',true);
				$criteria->compare('descripcion',$this->descripcion,true);
				$criteria->compare('observaciones',$this->observaciones,true);
			}
		}
		
		$criteria->order = 'status, fecharealizacion DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/*'sort'=>array(
				'defaultOrder'=>'username ASC',
			),*/
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
	}

	/*
	* Retorna una cadena de caracteres que se utiliza dentro de una etiqueta HTML,
	* con el objetivo de especificar una clase HTML y aplicar el estilo CSS correspondiente a esa clase.
	* Es llamada en nota/_view.php y en nota/_outbox.php
	*/
	public function getClaseInbox($status)
	{
		if($status)
			return "leido";
		else return "no-leido";
	}
	
	public function getListaDeAreasDelUsuario()
	{
		return CHtml::listData(UsuariosAreas::model()->findAll(array('condition'=>'`idusuario`=' . Yii::app()->user->id)),'idarea','nombrearea');
	}
		
	public function setearDatos($nota, $area)
	{
		$usuariosAreas = $this->getAreaUsuario();
		if(gettype($usuariosAreas) == "string")
		{
			/* CAMPO ORIGEN */
			$nota->origen = $usuariosAreas;
			$nota->mostrar_origen = $nota->origen0->nombre;
			
			/* CAMPO NRONOTA */
			//se carga la instancia de clase Areas con el id del área del usuario actual
			$area = Areas::model()->findByPk($usuariosAreas);
			$this->determinarNumeronota($usuariosAreas, $area);
			$nota->nronota = $this->nronota;
			#$nota->mostrar_nronota = $nota->nronota . '/' . date('Y');
			
			/* CAMPO FECHAREALIZACION */
			$nota->fecharealizacion = date('Y-m-d G:i:s');
			$nota->mostrar_fecharealizacion = date('d/m/Y');

			/* CAMPO IDUSUARIO */
			$nota->idusuario = Yii::app()->user->id;
			
			/* CAMPO STATUS */
			$nota->status = 0;
		}
		else
		{
			for($i = 0; $i < count($usuariosAreas); $i++)
				$var = $usuariosAreas[$i]->id;
			$this->determinarNumeronota($var, $area);
			
			/* CAMPO FECHAREALIZACION */
			$nota->fecharealizacion = date('Y-m-d G:i:s');
			$nota->mostrar_fecharealizacion = date('d/m/Y');

			/* CAMPO IDUSUARIO */
			$nota->idusuario = Yii::app()->user->id;

			/* CAMPO STATUS */
			$nota->status = 0;
		}
	}
	
	/* Esta función setea el número de nota, teniendo en cuenta el área que está enviando la nota
	 * (distintas áreas usan diferentes contadores de nota), y teniendo en cuenta también si
	 * ha cambiado el año, en cuyo caso todos los contadores se reinician a 1.
	 * Guarda el número de nota en tabla Nota, y mantiene actualizado el contador de números
	 * de nota por área, que se encuentra en la tabla Area.
	 * */
	public function determinarNumeronota($areaOrigen, $modelarea)
	{
		//se selecciona el último registro de la tabla Nota, del cual se obtiene el año
		$fecha = Yii::app()->db->createCommand("SELECT fecharealizacion AS max_f FROM notas ORDER BY id DESC LIMIT 1;")->queryRow();
		$f = explode('-', $fecha['max_f']);
		
		if(date('Y') != $f[0]) //si el año actual difiere del año registrado en el último INSERT realizado, se reinician los contadores
		{
			$modelarea->reiniciarContadores();
			$this->nronota = 1;
			$modelarea->contador = $this->nronota;
		}
		else
		{
			$modelarea->actualizarContador($areaOrigen, $modelarea);
			$this->nronota = $modelarea->contador;
		}
	}
	
	/*
	* Devuelve el área o un array -de objetos- de áreas a las que pertenece el usuario que tiene sesión iniciada actualmente.
	*/
	public function getAreaUsuario()
	{
		$uA = new UsuariosAreas;
		//busca a qué áreas pertenece el usuario actual
		$usuariosAreas = $uA->getAreaDeUsuario(Yii::app()->user->id);
		if(count($usuariosAreas) == 1)
		{
			//si es 1 área, devuelve el ID de esa área
			return $usuariosAreas[0]->idarea;			
		}
		else
		{
			//si el usuario pertenece a más de 1 área, devuelve un array de objetos de clase UsuariosAreas
			return $usuariosAreas;
		}
	}
	
	public function getListaAreas()
	{
		$usuariosAreas = $this->getAreaUsuario();
		$listaIDS = array();
		for($i=0; $i < count($usuariosAreas); $i++)
		{
			array_push($listaIDS,$usuariosAreas[$i]->idarea);
		}
			
		$criteria = new CDbCriteria();
		$criteria->addInCondition('id',$listaIDS);
		$result = Areas::model()->findAll($criteria);
		return CHtml::listData($result,'id','nombre');
	}
	
	public function checkVisible()
	{
		if(gettype($this->getAreaUsuario())==="string")
			return false;
		else return true;
	}
	
	/*
	* Devuelve el número de nota con el formato numeronota/año (23/2015).
	* Es llamada desde nota/_view.php, nota/_outbox.php, movimientonota/admin.php, nota/view2.php
	*/
	public function getNumeroDeNota($idNota)
	{
		$model = Notas::model()->findByPk($idNota);
		// $model->fecharealizacion viene de la DB con el formato yyyy-mm-dd G:i:s
		$fechaExploded = explode('-', $model->fecharealizacion);
		return strval($model->nronota) . '/' . $fechaExploded[0];
	}
	
	/*
	* Verifica si la nota fue leída o no. Si no estaba leída,
	* al abrir la nota la marca como leída.
	* Es llamada en nota/inbox.
	*/
	public function actualizarStatus($id)
	{
		$nota = Notas::model()->findByPk($id);
		$nota->status = 1;
		$nota->save();
	}
	
	/* Devuelve un string con el nombre del navegador que el cliente usa. */
	public function get_browser_name($user_agent)
	{
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
		elseif (strpos($user_agent, 'Edge')) return 'Edge';
		elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
		elseif (strpos($user_agent, 'Safari')) return 'Safari';
		elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
	   
		return 'Other';
	}

	/*
	* Devuelve la fecha con un formato amigable al usuario.
	* Llamada desde views/notas/_inboxNota.php
	*/
	public function setFecha($fecha)
	{
		if($fecha != null)
			return date("d/m/y" . html_entity_decode("&emsp;&emsp;") . "H:i", strtotime($fecha));
		else return '<span style="color: Coral;">Fecha no asignada</span>';
	}

	public function setFechaSinHora($fecha)
	{
		if($fecha != null)
			return date("d/m/y" . html_entity_decode("&emsp;&emsp;"), strtotime($fecha));
		else return '<span style="color: Coral;">Fecha no asignada</span>';
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}