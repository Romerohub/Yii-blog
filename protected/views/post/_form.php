
<div class="popup__overlay">
    <div class="popup">
        <a href="#" class="popup__close">X</a>
  	<h4>Загрузка файлов и drag&drop</h4>
    <form action="/index.php/images/addajax" method="POST" enctype="multipart/form-data">
         <input type="file" name="my-pic" id="file-field" /><br/>
         <input type="hidden" value="" name="post_id" id="post_id" />
        или просто перетащи в область ниже &dArr;
    </form>
    <div class="img-container" id="img-container">
        <ul class="img-list" id="img-list"></ul>
    </div>
        <button id="upload-all">Загрузить все</button>
    <button id="cancel-all">Отменить все</button>
   <br> Уже загружены<br>
    <div class="img-container-1" id="img-container-present">
        <ul class="img-list" id="img-list-present">
   		<?php 
   		if((int)$model->id){
		foreach(Images::items() as $k=>$v){?>
			<li><div><?=$v['file_name'];?><br><a class="addMainPic" href="#">Сделать главной</a></div>
			<img width="80px" id="<?=$v['id'];?>" src="<?=Yii::app()->baseUrl."/uploads/images/".date('Y',$v['date_add'])."/".date('m',$v['date_add'])."/".$v['file_name'];?>"></li>
		<?}}?>
        
        </ul>
    </div>

    
    </div>
</div>​



<div class="form">

<?php $form=$this->beginWidget('CActiveForm',array(
'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>
	<?php echo $form->HiddenField($model,'id', array('size'=>80,'maxlength'=>255)); ?>
	<?php echo $form->HiddenField($model,'main_pic'); ?>
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
		<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>80,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>80,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>
	<div class="row"><input type="button" value="Загрузка картинок" id="popup__toggle" />
		<?php echo $form->labelEx($model,'content'); ?>
	
	<?php //$this->widget('application.widgets.redactorjs.Redactor',
		// array( 'model' => $model, 'attribute' => 'content' )); // это редактор, добавлено ?>
	
		<?php echo CHtml::activeTextArea($model,'content',array('rows'=>10, 'cols'=>70)); //это просто тектовое поле из начала ?>
		
		<p class="hint">You may use <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">Markdown syntax</a>.</p>
		<?php echo $form->error($model,'content'); ?>
	</div>
<div id="show_post_main_pic">
<?if(!empty($model->main_pic)){
	?><a target="_blank" href="/uploads/images/<?=date('Y',$model->create_time)."/".date('m',$model->create_time)."/".$model->main_pic;?>">
	<img width="85px" src="/uploads/images/<?=date('Y',$model->create_time)."/".date('m',$model->create_time)."/".$model->main_pic;?>">
	</a>
	<?
}?>
</div>
	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php $this->widget('CAutoComplete', array(
			'model'=>$model,
			'attribute'=>'tags',
			'url'=>array('suggestTags'),
			'multiple'=>true,
			'htmlOptions'=>array('size'=>50),
		)); ?>
		<p class="hint">Please separate different tags with commas.</p>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PostStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id', Categories::items(), array('prompt'=>'--select--')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->