<?php

/**
 * This is the model class for table "seguimientos".
 *
 * The followings are the available columns in table 'seguimientos':
 * @property integer $id
 * @property integer $idnota
 * @property string $asunto
 * @property integer $idnota_referencia
 * @property integer $adestino
 * @property integer $aorigen
 * @property string $frealizacion
 * @property string $fenvio
 *
 * The followings are the available model relations:
 * @property Areas $adestino0
 * @property Areas $aorigen0
 * @property Notas $idnota0
 */
class Seguimientos extends CActiveRecord
{
	public $date_first;
	public $date_last;
	public $notamod;
	public $origenCustom;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'seguimientos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idnota, asunto, idnota_referencia, adestino, aorigen, frealizacion', 'required'),
			array('idnota, idnota_referencia, adestino, aorigen', 'numerical', 'integerOnly'=>true),
			array('asunto', 'length', 'max'=>10000),
			array('fenvio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('origenCustom, date_first, date_last, id, idnota, asunto, idnota_referencia, adestino, aorigen, frealizacion, fenvio', 'safe', 'on'=>'search'),
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
			'adestino0' => array(self::BELONGS_TO, 'Areas', 'adestino'),
			'aorigen0' => array(self::BELONGS_TO, 'Areas', 'aorigen'),
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
			'idnota' => 'Idnota',
			'asunto' => 'Asunto',
			'idnota_referencia' => 'ID de nota a contestar',
			'adestino' => 'Destino',
			'aorigen' => 'Origen',
			'frealizacion' => 'Fecha realización',
			'fenvio' => 'Fecha envío',
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
		if(Yii::app()->user->checkAccess('administrador'))
		{
			$criteria=new CDbCriteria;
			$criteria->compare('id',$this->id);
			$criteria->compare('idnota',$this->idnota);
			$criteria->compare('asunto',$this->asunto,true);
			$criteria->compare('idnota_referencia',$this->idnota_referencia);
			$criteria->compare('adestino',$this->adestino);
			$criteria->compare('aorigen',$this->aorigen);
			$criteria->compare('frealizacion',$this->frealizacion,true);
			$criteria->compare('fenvio',$this->fenvio,true);
			
			$criteria->addCondition('fenvio IS NOT NULL');
			$criteria->order = 'fenvio DESC';

			$_SESSION['seguimientos_filtrados'] = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				/*'sort'=>array(
					'attributes'=>array('asc' => 'destino'),
				),*/
				'pagination'=>false,
			));

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
		else
		{
			$usuariosAreas = new UsuariosAreas;
			$usuariosAreas = $usuariosAreas->getAreaDeUsuario(Yii::app()->user->id);
			$criteria=new CDbCriteria;

			if($this->notamod->nronota == null && $this->date_first == '' && $this->date_last == '' && 
				$this->aorigen == null && $this->adestino == null && $this->asunto == '' && $this->idnota_referencia == null)
			{
				$_SESSION['seguimientos_filtrados'] = new CActiveDataProvider('Seguimientos',array('data'=>array()));
				
				return new CActiveDataProvider ('Seguimientos',array('data'=>array()));
			}
			else
			{
				if(gettype($usuariosAreas) == "string")
					$criteria->compare('aorigen',$usuariosAreas);
				else
				{
					for($i = 0; $i < count($usuariosAreas); $i++)
						$criteria->compare('aorigen',$usuariosAreas[$i]->idarea, false, 'OR');
				}
				
				if(isset($this->origenCustom))
					$criteria->compare('origen',$this->origenCustom);
				
				$criteria->compare('id',$this->id);
				$criteria->compare('idnota',$this->idnota);
				$criteria->compare('asunto',$this->asunto,true);
				$criteria->compare('idnota_referencia',$this->idnota_referencia);
				$criteria->compare('adestino',$this->adestino);
				$criteria->compare('frealizacion',$this->frealizacion,true);
				$criteria->compare('fenvio',$this->fenvio,true);
				
				$criteria->with = array('idnota0');
				$criteria->together = true;
				$criteria->compare('idnota0.nronota',$this->notamod->nronota);
				
				if((isset($this->date_first) && trim($this->date_first) != "") && (isset($this->date_last) && trim($this->date_last) != ""))
					$criteria->addBetweenCondition('fenvio', ''.$this->date_first.'', ''.$this->date_last.'');
		
				$criteria->addCondition('fenvio IS NOT NULL');
				$criteria->order = 'fenvio DESC';

				$_SESSION['seguimientos_filtrados'] = new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					/*'sort'=>array(
						'attributes'=>array('asc' => 'destino'),
					),*/
					'pagination'=>false,
				));

				return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
				));
			}
		}
	}
	
	public function search2($ref)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('idnota_referencia',$ref);
		$criteria->addCondition('fenvio IS NOT NULL');
		$criteria->order = 'fenvio DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getListaAreas()
	{
		$usuariosAreas = UsuariosAreas::model()->getAreaDeUsuario(Yii::app()->user->id);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Seguimientos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}