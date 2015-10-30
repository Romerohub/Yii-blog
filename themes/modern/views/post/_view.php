<div class="post">
	<?php if(!empty($_GET['url']) or !empty($_GET['id'])){?>
		<h1 class="title"><?php echo $data->title; ?></h1>
	<?php }else{ ?>
		<h2><?php echo CHtml::link(CHtml::encode($data->title), array("/".$data->url)); }?></h2>
		

	<div class="entry">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			//echo $data->content;
			if(!empty($_GET['url']) or !empty($_GET['id'])){
			echo $data->full_text;
			}else{
			echo $data->text_preview;	
			}
			$this->endWidget();
		?>
	</div>
		<p class="byline"><small>		
		<b>Категория:</b>
		<?php echo  $data->category->name; ?> | 
		
		<?php echo CHtml::link("Комментарии ({$data->commentCount})",array("/".$data->url.'#comments')); ?> |
		<?php if(empty($_GET['url'])) echo CHtml::link("Читать дальше...", array("/".$data->url)); ?></small>
		</p>
</div>
