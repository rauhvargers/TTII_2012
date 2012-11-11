<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php
if (isset($page_title)) {
    echo $page_title;
}
if (isset($title)) {
    echo $title;
}
?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style type="text/css">
	    body {font-family:Arial, sans-serif;
		  width:70%;
		  margin:0 auto;
	    }
	    nav {border-bottom:1px solid blue;}
	    .alert-message {
		font-weight:bold;
		padding:5px;
		margin:10px;
		line-height:1em;
	    }
	    .alert-message.success {
		border:1px solid green;
		background-color: #008000;
	    }
	    .alert-message.error {
		border:1px solid red;
		background-color: indianred;
		color:white;
	    }
	    header h1 {
		border-bottom: 1px dotted #ccc;
		margin-bottom: 20px;
		margin-top:20px;
		color:#999; 
	    }
	    nav ul {
		zoom:1;
	    }
	    nav ul li {
		list-style-type: none;
		float:left;
		padding:8px;
	    }
	    
	</style>

    </head>
    <body>
	<header>
	    <h1>&laquo;Eventual&raquo; : an event management system</h1>
	    <nav>
		<ul class="clearfix">
		    <li><a href="/event/">Events</a></li>
		    <li><a href="/country/">Countries</a></li>

		</ul>
	    </nav>
	</header>
	<section id="main">
	    <div class="row">
		<?php if (Session::get_flash('success')): ?>
    		<div class="alert-message success">
    		    <p>
			    <?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
    		    </p>
    		</div>
		<?php endif; ?>
		<?php if (Session::get_flash('error')): ?>
    		<div class="alert-message error">
    		    <p>
			    <?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
    		    </p>
    		</div>
		<?php endif; ?>
	    </div>
	    
	    <article>
		<?php
		if (isset($page_content)) {
		    echo $page_content;
		};
		if (isset($content)) {
		    echo $content;
		};
		?>
	    </article>
	</section>
    </body>
</html>
