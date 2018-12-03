<?php

/* -----------------------------------------
 * Price : regular price and promo price  
 * 
 * ----------------------------------------- */

add_action('add_meta_boxes', 'init_metabox_apres_repas');

function init_metabox_apres_repas() {

    /**
     * create_prices_field() callback  create fields for all prices 
     */
    add_meta_box('price_apres_repas', 'Prix', 'create_price_apres_repas', 'apres_repas', 'normal');
    
}

function create_price_apres_repas($post) {

    $price_apres_repas = get_post_meta($post->ID, 'price_apres_repas', true);
    echo '<label for="price_apres_repas">Indiquer le Prix sans le signe € </label>';
    echo '<input class="widefat" id="price_apres_repas" type="text" name="price_apres_repas" value="' . $price_apres_repas . '" />';
    
}

add_action('save_post', 'save_price_apres_repas');

function save_price_apres_repas($post_id) {
    if (isset($_POST['price_apres_repas']))
        update_post_meta($post_id, 'price_apres_repas', strip_tags($_POST['price_apres_repas']));
}
