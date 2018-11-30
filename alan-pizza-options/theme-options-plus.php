<?php

/**
 * Add options : Prices , Flash Message 
 * 
 */
class T_Plus {

    public $options;

    public function __construct() {
//        delete_option('dro_alan_pizza_options');
        if (false == get_option('dro_alan_pizza_options')) {
            add_option('dro_alan_pizza_options');
        }
        $this->options = get_option('dro_alan_pizza_options');
        $this->add_section_fields();
    }

    /*
     * Create menu
     */

    public static function add_admin_menu() {
        add_menu_page('Alan Pizza Shop settings', 'Alan Pizza', 'administrator', __FILE__, array('T_Plus', 'display_content'), plugins_url('dro-alan-pizza-posttype/assets/images/alanpizza.png'));
    }

    /*
     * Display the conent 
     */

    static function display_content() {
        ?>
        <div class="wrap">
            <h1>Alan Pizza Options </h1>
            <?php printf('<p>' . esc_html('%1$s', 'dro-alan-pizza') . '</p>', 'Indiquer les prix sans le signe €'); ?>
            <p>
                <?php settings_errors(); ?>
                <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pizzas_options'; ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=dro-alan-pizza-posttype/alan-pizza-options/theme-options-plus.php&tab=pizzas_options"
                   class="nav-tab <?php echo $active_tab == 'pizzas_options' ? 'nav-tab-active' : ''; ?>">Pizzas</a>
                <a href="?page=dro-alan-pizza-posttype/alan-pizza-options/theme-options-plus.php&tab=fromagio_options" 
                   class="nav-tab <?php echo $active_tab == 'fromagio_options' ? 'nav-tab-active' : ''; ?>">Autres</a>
            </h2>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php
                if($active_tab == 'pizzas_options'){
                settings_fields('dro_alan_pizza_options');
                do_settings_sections(__FILE__);
                }else{
                    echo '<p> à définir ....</p>';
                }
                ?>

                <p class="submit">
                    <input type="submit" value="Save changes" class="button button-primary">
                </p>
            </form>
        </p>
        </div>
        <?php
    }

    /*
     * Create Settings
     */

    function add_section_fields() {
        
        // Prix Pizza 
        register_setting('dro_alan_pizza_options', 'dro_alan_pizza_options', array($this, 'dro_alan_pizza_options_cb'));
        add_settings_section('t_section', '', array($this, 't_section_cb'), __FILE__);

        add_settings_field('prix_senior_emporter', 'Prix Sénior à emporter', array($this, 'prix_senior_emporter_cb'), __FILE__, 't_section');
        add_settings_field('prix_senior_livraison', 'Prix Sénior en livraison', array($this, 'prix_senior_livraison_cb'), __FILE__, 't_section');

        add_settings_field('prix_mega_emporter', 'Prix Méga à emporter', array($this, 'prix_mega_emporter_cb'), __FILE__, 't_section');
        add_settings_field('prix_mega_livraison', 'Prix Méga en livraison', array($this, 'prix_mega_livraison_cb'), __FILE__, 't_section');

        add_settings_field('prix_fromagio', 'Prix La Fromagio', array($this, 'prix_fromagio_cb'), __FILE__, 't_section');
    }

    /*
     * section cb
     */

    function t_section_cb() {

        //
    }

    /*
     * settings cb
     */

    public function dro_alan_pizza_options_cb($plugin_options) {

        return $plugin_options;
    }

    /*
     * Inputs
     */

    function prix_senior_emporter_cb() {

        $value = '';
        if (isset($this->options['prix_senior_emporter'])) {
            $value = $this->options['prix_senior_emporter'];
        }
        echo "<input name='dro_alan_pizza_options[prix_senior_emporter]' type='text' value='$value' />";
    }

    function prix_senior_livraison_cb() {

        $value = '';
        if (isset($this->options['prix_senior_livraison'])) {
            $value = $this->options['prix_senior_livraison'];
        }
        echo "<input name='dro_alan_pizza_options[prix_senior_livraison]' type='text' value='$value' />";
    }

    function prix_mega_emporter_cb() {

        $value = '';
        if (isset($this->options['prix_mega_emporter'])) {
            $value = $this->options['prix_mega_emporter'];
        }
        echo "<input name='dro_alan_pizza_options[prix_mega_emporter]' type='text' value='$value' />";
    }

    function prix_mega_livraison_cb() {

        $value = '';
        if (isset($this->options['prix_mega_livraison'])) {
            $value = $this->options['prix_mega_livraison'];
        }
        echo "<input name='dro_alan_pizza_options[prix_mega_livraison]' type='text' value='$value' />";
    }

    function prix_fromagio_cb() {

        $value = '';
        if (isset($this->options['prix_fromagio'])) {
            $value = $this->options['prix_fromagio'];
        }
        echo "<input name='dro_alan_pizza_options[prix_fromagio]' type='text' value='$value' />";
    }

}

add_action('admin_menu', function() {

    T_Plus::add_admin_menu();
});

add_action('admin_init', function() {
    new T_Plus();
});
