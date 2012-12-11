<h2>New Event</h2>

<script type="text/javascript">
    
    //form enhancements
    $(document).ready(
    function(){
	//the "start" field should be a date (and time) picker
	$("#start").datetimepicker({
	    showSecond: false,
	    timeFormat: 'HH:mm:ss',
	    dateFormat: 'yy-mm-dd',
	    showOn: "button",
	    buttonImage: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAWCAMAAAAGlBe5AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAGAUExURfP+/4SbxMra+qSmuPr9/9fY+LzX+8axynWu+lBqtbnL68KntPHt/trz/1iL82eb/87F1+v+/6fFzZqrxS1htZdxgev0/5yz0qitv4Sk1Ozp/OLs/qm81Km4yDZtxpOs0LXN9FZ9w+X7/9nt/8zj/kxadFRphJmyxeL0/4qixqLI/3BNV4i5/Gh6kOPn/4OduLzn//7j7cDP4XyUverb7ZeZu9rY65qpsJnE/67F6vvX5qyGlOnZ99Po+uXI14enuSpDZIhrgT1YeP3y+4yw1n6i/4yIqJmzuszq/vT1/2h/m1h5qmaIy7q80vHI1Nvh+aS94MTh/qSZsdDf8LGpx/va3HqTr5mbrFSG32WBtzhTatPl/4SRpnWMtYCb0uvg8zFLbIeNnpW4+snO9q7T//Ly9muWz01lgLXT6DZPdClDWqaw07Kyzp+OoFxGW3ldcRdGYFU/VO7U4Oq7vv/RzCM9Yn6js+Dq+G2Fq22UsXV+nitXdICu4pG138bG4P39/U40qcsAAAIgSURBVHjadM5pV9pQEAbgIQRUJIVL5AYSwhJiSUABjaEioilaIAoGXBA3xIIL2kqrbW1tbf66tz+gz8x5P8ycOWfA/j+4oIWLJ/qCt8e29xmjawm9RTAL0jWD4OXlJbwZDvd64aNeI3HVmGpMEY2pRGIG/uSJ9PJw+DG9PDlHyvfhH5/vTRTC9WF+OMyn02Q3N7fcnSTTro+YjEJLc6hnqubQtKOj3vb2VSIa7UZnoqRnwEmbtN00MQaPAGaWlSSg7rAiM5vb4L+0vXaTt2kcorFp7pv2ZcFZoC2KvQaRxrYZokFJphBY1qHJewtVrzAoqhUIIADLKSDmZr2uZAu750vn/qprMOC0EdQCotjUI5HU+o9AKuT8PF0KBscT+7r+bEBAQjjbVJCUDzDYXJpeONhZe7+66qLYCrwD2vbu04CYmmRvLJQWiPtV/qS9+RtqIJCdLZTLNbzxsFI6OFh7+MpnPa1fXyCFMD/Qs4J8k9vjV3aCj992HjNr/r+R3DGsR1hdr96xuVxHdO6WxplxJnM/saufzt9CCARAIk6WGS5JuaxPLstl3VGUJ84Z5BcARVQUheGYZFLm5Hq7HXNT8WLMgEMMaI9NMrJblU+oYqddd8fVuDveUg1wPuHyIivLlEeVZXcr527HW44iOdP6IC4uimyHi+U6WzG1Q4JTtbNYzPFzawSn8/Ozx7fHRt8wKiOS/b7x3Rj1jVGl/yrAAB1dfRd6NP7oAAAAAElFTkSuQmCC",
	    buttonImageOnly: true});
	
	    
	//	    $("#locationtext").autocomplete({
	//		source: "http://www.eventual.org/location/search/",
	//		minLength: 1,
	//		select: function( event, ui ) {
	//	                if (ui.item) {
	//			    $("#locationid").val(ui.item.id);
	//			}
	//	            }	
	//	    });
	   
    });
    
    
    //adding new locations with ajax
    $(document).ready(function(){
	$opt_add = $("<option value='-1'id='addlocation'>Add new location...</option>")
	var $location = $("#form_location");
	$location.append($opt_add);
	$location.change(function(){
	    if ($(this).val()==-1) {
		$("#location_title").val(""); //cleaning out the old value
		$("#locationform").dialog({modal:true});
		
	    }
	});
    });
    
    /**
     * Saves a new location using AJAJ request.
     * The function is invoked by a button click from location dialog
     */
    function saveLocation(){
	var opts = {
	    type:"POST",    
	    url: "/location/create",
	    data: $("#location_title").serialize(), //POST data we're submitting
	    success: function(result){//success callback
		//if item was actually saved
		if (result.id) {
			
		    var $opt = $("<option/>");
		    $opt.val(result.id);
		    $opt.text($("#location_title").val());
		    $opt.attr("selected","selected");
		    $("#addlocation").before($opt);
		    $("#locationform").dialog('close');
		}
	    },
	    statusCode: {
		403 : function(){
			alert("Access denied!");
			$("#locationform").dialog('close');
		    }
		},
	    dataType: "json"
	}
	$.ajax(opts);
    }
</script>
<script src="http://cdn.aloha-editor.org/latest/lib/aloha.js"
	data-aloha-plugins="common/ui,
	common/format,
	common/list,
	common/link">
</script>
<script>
    Aloha.ready( function() {
	var $ = Aloha.jQuery;
	$('#description').aloha();
    });
</script>


<?php echo Form::open(array("enctype" => "multipart/form-data")); ?>
<fieldset>

    <div class="clearfix">
	<?php echo Form::label('Title of the event', 'title'); ?>

	<div class="input">
	    <?php
	    echo Form::input('title', Input::post('title', isset($event) ? $event->title : ''), array("class" => "span4")
	    );
	    ?>
	</div>
    </div>
    <div class="clearfix">
	<?php echo Form::label('Description of the event', 'description'); ?>

	<div class="input">
	    <?php
	    echo Form::textarea('description', Input::post('description', isset($event) ? $event->description : ''), array("id" => "description", "rows" => 4, "class" => "span4"));
	    ?>
	</div>
    </div>
    <div class="clearfix">
	<?php echo Form::label('Date', 'start'); ?>
	<div class="input">
	    <?php echo Form::input('start', Input::post('start', isset($event) ? $event->start : ''), array("id" => "start")); ?>
	</div>
    </div>

    <div class="clearfix">
	<?php echo Form::label('Location', 'location'); ?>
	<div class="input">

	    <?php
	    $location_options = array_merge(
		    array("0" => "Pick a location"), $locations);


	    echo Form::select("location", Input::post("location"), $location_options)
	    ?>
	</div>
	<div style="display:none" id="locationform" title="Add new location">
	    <label for="location_title">Title</label>
	    <input type="text" name="location_title" id="location_title" />
	    <input type="button" onclick="saveLocation()" value="Save" class="btn btn-primary" />
	</div>
    </div>

    <!--div class="clearfix">
    <?php echo Form::label('Location autocompelete', 'locationtext'); ?>
	<div class="input ui-widget">
	    <input type="text" name="locationtext" id="locationtext" />
	    <input type="text" name="locationid" id="locationid" />
	</div>
    </div-->

    <div class="clearfix">

	<?php
	echo Form::label('Event poster (PDF file)', 'poster');

	$existing_file = Session::get("uploaded_file_" . $form_key, null);
	if ($existing_file != null) {
	    ?>
    	<p>You already have uploaded a file: <?php echo $existing_file; ?></p>
	    <?php
	} else {
	    //no file uploaded yet - let's allow it!
	    ?>
    	<div class="input ui-widget">
    	    <input type="file" name="poster" id="posterfile" />	    
    	</div>
	<?php } ?>
    </div>
</fieldset>	
<div class="actions">
    <?php echo Form::hidden("form_key", $form_key); ?>
    <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>

</div>
<?php echo Form::close() ?>
