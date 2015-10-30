<ul>
	<li><b>Блог</b></li>
	<li><?php echo CHtml::link('Create New Post',array('post/create')); ?></li>
	<li><?php echo CHtml::link('Manage Posts',array('post/admin')); ?></li>
	<li><?php echo CHtml::link('Create Category',array('categories/create')); ?></li>
	<li><?php echo CHtml::link('Manage Category',array('categories/admin')); ?></li>
	<li><?php echo CHtml::link('Approve Comments',array('comment/index')) . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
	<li><b>Статические страницы</b></li>
	<li><?php echo CHtml::link('Create New Page',array('page/create')); ?></li>
	<li><?php echo CHtml::link('Manage Pages',array('page/admin')); ?></li>
	<li><b>Управление пользователями</b></li>
	<li><?php echo CHtml::link('Manage users',array('user/admin')); ?></li>
	<li><?php echo CHtml::link('Create user',array('user/create')); ?></li>
	<li><?php echo CHtml::link('Logout',array('site/logout')); ?></li>
	<li><b>Сообщения</b></li>
	<li><?php echo CHtml::link('Сообщения пользователей',array('privatMsgs/admin')); ?></li>
</ul>