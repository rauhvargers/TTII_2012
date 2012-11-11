<h2>Editing Country</h2>
<br>

<?php echo render('country/_form'); ?>
<p>
	<?php echo Html::anchor('country/view/'.$country->id, 'View'); ?> |
	<?php echo Html::anchor('country', 'Back'); ?></p>
