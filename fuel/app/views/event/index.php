<script type="text/javascript">
    $(document).ready(function(){
	//$("div.agenda").css("cursor","pointer").click(LoadAgendaXHR);
	$("div.agenda").css("cursor","pointer").click(LoadAgendaJquery);
    });
    
    function LoadAgendaJquery(){
	   var $self = $(this);
	   
	   $.get(
	    //url
	    "http://www.eventual.org/agenda/index/" + $(this).attr("data-event-id"), 
	    
	    //data to send, in our case nothing
	    null, 
	    
	    //success callback
	    function (agendas){
		var titles = [];
		    for (var agenda in agendas) {
			titles.push("<li>" + agendas[agenda]["title"] + "</li>");
		    }
		    var agendaHtml = "<ul>" + titles.join("") + "</ul>";
		    //finally, we replace the link that was clicked
		    //with the generated html
		    $self.replaceWith(agendaHtml);
	    },
	    //expected return type
	    "json"	
	
	    );
    }
    
    function LoadAgendaXHR (){
	    var $self = $(this);
	    var xhr = new XMLHttpRequest();
	    var eventid = $(this).attr("data-event-id");
	    var url = "http://www.eventual.org/agenda/index/" + eventid;
	    xhr.open("GET", url, true);
	    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
	    
	    xhr.onreadystatechange = function() {
		if (xhr.readyState == 4) {
		    //the /agenda/index returns JSON object, 
		    //hence we have to eval() it before use
		    var agendas = $.parseJSON( xhr.responseText );
		    
		    //looping through the return and generating HTML for it
		    var titles = [];
		    for (var agenda in agendas) {
			titles.push("<li>" + agendas[agenda]["title"] + "</li>");
		    }
		    var agendaHtml = "<ul>" + titles.join("") + "</ul>";
		    //finally, we replace the link that was clicked
		    //with the generated html
		    $self.replaceWith(agendaHtml);
		}
	    }
	    
	    xhr.send(null);
	}
</script>
    <?php
foreach ($event_model as $event) :
    ?>
    <h3><?php
    echo Html::anchor("event/view/" . $event->id, $event->title);
    ?></h3>
    <p><?php echo __('ACTION_INDEX_LOCATION'). (($event->location) ? $event->location->title : __('NOT_SET')) ?></p>
    <p><?php echo __('ACTION_INDEX_START') . (Date::create_from_string($event->start, "mysql")->format("%d.%m.%Y, %H:%M")); ?>
    
    <div class="agenda" data-event-id="<?php echo $event->id?>">
	   <?php echo __('LINK_SHOW_AGENDA')?>
    </div>
    <!--ul>
	<?php foreach ($event->agendas as $agenda) : ?>
	    <li><?php echo $agenda->title; ?></li>
	    <?php
	endforeach;  //foreach agenda item
	?>
    </ul-->
<?php endforeach; //foreach event?>
<?php if (Auth::has_access("event.create")) : ?>
    <p>
	<?php
	echo Html::anchor("/event/create/", __("ADD_EVENT_LINK"), array("class" => "btn btn-primary"))
	?>

    </p>
 <?php endif;
 