<h3><?php 
    echo Html::anchor("event/view/".$event->id, $event->title);
    ?>
</h3>
    <ul>
	<?php foreach ($event->agendas as $agenda) : ?>
	    <li><?php echo $agenda->title; ?></li>
	<?php 
	    endforeach;  //foreach agenda item
	?>
    </ul>
    <p>
	<?php 
	   echo Html::anchor("agenda/create/".$event->id, "Add a new agenda item", array("class"=> "btn"));
	?>
	
    </p>
    
