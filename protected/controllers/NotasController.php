<?php

class NotasController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow users with role administrador_notas to perform all actions
				'actions'=>array(/*'index',*/'ver','cargar','update','admin','delete','inbox','outbox','crearNronota','autocomplete','contestar','reenviar','inbox2','outbox2','pendientes','asignarFecha','excel'),
				'roles'=>array('administrador_notas'),
			),
			array('allow',  // allow users with role crear_notas to perform some actions
				'actions'=>array(/*'index',*/'ver','cargar','admin','inbox','outbox','crearNronota','autocomplete','contestar','reenviar','inbox2','outbox2','pendientes','asignarFecha','excel'),
				'roles'=>array('crear_notas'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionVer($id)
	{
		//cargo un modelo de clase Notas
		$model = $this->loadModel($id);
		$modelpro = NotasProveedores::model()->findByAttributes(array('idnota'=>$model->id));
		$modeldoc = Documentacionesadjuntas::model()->findByAttributes(array('idnota'=>$model->id));

		//averiguo si el usuario pertenece a un área o a más de un área
		$usuariosAreas = $model->getAreaUsuario();

		//si el usuario pertenece a 1 sola área...
		if(gettype($usuariosAreas) != "array")
		{
			if($model->destino == $usuariosAreas || $model->origen == $usuariosAreas || Yii::app()->user->checkAccess('administrador'))
			{
				if($model->destino == $usuariosAreas)
					$model->actualizarStatus($id);
				
				$this->render('view',array(
					'model'=>$this->loadModel($id),
					'modelpro'=>$modelpro,
					'modeldoc'=>$modeldoc,
				));
			}
			else $this->redirect(array('inbox'));
		}
		else //si el usuario pertenece a más de 1 área...
		{
			$areaD = 0;
			$areaO = 0;
			for($i = 0; $i < count($usuariosAreas); $i++)
			{
				if($model->destino == $usuariosAreas[$i]->idarea)
					$areaD = $usuariosAreas[$i]->idarea;
				if($model->origen == $usuariosAreas[$i]->idarea)
					$areaO = $usuariosAreas[$i]->idarea;
			}
			
			if($areaD == intval($model->destino) || $areaO == intval($model->origen) || Yii::app()->user->checkAccess('administrador'))
			{
				if($areaD == $model->destino)
					$model->actualizarStatus($id);
				
				$this->render('view',array(
					// para el CDetailView es 'model'=>$this->loadModel($id),
					'model'=>$this->loadModel($id),
					'modelpro'=>$modelpro,
					'modeldoc'=>$modeldoc,
				));
			}
			else $this->redirect(array('inbox'));
		}
	}
	
	public function actionReenviar($id)
	{
		//cargo un modelo de clase Notas
		$modelshow = $this->loadModel($id); //muestro los datos de la nota que estoy reenviando
		$model = new Notas; //instancia nueva que va a guardar los datos del usuario -y otros datos precargados automáticamente
		$modelseg = new Seguimientos;
		$modeldoc = new Documentacionesadjuntas;
		$modelpro = new NotasProveedores;

		$modelseg->frealizacion = date('Y-m-d G:i:s');
		$usuariosAreas = $model->getAreaUsuario();
		if(gettype($usuariosAreas) == "string") //si el usuario pertenece a un área, se carga automáticamente
		{
			$model->origen = $usuariosAreas;
			$model->mostrar_origen = $model->origen0->nombre;
			$modelseg->aorigen = $model->origen;
		}
		
		if(isset($_POST['Notas']))
		{
			$model->attributes = $_POST['Notas'];
			
			$usuariosAreas = $model->getAreaUsuario();
			if(intval($_POST['Notas']['origen']) !== 0) //si pertenece a más de un área, es el usuario el que carga este dato
			{
				$model->origen = $_POST['Notas']['origen'];
				$modelseg->aorigen = $model->origen;
			}
			
			if($_POST['Documentacionesadjuntas']['tipo'] !== '')
			{
				$modeldoc->attributes = $_POST['Documentacionesadjuntas'];
				$modeldoc->idnota = $_GET['id'];
				$modeldoc->save();
			}
			
			if(intval($_POST['NotasProveedores']['idproveedor']) == 0)
			{
				$newProv = new Proveedores;
				$newProv->nombre = strval($_POST['Notas']['name_prov']);
				$newProv->save();
			}

			if(intval($_POST['NotasProveedores']['idproveedor']) != 0 && intval($_POST['NotasProveedores']['importe']) == 0)
				$modelpro->scenario = "importeObligatorio";
			
			if($modelpro->validate())
			{
				if(intval($_POST['NotasProveedores']['idproveedor']) !== 0)
				{
					$modelpro->attributes = $_POST['NotasProveedores'];
					$modelpro->importe = str_replace(',','.',$modelpro->importe);
					$modelpro->save($modelpro->idnota=$_GET['id']);
				}
				else if(intval($_POST['NotasProveedores']['idproveedor']) == 0 && strval($_POST['Notas']['name_prov']) !== "")
				{
					$modelpro->attributes = $_POST['NotasProveedores'];
					$modelpro->idproveedor = Proveedores::model()->findByAttributes(array('nombre'=>strval($_POST['Notas']['name_prov'])))->id;
					$modelpro->importe = str_replace(',','.',$modelpro->importe);
					$modelpro->save($modelpro->idnota=$_GET['id']);
				}
			}

			$modelseg->idnota_referencia = Seguimientos::model()->findByAttributes(array('asunto'=>$modelshow->descripcion))->idnota_referencia;
			$modelseg->asunto = $model->descripcion;
			$modelseg->adestino = $model->destino;
			
			if(intval($_POST['Notas']['fechaenvio']) !== 0)
			{
				$model->fakefecha = $_POST['Notas']['fechaenvio'];
				$model->fechaenvio = DateTime::createFromFormat('d/m/Y', $model->fakefecha)->format('Y-m-d G:i:s');
				$modelseg->fenvio = $model->fechaenvio;
			}

			$model->nronota = $modelshow->nronota;
			$model->fecharealizacion = $modelseg->frealizacion;
			$model->idusuario = Yii::app()->user->id;
			$model->status = 0;

			if($model->save() && $modelseg->save($modelseg->idnota = $model->id))
			{
				if($model->fechaenvio !== null)
				{
					Yii::app()->user->setFlash('success', "La nota se ha enviado.");
					$this->redirect(array('outbox'));
				}
				else
				{
					Yii::app()->user->setFlash('success', "La nota está cargada. Queda pendiente de envío.");
					$this->redirect(array('pendientes'));
				}
			}
		}

		//averiguo si el usuario pertenece a un área o a más de un área
		$usuariosAreas = $modelshow->getAreaUsuario();

			//si el usuario pertenece a 1 sola área...
		if(gettype($usuariosAreas) != "array")
		{
			if($modelshow->destino == $usuariosAreas || $modelshow->origen == $usuariosAreas || Yii::app()->user->checkAccess('administrador'))
			{
				if($modelshow->destino == $usuariosAreas)
					$modelshow->actualizarStatus($id);
				
				$this->render('view2',array(
					'modelshow'=>$this->loadModel($id),
					'model'=>$model,
					'modelseg'=>$modelseg,
					'modeldoc'=>$modeldoc,
					'modelpro'=>$modelpro,
				));
			}
			else $this->redirect(array('inbox'));
		}
		else //si el usuario pertenece a más de 1 área...
		{
			$areaD = 0;
			$areaO = 0;
			for($i = 0; $i < count($usuariosAreas); $i++)
			{
				if($modelshow->destino == $usuariosAreas[$i]->idarea)
					$areaD = $usuariosAreas[$i]->idarea;
				if($modelshow->origen == $usuariosAreas[$i]->idarea)
					$areaO = $usuariosAreas[$i]->idarea;
			}
			
			if($areaD == $modelshow->destino || $areaO == intval($modelshow->origen) || Yii::app()->user->checkAccess('administrador'))
			{
				if($areaD == $modelshow->destino)
					$modelshow->actualizarStatus($id);
				
				$this->render('view2',array(
					// para el CDetailView es 'model'=>$this->loadModel($id),
					'modelshow'=>$this->loadModel($id),
					'model'=>$model,
					'modelseg'=>$modelseg,
					'modeldoc'=>$modeldoc,
					'modelpro'=>$modelpro,
				));
			}
			else $this->redirect(array('inbox'));
		}
	}
	
	public function actionAsignarFecha($id)
	{
		//cargo un modelo de clase Notas
		$model = $this->loadModel($id);
		$modelseg = Seguimientos::model()->findByAttributes(array('idnota'=>$id));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Notas']))
		{
			$model->fakefecha = $_POST['Notas']['fechaenvio'];
			$model->fechaenvio = DateTime::createFromFormat('d/m/Y', $model->fakefecha)->format('Y-m-d G:i:s');
			$modelseg->fenvio = $model->fechaenvio;
			
			if($model->save() && $modelseg->save())
			{
				Yii::app()->user->setFlash('success', "Se asignó fecha de envío. La nota ha sido enviada.");
				$this->redirect(array('outbox'));
			}
		}

		$this->render('view3',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCargar()
	{
		$model=new Notas;
		$modelseg = new Seguimientos;
		$modeldoc = new Documentacionesadjuntas;
		$modelpro = new NotasProveedores;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$modelarea = new Areas;
		$model->setearDatos($model, $modelarea); //precarga de datos por defecto
		$usuariosAreas = $model->getAreaUsuario();
		if(gettype($usuariosAreas) == "string")
		{
			$modelarea = $modelarea->findByPk($model->origen0->id);
			$modelarea->contador = $model->nronota;
		}
		
		if(isset($_POST['Notas']))
		{
			$model->attributes=$_POST['Notas'];

			if(strlen($_POST['Notas']['fechaenvio']) < 11 && strlen($_POST['Notas']['fechaenvio']) != null)
			{
				$model->fakefecha = $_POST['Notas']['fechaenvio'];
				$model->fechaenvio = DateTime::createFromFormat('d/m/Y', $model->fakefecha)->format('Y-m-d G:i:s');
			}
			else
			{
				if($_POST['Notas']['fechaenvio'] == '')
					$model->fechaenvio = null;
				else $model->fechaenvio = $_POST['Notas']['fechaenvio'];
			}
			
			if(gettype($usuariosAreas) == "array")
			{
				$model->origen = intval($_POST['Notas']['origen']);
				$modelarea = $modelarea->findByPk($model->origen);
				$modelarea->contador = $model->nronota;
			}

			if(intval($_POST['NotasProveedores']['idproveedor']) == 0)
			{
				$newProv = new Proveedores;
				$newProv->nombre = strval($_POST['Notas']['name_prov']);
				$newProv->save();
			}

			if(intval($_POST['NotasProveedores']['idproveedor']) != 0 && intval($_POST['NotasProveedores']['importe']) == 0)
				$modelpro->scenario = "importeObligatorio";
			
			$modelarea = $modelarea->findByPk($model->origen);
			if($modelarea->contador <= $model->nronota)
			{
				$modelarea->contador = $modelarea->contador + 1;
				$model->nronota = $modelarea->contador;
			}
			
			if($modelpro->validate())
			{
				if($model->save() && $modelarea->save())
				{
					if($_POST['Documentacionesadjuntas']['tipo'] !== '')
					{
						$modeldoc->attributes = $_POST['Documentacionesadjuntas'];
						$modeldoc->save($modeldoc->idnota=$model->id);
					}
				
					if(intval($_POST['NotasProveedores']['idproveedor']) !== 0)
					{
						$modelpro->attributes = $_POST['NotasProveedores'];
						$modelpro->importe = str_replace(',','.',$modelpro->importe);
						$modelpro->save($modelpro->idnota=$model->id);
					}
					else if(intval($_POST['NotasProveedores']['idproveedor']) == 0 && strval($_POST['Notas']['name_prov']) !== "")
					{
						$modelpro->attributes = $_POST['NotasProveedores'];
						$modelpro->idproveedor = Proveedores::model()->findByAttributes(array('nombre'=>strval($_POST['Notas']['name_prov'])))->id;
						$modelpro->importe = str_replace(',','.',$modelpro->importe);
						$modelpro->save($modelpro->idnota=$model->id);
					}
					
					$modelseg->idnota = $model->id;
					$modelseg->idnota_referencia = $model->id;
					$modelseg->asunto = $model->descripcion;
					$modelseg->adestino = $model->destino;
					$modelseg->aorigen = $model->origen;
					$modelseg->frealizacion = $model->fecharealizacion;
					$modelseg->fenvio = $model->fechaenvio;
					$modelseg->save();

					if($model->fechaenvio !== null)
					{
						Yii::app()->user->setFlash('success', "La nota se ha enviado.");
						$this->redirect(array('outbox'));
					}
					else
					{
						Yii::app()->user->setFlash('success', "La nota está cargada. Queda pendiente de envío.");
						$this->redirect(array('pendientes'));
					}
				}
			}
		}

		$this->render('cargar',array(
			'model'=>$model,
			'modelseg'=>$modelseg,
			'modeldoc'=>$modeldoc,
			'modelpro'=>$modelpro,
		));
	}
	
	public function actionContestar()
	{
		$model = new Notas;
		$modelseg = new Seguimientos;
		$modeldoc = new Documentacionesadjuntas;
		$modelpro = new NotasProveedores;

		$model->destino = $_GET['d']; //como contesto una nota, cargo automáticamente desde dónde se origina
		$model->origen = $_GET['o']; //y hacia dónde va
		//la referencia es lo que va a "linkear" a las notas entre sí, para que cuando quieran ver el seguimiento de la nota puedan hacerlo. Lo que las une es la referencia
		$modelseg->idnota_referencia = Seguimientos::model()->findByAttributes(array('idnota'=>$_GET['id']))->idnota_referencia;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$modelarea = new Areas;
		$model->setearDatos($model, $modelarea); //cargo datos por defecto
		$model->nronota = Areas::model()->findByPk($model->origen)->contador;
		$model->nronota = $model->nronota + 1; //cargo el número de nota por defecto para mostrar en la vista
		
		$usuariosAreas = $model->getAreaUsuario();
		if(gettype($usuariosAreas) == "string")
		{
			$modelarea = $modelarea->findByPk($model->origen);
			$modelarea->contador = $model->nronota; //por ahora, cargo el contador del área a la que pertenece el usuario con el número que cargué por defecto
		}

		if(isset($_POST['Notas'])) /* una vez que el usuario cargó los datos en el formulario */
		{
			$model->attributes=$_POST['Notas']; //paso lo que cargó el usuario en la vista a la instancia que va a hacer el insert

			/* si la fecha tiene formato d/m/Y y el campo NO está vacío, se le da el formato que acepta la base MySQL.
			   sounds dull but believe me, this way, the thing works */
			if(strlen($_POST['Notas']['fechaenvio']) < 11 && strlen($_POST['Notas']['fechaenvio']) != null)
			{
				$model->fakefecha = $_POST['Notas']['fechaenvio'];
				$model->fechaenvio = DateTime::createFromFormat('d/m/Y', $model->fakefecha)->format('Y-m-d G:i:s');
				$modelseg->fenvio = $model->fechaenvio;
			}
			else //si la fecha no tiene formato d/m/Y - caso que se da cuando falla la validación en el formulario pero algunos datos persisten, como el campo fecha
			{
				if($_POST['Notas']['fechaenvio'] == '') //si el usuario no puso ninguna fecha
				{
					$model->fechaenvio = null;
					$modelseg->fenvio = null;
				}
				else //si el usuario había puesto una fecha, pero por alguna razón no se validó el input, la fecha persiste con el formato Y-m-d G:i:s
				{
					$model->fechaenvio = $_POST['Notas']['fechaenvio'];
					$modelseg->fenvio = $model->fechaenvio;
				}
			}

			$usuariosAreas = $model->getAreaUsuario();
			//si el usuario pertence a más de un área, entonces él es quien determina el origen de la nota
			if(gettype($usuariosAreas) == "array")
			{
				$model->origen = intval($_POST['Notas']['origen']);
				$modelarea = $modelarea->findByPk($model->origen0->id);
				//se carga al contador del área lo que vino del formulario de la nota
				$modelarea->contador = $model->nronota;
			}

			/* esto vuelve a contrastar el contador con lo que viene del formulario, porque si dos usuarios guardan al mismo tiempo, entonces hay que evitar que se guarde dos veces
			   el mismo número de nota. También ayuda a que, por ejemplo, no se dé el caso de que la nota 3/2016 se guarde ANTES que la nota 2/2016 */
			$modelarea = $modelarea->findByPk($model->origen);
			if($modelarea->contador <= $model->nronota)
			{
				$modelarea->contador = $modelarea->contador + 1;
				$model->nronota = $modelarea->contador;
			}

			if($model->save() && $modelarea->save()) /* valida ambas instancias en sus respectivos modelos, con la función rules(). Si todo está bien, hace el save() */
			{
				//si el usuario ingresó un proveedor que no estaba en la base de datos, se guarda ese nuevo registro
				if(intval($_POST['NotasProveedores']['idproveedor']) == 0)
				{
					$newProv = new Proveedores;
					$newProv->nombre = strval($_POST['Notas']['name_prov']);
					$newProv->save();
				}

				/* Una vez guardada la nota, se intenta guardar documentación adjunta y/o proveedor asociados a esa nota.
				   Si no se ingresaron datos, no se crean registros nuevos para las tablas Documentacionesadjuntas y NotasProveedores. */
				if($_POST['Documentacionesadjuntas']['tipo'] !== '')
				{
					$modeldoc->attributes = $_POST['Documentacionesadjuntas'];
					$modeldoc->save($modeldoc->idnota=$model->id);
				}

				if(intval($_POST['NotasProveedores']['idproveedor']) !== 0)
				{
					$modelpro->attributes = $_POST['NotasProveedores'];
					$modelpro->importe = str_replace(',','.',$modelpro->importe);
					$modelpro->save($modelpro->idnota=$model->id);
				} //si el usuario había ingresado un nuevo proveedor, hay que asociarlo a la nota ue se acaba de guardar
				else if(intval($_POST['NotasProveedores']['idproveedor']) == 0 && strval($_POST['Notas']['name_prov']) !== "")
				{
					$modelpro->attributes = $_POST['NotasProveedores'];
					$modelpro->idproveedor = Proveedores::model()->findByAttributes(array('nombre'=>strval($_POST['Notas']['name_prov'])))->id;
					$modelpro->importe = str_replace(',','.',$modelpro->importe);
					$modelpro->save($modelpro->idnota=$model->id);
				}

				//se guarda en la tabla Seguimientos
				$modelseg->idnota = $model->id;
				$modelseg->asunto = $model->descripcion;
				$modelseg->aorigen = $model->origen;
				$modelseg->adestino = $model->destino;
				$modelseg->frealizacion = $model->fecharealizacion;
				$modelseg->save();

				if($model->fechaenvio !== null) //se redirige a Bandeja de elementos enviados o a Bandeja de Notas Pendientes, dependiendo de si el usuario puso una fecha de envío en el formulario o no.
				{
					Yii::app()->user->setFlash('success', "La nota se ha enviado.");
					$this->redirect(array('outbox'));
				}
				else
				{
					Yii::app()->user->setFlash('success', "La nota está cargada. Queda pendiente de envío.");
					$this->redirect(array('pendientes'));
				}
			}
		}

		$this->render('contestar',array(
			'model'=>$model,
			'modelseg'=>$modelseg,
			'modeldoc'=>$modeldoc,
			'modelpro'=>$modelpro,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notas']))
		{
			$model->attributes=$_POST['Notas'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Notas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notas']))
			$model->attributes=$_GET['Notas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Bandeja de entrada.
	 */
	public function actionInbox()
	{
		$model = new Notas('search');
		$modelpro = new NotasProveedores;
		$model->unsetAttributes(); //clear any default values
		$modelpro->unsetAttributes(); //clear any default values
		$model->prov = $modelpro;
		
		if(isset($_GET['NotasProveedores']))
		{
			$modelpro->attributes = $_GET['NotasProveedores'];
		}

		if(isset($_GET['Notas']))
		{
			$model->attributes = $_GET['Notas'];
			//send model object for search
			$this->render('inbox',array(
				'dataProvider'=>$model->search2(),
				'model'=>$model,
			));
		}
		else
		{		
			//send model object for search
			$this->render('inbox',array(
				'dataProvider'=>$model->search2(), 
				'model'=>$model,
				'modelpro'=>$modelpro,
			));
		}
	}
	
	public function actionInbox2()
	{
		$model=new Notas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notas']))
		{
			$model->attributes = $_GET['Notas'];
			//send model object for search
			$this->render('inbox2',array(
				'dataProvider'=>$model->search2(),
				'model'=>$model,
			));
		}
		else
		{			
			//send model object for search
			$this->render('inbox2',array(
				'dataProvider'=>$model->search2(), 
				'model'=>$model,
			));
		}
	}
	
	/**
	 * Bandeja de notas enviadas.
	 */
	public function actionOutbox()
	{
		$model = new Notas('search');
		$model->unsetAttributes(); //clear any default values
		$modelpro = new NotasProveedores;
		$modelpro->unsetAttributes(); //clear any default values
		$model->prov = $modelpro;
		
		if(isset($_GET['NotasProveedores']))
		{
			$modelpro->attributes = $_GET['NotasProveedores'];
		}

		if(isset($_GET['Notas']))
		{
			$model->attributes = $_GET['Notas'];
			//send model object for search
			$this->render('outbox',array(
				//utiliza el conjunto de notas que ya había sido filtrado, y lo vuelve a filtrar, según lo que el usuario ingrese en los campos de búsqueda
				'dataProvider'=>$model->search3(),
				'model'=>$model,
			));
		}
		else
		{			
			//send model object for search
			$this->render('outbox',array(
				'dataProvider'=>$model->search3(), 
				'model'=>$model,
			));
		}
	}
	
	public function actionOutbox2()
	{
		$model = new Notas('search');
		$model->unsetAttributes(); //clear any default values

		if(isset($_GET['Notas']))
		{
			$model->attributes = $_GET['Notas'];
			//send model object for search
			$this->render('outbox2',array(
				//utiliza el conjunto de notas que ya había sido filtrado, y lo vuelve a filtrar, según lo que el usuario ingrese en los campos de búsqueda
				'dataProvider'=>$model->search3(),
				'model'=>$model,
			));
		}
		else
		{
			//send model object for search
			$this->render('outbox2',array(
				'dataProvider'=>$model->search3(), 
				'model'=>$model,
			));
		}
	}
	
	public function actionPendientes()
	{
		$model = new Notas('search');
		$model->unsetAttributes(); //clear any default values

		if(isset($_GET['Notas']))
		{
			$model->attributes = $_GET['Notas'];
			//send model object for search
			$this->render('pendientes',array(
				//utiliza el conjunto de notas que ya había sido filtrado, y lo vuelve a filtrar, según lo que el usuario ingrese en los campos de búsqueda
				'dataProvider'=>$model->search4(),
				'model'=>$model,
			));
		}
		else
		{			
			//send model object for search
			$this->render('pendientes',array(
				'dataProvider'=>$model->search4(), 
				'model'=>$model,
			));
		}
	}
	
	/*
	* Carga el número de nota de forma dinámica cuando el usuario pertenece a más de un área.
	* Llamada desde notas/cargar. Ver views/notas/_cargar.php, línea 73
	*/
	public function actionCrearNronota()
	{
		$area = Areas::model()->findAll("id=?",array($_POST['Notas']['origen']));
		$contador = $area[0]->contador + 1;
		echo $contador;
	}

	public function actionAutocomplete($term)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('LOWER(nombre)', strtolower($_GET['term']), true);
		$criteria->order = 'nombre';
		$criteria->limit = 30;
		$data = Areas::model()->findAll($criteria);
		
		if (!empty($data))
		{
			$arr = array();
			foreach ($data as $item)
			{
				$arr[] = array(
					'value'=>$item->nombre,
					'label'=>$item->nombre,
					'id'=>$item->id,
				);
			}
		}
		else
		{
			$arr = array();
			$arr[] = array(
					'value'=>'No se han encontrado resultados para su búsqueda',
					'label'=>'No se han encontrado resultados para su búsqueda',
					'id'=>'',
				);
		}
		
		echo CJSON::encode($arr);
	}
	
	public function actionExcel()
	{
		$data = $_SESSION['datos_filtrados']->getData();
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'N° nota')
		->setCellValue('B1', 'Fecha realización')
		->setCellValue('C1', 'Fecha envío')
		->setCellValue('D1', 'Detalle')
		->setCellValue('E1', 'Destino')
		->setCellValue('F1', 'Proveedor')
		->setCellValue('G1', 'Importe')
		->setCellValue('H1', 'Origen');

		for($i = 0; $i < count($data); $i++)
		{
			$j = $i + 2;
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $j, $data[$i]->getNumeroDeNota($data[$i]->id))
			->setCellValue('B' . $j, $data[$i]->setFechaSinHora($data[$i]->fecharealizacion))
			->setCellValue('C' . $j, $data[$i]->setFechaSinHora($data[$i]->fechaenvio))
			->setCellValue('D' . $j, $data[$i]['descripcion'])
			->setCellValue('E' . $j, $data[$i]->destino0->nombre)
			->setCellValue('F' . $j, NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id)) ? NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id))->idproveedor0->nombre : "")
			->setCellValue('G' . $j, NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id)) ? NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id))->importe : "")
			->setCellValue('H' . $j, $data[$i]->origen0->nombre);
		}

		$styleArray = array(
			'font'=>array(
				'bold'=>true,
			),
			'borders'=>array(
				'allBorders'=>array(
					'style'=>PHPExcel_Style_Border::BORDER_MEDIUM
				),
			),
			'alignment'=>array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		);
		
		$styleArray2 = array(
			'font'=>array(
				'size'=>12,
				'name'=>'Arial',
			),
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:H1');

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("107");
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

		$objPHPExcel->getSheet(0)->setTitle('Notas enviadas');
		$objPHPExcel->setActiveSheetIndex(0);

		#$objPHPExcel->getActiveSheet()->setTitle('Nombre del área, supongo');

		#$objPHPExcel->setActiveSheetIndex(0);

		ob_end_clean(); ob_start();

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="test.xlsx"');
		header('Cache-Control: max-age=0');
		#$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Notas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La nota requerida no existe.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}