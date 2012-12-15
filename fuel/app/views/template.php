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
	    <div id="setlang">
		<?php
		    echo Html::anchor("account/setlang/lv", "LV");
		    echo " | ";
		    echo Html::anchor("account/setlang/en", "EN");
		?>
		
	    </div>
	    <h1><?php echo Html::anchor("/", __("EVENTUAL_TITLE"));?></h1>
	    <h3><?php
	if (isset($page_title)) {
	    echo $page_title;
	}
	if (isset($title)) {
	    echo $title;
	}
	?></h3>

	    <aside id="auth">	    
		<?php
		$auth = Auth::instance();
		$user_id = $auth->get_user_id();
		if ($user_id[1] != 0) :
		    ?>
		<div id="logged-in">
		    <?php echo __("LOGGED_IN_AS") . $auth->get_email(); ?>
		</div>
		<div id="logout">
			<?php
			echo Html::anchor("account/logout", __("LOG_OUT"));
			?>
    		</div>
		    <?php
		else :
		    echo Html::anchor("account/simpleauth", __("NOT_LOGGED_IN"));
		    ?>
		<?php
		endif;
		?>
	    </aside>
	    <nav>
		<ul class="clearfix">
		    <li><?php echo Html::anchor('/event', __('MENU_TITLE_EVENTS'))?></li>
		    <li><?php echo Html::anchor('/country', __('MENU_TITLE_COUNTRIES'))?></li>

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
