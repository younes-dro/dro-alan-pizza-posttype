<?php

/* -----------------------------------------
 * Price 
 * 
 * ----------------------------------------- */

add_action('add_meta_boxes', 'init_metabox_chiken_wings');

function init_metabox_chiken_wings() {

    /**
     * create_prices_field() callback  create fields for all prices 
     */
    add_meta_box('price_chiken_wings', 'Prix', 'create_price_chiken_wings', 'menu', 'normal');
    
    
}

function create_price_chiken_wings($post) {

    $price_chiken_wings = get_post_meta($post->ID, 'price_chiken_wings', true);
    echo '<label for="price_chiken_wings">Si le menu a un prix individuel<br>(Indiquer le Prix sans le signe € )</label>';
    echo '<input class="widefat" id="price_chiken_wings" type="text" name="price_chiken_wings" value="' . $price_chiken_wings . '" />';
    
}

add_action('save_post', 'save_price_chiken_wings');

function save_price_chiken_wings($post_id) {
    if (isset($_POST['price_chiken_wings']))
        update_post_meta($post_id, 'price_chiken_wings', strip_tags($_POST['price_chiken_wings']));
}
