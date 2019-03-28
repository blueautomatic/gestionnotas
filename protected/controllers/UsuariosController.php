<?php

class UsuariosController extends Controller
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
			array('allow',  // allow admin users to perform all actions
				'actions'=>array('asignarRol'),
				'roles'=>array('administrador'),
			),
			array('allow',  // allow admin users to perform all actions
				'actions'=>array(/*'index',*/'view','create','modificar','admin','delete','autocomplete'),
				'roles'=>array('administrador_usuarios'),
			),
			array('allow',  // allow admin users to perform all actions
				'actions'=>array('modificar','autocomplete'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usuarios;
		$modelua = new UsuariosAreas('crearNuevaArea');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuarios']))
		{
			$model->attributes=$_POST['Usuarios'];
			if($model->save())
			{
				$modelua->idusuario = $model->id;
				$modelua->idarea = $_POST['UsuariosAreas']['idarea'];
				$modelua->save();
				Yii::app()->user->setFlash('success', "Se ha guardado el nuevo usuario.");
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'modelua'=>$modelua,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionModificar($id)
	{
		$model=$this->loadModel($id);
		$modelua = new UsuariosAreas;
		
		if($model->id === Yii::app()->user->id && !Yii::app()->user->checkAccess('administrador_usuarios'))
		{
			$contraseniaVieja = $model->contrasenia;
			$model->contrasenia = ''; //pa'blanquear el campo Contraseña, ¿vió?
			$model->contrasenia_repeat = '';
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			
			if(isset($_POST['Usuarios']))
			{
				$model->attributes=$_POST['Usuarios'];
				
				if($model->contrasenia =='')
				{
					$model->contrasenia = $contraseniaVieja;
					$model->contrasenia_repeat = $contraseniaVieja;
				}
				else 
				{
					$model->contrasenia=sha1($model->contrasenia);
					$model->contrasenia_repeat=sha1($model->contrasenia_repeat);
				};
				if($model->save())
				{
					Yii::app()->user->setFlash('success', "Se ha modificado la contraseña exitosamente.");
					$this->redirect(array('notas/inbox'));
				}
			}

			$this->render('updatepass',array(
				'model'=>$model,
			));
		}
		else if(Yii::app()->user->checkAccess('administrador'))
		{
			$contraseniaVieja = $model->contrasenia;
			$model->contrasenia = ''; //pa'blanquear el campo Contraseña, ¿vió?
			$model->contrasenia_repeat = '';
			// Uncomment the following line if AJAX validation is needed
			// $this->performAjaxValidation($model);
			
			if(isset($_POST['Usuarios']))
			{
				$model->attributes=$_POST['Usuarios'];
				
				if($model->contrasenia =='')
				{
					$model->contrasenia = $contraseniaVieja;
					$model->contrasenia_repeat = $contraseniaVieja;
				}
				else 
				{
					$model->contrasenia=sha1($model->contrasenia);
					$model->contrasenia_repeat=sha1($model->contrasenia_repeat);
				};
				if($model->save())
				{
					if(intval($_POST['UsuariosAreas']['idarea']) != 0)
					{
						$modelua->idusuario = $model->id;
						$modelua->idarea = $_POST['UsuariosAreas']['idarea'];
						$modelua->save();
					}
					Yii::app()->user->setFlash('success', "Se ha modificado el perfil exitosamente.");
					$this->redirect(array('view','id'=>$model->id));
				}
			}

			$this->render('update',array(
				'model'=>$model,
				'modelua'=>$modelua,
			));
		}
		else throw new CHttpException(403,'Usted no está autorizado a realizar esta acción.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		Yii::app()->user->setFlash('success', "Se ha eliminado el usuario.");
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Usuarios');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuarios']))
			$model->attributes=$_GET['Usuarios'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionAsignarRol($id)
	{
		if(Yii::app()->authManager->checkAccess($_GET["item"], $id))
			Yii::app()->authManager->revoke($_GET["item"], $id);
		else Yii::app()->authManager->assign($_GET["item"], $id);
		$this->redirect(array('view','id'=>$id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuarios the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuarios::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuarios $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}