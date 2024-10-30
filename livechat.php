<?php
/**
 * @package Jitbit_Livechat
 * @version 0.1
 */
/*
Plugin Name: Jitbit Livechat for Wordpress
Plugin URI: http://www.jitbit.com/livechat/
Description: This plugin inserts Jitbit Livechat widget on every page of your Wordpress blog.
Author: Jitbit
Version: 0.1
Author URI: http://jitbit.com/
*/


// This just echoes the chosen line, we'll position it later
function get_widget() {
	$jitbit_livechat_url = rtrim(get_option("jitbit_livechat_url"), "/");
    if(!empty($jitbit_livechat_url)){
    $path = "/Scripts/chatwidget.js";
		echo "<div class='lc-widget'><a href='http://www.jitbit.com/livechat/'>Start a live chat</a></div>
	<script type='text/javascript' src='".$jitbit_livechat_url.$path."'></script>";
	}
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'wp_footer', 'get_widget' );


function setup_admin_menus() {
      add_submenu_page('plugins.php',
        'Livechat Settings', 'Jitbit Livechat', 'manage_options',
        'livecaht-elements', 'livechat_settings');
}

function livechat_settings() {
	if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
	}

	if (isset($_POST["update_settings"])) {
    // Do the saving
    $url = esc_attr($_POST["url"]);
		update_option("jitbit_livechat_url", $url);
		?>
    <div id="message" class="updated">Settings saved</div>
		<?php
	}

	$jitbit_livechat_url = get_option("jitbit_livechat_url");
 ?>
 <div class="wrap">
        <?php screen_icon('plugins'); ?> <h2>Jitbit Livechat Settings</h2>

        <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                            <label for="url">
												        Your Livechat URL:
												    </label>
                    </th>
                    <td>
                            <input type="text" name="url" value="<?php echo $jitbit_livechat_url;?>" placeholder="https://chat.jitbit.com/chat">
                            <p class="description">Make sure you enter the full URL like this https://%your_company_name%.jitbit.com<b>/chat</b>"</p>
                            <input type="hidden" name="update_settings" value="Y" />
                    </td>
                </tr>
            </table>
            <p>
					    <input type="submit" value="Save settings" class="button-primary"/>
						</p>
        </form>
    </div>



<?php
}
// This tells WordPress to call the function named "setup_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_admin_menus");
?>
