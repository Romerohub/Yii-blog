<div class="post">
	<?php if(!empty($_GET['url']) or !empty($_GET['id'])){?>
		<h1 class="title"><?php echo $data->title; ?></h1>
	<?php }else{ ?>
		<h2><?php echo CHtml::link(CHtml::encode($data->title), array("/".$data->url)); }?></h2>
		

	<div class="entry">
		<?php
			//$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			//echo $data->content;

			echo $data->full_text;	
			
			//$this->endWidget();
		?>
	</div>

</div>
