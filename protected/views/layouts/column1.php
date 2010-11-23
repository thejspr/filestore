<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
     <div class="sublinks">
	<? 
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'clearfix'),
		));
	?>
     </div>
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>
