<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


	<?php
		Yii::app()->getClientScript()->registerCoreScript('jquery'); 
		
	$categories = new Categories;
	 $blog_categories = $categories->fullItems();?>
	
	<title><?php if(empty($_GET['url']) && empty($_GET['id']) && empty($_GET['cat'])){
		echo "Сайт программиста.";
	}
	elseif( empty($_GET['cat'])){
		echo CHtml::encode($this->pageTitle); 
	}else{
		echo $blog_categories[trim($_GET['cat'])]['label'];
		if(!empty($_GET['page']) && (int)$_GET['page']){
			echo " | Страница ".(int)$_GET['page'];
		}
	}
	?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" media="screen, print, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<script type='text/javascript' src='<?php echo Yii::app()->request->baseUrl; ?>/js/main.js'></script>
	
</head>
<body>

<!--Всплывающее окно обратной связи.-->

<div id="topPop">
<form method="post" id="privatMsg">
<input type="hidden" name="yt0" value="Create" >
	<div id="innerPopText">
		<p>Ваше имя: <strong class="inputError" id="innerPopNameError"></strong></p>
		<input type="text" class="privatInput" id="innerPopName" name="PrivatMsgs[name]" maxsize="5">
		<p></p>
		<p>Ваш email: <strong class="inputError" id="innerPopEmailError" ></strong></p>
		<input type="text" class="privatInput" id="innerPopEmail" name="PrivatMsgs[email]" maxsize="100">
		<p></p>
		<p>Сообщение: <strong class="inputError" id="innerPopMsgError"></strong></p>
		<textarea id="innerPopMsgText" placeholder="Введите сообщение" rows="4" class="privatInput" name="PrivatMsgs[msg_text]"></textarea>
	</div>
	<div id="innerPopBtn">
		<strong id="statusPopUpMSg"></strong>
		<img src="/images/spinner_w.gif" style="display:none;" id="sendPrivatMsgImg">
		<button type="button" id="sendPrivatMsg">Отправить</button>
	</div>
</form>
	<div id="innerPop">
		<a href="#" id="innerPopLink">Обратная связь/Показать</a>
	</div>
</div>
<!--КОНЕЦ - Всплывающее окно обратной связи.-->

<!-- start header -->
<div id="header_div">
<div id="logo">
	<strong><a href="/">Сайт программиста.</a></strong>
	<p> Сделать могу что угодно,<br> вопрос только во времени и деньгах.</p>
</div>
<div id="menu">

	<ul id="main">
		<li ><a href="/">Главная</a></li>
		<li><a href="/page/portfolio.html">Портфолио</a></li>
		<li><a href="/page/uslugi.html">Услуги</a></li>
		<li><a href="/page/contacts.html">Контакты</a></li> 
	</ul>
</div>
</div>
<!-- end header -->


<div id="wrapper">
<!-- start page -->
<div id="page">
	<div id="sidebar1" class="sidebar">
		
		<ul>
			<li>
			<?php
			if(!Yii::app()->user->isGuest){
					echo "<h3>Администрирование.</h3>";
					$this->widget('UserMenu'); 
			} ?>
					
			<h3>Категории</h3>	
			<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>$blog_categories,
			)); 
			?>
			</li>

		</ul>
		
	</div>	

	
	<!-- start content -->
	
		<?php echo $content; ?>

	<!-- end content -->
	<!-- start sidebars -->
	
	<div id="sidebar2" class="sidebar">
		<ul>
			<li>
				<h2>Последние комментарии</h2>
		</ul>
	</div>
	<!-- end sidebars -->
	<div style="clear: both;">&nbsp;</div>
</div>
<!-- end page -->
</div>
<div id="footer">
	<p>&copy;<?=date("Y")?> <a href="/">NetKurator</a>.</p><div class="vlinks"></div>
</div>
</body>
</html>