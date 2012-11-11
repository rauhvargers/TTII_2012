<h2>Viewing #<?php echo $country->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $country->name; ?></p>
<p>
	<strong>Iso code:</strong>
	<?php echo $country->iso_code; ?></p>

<?php echo Html::anchor('country/edit/'.$country->id, 'Edit'); ?> |
<?php echo Html::anchor('country', 'Back'); ?>