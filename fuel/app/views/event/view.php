<h2><?php echo $event->title ?></h2>

<p>
    <strong><?php echo __("ACTION_VIEW_LABEL_TITLE")?>:</strong>
    <?php echo $event->title; ?></p>
<p>
    <strong><?php echo __("ACTION_VIEW_LABEL_START")?>:</strong>
    <?php echo $event->start; ?></p>

<p>
    <strong><?php echo __("ACTION_VIEW_LABEL_DESCRIPTION")?>:</strong>
    <?php
    //Stupid hack. Since FuelPHP encodes everything, 
    //even HTML content coming from Aloha editor.
    //hence we have to decode "htmlspecialchars" to avoid
    //double encoding
    echo ($event->description) ? htmlspecialchars_decode($event->description) : __("ACTION_VIEW_NO_DESCRIPTION");
    ?></p>
<p>

<h3><?php echo __("ACTION_VIEW_LABEL_AGENDA")?></h3>
<ul id="agenda">
	<?php foreach ($event->agendas as $agenda) : ?>
        <li><?php
	    echo $agenda->title;
	    echo " " . Html::anchor("agenda/delete/" . $agenda->id, 
				    "<i class='icon-remove'></i>", 
				    array("onclick" => "return confirm('Do you want to delete this agenda item?');"));
	    ?></li>
	<?php
    endforeach;  //foreach agenda item
    ?>
    <li><?php echo Html::anchor('agenda/create/' . $event->id,
		    '<i class="icon-plus-sign"></i> '.__('ACTION_VIEW_ADD_AGENDA'))
    ?>
    </li>
</ul>

<?php
if ($event->poster!=null) : ?>
    <p><?php echo Html::anchor("event/poster/".$event->id, "<i class='icon-file'></i>See the poster!")?></p>
<?php endif; //if we have a poster ?>

<p>    
    <?php echo Html::anchor('event/edit/' . $event->id, '<i class="icon-edit"></i> '.__('ACTION_VIEW_EDIT_EVENT'), array("class" => "btn")); ?>
    <?php echo Html::anchor('event/delete/' . $event->id, '<i class="icon-remove"></i> '.__('ACTION_VIEW_DELETE_EVENT'), array("class" => "btn", "onclick"=>"return confirm('Really?');")); ?>
</p>
<p>
    <?php echo Html::anchor('event', __("ACTION_VIEW_BACK"), array("class" => "btn-link")); ?>
</p>