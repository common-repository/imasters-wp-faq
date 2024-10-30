<!-- Uninstall iMasters FAQ -->
<?php
    if( !current_user_can('install_plugins')):
        die('Access Denied');
    endif;
$base_name = plugin_basename('imasters-wp-faq/imasters-wp-faq.php');
$base_page = 'admin.php?page='.$base_name;
if ( isset ($_GET['mode']) )
    $mode = trim($_GET['mode']);
else
    $mode = '';
$faq_tables = array($wpdb->imasters_wp_faq, $wpdb->imasters_wp_faq_categories);
$faq_settings = array('imasters_wp_faq_db_version','imasters_wp_faq_insert_js');

//Form Process
if( isset( $_POST['do'], $_POST['uninstall_faq_yes'] ) ) :
    echo '<div class="wrap">';
    ?>
    <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Uninstall iMasters WP FAQ', 'imasters-wp-faq') ?></h2>
    <?php
    switch($_POST['do']) {
        //  Uninstall iMasters WP FAQ
        case __('Uninstall iMasters WP FAQ', 'imasters-wp-faq') :
        if(trim($_POST['uninstall_faq_yes']) == 'yes') :
        echo '<h3>'.__( 'Tables', 'imasters-wp-faq').'</h3>';
        echo '<ol>';
        foreach($faq_tables as $table) :
            $wpdb->query("DROP TABLE {$table}");
            printf(__('<li>Table \'%s\' has been deleted.</li>', 'imasters-wp-faq'), "<strong><em>{$table}</em></strong>");
        endforeach;
        echo '</ol>';
        echo '<h3>'.__( 'Options', 'imasters-wp-faq').'</h3>';
        echo '<ol>';
        foreach($faq_settings as $setting) :
            $delete_setting = delete_option($setting);
            if($delete_setting) {
            printf(__('<li>Option \'%s\' has been deleted.</li>', 'imasters-wp-faq'), "<strong><em>{$setting}</em></strong>");
            }
            else {
                printf(__('<li>Error deleting Option \'%s\'.</li>', 'imasters-wp-faq'), "<strong><em>{$setting}</em></strong>");
                }
        endforeach;
        echo '</ol>';
        echo '<br/>';
        $mode = 'end-UNINSTALL';
        endif;
        break;
    }
endif;
    switch($mode) {
    //  Deactivating Uninstall iMasters WP FAQ
    case 'end-UNINSTALL':
        $deactivate_url = 'plugins.php?action=deactivate&amp;plugin=imasters-wp-faq/imasters-wp-faq.php';
        if(function_exists('wp_nonce_url')) {
            $deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_imasters-wp-faq/imasters-wp-faq.php');
        }
    echo sprintf(__('<a href="%s" class="button-primary">Deactivate iMasters WP FAQ</a> Disable that plugin to conclude the uninstalling.', 'imasters-wp-faq'), $deactivate_url);
    echo '</div>';
    break;
    default:
    ?>
    <!-- Uninstall iMasters WP FAQ -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo plugin_basename(__FILE__); ?>">
        <div class="wrap">
            <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Uninstall iMasters WP FAQ', 'imasters-wp-faq'); ?></h2>
            <p><?php _e('Uninstaling this plugin the options and table used by iMasters WP FAQ will be removed.', 'imasters-wp-faq'); ?></p>
            <div class="error">
            <p><?php _e('Warning:', 'imasters-wp-faq'); ?>
            <?php _e('This process is irreversible. We suggest that you do a database backup first.', 'imasters-wp-faq'); ?></p>
            </div>
            <table>
                <tr>
                    <td>
                    <?php _e('The following WordPress Options and Tables will be deleted:', 'imasters-wp-faq'); ?>
                    </td>
                </tr>
            </table>
            <table class="widefat">
                <thead>
                    <tr>
                        <th><?php _e('WordPress Options', 'imasters-wp-faq'); ?></th>
                        <th><strong><?php _e('WordPress Tables', 'imasters-wp-faq'); ?></th>
                    </tr>
                </thead>
                <tr>
                    <td valign="top">
                        <ol>
                        <?php
                        foreach($faq_settings as $settings)
                            printf( "<li>%s</li>\n", $settings );
                        ?>
                        </ol>
                    </td>
                    <td valign="top" class="alternate">
                        <ol>
                            <?php
                            foreach( $faq_tables as $table_name )
                                printf( "<li>%s</li>\n", $table_name );
                            ?>
                        </ol>
                    </td>
                </tr>
            </table>
            <p>
                <input type="checkbox" name="uninstall_faq_yes" id="uninstall_faq_yes" value="yes" />
                <label for="uninstall_faq_yes"><?php _e('Yes. Uninstall iMasters WP FAQ now', 'imasters-wp-faq'); ?></label>
            </p>
            <p>
                <input type="submit" name="do" value="<?php _e('Uninstall iMasters WP FAQ', 'imasters-wp-faq'); ?>" class="button-primary" />
            </p>
        </div>
    </form>
<?php
}
?>