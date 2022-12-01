<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Visibility extenstion
 *
 * Conditional Visibility Widgets & Rows/Sections
 *
 * @since 1.0.1
 */
class DCE_Extension_Masking extends DCE_Extension_Prototype {

        public $name = 'Advanced Masking Controls';
        public static $docs = 'https://www.dynamic.ooo/widget/advanced-masking/';
        private $is_common = false;
        public $has_action = false;

        static public function is_enabled() {
            return true;
        }
        
        public function get_docs() {
            return self::$docs;
        }

        public static function get_description() {
            return __('Advanced Masking features for Image/Image-box/Video Widgets', 'dynamic-content-for-elementor');
        }

        /**
         * Get Name
         *
         * Return the action name
         *
         * @access public
         * @return string
         */
        public function get_name() {
            return 'dce_masking';
        }

        /**
         * Add Actions
         *
         * @since 0.5.5
         *
         * @access private
         */
        protected function add_actions() {
            
            add_action("elementor/widget/render_content", array($this, '_render_masking'), 10, 2);

            //add_action('elementor/element/image/section_image/before_section_start', [$this, 'add_control_section_to_masking'], 10, 2);
            
            add_action( 'elementor/element/image/section_image/before_section_end', [$this, 'add_dce_masking_controls'], 10, 2);

            add_action( 'elementor/element/image-box/section_image/before_section_end', [$this, 'add_dce_masking_controls'], 10, 2);

            add_action( 'elementor/element/video/dce_video_section/before_section_end', [$this, 'add_dce_masking_controls'], 10, 2);

            /*
            add_action( 'elementor/widget/print_template', function( $template, $widget ) {
               if ( 'masking' === $widget->get_name() ) {
                    $template = false;
               }
               return $template;
            }, 10, 2 );
            */

        }
        public function add_dce_masking_controls($element, $args) {
            /*$type = $element->get_data( 'widgetType' );

            if($type == 'video'){
                $keyImage = 'image_overlay[url]!';
                
            }else{
                $keyImage = 'image[url]!';
            }*/
            //var_dump($keyImage);
            
           
            $element->add_control(
              'mask_type', [
                'label' => __('Mask', 'dynamic-content-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'separator' => 'before',
                'options' => [
                    'none' => [
                        'title' => 'None',
                        'icon' => 'fa fa-ban',
                    ],
                    'image' => [
                        'title' => 'Dynamic',
                        'icon' => 'fa fa-image',
                    ],
                    'clippath' => [
                        'title' => 'Clip-Path',
                        'icon' => 'fa fa-circle',
                    ],

                ],
                'prefix_class' => 'dce_masking-',
                'label_block' => false,
                'default' => 'none',
              ]
            );
            $element->add_control(
              'images_mask', [
                'label' => __('Select IMAGE mask', 'dynamic-content-for-elementor','smoothscroll'),
                'type' => 'images_selector',
                'toggle' => false,
                'type_selector' => 'image',
                'columns_grid' => 4,
                'default' => DCE_URL . 'assets/img/mask/flower.png',
                'options' => [
                    'mask1' => [
                        'title' => 'Flower',
                        'image' => DCE_URL . 'assets/img/mask/flower.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/flower.jpg'
                    ],
                    'mask2' => [
                        'title' => 'Blob',
                        'image' => DCE_URL . 'assets/img/mask/blob.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/blob.jpg'
                    ],
                    'mask3' => [
                        'title' => 'Diagonals',
                        'image' => DCE_URL . 'assets/img/mask/diagonal.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/diagonal.jpg'
                    ],
                    'mask4' => [
                        'title' => 'Rhombus',
                        'image' => DCE_URL . 'assets/img/mask/rombs.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/rombs.jpg'
                    ],
                    'mask5' => [
                        'title' => 'Waves',
                        'image' => DCE_URL . 'assets/img/mask/waves.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/waves.jpg'
                    ],
                    'mask6' => [
                        'title' => 'Drawing',
                        'image' => DCE_URL . 'assets/img/mask/draw.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/draw.jpg'
                    ],
                    'mask7' => [
                        'title' => 'Sketch',
                        'image' => DCE_URL . 'assets/img/mask/sketch.png',
                        'image_preview' => DCE_URL . 'assets/img/mask/low/sketch.jpg'
                    ],
                    
                    'custom_mask' => [
                        'title' => 'Custom mask',
                        //'icon' => 'fa fa-list-ul',
                        'return_val' => 'val',
                        'image' => DCE_URL . 'assets/displacement/custom.jpg',
                        'image_preview' => DCE_URL . 'assets/displacement/custom.jpg',
                    ],
                ],
                'condition' => [
                    'mask_type' => 'image'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-image: url({{VALUE}}); mask-image: url({{VALUE}}); -webkit-mask-position: 50% 50%; mask-position: 50% 50%; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-size: contain; mask-size: contain;',
                ],
              ]
            );
            $element->add_control(
              'custom_image_mask',
              [
                 'label' => __( 'sellect PNG:', 'dynamic-content-for-elementor' ),
                 'type' => Controls_Manager::MEDIA,
                 'dynamic' => [
                    'active' => true,
                  ],
                 'default' => [
                    'url' => DCE_Helper::get_placeholder_image_src(),
                 ],
                 'selectors' => [
                    '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-image: url({{URL}}); mask-image: url({{URL}}); -webkit-mask-position: 50% 50%; mask-position: 50% 50%; -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat; -webkit-mask-size: contain; mask-size: contain;'
                ],
                'condition' => [
                    'images_mask' => 'custom_mask',
                    'mask_type' => 'image'            
                ],
              ]
            );
            
            // --------------------------
            $element->add_responsive_control(
              'position_image_mask',
                [
                    'label' => __( 'Position', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => __( 'Default', 'dynamic-content-for-elementor'),
                        'center center' => __( 'Center Center', 'dynamic-content-for-elementor'),
                        'center left' => __( 'Center Left', 'dynamic-content-for-elementor'),
                        'center right' => __( 'Center Right', 'dynamic-content-for-elementor'),
                        'top center' => __( 'Top Center', 'dynamic-content-for-elementor'),
                        'top left' => __( 'Top Left', 'dynamic-content-for-elementor'),
                        'top right' => __( 'Top Right', 'dynamic-content-for-elementor'),
                        'bottom center' => __( 'Bottom Center', 'dynamic-content-for-elementor'),
                        'bottom left' => __( 'Bottom Left', 'dynamic-content-for-elementor'),
                        'bottom right' => __( 'Bottom Right', 'dynamic-content-for-elementor'),
                        'initial' => __( 'Custom', 'dynamic-content-for-elementor'),

                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
                    ],
                    'condition' => [
                        'mask_type' => 'image', 
                        
                    ],
                ]
            );

            $element->add_responsive_control(
              'xpos_image_mask',
                [
                    'label' => __( 'X Position', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', '%', 'vw' ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'tablet_default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'mobile_default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'range' => [
                        'px' => [
                            'min' => -800,
                            'max' => 800,
                        ],
                        'em' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                        'vw' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => 'mask-position: {{SIZE}}{{UNIT}} {{ypos_image_mask.SIZE}}{{ypos_image_mask.UNIT}}',
                    ],
                    'condition' => [
                        'mask_type' => 'image', 
                        'position_image_mask' => [ 'initial' ],
                        
                    ],
                ]
            );

            $element->add_responsive_control(
              'ypos_image_mask',
                [
                    'label' => __( 'Y Position', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', '%', 'vh' ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'tablet_default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'mobile_default' => [
                        'unit' => 'px',
                        'size' => 0,
                    ],
                    'range' => [
                        'px' => [
                            'min' => -800,
                            'max' => 800,
                        ],
                        'em' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                        'vh' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => 'mask-position: {{xpos_image_mask.SIZE}}{{xpos_image_mask.UNIT}} {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'mask_type' => 'image', 
                        'position_image_mask' => [ 'initial' ],
                        
                        
                    ],
                ]
            );

            

            $element->add_responsive_control(
              'repeat_image_mask',
                [
                    'label' => __( 'Repeat', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => __( 'Default', 'dynamic-content-for-elementor'),
                        'no-repeat' => __( 'No-repeat', 'dynamic-content-for-elementor'),
                        'repeat' => __( 'Repeat', 'dynamic-content-for-elementor'),
                        'repeat-x' => __( 'Repeat-x', 'dynamic-content-for-elementor'),
                        'repeat-y' => __( 'Repeat-y', 'dynamic-content-for-elementor'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
                    ],
                    'condition' => [
                        'mask_type' => 'image', 
                    ],
                ]
            );

            $element->add_responsive_control(
              'size_image_mask',
                [
                    'label' => __( 'Size', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => __( 'Default', 'dynamic-content-for-elementor'),
                        'auto' => __( 'Auto', 'dynamic-content-for-elementor'),
                        'cover' => __( 'Cover', 'dynamic-content-for-elementor'),
                        'contain' => __( 'Contain', 'dynamic-content-for-elementor'),
                        'initial' => __( 'Custom', 'dynamic-content-for-elementor'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
                    ],
                    'condition' => [
                        'mask_type' => 'image', 
                        
                        
                    ],
                ]
            );

            $element->add_responsive_control(
              'width_image_mask',
                [
                    'label' => __( 'Width', 'dynamic-content-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', 'em', '%', 'vw' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                        'vw' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'size' => 100,
                        'unit' => '%',
                    ],
                    'required' => true,
                    'selectors' => [
                        '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',

                    ],
                    'condition' => [
                        'mask_type' => 'image',
                        'size_image_mask' => [ 'initial' ],
                        
                        
                    ],
                ]
            );




            /*$element->add_control(
                'svg_masking',
                [
                    'label' => __( 'Icon', 'elementor-pro' ),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                    'recommended' => [
                        'fa-solid' => [
                            'circle',
                            'dot-circle',
                            'square-full',
                        ],
                        'fa-regular' => [
                            'circle',
                            'dot-circle',
                            'square-full',
                        ],
                    ],
                    'condition' => [
                        'mask_type' => 'svg'
                    ],
                    //'skin' => 'inline',
                    //'label_block' => false,
                    //'exclude_inline_options' => [ 'icon' ],
                ]
            );*/
             $element->add_control(
              'clippath_mask', [
                'label' => __('Predefined Clip-Path', 'dynamic-content-for-elementor'),
                'type' => 'images_selector',
                'toggle' => false,
                'type_selector' => 'image',
                'columns_grid' => 5,
                'default' => 'polygon(50% 0%, 0% 100%, 100% 100%)',
                'options' => [
                    'polygon(50% 0%, 0% 100%, 100% 100%)' => [
                        'title' => 'Triangle',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/triangle.png'
                    ],
                    'polygon(20% 0%, 80% 0%, 100% 100%, 0% 100%)' => [
                        'title' => 'Trapezoid',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/trapezoid.png'
                    ],
                    'polygon(25% 0%, 100% 0%, 75% 100%, 0% 100%)' => [
                        'title' => 'Parallelogram',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/parallelogram.png'
                    ],
                    'polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%)' => [
                        'title' => 'Rombus',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/rombus.png'
                    ],
                    'polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%)' => [
                        'title' => 'Pentagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/pentagon.png'
                    ],
                    'polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%)' => [
                        'title' => 'Hexagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/hexagon.png'
                    ],
                    'polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%)' => [
                        'title' => 'Heptagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/heptagon.png'
                    ],
                    'polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%)' => [
                        'title' => 'Octagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/octagon.png'
                    ],
                    'polygon(50% 0%, 83% 12%, 100% 43%, 94% 78%, 68% 100%, 32% 100%, 6% 78%, 0% 43%, 17% 12%)' => [
                        'title' => 'Nonagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/nonagon.png'
                    ],
                    'polygon(50% 0%, 80% 10%, 100% 35%, 100% 70%, 80% 90%, 50% 100%, 20% 90%, 0% 70%, 0% 35%, 20% 10%)' => [
                        'title' => 'Decagon',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/decagon.png'
                    ],
                    'polygon(20% 0%, 80% 0%, 100% 20%, 100% 80%, 80% 100%, 20% 100%, 0% 80%, 0% 20%)' => [
                        'title' => 'Bevel',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/bevel.png'
                    ],
                    'polygon(0% 15%, 15% 15%, 15% 0%, 85% 0%, 85% 15%, 100% 15%, 100% 85%, 85% 85%, 85% 100%, 15% 100%, 15% 85%, 0% 85%)' => [
                        'title' => 'Rabbet',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/rabbet.png'
                    ],
                    'polygon(40% 0%, 40% 20%, 100% 20%, 100% 80%, 40% 80%, 40% 100%, 0% 50%)' => [
                        'title' => 'Left arrow',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/leftarrow.png'
                    ],
                    'polygon(0% 20%, 60% 20%, 60% 0%, 100% 50%, 60% 100%, 60% 80%, 0% 80%)' => [
                        'title' => 'Right arrow',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/rightarrow.png'
                    ],
                    'polygon(25% 0%, 100% 1%, 100% 100%, 25% 100%, 0% 50%)' => [
                        'title' => 'Left point',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/leftpoint.png'
                    ],
                    'polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%)' => [
                        'title' => 'Right point',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/rightpoint.png'
                    ],
                    'polygon(100% 0%, 75% 50%, 100% 100%, 25% 100%, 0% 50%, 25% 0%)' => [
                        'title' => 'Left chevron',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/leftchevron.png'
                    ],
                    'polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 25% 50%, 0% 0%)' => [
                        'title' => 'Right Chevron',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/rightchevron.png'
                    ],
                    'polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%)' => [
                        'title' => 'Star',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/star.png'
                    ],
                    'polygon(10% 25%, 35% 25%, 35% 0%, 65% 0%, 65% 25%, 90% 25%, 90% 50%, 65% 50%, 65% 100%, 35% 100%, 35% 50%, 10% 50%)' => [
                        'title' => 'Cross',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/cross.png'
                    ],
                    'polygon(0% 0%, 100% 0%, 100% 75%, 75% 75%, 75% 100%, 50% 75%, 0% 75%)' => [
                        'title' => 'Message',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/message.png'
                    ],
                    'polygon(20% 0%, 0% 20%, 30% 50%, 0% 80%, 20% 100%, 50% 70%, 80% 100%, 100% 80%, 70% 50%, 100% 20%, 80% 0%, 50% 30%)' => [
                        'title' => 'Close',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/close.png'
                    ],
                    'polygon(0% 0%, 0% 100%, 25% 100%, 25% 25%, 75% 25%, 75% 75%, 25% 75%, 25% 100%, 100% 100%, 100% 0%)' => [
                        'title' => 'Frame',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/frame.png'
                    ],
                    'circle(50% at 50% 50%)' => [
                        'title' => 'Circle',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/circle.png'
                    ],
                    'ellipse(25% 40% at 50% 50%)' => [
                        'title' => 'Ellipse',
                        'return_val' => 'val',
                        'image_preview' => DCE_URL . 'assets/img/shapes/ellipse.png'
                    ],
                ],
                'condition' => [
                    'mask_type' => 'clippath'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img, {{WRAPPER}} .elementor-image-box-img img, {{WRAPPER}} .elementor-custom-embed-image-overlay,{{WRAPPER}} .elementor-video-iframe, {{WRAPPER}} .plyr__video-wrapper' => '-webkit-clip-path: {{VALUE}}; clip-path: {{VALUE}};'
                ],
              ]
            );
        }
        public function add_control_section_to_masking($element, $args) {

            

            /*$element->start_controls_section(
                    'dce_masking_section',
                    [
                        'label' => __('Masking', 'dynamic-content-for-elementor'),
                        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    ]
            );
            
 
            $element->end_controls_section();*/
            
            // --------------------------------- STYLE
            /*$element->start_controls_section(
                    'dce_masking_style',
                    [
                        'label' => __('Custom controls', 'dynamic-content-for-elementor'),
                        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                        'condition' => [
                            'dce_masking_custom_controls!' => '',
                        ]
                    ]
            );
           
            
            $element->end_controls_section();*/
        }
        
        
        /*public function get_script_depends() {        
            return ['dce-advancedmask'];
        }*/
        /*public function get_style_depends() {        
            return [];
        }*/
        public function _render_masking($content, $widget) {
            if ($widget->get_name() == 'image') {
                $settings = $widget->get_settings();


                
            }
            return $content;
        }
}
