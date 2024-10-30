<?php
    $wpconfig = realpath("../../../wp-config.php");
    if (!file_exists($wpconfig))  {
        echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;
        die;
    }
    require_once($wpconfig);
    require_once(ABSPATH.'/wp-admin/admin.php');
    global $wpdb;
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>iMasters WP FAQ</title>
        <!-- 	<meta http-equiv="Content-Type" content="<?php// bloginfo('html_type'); ?>; charset=<?php //echo get_option('blog_charset'); ?>" /> -->
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/imasters-wp-faq/assets/javascript/tinymce.js"></script>
        <base target="_self" />
    </head>
    <body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
        <!-- <form onsubmit="insertAction();return false;" action="#" autocomplete="off">-->
        <form name="faq" action="#">
            <table border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td nowrap="nowrap"><label for="faq_main"><?php _e("Select Category", 'imasters-wp-faq'); ?></label></td>
                    <td>
                        <select id="faq_categories" name="faq_main" style="width: 200px">
                            <?php $objCategories = $wpdb->get_results( "
                                    SELECT * FROM $wpdb->imasters_wp_faq_categories
                                    ORDER BY category_name
                                " );
                            if( $objCategories ) :
                            foreach( $objCategories as $objCategory ) : ?>
                            <option value="<?php echo $objCategory->category_id; ?>"><?php echo $objCategory->category_name;  ?></option>
                            <?php endforeach; ?>
                            <?php else :?>
                            <option value=""><?php _e('No category until the moment.', 'imasters-wp-faq'); ?></option>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td nowrap="nowrap" valign="top"><label for="showtype"><?php _e("Letters filter", 'imasters-wp-faq'); ?></label></td>
                    <td><label><input name="showtype" id='faq_filters' type="checkbox" checked="checked" /><span><?php _e( 'Mark to show letters filter', 'imasters-wp-faq' ); ?></span></label></td>
                </tr>
            </table>
            <div class="mceActionPanel">
            <p>
                <div style="float: left">
                    <input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'imasters-wp-faq'); ?>" onclick="tinyMCEPopup.close();" />
                </div>
                <div style="float: right">
                    <input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'imasters-wp-faq'); ?>" onclick="insertFAQcode();" />
                </div>
            </p>
            </div>
        </form>
    </body>
</html>