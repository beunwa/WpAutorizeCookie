<?php
/*
Plugin Name: WpAutorizeCookie
Plugin URI: http://divioseo.fr
Description: ask user if he want to autorize the storage of cookie, if not the plugin delete all the domain cookies at each page loads
Author: beunwa
Author URI: http://divioseo.fr
Version: 1
Stable tag: 1
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/


function wpac_popup(){
	if(isset($_COOKIE['wpac_choice']) || isset($_REQUEST['wpac_choice'])) return;
	
	?>
	<style type="text/css">
		#wpacPopup{
			height: 100px;
			position:absolute;
			width:100%;
			padding:10px;
			top:0;
			background-color:#ccc;
			text-align:center;
			z-index: 1000;
		}
		
		#wpacPopup .green{
			background-color:#7a7;
			border:none;
		}
		
		#wpacPopup .grey{
			border:none;
			background-color:#777;
		}
	</style>
	<div id="wpacPopup">
	<p><span style="font-weight: bold;">Afin de réaliser des statistiques publicitaires et audience anonymes, je souhaite implanter un cookie sur votre ordinateur.</span></p>
	<div class="buttons">
		<form action="" method="post">
			<button class="grey" value="decline" name="wpac_choice" type="submit">Non merci</button>
			<button class="green" value="accept" name="wpac_choice" type="submit">Accepter</button>
		</form>
		<p class="legend">Je vais mémoriser votre choix dans un cookie. :D (si vous refusez alors certaines fonctionnalités du site seront inaccessible)</p>
	</div>
</div>
	<?php
}

function wpac_check(){
	
	if(isset($_REQUEST['wpac_choice'])) setcookie('wpac_choice', $_REQUEST['wpac_choice'], 0, '/' );
	//echo $_COOKIE['wpac_choice'];die();
	if($_COOKIE['wpac_choice'] == 'decline' && !is_user_logged_in()){
		$past = time() - 3600;
		foreach($_COOKIE as $key => $value ){
			if($key == 'wpac_choice') continue;
			setcookie($key, $value, $past, '/' );
		}
	}
}

add_action('get_header','wpac_check');
add_action('wp_footer','wpac_popup');
?>
