<?php

/**
 * Add options : Prices , Flash Message 
 * 
 */
class T_Plus {

    public $options;
    public $infos_options;

    public function __construct() {
//        delete_option('dro_alan_pizza_options');
//        delete_option('dro_alan_pizza_infos_options');

        if (false == get_option('dro_alan_pizza_options')) {
            add_option('dro_alan_pizza_options');
        }
        if (false == get_option('dro_alan_pizza_infos_options')) {
            add_option('dro_alan_pizza_infos_options');
        }
        $this->options = get_option('dro_alan_pizza_options');
        $this->infos_options = get_option('dro_alan_pizza_infos_options');
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
            <h1>Alan Pizza Options</h1>
            <p>
                <?php settings_errors(); ?>
                <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pizzas_options'; ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=dro-alan-pizza-posttype/alan-pizza-options/theme-options-plus.php&tab=pizzas_options"
                   class="nav-tab <?php echo $active_tab == 'pizzas_options' ? 'nav-tab-active' : ''; ?>">Prix Pizzas</a>
                <a href="?page=dro-alan-pizza-posttype/alan-pizza-options/theme-options-plus.php&tab=infos_options" 
                   class="nav-tab <?php echo $active_tab == 'infos_options' ? 'nav-tab-active' : ''; ?>">Infos</a>
                <a href="#"
                   class="nav-tab">Zones de Livraison</a>
            </h2>
            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php
                if ($active_tab == 'pizzas_options') {
                    settings_fields('dro_alan_pizza_options');
                    do_settings_sections(__FILE__);
                } else {
                    settings_fields('dro_alan_pizza_infos_options');
                    do_settings_sections('dro_alan_pizza_infos_options');
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

        // Infos
        register_setting('dro_alan_pizza_infos_options', 'dro_alan_pizza_infos_options', array($this, 'dro_alan_pizza_infos_options_cb'));
        add_settings_section('dro_alan_pizza_infos_section', '', array($this, 'phone_section_cb'), 'dro_alan_pizza_infos_options');
        add_settings_field('tele_1', 'Téléphone 1 ', array($this, 'tele_1_cb'), 'dro_alan_pizza_infos_options', 'dro_alan_pizza_infos_section');
        add_settings_field('tele_2', 'Téléphone 2 ', array($this, 'tele_2_cb'), 'dro_alan_pizza_infos_options', 'dro_alan_pizza_infos_section');
    }

    /**
     * sections cb
     */
    function t_section_cb() {
        printf('<p>' . esc_html('%1$s', 'dro-alan-pizza') . '</p>', 'Indiquer les prix sans le signe €');
    }

    function phone_section_cb() {
        echo '<p> Péfixer les numéros de téléphone avec : + </p>';
    }

    /*
     * settings cb
     */

    public function dro_alan_pizza_options_cb($plugin_options) {

        return $plugin_options;
    }

    public function dro_alan_pizza_infos_options_cb($plugin_options) {

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

    function tele_1_cb() {
        $value = '';
        if (isset($this->infos_options['tele_1'])) {
            $value = $this->infos_options['tele_1'];
        }
        echo "<input name='dro_alan_pizza_infos_options[tele_1]' type='text' value='$value' />";
    }

    function tele_2_cb() {
        $value = '';
        if (isset($this->infos_options['tele_2'])) {
            $value = $this->infos_options['tele_2'];
        }
        echo "<input name='dro_alan_pizza_infos_options[tele_2]' type='text' value='$value' />";
    }

}

add_action('admin_menu', function() {

    T_Plus::add_admin_menu();
});

add_action('admin_init', function() {
    new T_Plus();
});
