<?php
/*
 * Plugin Name: DRO Post Type
 * Plugin URI: https://github.com/younes-dro/dro-posttype
 * Author: Younes DRO
 * Author URI: http://www.dro.123.fr
 * Version: 1.0.0
 * License: GPLv2 or later
 * Description: Class generator for post type and taxanomies and custom post meta
 * Text Domain: dro-alan-pizza
 */

include plugin_dir_path(__FILE__) . 'includes/dro-posttype-pizza.php';
include plugin_dir_path(__FILE__) . 'includes/dro-posttype-menu.php';
include plugin_dir_path(__FILE__) . 'includes/dro-posttype-after-meal.php';
include plugin_dir_path(__FILE__) . 'includes/class-dro-posttype.php';
include plugin_dir_path(__FILE__) . 'includes/class-dro-taxonomies.php';
include plugin_dir_path(__FILE__) . 'includes/class-dro-metaboxes.php';
include plugin_dir_path(__FILE__) . 'includes/class-showcase-taxonomy-images.php';
include plugin_dir_path(__FILE__) . 'includes/class-showcase-taxonomy-images-type-menu.php';
include plugin_dir_path(__FILE__) . 'includes/class-showcase-taxonomy-images-apres-repas.php';
include plugin_dir_path(__FILE__) . 'alan-pizza-options/theme-options-plus.php';
include plugin_dir_path(__FILE__) . 'includes/class-ajaxed-type-pizza.php';


/**
 *  Initialze the Class
 */
add_action('init', function() {

    /**
     * Global variabl Array
     */
    global $posttypes, $taxonomies;

    /**
     * Create the Post Types 
     */
    $dro_post_type = new DRO_PostType($posttypes);
    $dro_post_type->register_post_type();

    /**
     * Create the taxonomies
     */
    $dro_taxonomies = new DRO_Taxonomies($taxonomies);
    $dro_taxonomies->create_taxanomies();

    /**
     * Add custom taxonomy filed : price  for type_menu taxonomy 
     */
    add_action('type_menu_add_form_fields', 'dro_alan_pizza_taxonomy_add_custom_meta_field', 10, 2);
    add_action('type_menu_edit_form_fields', 'dro_alan_pizza_taxonomy_edit_custom_meta_field', 10, 2);
    add_action('edited_type_menu', 'dro_alan_pizza_save_taxonomy_custom_meta_field', 10, 2);
    add_action('create_type_menu', 'dro_alan_pizza_save_taxonomy_custom_meta_field', 10, 2);

    /**
     * Add image upload for type_pizza taxonomy
     */
    $Showcase_Taxonomy_Images = new Showcase_Taxonomy_Images();
    $Showcase_Taxonomy_Images->init();
    
    /**
     * Add image upload for type_menu taxonomy
     */
    $Showcase_Taxonomy_Images_Type_Menu = new Showcase_Taxonomy_Images_Type_Menu();
    $Showcase_Taxonomy_Images_Type_Menu->init();
    
    /**
     * Add image upload for apres_repas taxonomy
     */
    $Showcase_Taxonomy_Images_Apres_Repas = new Showcase_Taxonomy_Images_Apres_Repas();
    $Showcase_Taxonomy_Images_Apres_Repas->init(); 

    /**
     * Add Custom Post Type columns for Pizza Screen Edit 
     */
    add_filter('manage_edit-pizza_columns', function($pizza_columns) {
        $pizza_columns['type_pizza'] = __('Type de Pizza');
//        $pizza_columns['prices'] = __('Prix');
//        $pizza_columns['promo'] = __('Pomo');

        return $pizza_columns;
    });
    add_action('manage_pizza_posts_custom_column', 'manage_pizza_colums', 10, 2);

    function manage_pizza_colums($column_name, $id) {
        global $wpdb;
        switch ($column_name) {

            case 'type_pizza':
                $type_pizza_sql = "SELECT t.term_id, t.name 
                    FROM $wpdb->terms t
                    inner join $wpdb->term_taxonomy tt on tt.term_id = t.term_id
                    where tt.taxonomy = 'type_pizza'";
                $type_pizza_results = $wpdb->get_results($type_pizza_sql, ARRAY_A);
                $current_type_pizza = "SELECT t.term_id
                    FROM $wpdb->term_relationships tr
                    join $wpdb->terms t on t.term_id = tr.term_taxonomy_id 
                    where tr.object_id =" . $id;
                $current_row = $wpdb->get_row($current_type_pizza, ARRAY_A);
                echo "<select name='type_pizza_select_$id' id='type_pizza_select_$id' class='widefat tax_type_pizza'>";
                echo '<option disabled="disabled">-</option>';
                foreach ($type_pizza_results as $key => $value) {
                    $selected = ($current_row['term_id'] === $value['term_id']) ? 'selected="selected"' : '';
                    echo '<option ' . $selected . ' value="' . $value['term_id'] . '">' . $value['name'] . '</value>';
                }
                echo '</select>';
                break;
            default:
                break;
        }
    }

    
    
    // Add Filter for posty_type pizza
    add_action( 'restrict_manage_posts', 'filter_pizza_by_taxonomies' , 10, 2);
});

/**
 * Change the Excerpt label
 */
add_filter('gettext', 'wpse22764_gettext', 10, 2);

function wpse22764_gettext($translation, $original) {
    if ('Excerpt' == $original) {
        return 'Ingrédients';
    } else {
        $pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
        if ($pos !== false) {
            return 'mettez un espace aprés chaque virgule';
        }
    }
    return $translation;
}



/**
 * Callback functions for Custom Field Price for type_menu taxonomy
 */
function dro_alan_pizza_taxonomy_add_custom_meta_field() {
    ?>
    <div class="form-field">
        <label for="term_meta[type_menu_price]"><?php _e('Prix', 'dro-alan-pizza'); ?></label>
        <input type="text" name="term_meta[type_menu_price]" id="term_meta[type_menu_price]" value="">
        <p class="description"><?php _e('Si le groupe de menus a un prix uni(ex: Spécial Medi 7 euro)', 'dro-alan-pizza'); ?></p>
    </div>
    <?php
}

function dro_alan_pizza_taxonomy_edit_custom_meta_field($term) {

    $t_id = $term->term_id;
    $term_meta = get_option("taxonomy_$t_id");
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[type_menu_price]"><?php _e('Prix', 'dro-alan-pizza'); ?></label></th>
        <td>
            <input type="text" name="term_meta[type_menu_price]" id="term_meta[type_menu_price]" value="<?php echo esc_attr($term_meta['type_menu_price']) ? esc_attr($term_meta['type_menu_price']) : ''; ?>">
            <p class="description"><?php _e('Si le groupe de menus a un prix uni(ex: Spécial Medi 7 euro)', 'dro-alan-pizza'); ?></p>
        </td>
    </tr>
    <?php
}

function dro_alan_pizza_save_taxonomy_custom_meta_field($term_id) {
    if (isset($_POST['term_meta'])) {

        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option("taxonomy_$t_id", $term_meta);
    }
}


function filter_pizza_by_taxonomies( $post_type, $which ) {

	// Apply this only on a specific post type
	if ( 'pizza' !== $post_type )
		return;

	// A list of taxonomy slugs to filter by
	$taxonomies = array( 'type_pizza');

	foreach ( $taxonomies as $taxonomy_slug ) {

		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;

		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

}

