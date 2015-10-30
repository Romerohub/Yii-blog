<?php

class SiteController extends Controller
{
	//public $layout='column1';
	public $layout='main';

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('login', 'rss', 'ping'),
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
	public function actionPing(){
//		Yii::import('application.vendors.*');
//		require_once('seo.php');
//		
//		$seo = new seo;
//		echo "1";
	//	$seo->ping($siteName, $siteURL, $pageURL );
	}
	
	//генерируем sitemap xml на лету
/*	public function actionXml11(){
		exit;
		header("Content-Type: text/xml;charset=iso-8859-1");
//		echo "2".$this->createAbsoluteUrl('/').Yii::app()->baseUrl;
//		exit;
/*	echo '<?xml version="1.0" encoding="UTF-8"?> 
		<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">'; */
	/*	
		echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.$this->createAbsoluteUrl('/').'/sitemap.xsl.xml"?>';
		echo ' <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		 xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
		 xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> ';
	  echo  
		    '  
		        <url>  
		        <loc>'.$this->createAbsoluteUrl('/').'/</loc>  
		        <lastmod>'.date("Y-m-d h:i").'</lastmod>  
		        <changefreq>Weekly</changefreq>  
		        <priority>1.0</priority>  
		        </url>  
		    '; 
		  $res = array();
		  
		$criteria=new CDbCriteria;
		$criteria->condition='status=2';
		$criteria->order = 'id DESC';
		$res = Post::model()->findAll($criteria);
		
		foreach($res as $k=>$v){
		    echo  
		    '  
		        <url>  
		        <loc>'.$this->createAbsoluteUrl('/')."/".$v->url.'.html</loc>  
		        <lastmod>'.date("Y-m-d h:i",$v->create_time).'</lastmod>  
		        <changefreq>Monthly</changefreq>  
		        <priority>0.2</priority>  
		        </url>  
		    '; 
		}
		$criteria=new CDbCriteria;
		$criteria->order = 'id DESC';
		$res = Categories::model()->findAll($criteria);
		
		foreach($res as $k=>$v){
		    echo  
		    '  
		        <url>  
		        <loc>'.$this->createAbsoluteUrl('/')."/cat/".$v->url.'.html</loc>  
		        <changefreq>Weekly</changefreq>  
		        <priority>0.3</priority>  
		        </url>  
		    '; 
		}
		
		echo  '</urlset>'; 
		
	}
*/
	public function actionRss(){  
		exit;
		//header("Content-Type: application/rss+xml; charset=ISO-8859-1");
	$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>
	    		';
	$rssfeed .= '<rss version="2.0">
	    		';
	    $rssfeed .= '<channel>
	    		';
	    $rssfeed .= '<title>My RSS feed</title>
	   			 ';
	    $rssfeed .= '<link>http://www.mywebsite.com</link>
	    		';
	    $rssfeed .= '<description>This is an example RSS feed</description>
	    		'
	    ;
	    $rssfeed .= '<language>en-us</language>
	    		';
	    $rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>
	    		';
	 
	
	 	$criteria=new CDbCriteria;
	 	$criteria->limit='5';
		$criteria->condition='status=2';
		$criteria->order = 'id DESC';

		$res = Post::model()->findAll($criteria);

	    foreach($res as $k=>$v){
	 
	    $rssfeed .= '<item>
	        		';
	        $rssfeed .= '<title>' . $v->title . '</title>
	        		';
	       		$rssfeed .= '<description>' . $v->description . '</description>
	        		';
	       		$rssfeed .= '<link>' . $v->url . '</link>
	        		';
	        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($v->update_time)) . '</pubDate>
	        		';
	    $rssfeed .= '</item>
	        		';
	    }
	 
	$rssfeed .= '</channel>';
	$rssfeed .= '</rss>';
 echo $rssfeed;
	    Yii::app()->end();
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

//	/**
//	 * Displays the contact page
//	 */
//	public function actionContact()
//	{
//		$model=new ContactForm;
//		if(isset($_POST['ContactForm']))
//		{
//			$model->attributes=$_POST['ContactForm'];
//			if($model->validate())
//			{
//				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
//				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
//				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
//				$this->refresh();
//			}
//		}
//		$this->render('contact',array('model'=>$model));
//	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
//	public function actionStatistic()
//	{
//		$hitArr['date'] = date("Y-m-d");
//		$connection=Yii::app()->db;
//		
//		$sql='SELECT ip FROM   tbl_stata_by_date WHERE  date = :date';
//		$command=$connection->createCommand($sql);
//		$command->bindParam(":date", $hitArr['date'],PDO::PARAM_STR);
//		$command->queryAll();
//		
//		$sql='SELECT ip FROM   tbl_stata_visites_data ORDER BY id DESC LIMIT 20';
//		$command=$connection->createCommand($sql);
//		$command->queryAll();
//		
//		
//		//$this->render('login',array('model'=>""));
//	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionUslugi(){
		
		$model=new UslugiForm;

		$this->render('UslugiForm',array('model'=>$model));
	}
}