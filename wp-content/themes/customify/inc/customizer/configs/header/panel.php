<?php

Customify_Customize_Layout_Builder()->register_builder('header', new Customify_Builder_Header());

class Customify_Builder_Header extends Customify_Customize_Builder_Panel
{
    public $id = 'header';

    function get_config()
    {
        return array(
            'id'         => $this->id,
            'title'      => __('Header Builder', 'customify'),
            'control_id' => 'header_builder_panel',
            'panel'      => 'header_settings',
            'section'    => 'header_builder_panel',
            'devices'    => array(
                'desktop' => __('Desktop', 'customify'),
                'mobile'  => __('Mobile/Tablet', 'customify'),
            ),
        );
    }

    function get_rows_config()
    {
        return array(
            'top'     => __('Header Top', 'customify'),
            'main'    => __('Header Main', 'customify'),
            'bottom'  => __('Header Bottom', 'customify'),
            'sidebar' => __('Menu Sidebar', 'customify'),
        );
    }

    function customize()
    {

        $fn = 'customify_customize_render_header';
        $config = array(
            array(
                'name'     => 'header_settings',
                'type'     => 'panel',
                'priority' => 1,
                'title'    => __('Header', 'customify'),
            ),

            array(
                'name'  => 'header_builder_panel',
                'type'  => 'section',
                'panel' => 'header_settings',
                'title' => __('Header Builder', 'customify'),
            ),

            array(
                'name'                => 'header_builder_panel',
                'type'                => 'js_raw',
                'section'             => 'header_builder_panel',
                'theme_supports'      => '',
                'title'               => __('Header Builder', 'customify'),
                'selector'            => '#masthead',
                'render_callback'     => $fn,
                'container_inclusive' => true
            ),
        );

        return $config;
    }

    function row_config($section = false, $section_name = false)
    {

        if (!$section) {
            $section = 'header_top';
        }
        if (!$section_name) {
            $section_name = __('Header Top', 'customify');
        }

        $selector = '.header--row.' . str_replace('_', '-', $section);

        $fn = 'customify_customize_render_header';
        $selector_all = '#masthead';

        $config = array(
            array(
                'name'           => $section,
                'type'           => 'section',
                'panel'          => 'header_settings',
                'theme_supports' => '',
                'title'          => $section_name,
            ),

            array(
                'name'            => $section . '_layout',
                'type'            => 'select',
                'section'         => $section,
                'title'           => __('Layout', 'customify'),
                'selector'        => $selector,
                'css_format'      => 'html_class',
                'render_callback' => $fn,
                'default'         => 'layout-full-contained',
                'choices'         => array(
                    'layout-full-contained' => __('Full width - Contained', 'customify'),
                    'layout-fullwidth'      => __('Full Width', 'customify'),
                    'layout-contained'      => __('Contained', 'customify'),
                )
            ),

            array(
                'name'        => $section . '_noti_layout',
                'type'        => 'custom_html',
                'section'     => $section,
                'title'       => '',
                'description' => __("Layout <code>Full width - Contained</code> and <code>Full Width</code> will not fit browser width because you've selected <a class='focus-control' data-id='site_layout' href='#'>Site Layout</a> as <code>Boxed</code> or <code>Framed</code>", 'customify'),
                'required'    => array(
                    array('site_layout', '=', array('site-boxed', 'site-framed')),
                )
            ),

            array(
                'name'            => $section . '_height',
                'type'            => 'slider',
                'section'         => $section,
                'theme_supports'  => '',
                'device_settings' => true,
                'max'             => 250,
                'selector'        => $selector . " .customify-grid, $selector .style-full-height .primary-menu-ul > li > a",
                'css_format'      => 'min-height: {{value}};',
                'title'           => __('Height', 'customify'),
            ),

            array(
                'name'             => $section . '_styling',
                'type'             => 'styling',
                'section'          => $section,
                'title'            => __('Styling', 'customify'),
                'description'      => sprintf(__('Advanced styling for %s', 'customify'), $section_name),
                'live_title_field' => 'title',
                'selector'         => array(
                    'normal'            => "{$selector} .customify-container, {$selector}.layout-full-contained, {$selector}.layout-fullwidth",
                    'normal_box_shadow' => "{$selector} .customify-container, {$selector}.layout-full-contained, {$selector}.layout-fullwidth",
                    'normal_text_color' => "{$selector}, {$selector} .site-branding a",
                    'normal_link_color' => "{$selector} a",
                    'hover_link_color'  => "{$selector} a:hover",
                ),
                'css_format'       => 'styling', // styling
                'fields'           => array(
                    'normal_fields' => array(
                        //'text_color' => false, // disable for special field.
                        //'link_color' => false, // disable for special field.
                        'padding' => false // disable for special field.
                    ),
                    'hover_fields'  => array(
                        'text_color' => false,
                        //'link_color' => false,
                        'padding'        => false,
                        'bg_color'       => false,
                        'bg_heading'     => false,
                        'bg_cover'       => false,
                        'bg_image'       => false,
                        'bg_repeat'      => false,
                        'border_heading' => false,
                        'border_color'   => false,
                        'border_radius'  => false,
                        'border_width'   => false,
                        'border_style'   => false,
                        'box_shadow'     => false,
                    ), // disable hover tab and all fields inside.
                )
            ),

        );

        return $config;

    }

    function row_sidebar_config($section, $section_name)
    {
        //$selector = '#header-menu-sidebar-inner';
        $selector = '#header-menu-sidebar-bg';

        // #header-menu-sidebar-bg

        $config = array(
            array(
                'name'           => $section,
                'type'           => 'section',
                'panel'          => 'header_settings',
                'theme_supports' => '',
                'title'          => $section_name,
            ),

            array(
                'name'            => $section . '_animate',
                'type'            => 'select',
                'section'         => $section,
                'selector'        => 'body',
                'render_callback' => 'customify_customize_render_header',
                'css_format'      => 'html_class',
                'title'           => __('Display Type', 'customify'),
                'default'         => 'menu_sidebar_slide_left',
                'choices'         => array(
                    'menu_sidebar_slide_left'    => __('Slide From Left', 'customify'),
                    'menu_sidebar_slide_right'   => __('Slide From Right', 'customify'),
                    'menu_sidebar_slide_overlay' => __('Full-screen Overlay', 'customify'),
                    'menu_sidebar_dropdown'      => __('Toggle Dropdown', 'customify'),
                )
            ),


            array(
                'name'       => $section . '_text_mode',
                'type'       => 'image_select',
                'section'    => $section,
                'selector'   => '#header-menu-sidebar, .close-sidebar-panel',
                'css_format' => 'html_class',
                'title'      => __('Text Mode Color', 'customify'),
                'default'    => 'is-text-light',
                'choices'    => array(
                    'is-text-light' => array(
                        'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/text_mode_light.svg',
                    ),
                    'is-text-dark'  => array(
                        'img' => esc_url( get_template_directory_uri() ) . '/assets/images/customizer/text_mode_dark.svg',
                    ),
                )
            ),


            array(
                'name'             => $section . '_styling',
                'type'             => 'styling',
                'section'          => $section,
                'title'            => __('Styling', 'customify'),
                'description'      => sprintf(__('Advanced styling for %s', 'customify'), $section_name),
                'live_title_field' => 'title',
                'selector'         => array(
                    'normal'               => $selector,
                    'normal_link_color'    => "{$selector} a",
                    'hover_link_color'     => "{$selector} a:hover",
                    'normal_bg_color'      => "#header-menu-sidebar-bg:before",
                    'normal_bg_image'      => "#header-menu-sidebar-bg:before",
                    'normal_bg_attachment' => "#header-menu-sidebar-bg:before",
                    'normal_bg_cover'      => "#header-menu-sidebar-bg:before",
                    'normal_bg_repeat'     => "#header-menu-sidebar-bg:before",
                    'normal_bg_position'   => "#header-menu-sidebar-bg:before",
                    'normal_box_shadow'    => "#header-menu-sidebar",
                ),
                'css_format'       => 'styling', // styling
                'fields'           => array(
                    'normal_fields' => array(
                        //'link_color' => false, // disable for special field.
                        //'padding' => false // disable for special field.
                        //'border_heading' => false,
                        'border_color'  => false,
                        'border_radius' => false,
                        'border_width'  => false,
                        'border_style'  => false,
                    ),
                    'hover_fields'  => array(
                        'text_color'     => false,
                        'padding'        => false,
                        'bg_color'       => false,
                        'bg_heading'     => false,
                        'bg_cover'       => false,
                        'bg_image'       => false,
                        'bg_repeat'      => false,
                        'border_heading' => false,
                        'border_color'   => false,
                        'border_radius'  => false,
                        'border_width'   => false,
                        'border_style'   => false,
                        'box_shadow'     => false,
                    ), // disable hover tab and all fields inside.
                )
            ),


        );
        return $config;
    }

}

if (!function_exists('customify_header_layout_settings')) {
    function customify_header_layout_settings($item_id = '', $section = '')
    {

        $layout = array(
            array(
                'name'     => 'header_' . $item_id . '_l_heading',
                'type'     => 'heading',
                'priority' => 800,
                'section'  => $section,
                'title'    => __('Item Layout', 'customify')
            ),

            array(
                'name'            => 'header_' . $item_id . '_margin',
                'type'            => 'css_ruler',
                'priority'        => 810,
                'section'         => $section,
                'device_settings' => true,
                'css_format'      => array(
                    'top'    => 'margin-top: {{value}};',
                    'right'  => 'margin-right: {{value}};',
                    'bottom' => 'margin-bottom: {{value}};',
                    'left'   => 'margin-left: {{value}};',
                ),
                'selector'        => ".header--row .builder-item--{$item_id}, .builder-item.builder-item--group .item--inner.builder-item--{$item_id}",
                'label'           => __('Margin', 'customify'),
            ),

            array(
                'name'            => 'header_' . $item_id . '_align',
                'type'            => 'text_align_no_justify',
                'section'         => $section,
                'priority'        => 820,
                'device_settings' => true,
                'selector'        => '.builder-first--' . $item_id,
                'css_format'      => 'text-align: {{value}};',
                'title'           => __('Align', 'customify'),
            ),

            array(
                'name'            => 'header_' . $item_id . '_merge',
                'type'            => 'select',
                'section'         => $section,
                'selector'        => '#masthead',
                'render_callback' => 'customify_customize_render_header',
                'priority'        => 999,
                'device_settings' => true,
                'devices'         => array('desktop', 'mobile'),
                'title'           => __('Merge Item', 'customify'),
                'description'     => __('If you choose to merge this item, the alignment setting will inherit from the item you are merging.', 'customify'),
                'choices'         => array(
                    0      => __('No', 'customify'),
                    'prev' => __('Merge with left item', 'customify'),
                    'next' => __('Merge with right item', 'customify'),
                )
            )
        );

        return $layout;
    }
}
