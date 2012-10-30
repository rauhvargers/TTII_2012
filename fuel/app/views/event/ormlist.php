<?php
foreach ($event_model as $event) :
    ?>
    <h3><?php echo $event->title ?></h3>
    <p>Location: <?php echo $event->location->title ?></p>

    <ul>
	<?php foreach ($event->agendas as $agenda) : ?>
	    <li><?php echo $agenda->title; ?></li>
	<?php 
	    endforeach;  //foreach agenda item
	?>
    </ul>
<?
endforeach; //foreach event
