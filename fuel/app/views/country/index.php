<h2>Listing Countries</h2>
<br>
<?php if ($countries): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Iso code</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($countries as $country): ?>		<tr>

			<td><?php echo $country->name; ?></td>
			<td><?php echo $country->iso_code; ?></td>
			<td>
				<?php echo Html::anchor('country/view/'.$country->id, 'View'); ?> |
				<?php echo Html::anchor('country/edit/'.$country->id, 'Edit'); ?> |
				<?php echo Html::anchor('country/delete/'.$country->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Countries.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('country/create', 'Add new Country', array('class' => 'btn btn-success')); ?>

</p>
