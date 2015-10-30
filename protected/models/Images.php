<?php

/**
 * This is the model class for table "{{images}}".
 *
 * The followings are the available columns in table '{{images}}':
 * @property string $id
 * @property integer $date_add
 * @property integer $date_edit
 * @property string $file_name
 * @property string $title
 * @property string $description
 */
class Images extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_add, date_edit, file_name, title, description, post_id, author_id, note_type', 'required'),
			array('date_add, date_edit', 'numerical', 'integerOnly'=>true),
			array('file_name, title, description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_add, date_edit, file_name, title, description', 'safe', 'on'=>'search'),
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
			//'images'=>array(self::MANY_MANY, 'Images', 'tbl_images_map(post_id, image_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_add' => 'Date Add',
			'date_edit' => 'Date Edit',
			'file_name' => 'File Name',
			'title' => 'Title',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('date_add',$this->date_add);
		$criteria->compare('date_edit',$this->date_edit);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function items($post_id = false, $note_type = "post"){
		if(!$post_id){
			if((int)$_GET['id'])
				$post_id = $_GET['id'];
			elseif((int)$_POST['Post']['id'])
				$post_id = (int)$_POST['Post']['id'];
		}
		$models=self::model()->findAll(array(
			//'condition'=>'t.post_id='.$post_id,
			'condition'=>'t.post_id='.$post_id." AND t.note_type = '".$note_type."'",
			'order'=>'t.id ASC',
	
		));
		
		$arr = array();
		//$models=self::model()->findAll();
		foreach($models as $model){
			$arr[$model->id]['date_add'] = $model->date_add;
			$arr[$model->id]['file_name'] = $model->file_name;
			$arr[$model->id]['post_id'] = $model->post_id;
			$arr[$model->id]['title'] = $model->title;
			$arr[$model->id]['description'] = $model->description;
		}
		//print_r($arr);
		
		return $arr; 
	}
}