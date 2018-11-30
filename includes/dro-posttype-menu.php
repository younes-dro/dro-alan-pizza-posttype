<?php

/* * ***************************************************************
 * 
 *  Menus
 * 
 * **************************************************************** */

// Menu
$menu_labels = array(
    'name' => _x('Menu', 'post type general name'),
    'singular_name' => _x('Menu', 'post type singular name'),
    'add_new' => _x('Add New', 'Menu'),
    'add_new_item' => __('Add New Menu'),
    'edit_item' => __('Edit Menu'),
    'new_item' => __('New Menu'),
    'all_items' => __('All Menus'),
    'view_item' => __('View Menu'),
    'search_items' => __('Search Menus'),
    'not_found' => __('No Menus found'),
    'not_found_in_trash' => __('No Menus found in the Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Menus'
);
$menu_options = array(
    'labels' => $menu_labels,
    'description' => 'Holds our Menus and menu specific data',
    'public' => true,
//    'menu_position' => 5,
    'menu_icon' => dirname(plugin_dir_url(__FILE__)).'/assets/images/icons8-meal-48.png',
    'supports' => array('title', 'excerpt', 'thumbnail'),
    'has_archive' => true,
    'rewrite' => array(
        'slug' => 'rapido-vaureal'
    )
);


$posttypes['menu'] = array(
    'posttype_options' => $menu_options
);

/* * ******************************* End Post type  options ******************* */

 
 
/* * ***************************************************************
 * 
 *  Taxonomies  options 
 * 
 * **************************************************************** */

// Taxonomy  : Famille de Menu (example : Menu Panini , Menu Switch .....) 
$menu_type = array(
    'name' => _x('Type du Menu', 'taxonomy general name'),
    'singular_name' => _x('Type de Menu', 'taxonomy singular name'),
    'search_items' => __('Search Type de Menu'),
    'all_items' => __('All Products'),
    'parent_item' => __('Parent Type de Menu'),
    'parent_item_colon' => __('Parent Type de Menu:'),
    'edit_item' => __('Edit Type de Menu'),
    'update_item' => __('Update Type de Menu'),
    'add_new_item' => __('Add New Type de Menu'),
    'new_item_name' => __('New Type de Menu'),
    'menu_name' => __('Type de Menu'),
);

$taxonomies['type_menu'] = array(
    'post_types' => array('menu'),// ID post type
    'description' =>' Les Menus Alan-Pizza Vauréal',
    'options' => array(
        'labels' => $menu_type,
        'hierarchical' => true,
        'rewrite'      => array('slug' => 'menu-alan-pizza', 'with_front' => false)
    ),
);





