<h2><?php echo $event->title?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $event->title; ?></p>
<p>
	<strong>Start date:</strong>
	<?php echo $event->start; ?></p>
<p>
    
<h3>Event agenda</h3>
<ul>
	<?php foreach ($event->agendas as $agenda) : ?>
	    <li><?php echo $agenda->title; ?></li>
	<?php 
	    endforeach;  //foreach agenda item
	?>
</ul>
<?php echo Html::anchor('event', 'List of events'); ?>
</p>