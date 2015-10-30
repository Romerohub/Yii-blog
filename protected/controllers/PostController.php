<?php

class PostController extends Controller
{
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$post=$this->loadModel();
		$comment=$this->newComment($post);

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}
	/*подготовка текста для сохранения*/
	protected function prepareText($post){
		/*Если не указан main_pic то найдем првй попавшейся по посту и поставим*/
		if(empty($post['main_pic']) && !empty($post['id'])){
			$img_arr = Images::items($post['id']);
			/*Если что то найдет то вставит*/
			if(!empty($img_arr)){
				reset($img_arr);
				
				$img_arr = current($img_arr);
				$post['main_pic'] = $img_arr['file_name'];
			}
		}elseif(!empty($post['main_pic'])){
			$post['main_pic'] = explode("/", $post['main_pic']);
			$post['main_pic'] = end($post['main_pic']);
			$post['main_pic'] = trim($post['main_pic']);
		}

		/**подготавливаем текст для сохранения*/
		$post['full_text'] = $post['content'];
		
		if($str_res = strpos($post['full_text'], '<!--more-->')){
			$post['text_preview'] = substr( $post['full_text'] , 0 , $str_res);
		}else{
			$post['full_text'] = strip_tags($post['full_text']);
			$post['text_preview'] = substr( $post['full_text'] , 0 , 400);
			if($str_res = strripos($post['text_preview'], ' ')){
				$post['text_preview'] = substr( $post['text_preview'], 0, $str_res);
			}
		}
		$post['full_text'] = str_replace('<!--more-->', " ", $post['content']);
		return $post;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

		$model=new Post;
		//$settings['status'] = 'create';
		if(isset($_POST['Post'])){
				$post = $_POST['Post'];
		
		/*если нужно предварительное сохранение*/
		if(isset($_POST['Draft'])){
			$post['status'] = 1;
			$tmp_time = date("Y-m-d")."-".time();
			if(empty($post['title'])) $post['title'] = "draft ".$tmp_time;
			if(empty($post['content'])) $post['content'] = "draft ".$tmp_time;
			if(empty($post['category_id'])) $post['category_id'] = "1";
			if(empty($post['url'])) $post['url'] = "draft-".$tmp_time;
		}
		/*если уже есть id то нужно проcто проапдейтить*/
		if((int)$post['id']){
			$post['yt0'] = 'Save';
			//$settings['status'] = 'update';
		} 
		
		if(!empty($post))
		{
			$post = $this->prepareText($post);
			
			$model->attributes = $post;
			
			if($model->save()){
				
				/*Если сохраняем временный драфт*/
				if(isset($_POST['Draft'])){
					echo $model->id;
					 Yii::app()->end();
				}
			$this->redirect(array('view','id'=>$model->id));
			}
				
		}
		}
		$this->loadPostScripts();
		
		$this->render('create',array(
			'model'=>$model,
			//'images_list' => Images::items(),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		
		
//	print_r($_POST);
//	exit;	

		$model=$this->loadModel();
		if(isset($_POST['Post']))
		{
			$post = $_POST['Post'];
			$post = $this->prepareText($post);
			
			$model->attributes=$post;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		
		$this->loadPostScripts();
		$this->render('update',array(
			'model'=>$model,
		));
	}
/**
 * Загрузка скриптов и стилей для работы с постами
 * 
 * */
	protected function loadPostScripts(){
		
		$baseUrl = Yii::app()->baseUrl;
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($baseUrl.'/css/admin/upload_image.css');
		$cs->registerCssFile($baseUrl.'/css/admin/post/edit.css');
		$cs->registerScriptFile($baseUrl.'/js/lib/jquery.damnUploader.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/upload_image.js');
		$cs->registerScriptFile($baseUrl.'/js/admin/post/edit.js');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time ASC',
			'with'=>array('commentCount', 'category'),
		));

		if(isset($_GET['tag'])){
			$criteria->addSearchCondition('tags',$_GET['tag']);

		}elseif(isset($_GET['cat'])) {
			$criteria->addCondition(array('category.url = :url'));
			$criteria->params = array(':url'=>$_GET['cat']);
		}else{
			$criteria->mergeWith(array('order'=>'update_time DESC','limit'=>7));
		}

		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
				'pageVar' => "page"
			),
		
			'criteria'=>$criteria,
		));
		if(!isset($_GET['tag']) && !isset($_GET['cat']))$dataProvider->setPagination(false);
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']) or isset($_POST['Post']['id']))
			{
				if(isset($_GET['id'])) $p_id = $_GET['id']; elseif(isset($_POST['Post']['id'])) $p_id = $_POST['Post']['id'];
				if(Yii::app()->user->isGuest)
					$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Post::model()->findByPk($p_id, $condition);
			}
			if(isset($_GET['url'])){
				if(Yii::app()->user->isGuest)
					$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Post::model()->findByAttributes(array('url'=>$_GET['url']), $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
}
