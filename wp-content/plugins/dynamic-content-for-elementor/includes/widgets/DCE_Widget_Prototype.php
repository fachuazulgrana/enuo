<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Utils;
use Elementor\Repeater;

use DynamicContentForElementor\DCE_Widgets;
use DynamicContentForElementor\DCE_Helper;
use DynamicContentForElementor\Group_Control_Outline;
use DynamicContentForElementor\Controls\DCE_Group_Control_Filters_CSS;
use DynamicContentForElementor\Controls\DCE_Group_Control_Transform_Element;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * DCE_Widget_Prototype Base widget class
 *
 * Base class for Dynamic Content for Elementor
 *
 * @since 0.4.0
 */

class DCE_Widget_Prototype extends Widget_Base {
    
    /**
    * Settings.
    *
    * Holds the object settings.
    *
    * @access public
    *
    * @var array
    */
    public $settings;
    
    /**
    * Raw Data.
    *
    * Holds all the raw data including the element type, the child elements,
    * the user data.
    *
    * @access public
    *
    * @var null|array
    */
    public $data;
    
    public $docs = 'https://www.dynamic.ooo';

    public function get_name() {
        return 'dce-prototype';
    }

    public function get_title() {
        return __('Prototype', 'dynamic-content-for-elementor');
    }
    
    public function get_description() {
        return __('Another Dynamic Widget', 'dynamic-content-for-elementor');
    }
    
    public function get_docs() {
        return $this->docs;
    }
    
    public function get_help_url() {
        return 'https://docs.dynamic.ooo';
    }
    
    public function get_custom_help_url() {
        return $this->get_docs();
    }

    public function get_icon() {
        return 'eicon-animation';
    }

    static public function is_enabled() {
        return false;
    }
    
    public function is_reload_preview_required() {
            return false;
    }

    public function get_categories() {
        $grouped_widgets = DCE_Widgets::get_widgets_by_group();
        $fullname = basename(get_class($this));
        $pieces = explode('\\', $fullname);
        $name = end($pieces);
        //var_dump($name); die();
        foreach ($grouped_widgets as $gkey => $group) {
            foreach ($group as $wkey => $widget) {
                if ($widget == $name) {
                    //var_dump($gkey); die();
                    return [ 'dynamic-content-for-elementor-'.  strtolower($gkey) ];
                }
            }
        }
        return [ 'dynamic-content-for-elementor' ];
    }
    
    static public function get_position() {
        return 666;
    }
    
    static public function get_satisfy_dependencies($ret = false) {
        $widgetClass = get_called_class();
        //require_once( __DIR__ . '/'.$widgetClass.'.php' );
        $myWdgt = new $widgetClass();
        return $myWdgt->satisfy_dependencies($ret);
    }
    
    public function get_plugin_depends() {
        return array();
    }
    
    public function satisfy_dependencies($ret = false, $deps = array()) {
        if (empty($deps)) {
            $deps = $this->get_plugin_depends();
        }
        $depsDisabled = array();
        if (!empty($deps)) {
            $isActive = true;
            foreach ($deps as $pkey => $plugin) {
                if (!is_numeric($pkey)) {
                    if (!DCE_Helper::is_plugin_active($pkey)) {
                        $isActive = false;
                    }
                } else {
                    if (!DCE_Helper::is_plugin_active($plugin)) {
                        $isActive = false;
                    }
                }
                if (!$isActive) {
                    if (!$ret) {
                        return false;
                    }
                    if (is_numeric($pkey)) {
                        $depsDisabled[] = $plugin;
                    } else {
                        $depsDisabled[] = $pkey;
                    }
                }
            }
        }
        if ($ret) {
            return $depsDisabled;
        }
        return true;
    }

    /**
     * A list of scripts that the widgets is depended in
     * */
    public function get_script_depends() {
        return [ ];
    }
    
    /*
    public function get_settings_for_display() {
        
    }
    */
    public function get_settings_for_display($setting_key = null, $original = false) {
        $settings = parent::get_settings_for_display($setting_key);
        if ($original) {
            return $settings;
        }
        $settings = DCE_Helper::get_dynamic_value($settings);
        return $settings;
    }
    
    protected function _register_controls() {}

    protected function render() {}

    protected function _content_template() {}
    
    final public function update_settings( $key, $value = null ) {
        $widget_id = $this->get_id();
        DCE_Helper::set_settings_by_id($widget_id, $key, $value);
        
        $this->set_settings($key, $value);
    }
    
    /*
    public function add_wpml_support() {
            add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'wpml_widgets_to_translate_filter' ] );
    }
    public function wpml_widgets_to_translate_filter( $widgets ) {
        
            $stack = $this->get_controls();
            $widgets[ $this->get_name() ] = [
                    'conditions' => [ 'widgetType' => $this->get_name() ],
                    'fields'     => [
                            [
                                    'field'       => 'title',
                                    'type'        => __( 'Hello World Title', 'hello-world' ),
                                    'editor_type' => 'LINE'
                            ],
                    ],
            ];
            return $widgets;
    }
    */

}
