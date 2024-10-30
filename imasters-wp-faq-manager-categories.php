<?php
/**
 * Define name of base_name and base_page
 */
$base_name = plugin_basename('imasters-wp-faq/imasters-wp-faq-manager-categories.php');
$base_page = 'admin.php?page='.$base_name;

if ( isset( $_POST['act'] ) ) :

    switch( $_POST['act'] ) :

        case 'add_category' :

            /** Include validation class */
            include 'includes/validation.php';

            /** Import variables into the current symbol table from an array */
            extract($_POST, EXTR_SKIP);

            /** Set the errors array to empty, by default */
            $errors = array();

            /** Stores the field values */
            $fields = array();

            /** Define an empty success message, by default */
            $success_message = "";

            /** Stores the validation rules */
            $rules = array();

            /** Standard form fields */

            /** Defaul data required*/
            $rules[] = sprintf("required,category_name,   %s", __('Category name is required.', 'imasters-wp-faq'));

            /** Check the validation rules against the values informed */
            $errors = validateFields($_POST, $rules);

            /** If no errors, procede */
            if ( empty($errors) ) :

                $add_category = $objiMastersWPFaq->add_category( $_POST );

                if ( $add_category ) :

                    /** Set up a user message */
                    $text_message   = __('Category added successfully.', 'imasters-wp-faq');
                    $class_name     = 'updated fade';

                else :

                    /** Set up a user message */
                    $text_message   = __('Category dont\'t added', 'imasters-wp-faq');
                    $class_name     = 'error';

                endif;
            endif;

        break;

        case 'edit_category' :

            /** Include validation class */
            include 'includes/validation.php';

            /** Import variables into the current symbol table from an array */
            extract($_POST, EXTR_SKIP);

            /** Set the errors array to empty, by default */
            $errors = array();

            /** Stores the field values */
            $fields = array();

            /** Define an empty success message, by default */
            $success_message = "";

            /** Stores the validation rules */
            $rules = array();

            /** Standard form fields */

            /** Defaul data required*/
            $rules[] = sprintf("required,category_name,   %s", __('Category name is required.', 'imasters-wp-faq'));

            /** Check the validation rules against the values informed */
            $errors = validateFields($_POST, $rules);

            /** If no errors, procede */
            if ( empty($errors) ) :

                $updated_category = $objiMastersWPFaq->edit_category( $_POST );

                if ( $updated_category ) :

                    /** Set up a user message */
                    $text_message   = __('Category updated successfully.', 'imasters-wp-faq');
                    $class_name     = 'updated fade';

                else :

                    /** Set up a user message */
                    $text_message   = __('Category dont\'t updated', 'imasters-wp-faq');
                    $class_name     = 'error';

                endif;
            endif;

        break;

        case __('Delete', 'imasters-wp-faq') :

            if ( isset($_POST['delete']) ) :

                    foreach( $_POST['delete'] as $id ) :

                        $category_id = (int)$id;

                        $is_used = $objiMastersWPFaq->is_used_by_faq($category_id);

                        if( !$is_used )
                            $delete = $wpdb->query("DELETE FROM $wpdb->imasters_wp_faq_categories WHERE category_id = $category_id");
                       
                    endforeach;

                    if( $delete ) :

                        /** Set up a user message */
                        $text_message 	= __('Category deleted successfully.', 'imasters-wp-faq');
                        $class_name 	= 'updated fade';

                    elseif( $is_used ) :
                        /** Set up a user message */
                        $text_message 	= __("Category in using by some FAQ can't be deleted.", 'imasters-wp-faq');
                        $class_name 	= 'error';

                    else :
                        /** Set up a user message */
                        $text_message 	= __('Delete category unsuccessful.', 'imasters-wp-faq');
                        $class_name 	= 'error';
                    endif;
            endif;

        break;

    endswitch;
endif;
?>

<div class="wrap">

<?php
/**
 * Show a message to user about the insertion proccess
 */
if ( !empty($text_message) ) :
?>

<div id="message" class="<?php echo $class_name; ?>">
    <p><?php echo $text_message; ?><a href="<?php echo $base_page; ?>" title="<?php _e('Back to manager categories.', 'imasters-wp-faq'); ?>"><?php _e('Manager categories', 'imasters-wp-faq'); ?></a></p>
</div>
<?php endif; ?>

<?php
/**
 * If we have errors about the validation, shows then
 */
if ( !empty($errors) ) :
?>
<div id="message" class="error">
    <p><strong><?php _e('Observations:', 'imasters-wp-faq'); ?></strong></p>
    <ul>
<?php foreach($errors as $error) : ?>
        <li><?php echo $error; ?></li>
<?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>


<?php

    if (isset ($_GET['mode']) )
        $mode = trim( $_GET['mode'] );
    else
        $mode = '';

    switch( $mode ) :

        case 'add_category' : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="form-table">
                <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Add category', 'imasters-wp-faq'); ?></h2>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="category_name"><?php _e('Category', 'imasters-wp-faq'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="category_name" name="category_name" class="regular-text" />
                            </td>
                        </tr>
                   </tbody>
               </table>
                <p class="submit">
                    <input type="hidden" id="act" name="act" value="add_category" />
                    <input type="submit" id="button" name="button" value="<?php _e('Save', 'imasters-wp-faq'); ?>" class="button-primary"/> <?php _e('or', 'imasters-wp-faq'); ?> <a href="<?php echo $base_page; ?>"> <?php _e('cancel', 'imasters-wp-faq'); ?></a>
                </p>
            </form>
<?php   break;

        case 'edit_category' :

            if( $_GET['category_id'] ) :

                $objCategory = $wpdb->get_row( $wpdb->prepare( "
                    SELECT * FROM $wpdb->imasters_wp_faq_categories
                    WHERE
                    category_id = %d
                    ",
                    $_GET['category_id']
                ));

                if ( $objCategory ) : ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="form-table">
                        <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Edit category', 'imasters-wp-faq'); ?></h2>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="category_name"><?php _e('Category', 'imasters-wp-faq'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="category_name" name="category_name" value="<?php echo $objiMastersWPFaq->clean_chars( $objCategory->category_name ); ?>" class="regular-text"/>
                                    </td>
                                </tr>
                           </tbody>
                       </table>
                        <p class="submit">
                            <input type="hidden" id="category_id" name="category_id" value="<?php echo $objCategory->category_id; ?>" />
                            <input type="hidden" id="act" name="act" value="edit_category"  />
                            <input type="submit" id="button" name="button-primary" value="<?php _e('Save', 'imasters-wp-faq'); ?>" class="button-primary"/>  <?php _e('or', 'imasters-wp-faq'); ?> <a href="<?php echo $base_page; ?>"> <?php _e('cancel', 'imasters-wp-faq'); ?></a>
                        </p>
                    </form>
<?php           endif;
            endif;

	break;
	default : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
                    <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Manager categories', 'imasters-wp-faq'); ?></h2>
                    <div class="tablenav">
                        <div class="alignleft">
                            <input type="submit" id="delete-cat" class="button" name="act" value="<?php _e('Delete', 'imasters-wp-faq'); ?>" onclick="return confirm(' <?php _e( 'You are about to delete the selected Category FAQs. \n\n Choose [Cancel] To Stop, [OK] To Delete.', 'imasters-wp-faq' ); ?>')"/>
                            <a class="button-primary" href="<?php echo $base_page; ?>&amp;mode=add_category"><?php _e('Add category', 'imasters-wp-faq'); ?></a>
                        </div>
                    <br class="clear"/>
                    </div>
                    <table class="widefat fixed">
                        <thead>
                            <tr>
                                <th class="check-column" scope="col"><input type="checkbox" /></th>
                                <th scope="col"><?php _e('Category name', 'imasters-wp-faq'); ?></th>
                                <th scope="col"><?php _e('ID','imasters-wp-faq'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                            $objCategories = $wpdb->get_results( "
                                SELECT * FROM $wpdb->imasters_wp_faq_categories
                                ORDER BY category_name
                                "
                            );

                        if( $objCategories ) :

                            foreach( $objCategories as $objCategory ) : ?>

                            <tr>
                                <th class="check-column" scope="row">
                                    <input type="checkbox" value="<?php echo $objCategory->category_id; ?>" name="delete[]" />
                                </th>
                                <td><a href="<?php echo $base_page;?>&amp;mode=edit_category&amp;category_id=<?php echo $objCategory->category_id; ?>"><?php echo $objiMastersWPFaq->clean_chars($objCategory->category_name); ?></a></td>
                                <td><?php echo $objCategory->category_id; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="check-column" scope="col"><input type="checkbox" /></th>
                                    <th scope="col"><?php _e('Category name', 'imasters-wp-faq'); ?></th>
                                    <th scope="col"><?php _e('ID','imasters-wp-faq'); ?></th>
                                </tr>
                            </tfoot>

                        <?php else :?>
                            <tr>
                                <td colspan="3"><strong><?php _e('No category until the moment.', 'imasters-wp-faq'); ?></strong></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </form>
<?php
	break;
endswitch;
?>
</div>
