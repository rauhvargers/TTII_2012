<h1>List of current events</h1>
<ul>
    <?php foreach ($event_dates as $event_date=>$event_title) : ?>
        <li>
	    <?php echo $event_date ?> : 
	    <?php echo $event_title ?>
        </li>

    <? endforeach; ?>
	
<?php foreach ($event_dates_db as $event) : ?>
        <li>
	    <?php echo $event['id'] ?> : 
	    <?php echo $event['title'] ?>
        </li>

    <? endforeach; ?>
</ul>

<footer>
    <small>Page generated: <?php
    echo $generation_time;
    ?>.</small>
</footer>