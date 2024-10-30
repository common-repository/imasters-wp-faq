<div class="wrap">
<?php
/** Define name of base_name and base_page */
$base_name = plugin_basename('imasters-wp-faq/imasters-wp-faq-manager.php');
$base_page = 'admin.php?page='.$base_name;

/**
 * Check if update successfull and show message.
 */
if ( isset( $_GET['updated'] ) ) :

    if ( $_GET['updated'] ) :

        // Set up a user message
        $text_message 	= __('Settings updated successfully.', 'imasters-wp-faq');
        $class_name 	= 'updated fade';
    endif;
endif;
?>

<?php
/**
 * Show a message to user about the insertion proccess
 */
if ( !empty($text_message) ) :
?>
<div id="message" class="<?php echo $class_name; ?>">
	<p><?php echo $text_message; ?></p>
</div>
<?php endif; ?>

    <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Settings', 'imasters-wp-faq'); ?></h2>
    <form method="post" action="options.php">
    <table class="form-table">
        <tbody>
            <?php
                /**
                * This will insert two hidden fields which automatically help to check that the user can update
                * options and also redirect the user back to the correct admin page (because the form action is a different page).
                */
                wp_nonce_field('update-options'); ?>
            <tr valign="top">
                <th><label for="imasters_wp_faq_insert_js"><?php _e('Insert JavaScript to collapse answers?', 'imasters-wp-faq'); ?></label></th>
                <td>
                    <input type="checkbox" id="imasters_wp_faq_insert_js" name="imasters_wp_faq_insert_js" value="1" <?php echo( get_option('imasters_wp_faq_insert_js') == 1 ) ? 'checked="checked"' : ''; ?>  />
                    <span class="description"><?php _e('Mark this option to insert javascript.', 'imasters-wp-faq'); ?></span>
                </td>
            </tr>
            <tr>
            <td>
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="imasters_wp_faq_insert_js" />
                <p class="submit">
                <input class="button-primary" type="submit" name="submit" value="<?php _e('Save', 'imasters-wp-faq'); ?>" /> <?php _e('or', 'imasters-wp-faq'); ?> <a href="<?php echo $base_page; ?>"><?php _e('cancel', 'imasters-wp-faq'); ?></a>
                </p>
            </td>
        </tr>
        <tbody>
    </table>
    </form>
</div>