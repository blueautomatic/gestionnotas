<?php

class NotasProveedoresController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','autocomplete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new NotasProveedores;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NotasProveedores']))
		{
			$model->attributes=$_POST['NotasProveedores'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['NotasProveedores']))
		{
			$model->attributes=$_POST['NotasProveedores'];
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
		$dataProvider=new CActiveDataProvider('NotasProveedores');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NotasProveedores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NotasProveedores']))
			$model->attributes=$_GET['NotasProveedores'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAutocomplete($term)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('LOWER(nombre)', strtolower($_GET['term']), true);
		$criteria->order = 'nombre';
		$criteria->limit = 30;
		$data = Proveedores::model()->findAll($criteria);
		
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

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NotasProveedores the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NotasProveedores::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NotasProveedores $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notas-proveedores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
