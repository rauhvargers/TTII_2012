<h2>New agenda item</h2>
<?php echo Form::open(); ?>
<fieldset>

    <div class="clearfix">
	<?php echo Form::label('Title of agenda item', 'title'); ?>

	<div class="input">
	    <?php echo Form::input('title', 
			Input::post('title', 
			    isset($agenda) ? $agenda->title : '')); ?>
	</div>
    </div>
</fieldset>	
<div class="actions">
    <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

</div>
<?php echo Form::close() ?>
