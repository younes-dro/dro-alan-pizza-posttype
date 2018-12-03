<?php
/* * ***************************************************************
 * 
 *  Apres repas 
 * 
 * **************************************************************** */

// Après repas
$apres_repas_labels = array(
    'name' => _x('Après repas', 'post type general name'),
    'singular_name' => _x('Après repas', 'post type singular name'),
    'add_new' => _x('Add New', 'Après repas'),
    'add_new_item' => __('Add New Après repas'),
    'edit_item' => __('Edit Après repas'),
    'new_item' => __('New Après repas'),
    'all_items' => __('All Après repas'),
    'view_item' => __('View Après repas'),
    'search_items' => __('Search Après repas'),
    'not_found' => __('No Après repas found'),
    'not_found_in_trash' => __('No Après repas found in the Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Après repas'
);
$apres_repas_options = array(
    'labels' => $apres_repas_labels,
    'description' => 'Holds our Après repas and pizza specific data',
    'public' => true,
//    'menu_position' => 1,
    'menu_icon' => dirname(plugin_dir_url(__FILE__)).'/assets/images/after-meal.png',
    'supports' => array('title', 'excerpt', 'thumbnail'),
    'has_archive' => true,
    'rewrite' => array(
        'slug' => 'apres-repas'
    )
);


$posttypes['apres_repas'] = array(
    'posttype_options' => $apres_repas_options
);

/* * ******************************* End Post type  options ******************* */

// Taxonomy  : Famille de Après repas (example : Boissons , Glaces , Dessert ..) 
$apres_repas_type = array(
    'name' => _x('Type de Après repas', 'taxonomy general name'),
    'singular_name' => _x('Type de Après repas', 'taxonomy singular name'),
    'search_items' => __('Search Type de Après repas'),
    'all_items' => __('All Product '),
    'parent_item' => __('Parent Type de Après repas'),
    'parent_item_colon' => __('Parent Type de Après repas:'),
    'edit_item' => __('Edit Type de Après repas'),
    'update_item' => __('Update Type de Après repas'),
    'add_new_item' => __('Add New Type de Après repas'),
    'new_item_name' => __('New Type de Après repas'),
    'menu_name' => __('Type de Après repas'),
);

$taxonomies['type_apres_repas'] = array(
    'post_types' => array('apres_repas'),// ID post type
    'description' =>'La base des Après repas',
    'options' => array(
        'labels' => $apres_repas_type,
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'glaces-dessert-boissons-vaureal', 'with_front' => false)
    ),
);


