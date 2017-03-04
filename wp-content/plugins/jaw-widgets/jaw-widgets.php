<?php
/*
  Plugin Name: JaW Widgets
  Plugin URI: http://jawtemplates.com
  Description: Package of widgets by JaW Templates
  Version: 1.5.9
  Author: JaW Templates
  Author URI: http://jawtemplates.com
 */

define('JAW_WIDGETS_DIR', dirname(__FILE__) . "/");
define('JAW_WIDGETS_URI', plugins_url('', __FILE__) . "/");

class jaw_widgets {

    private $_version = 100;   // plugin version
    private $_name = 'jaw_widgets';       // plugin ID for store option in DB
    private $_data = array();     // data from DB    
    static private $_instance;
    private $_avaible = array(
        'jaw_about_author' => array('label' => 'About Author Widget', 'description' => ''),
        'jaw_banner_widget' => array('label' => 'Custom Banner Widget', 'description' => ''),
        'jaw_ecommerce_widget' => array('label' => 'eCommerce Widget', 'description' => ''),
        'jaw_latest_post_widget' => array('label' => 'Latest Posts Widget', 'description' => ''),
        'jaw_login_widget' => array('label' => 'Login Widget', 'description' => ''),
        'jaw_popular_posts_widget' => array('label' => 'Popular Posts', 'description' => ''),
        'jaw_posts_widget' => array('label' => 'Posts Widget for Gdaynews', 'description' => ''),
        'jaw_rate_post_widget' => array('label' => 'Rate Post Widget', 'description' => ''),
        'jaw_rate_post_gdn_widget' => array('label' => 'Rate Post Widget for GDN', 'description' => ''),
        'jaw_rating_widget' => array('label' => 'Ratng Widget', 'description' => ''),
        'jaw_recent_comments_widget' => array('label' => 'Recent Comments Widget', 'description' => ''),
        'jaw_recent_comments_widget_gdn' => array('label' => 'Recent Comments Widget for GDN', 'description' => ''),
        'jaw_social_widget' => array('label' => 'Social Widget', 'description' => ''),
        'jaw_social_icons_widget' => array('label' => 'Social Icons Widget', 'description' => ''),
        'jaw_tab_post_widget' => array('label' => 'Tab Posts Widget', 'description' => ''),
        'jaw_twitter_widget' => array('label' => 'Twitter Widget', 'description' => ''),
        'jaw_submit_message_widget' => array('label' => 'Submit Message Widget', 'description' => ''),
        'jaw_instagram_widget' => array('label' => 'Instagram for GDN Widget', 'description' => ''),
        'jaw_jaw_gallery_widget' => array('label' => 'JaW Gallery for GDN Widget', 'description' => ''),
        'jaw_icons_menu' => array('label' => 'JaW Special Menu', 'description' => '')
    );

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            return self::$_instance = new jaw_widgets();
        } else {
            return self::$_instance;
        }
    }

    function __construct() {

        require_once (JAW_WIDGETS_DIR . "jaw-widgets_templater.php");

        if (isset($_POST[$this->_name]) && is_admin()) {
            $active = array();
            if (isset($_POST['typ'])) {
                foreach ($_POST['typ'] as $value) {
                    $active[$value] = $value;
                }
            }
            $this->_store($active);
        }
        $this->_data = get_option($this->_name);
        if (!isset($this->_data['active'])) {
               $this->_data['active'] = $this->_avaible;   
        }
        if (!isset($this->_data['avaible'])) {
            $this->_data['avaible'] = array_keys($this->_avaible);
        }
        $this->_registerPluginPage();
        if ($this->_data !== false) { // Plugin is initialized.
            add_action('widgets_init', array(&$this, '_bootloader'));
        }
        //add themeoptions link to top bar
        add_action('admin_bar_menu', array(&$this, 'jaw_modify_admin_bar'), 101);
    }

    public function _bootloader() {

        require_once(JAW_WIDGETS_DIR . "/widgets/jaw_default_widget.php");
        if ($this->_data['active']) {
            foreach ($this->_data['active'] as $key => $short) {
                if (file_exists(JAW_WIDGETS_DIR . "/widgets/" . $key . ".php")) {
                    require_once(JAW_WIDGETS_DIR . "/widgets/" . $key . ".php");
                    if(class_exists($key)){
                        register_widget($key);
                    } 
                } else {
                    echo "<div class='alert alert-warning'>File <strong>" . $key . ".php</strong> is not avalible - <strong>Please check settings of jw-widgets plugin</strong></div>";
                }
            }
        }
    }

    public function getData() {
        return $this->_data;
    }

    private function _store($active, $avaible = null) {
        $theme = wp_get_theme();
        $atts['theme'] = $theme->get('Name');
        $atts['version'] = $theme->get('Version');
        $atts['active'] = $active;
        $atts['plugin'] = $this->_version;
        if (!is_null($avaible)) {
            $atts['avaible'] = $avaible;
        } else { // nacteme dostupne pluginy z DB z predchozi inicializace
            $this->_data = get_option($this->_name);
            $atts['avaible'] = $this->_data['avaible'];
        }
        update_option($this->_name, $atts);
    }

    /**
     * 
     * @param type $plugin
     * @param type $theme
     * @param type $themecheck
     * @return boolean
     */
    private function _checkVersion($plugin) {
        $attrs = $plugin->attributes();
        if ((int) (string) $attrs->vmin <= $this->_version && (int) (string) $attrs->vmax >= $this->_version) {
            return true;  //  Version of plugin is correct
        } else {
            return false; // dont match
        }
    }

    private function _options(SimpleXMLElement $plugin) {
        if ($plugin->children()) {
            $out = null;
            foreach ($plugin->children() as $name => $option) {
                $out[] = (string) $name;
            }
            return $out;
        }
        return false;
    }

    public function init($plugin, $theme) { // theme run this function
        if ($this->_checkVersion($plugin)) {
            if (get_option($this->_name) === false) {
                $active = $this->_options($plugin);
                $this->_store(array_combine($active,$active), $active);
            } else { // updatovalo se neco
                $avaible = $this->_options($plugin);
                $this->_store($this->_data['active'], $avaible);
            }
            if (isset($_POST[$this->_name]) && is_admin()) {
// kvuli aktualiyaci udelame redirect, abz se zmenz provedly/zobrazily ihned

                if (!empty($_SERVER['QUERY_STRING'])) {
                    $query_string = $_SERVER['QUERY_STRING'];
                } else {
                    $query_string = 'page=' . $this->_name;
                }

                wp_redirect(admin_url('plugins.php?' . $query_string));
            }
            return true;
        } else {
            return false;
        }
    }

    private function _registerPluginPage() {
        add_action('admin_menu', array(&$this, 'addPage'));
    }

    public function addPage() {
        $page = add_plugins_page('JaW Widgets', 'JaW Widgets', 'manage_options', $this->_name, array(&$this, 'doPage'));
    }

    public function doPage() {
        if (!current_user_can('manage_options')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }


        echo '<div id="cp-check" class="wrap">';
        echo '<div id="icon-plugins" class="icon32"><br /></div>
            <h2>JaW Widgets</h2>';
        echo '<div class="jawcustomposts">';
        echo $this->_form();
        echo '</div>';
        echo '</div>';
    }

    private function _form() {

        ob_start();
        ?>

        <form action="plugins.php?page=<?php echo $this->_name; ?>" method="post">
            <input id="_wpnonce" type="hidden" value="<?php echo wp_create_nonce($this->_name); ?>" name="_wpnonce">
            <p>Turn on and off widgets </p>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">J&W widgets:</th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span>Active this widgets:</span></legend>
        <?php
        foreach ((array) $this->_avaible as $key => $item) {
            if (in_array($key, $this->_data['avaible'])) {
                $checked = in_array($key, array_keys($this->_data['active'])) ? 'checked="checked"' : '';
                ?>
                                        <label for="<?php echo $key; ?>">
                                            <input type="checkbox" value="<?php echo $key; ?>" <?php echo $checked ?> id="<?php echo $key; ?>" name="typ[]">
                                        <?php echo esc_attr($this->_avaible[$key]['label']); ?></label>
                                        <?php if ($this->_avaible[$key]['description']) { ?>
                                            <br>
                                            <small><em>(<?php echo esc_attr($this->_avaible[$key]['description']); ?>)</em></small>
                <?php } ?>
                                        <br>
                                            <?php
                                    }
                                }
                                ?>

                            </fieldset>
                        </td>
                    </tr>
                </tbody>

            </table>

        <?php submit_button(null, 'primary', $this->_name); ?>
        </form>


        <?php
        return ob_get_clean();
    }

    function jaw_modify_admin_bar($wp_admin_bar) {
        if (current_user_can('manage_options')) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'jaw_options',
                'id' => 'jaw_widgets',
                'title' => __('JaW Widgets', 'jawtemplates'),
                'href' => admin_url('plugins.php?page=jaw_widgets')
            ));
        }
    }

}

$scds = jaw_widgets::getInstance();
//$scds = jaw_shortcodes::getInstance();
?>
