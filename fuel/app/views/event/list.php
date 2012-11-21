<?php
foreach ($event_model as $event) :
    ?>
    <h3><?php 
	echo Html::anchor("event/view/".$event->id, $event->title);
	?></h3>
    <p>Location: <?php echo ($event->location)? $event->location->title : "(not set)" ?></p>
    <p>Start: <?php echo Date::create_from_string($event->start, "mysql")->format("%d.%m.%Y, %H:%M"); ?>
    <ul>
	<?php foreach ($event->agendas as $agenda) : ?>
	    <li><?php echo $agenda->title; ?></li>
	<?php 
	    endforeach;  //foreach agenda item
	?>
    </ul>
<?php endforeach; //foreach event?>

    <p>
	<?php 
	   echo Html::anchor("/event/create/", "Add an event", array("class"=> "btn btn-primary"))
	?>
	
    </p>
    
