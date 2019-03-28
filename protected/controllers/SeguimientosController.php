<?php

class SeguimientosController extends Controller
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
			array('allow', 
				'actions'=>array('create','update','delete','index2','excel'),
				'roles'=>array('administrador_notas'),
			),
			array('allow',  
				'actions'=>array('index','view','index2','excel'),
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
		$model = $this->loadModel($id);
		if(Yii::app()->request->isAjaxRequest)
		{
			$this->renderPartial('view',array(
				'model'=>$this->loadModel($id),
			), false, true);
			Yii::app()->end();
		}
		else $this->render('view',array('model'=>$this->loadModel($id),));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Seguimientos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Seguimientos']))
		{
			$model->attributes=$_POST['Seguimientos'];
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

		if(isset($_POST['Seguimientos']))
		{
			$model->attributes=$_POST['Seguimientos'];
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
	public function actionIndex2()
	{
		$dataProvider=new CActiveDataProvider('Seguimientos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Seguimientos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Seguimientos']))
			$model->attributes=$_GET['Seguimientos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionIndex()
	{
		$model=new Seguimientos('search');
		$modelnot=new Notas;
		$model->unsetAttributes();  // clear any default values
		$modelnot->unsetAttributes();
		$model->notamod = $modelnot;

		if(isset($_GET['Notas']))
		{
			$modelnot->attributes = $_GET['Notas'];
		}

		if(isset($_GET['Seguimientos']))
		{
			$model->attributes=$_GET['Seguimientos'];
			//send model object for search
			$this->render('admin',array(
				'dataProvider'=>$model->search(),
				'model'=>$model,
			));
		}
		else
		{
			$this->render('admin',array(
				'dataProvider'=>$model->search(),
				'model'=>$model,
			));
		}
	}
	
	public function actionExcel()
	{
		$data = $_SESSION['seguimientos_filtrados']->getData();
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'N° nota')
		->setCellValue('B1', 'Fecha realización')
		->setCellValue('C1', 'Fecha envío')
		->setCellValue('D1', 'Origen')
		->setCellValue('E1', 'Destino')
		->setCellValue('F1', 'Detalle')
		->setCellValue('G1', 'Proveedor')
		->setCellValue('H1', 'Importe');

		for($i = 0; $i < count($data); $i++)
		{
			$j = $i + 2;
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' . $j, $data[$i]->idnota0->getNumeroDeNota($data[$i]->idnota))
			->setCellValue('B' . $j, $data[$i]->idnota0->setFechaSinHora($data[$i]->frealizacion))
			->setCellValue('C' . $j, $data[$i]->idnota0->setFechaSinHora($data[$i]->fenvio))
			->setCellValue('D' . $j, $data[$i]->aorigen0->nombre)
			->setCellValue('E' . $j, $data[$i]->adestino0->nombre)
			->setCellValue('F' . $j, $data[$i]['asunto'])
			->setCellValue('G' . $j, NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->idnota)) ? NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id))->idproveedor0->nombre : "")
			->setCellValue('H' . $j, NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->idnota)) ? NotasProveedores::model()->findByAttributes(array('idnota'=>$data[$i]->id))->importe : "");
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

		$objPHPExcel->getSheet(0)->setTitle('Seguimientos');
		$objPHPExcel->setActiveSheetIndex(0);
		ob_end_clean(); ob_start();

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="test.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Seguimientos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Seguimientos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Seguimientos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='seguimientos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}