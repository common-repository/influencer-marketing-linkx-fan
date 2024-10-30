<?php
/*
 * Influencer Marketing - LinkX.fan 
 *
 * @package sahu_influencer_track
 * @copyright Copyright (c) 2021, SAHU MEDIA®
*/

// Registriere Menü

add_action( 'admin_menu', 'sahu_influencer_main_admin_menu' );
function sahu_influencer_main_admin_menu() {
	
	add_menu_page(
		__( 'Influencer', 'sahu_influencer_track' ),
		__( 'Influencer', 'sahu_influencer_track' ),
		'manage_options',
		'sahu-influencer-plugin-main',
		'sahu_influencer_admin_page_contents',
		'dashicons-schedule',
		3
	);
}

function sahu_influencer_admin_page_contents() {
    ?>
    <h1><?php esc_html_e( 'Influencer Marketing - linkX.fan ®', 'sahu_influencer_track' ); ?></h1>
    <form method="POST" action="options.php">
    <?php
		settings_fields( 'sahu_influencer-options-app-page' );
		do_settings_sections( 'sahu_influencer-options-app-page' );
		submit_button( __( 'Save', 'sahu_influencer_track' ), 'primary' )
    ?>
    </form>
    <?php
		do_settings_sections( 'sahu_influencer-options-app-page_footer' );
}

// Lade Formular

add_action( 'admin_init', 'sahu_influencer_settings_init' );
function sahu_influencer_settings_init() {

    add_settings_section(
        'sahu_influencer_setting_section',
        __( 'Settings', 'sahu_influencer_track' ),
        'sahu_influencer_callback_function',
        'sahu_influencer-options-app-page'
    );
	
		add_settings_field(
		   'sahu_influencer_appid',
		   __( 'ApplicationID', 'sahu_influencer_track' ),
		   'sahu_influencer_appid',
		   'sahu_influencer-options-app-page',
		   'sahu_influencer_setting_section'
		); 
		
		register_setting( 'sahu_influencer-options-app-page', 'sahu_influencer_appid' );	
		
		
	add_settings_section(
        'sahu_influencer_setting_section_footer',
        __( 'Easy! How it works!', 'sahu_influencer_track' ),
        'sahu_influencer_callback_function_footer',
        'sahu_influencer-options-app-page_footer'
    );

}

function sahu_influencer_callback_function() {
	
	echo __( 'Track Influencer with LinkX.fan - Evaluate influencers and see sales. Your APPID - u got it from https://app.linkx.fan - <strong>Please Register under current Beta-URL to start tracking your influencers <a href="https://linkx.fan/beta" target="_blank">https://linkx.fan/beta</a></strong>', 'sahu_influencer_track' );
	
}


function sahu_influencer_appid() {
	$app_id = get_option( 'sahu_influencer_appid' );
	
    ?>
    <input type="text" id="sahu_influencer_appid" name="sahu_influencer_appid" value="<?php print esc_attr($app_id) ?>" placeholder="<?php print __( 'APPID', 'sahu_influencer_track' ) ?>">
    <?php
}


function sahu_influencer_callback_function_footer() {
	//Get the active tab from the $_GET param
	$default_tab = null;
	$tab = isset($_GET['tab']) ? sanitize_title($_GET['tab']) : $default_tab;
	
	?>
	<!-- Our admin page content should all be inside .wrap -->
	<div class="wrap">
    <!-- Here are our tabs -->
    <nav class="nav-tab-wrapper">
		<a href="?page=sahu-influencer-plugin-main" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>"><?php echo __( 'LinkX.fan', 'sahu_influencer_track' );?></a>
		<a href="?page=sahu-influencer-plugin-main&tab=pversion" class="nav-tab <?php if($tab==='pversion'):?>nav-tab-active<?php endif;?>" ><?php echo __( 'Guide', 'sahu_influencer_track' );?></a>
    </nav>
	<div class="tab-content">
	<?php
	switch($tab) :
		case 'pversion':
			echo __( '<h2>How to use?</h2>', 'sahu_influencer_track' );
			echo __( '1) Register an Account on https://linx.fan/beta (its 4 free!).', 'sahu_influencer_track' );
			echo '<br>';
			echo __( '2) After 24 h we will send u Logins for https://app.linkx.fan - after Login under Profil u find a APPID.', 'sahu_influencer_track' );
			echo '<br>';
			echo __( '3) Enter the appid in the ApplicationID field and save.', 'sahu_influencer_track' );
			echo '<br>';
			echo __( '4) Know u Website is rdy 4 track! Please go to https://app.linkx.fan and create your first campaign.', 'sahu_influencer_track' );
		break;
		default:
			echo __( '<h2>Register on linkx.fan 4 free!</h2>', 'sahu_influencer_track' );
			echo '<p>';
			echo __( 'Current is linkX.fan free to use and only available in English & German. Still, you can use the whole thing. Please register on our website and we will set up a free account for you within 24 hours.', 'sahu_influencer_track' );
			echo '</p>';
			echo '<a target="_blank" href="https://linkx.fan/beta">';
			echo __( 'Click here to register for free!', 'sahu_influencer_track' );
			echo '</a>';
		break;
	endswitch; 
	?>
	</div>
	</div>
	<?php
}

?>