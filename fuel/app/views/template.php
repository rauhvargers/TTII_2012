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
	<?php
	if (isset($libs_js)) {
	    //some views may want to add extra scripts
	    echo Asset::js($libs_js);
	}
	?>

	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('eventual.css'); ?>
	<?php
	if (isset($libs_css)) {
	    //some views may want to add extra stylesheets
	    echo Asset::css($libs_css);
	}
	?>
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
