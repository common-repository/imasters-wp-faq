<?php
/**
 * Define name of base_name and base_page 
 */
$base_name = plugin_basename('imasters-wp-faq/imasters-wp-faq-manager.php');
$base_page = 'admin.php?page='.$base_name;

if ( isset( $_POST['act'] ) ) :

    switch( $_POST['act'] ) :

        case 'add_faq' :

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
            $rules[] = sprintf("required,faq_category_id,   %s", __('FAQ category is required.', 'imasters-wp-faq'));
            $rules[] = sprintf("required,faq_topic,         %s", __('FAQ topic is required.', 'imasters-wp-faq'));
            $rules[] = sprintf("required,faq_answer,        %s", __('FAQ answer is required.','imasters-wp-faq'));

            /** Check the validation rules against the values informed */
            $errors = validateFields($_POST, $rules);

            /** If no errors, procede */
            if ( empty($errors) ) :

                $add_faq = $objiMastersWPFaq->add_faq( $_POST );

                if ( $add_faq ) :

                    /** Set up a user message */
                    $text_message   = __('FAQ added successfully.', 'imasters-wp-faq');
                    $class_name     = 'updated fade';

                else :

                    /** Set up a user message */
                    $text_message   = __('FAQ dont\'t added', 'imasters-wp-faq');
                    $class_name     = 'error';

                endif;
            endif;

        break;

        case 'edit_faq' :

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
            $rules[] = sprintf("required,faq_category_id,   %s", __('FAQ category is required.', 'imasters-wp-faq'));
            $rules[] = sprintf("required,faq_topic,         %s", __('FAQ topic is required.', 'imasters-wp-faq'));
            $rules[] = sprintf("required,faq_answer,        %s", __('FAQ answer is required.','imasters-wp-faq'));

            /** Check the validation rules against the values informed */
            $errors = validateFields( $_POST, $rules );

            /** If no errors, procede */
            if ( empty($errors) ) :

                $update = $objiMastersWPFaq->edit_faq( $_POST );

                if ( $update ) :

                    /** Set up a user message */
                    $text_message 	= __('FAQ updated successfully', 'imasters-wp-faq');
                    $class_name 	= 'updated fade';

                else :

                    /** Set up a user message */
                    $text_message 	= __('FAQ don\'t updated.', 'imasters-wp-faq');
                    $class_name 	= 'error';

                endif;
            endif;

        break;

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

    endswitch;
endif;

if( isset( $_GET['act'] ) ) :

    switch( $_GET['act'] ) :

        case __('Delete', 'imasters-wp-faq') :
            
            if ( isset($_GET['delete']) ) :

                foreach( $_GET['delete'] as $id ) :

                    $faq_id = (int)$id;

                    $delete = $wpdb->query("DELETE FROM $wpdb->imasters_wp_faq WHERE faq_id = $faq_id");

                endforeach;

                if( $delete ) :

                    /** Set up a user message */
                    $text_message 	= __('FAQ deleted successfully.', 'imasters-wp-faq');
                    $class_name 	= 'updated fade';

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
    <p><?php echo $text_message; ?> <a href="<?php echo $base_page; ?>" title="<?php _e('Back to manager FAQ\'s.', 'imasters-wp-faq'); ?>"><?php _e('Manager FAQ\'s', 'imasters-wp-faq'); ?></a></p>
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

	case 'add_faq' : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="form-table">
                <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Add FAQ', 'imasters-wp-faq'); ?></h2>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="faq_category_id"><?php _e('Category', 'imasters-wp-faq'); ?></label>
                            </th>
                            <td>
                                <?php $categories = $objiMastersWPFaq->get_categories(); ?>
                                <select id="faq_category_id" name="faq_category_id">
                                    <?php if( $categories ) : ?>
                                    <?php foreach( $categories as $category ) : ?>
                                    <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value=""><?php _e('Any category added. Add one first.', 'imasters-wp-faq'); ?></option>
                                    <?php endif; ?>
                                </select>
                                <?php if( empty( $categories ) ) : ?>
                                <a href="<?php echo 'admin.php?page=imasters-wp-faq/imasters-wp-faq-manager-categories.php&mode=add_category'?>"><?php _e( 'Add category', 'imasters-wp-faq' ); ?></a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="faq_topic"><?php _e('Topic', 'imasters-wp-faq'); ?></label>
                            </th>
                            <td>
                                <input type="text" id="faq_topic" name="faq_topic" class="regular-text"/>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="faq_answer"><?php _e('Answer', 'imasters-wp-faq'); ?></label>
                            </th>
                            <td>
                                <textarea id="faq_answer" name="faq_answer" rows="10" cols="50" class="large-text"></textarea>
                            </td>
                        </tr>
                   </tbody>
               </table>
                <p class="submit">
                    <input type="hidden" id="act" name="act" value="add_faq" />
                    <input type="submit" id="button" name="button" value="<?php _e('Save', 'imasters-wp-faq'); ?>" class="button-primary"/> <?php _e('or', 'imasters-wp-faq'); ?> <a href="<?php echo $base_page; ?>"> <?php _e('cancel', 'imasters-wp-faq'); ?></a>
                </p>
            </form>
<?php   break;

	case 'edit_faq' :

            if( $_GET['faq_id'] ) :

                $objFaq = $wpdb->get_row( $wpdb->prepare( "
                    SELECT * FROM $wpdb->imasters_wp_faq
                    WHERE
                    faq_id = %d
                    ",
                    $_GET['faq_id']
                ));

                if ( $objFaq ) : ?>
                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" class="form-table">
                        <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Edit FAQ', 'imasters-wp-faq'); ?></h2>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="faq_category_id"><?php _e('Category', 'imasters-wp-faq'); ?></label>
                                    </th>
                                    <td>
                                        <?php $categories = $objiMastersWPFaq->get_categories(); ?>
                                        <select id="faq_category_id" name="faq_category_id">
                                            <?php if( $categories ) : ?>
                                            <?php foreach( $categories as $category ) : ?>
                                            <option value="<?php echo $category->category_id; ?>" <?php echo( $category->category_id == $objFaq->faq_category_id ) ? 'selected="selected"' : ''; ?>><?php echo $category->category_name; ?></option>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="faq_topic"><?php _e('Topic', 'imasters-wp-faq'); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="faq_topic" name="faq_topic" value="<?php echo $objiMastersWPFaq->clean_chars( $objFaq->faq_topic ); ?>" class="regular-text" />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row">
                                        <label for="faq_answer"><?php _e('Answer', 'imasters-wp-faq'); ?></label>
                                    </th>
                                    <td>
                                        <textarea id="faq_answer" name="faq_answer" rows="10" cols="50" class="large-text code"><?php echo $objiMastersWPFaq->clean_chars( $objFaq->faq_answer ); ?></textarea>
                                    </td>
                                </tr>
                           </tbody>
                       </table>
                        <p class="submit">
                            <input type="hidden" id="faq_id" name="faq_id" value="<?php echo $objFaq->faq_id; ?>" />
                            <input type="hidden" id="act" name="act" value="edit_faq"  />
                            <input type="submit" id="button" name="button" class="button-primary" value="<?php _e('Save', 'imasters-wp-faq'); ?>"/>  <?php _e('or', 'imasters-wp-faq'); ?> <a href="<?php echo $base_page; ?>"> <?php _e('cancel', 'imasters-wp-faq'); ?></a>
                        </p>
                    </form>
<?php           endif;
            endif;
	break;
        default : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="get">
                    <h2><img style="margin-right: 5px;" src="<?php echo plugins_url( 'imasters-wp-faq/assets/images/imasters32.png' )?>" alt="imasters-ico"/><?php _e('Manager FAQ\'s', 'imasters-wp-faq'); ?></h2>
                    <div class="tablenav">
                        <p class="search-box">
                            <?php _e('Filter by category: ', 'imasters-wp-faq'); ?>
                            <select id="by_category" name="by_category">
                                <?php $cats = $objiMastersWPFaq->get_categories();?>
                                <option value="0"><?php _e('All', 'imasters-wp-faq'); ?></option>
                                <?php foreach( $cats as $cat ) : ?>
                                <option value="<?php echo $cat->category_id; ?>" <?php echo( $cat->category_id == $_GET['by_category'] ) ? 'selected="selected"' : ''; ?>><?php echo $cat->category_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" class="button-secondary action" id="filter-by-cat" name="filter-by-cat" value="<?php _e('Filter', 'imasters-wp-faq')?>">
                            <input type="text" class="search-input" id="search" name="search" value="<?php echo ( isset ( $_GET['search'] ) ? $_GET['search'] : ''); ?>" />
                            <input type="hidden" name="page" value="<?php echo( isset ( $_GET['page'] ) ? $_GET['page'] :  ''); ?>" />
                            <input type="submit" class="button-secondary action" id="act_search" name="act_search" value="<?php _e('Search', 'imasters-wp-faq'); ?>" />
                        </p>
                        <div class="alignleft">
                            <input type="submit" id="delete-faq" class="button-secondary delete" name="act" value="<?php _e('Delete', 'imasters-wp-faq'); ?>" onclick="return confirm(' <?php _e( 'You are about to delete the selected FAQs. \n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'imasters-wp-faq' ); ?>')"/>
                            <a class="button-primary" href="<?php echo $base_page; ?>&amp;mode=add_faq"><?php _e('Add FAQ', 'imasters-wp-faq'); ?></a>
                        </div>
                    <br class="clear"/>
                    </div>
                    <table class="widefat fixed">
                        <thead>
                            <tr>
                                <th class="check-column" scope="col"><input type="checkbox" /></th>
                                <th scope="col"><?php _e('Topic',   'imasters-wp-faq'); ?></th>
                                <th scope="col"><?php _e('Answer',  'imasters-wp-faq'); ?></th>
                                <th scope="col"><?php _e('Category','imasters-wp-faq'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if( isset( $_GET['paged'] ) ) :  //If exists page in URl
                            $paged = $_GET['paged'];    //Alter value to value in URL
                            $show_init = $paged * FAQS_PER_PAGE;    //Start of show of records
                        else :
                            $show_init = 0;
                        endif;
                        if( $show_init <> 0 )
                            $show_init = $paged * FAQS_PER_PAGE - FAQS_PER_PAGE;    //Start of show of records

                        if( !empty( $_GET['search'] ) and isset( $_GET['search'] ) ) :

                            $search = $wpdb->escape( $_GET['search'] );

                            $objFaqs = $wpdb->get_results( sprintf( "
                                SELECT * FROM $wpdb->imasters_wp_faq
                                WHERE
                                faq_topic LIKE '%%%s%%'
                                OR
                                faq_answer LIKE '%%%s%%'
                                ORDER BY faq_topic
                                LIMIT %d, %d
                                ",
                                $search,
                                $search,
                                $show_init,
                                FAQS_PER_PAGE
                            ) );

                            $objFaqsCount = $wpdb->get_var("
                                SELECT COUNT(*) FROM $wpdb->imasters_wp_faq
                                WHERE
                                faq_topic LIKE '%$search%'
                                OR
                                faq_answer LIKE '%$search%'
                                ORDER BY faq_topic"
                            );

                        elseif( !empty( $_GET['by_category']) and isset( $_GET['by_category']) ) :

                            $cat_id = $_GET['by_category'];

                            $objFaqs = $wpdb->get_results( sprintf( "
                                SELECT * FROM $wpdb->imasters_wp_faq
                                WHERE
                                faq_category_id = %d
                                ORDER BY faq_topic
                                LIMIT %d, %d
                                ",
                                $cat_id,
                                $show_init,
                                FAQS_PER_PAGE
                            ) );

                            $objFaqsCount = $wpdb->get_var("
                                SELECT COUNT(*) FROM $wpdb->imasters_wp_faq
                                WHERE
                                faq_category_id = $cat_id
                                ORDER BY faq_topic"
                            );
                            
                        else :

                            $objFaqs = $wpdb->get_results( $wpdb->prepare( "
                                SELECT * FROM $wpdb->imasters_wp_faq
                                ORDER BY faq_topic
                                LIMIT %d, %d
                                ",
                                $show_init,
                                FAQS_PER_PAGE
                            ) );

                            $objFaqsCount = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->imasters_wp_faq ORDER BY faq_topic" );

                        endif;

                        $page_links = paginate_links( array(
                            'base' => add_query_arg( 'paged', '%#%' ),
                            'format' => '',
                            'prev_text' => __('&laquo;'),
                            'next_text' => __('&raquo;'),
                            'total' => ceil($objFaqsCount/FAQS_PER_PAGE), // Max num pages
                            'current' => (isset( $_GET['paged'] ) ) ? $_GET['paged'] : 1
                        ));

                        if( $objFaqs ) :

                            foreach( $objFaqs as $objFaq ) : ?>

                            <tr>
                                <th class="check-column" scope="row">
                                    <input type="checkbox" value="<?php echo $objFaq->faq_id; ?>" name="delete[]" />
                                </th>
                                <?php
                                  if ( isset ($_GET['search']) )
                                    $search = $_GET['search'];
                                  else
                                    $search = '';
                                ?>
                                <td><a href="<?php echo $base_page;?>&amp;mode=edit_faq&amp;faq_id=<?php echo $objFaq->faq_id; ?>"><?php echo str_ireplace( $search, '<strong>' . $search . '</strong>', $objiMastersWPFaq->clean_chars($objFaq->faq_topic) ); ?></a></td>
                                <td><a href="javascript:FAQ.answer_show(<?php echo $objFaq->faq_id; ?>);" class="view-answer"><?php _e('View answer', 'imasters-wp-faq'); ?></a></td>
                                <td><?php echo $objiMastersWPFaq->get_category_name($objFaq->faq_category_id); ?></td>
                                
                            </tr>
                             <tr class="faq-answer" id="answer-to-topic-<?php echo $objFaq->faq_id; ?>">
                                <td colspan="4"><?php echo str_ireplace( $search, '<strong>' . $search . '</strong>', nl2br( $objiMastersWPFaq->clean_chars( $objFaq->faq_answer ) ) ); ?></td>
                             </tr>

                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="check-column" scope="col"><input type="checkbox" /></th>
                                    <th  scope="col"><?php _e('Topic',   'imasters-wp-faq'); ?></th>
                                    <th  scope="col"><?php _e('Answer',  'imasters-wp-faq'); ?></th>
                                    <th  scope="col"><?php _e('Category','imasters-wp-faq'); ?></th>
                                </tr>
                            </tfoot>

                        <?php elseif( isset( $_GET['by_category'] ) and !empty( $_GET['by_category'] ) ) :?>
                            <tr>
                                <td colspan="4"><strong><?php printf( '%s "%s". <a href="%s">%s</a>.', __('No FAQ by category: ', 'imasters-wp-faq'), $objiMastersWPFaq->get_category_name($_GET['by_category']), $base_page, __( 'Show all FAQs', 'imasters-wp-faq' ) ); ?></strong></td>
                            </tr>

                        <?php elseif( isset( $_GET['search']) and !empty( $_GET['search'] ) ) : ?>
                            <tr>
                                <td colspan="4"><strong><?php printf( '%s "%s". <a href="%s">%s</a>.', __('No FAQ with the term: ', 'imasters-wp-faq'), $_GET['search'], $base_page, __( 'Show all FAQs', 'imasters-wp-faq' ) ); ?></strong></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <td colspan="4"><strong><?php _e('No FAQ until the moment.', 'imasters-wp-faq'); ?></strong></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </form>

        <?php if ( $page_links ) { ?>
        <div class="tablenav-pages">
            <?php
            $paged = $_GET['paged'];
            if( $paged == 0 )
                $paged = 1;

            $page_links_text = sprintf( '<span class="displaying-num">' . __( 'Displaying %s&#8211;%s of %s', 'imasters-wp-faq' ) . '</span>%s',
            number_format_i18n( ( $paged - 1 ) * FAQS_PER_PAGE + 1 ),
            number_format_i18n( min( $paged * FAQS_PER_PAGE, $objFaqsCount ) ),
            number_format_i18n( $objFaqsCount ),
            $page_links
            );
            ?>
        </div>
        <?php } ?>

        <!-- Pagination -->

        <div class="tablenav">

            <?php
            if ( $page_links )
                echo "<div class='tablenav-pages'>$page_links_text</div>";
            ?>

        </div>

        <!-- / Pagination -->
<?php
	break;
endswitch;
?>
</div>
