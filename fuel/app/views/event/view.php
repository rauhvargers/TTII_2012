<h2><?php echo $event->title ?></h2>

<p>
    <strong>Title:</strong>
    <?php echo $event->title; ?></p>
<p>
    <strong>Start date:</strong>
    <?php echo $event->start; ?></p>

<p>
    <strong>Description:</strong>
    <?php
    //Stupid hack. Since FuelPHP encodes everything, 
    //even HTML content coming from Aloha editor.
    //hence we have to decode "htmlspecialchars" to avoid
    //double encoding
    echo ($event->description) ? htmlspecialchars_decode($event->description) : "(no description)";
    ?></p>
<p>

<h3>Event agenda</h3>
<ul id="agenda">
	<?php foreach ($event->agendas as $agenda) : ?>
        <li><?php
	    echo $agenda->title;
	    echo " " . Html::anchor("agenda/delete/" . $agenda->id, "<i class='icon-remove'></i>", array("onclick" => "return confirm('Do you want to delete this agenda item?');"));
	    ?></li>
	<?php
    endforeach;  //foreach agenda item
    ?>
    <li><?php echo Html::anchor('agenda/create/' . $event->id, '<i class="icon-plus-sign"></i> Add new agenda item')
    ?>
    </li>
</ul>

<?php
if ($event->poster!=null) : ?>
    <p><?php echo Html::anchor("event/poster/".$event->id, "<i class='icon-file'></i>See the poster!")?></p>
<?php endif; //if we have a poster ?>

<p>    
    <?php echo Html::anchor('event/edit/' . $event->id, '<i class="icon-edit"></i> Edit this event', array("class" => "btn")); ?>
    <?php echo Html::anchor('event/delete/' . $event->id, '<i class="icon-remove"></i> Delete this event', array("class" => "btn", "onclick"=>"return confirm('Really?');")); ?>
</p>
<p>
    <?php echo Html::anchor('event', 'Back to list', array("class" => "btn-link")); ?>
</p>