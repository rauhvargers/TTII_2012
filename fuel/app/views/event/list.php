<h1>List of current events</h1>
<ul>
    <?php foreach ($event_dates as $event_date) : ?>
        <li>
	    <?php echo $event_date ?>
        </li>

    <? endforeach; ?>
</ul>

<footer>
    <small>Page generated: <?php
    echo $generation_time;
    ?>.</small>
</footer>