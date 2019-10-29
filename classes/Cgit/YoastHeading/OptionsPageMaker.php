<?php


namespace Cgit\YoastHeading;

class OptionsPageMaker
{
    /**
     * Default options page settings
     *
     * @var array
     */
    private $args = [
        'page_title' => 'SEO',
        'menu_slug'  => 'seo_options',
        'post_id'    => 'seo_options',
    ];
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        // Allow customization of options page settings
        $this->args = apply_filters('cgit_seo_options_page_args', $this->args);
        
        // Register options page. This must happen before admin_menu 99, which
        // is when the admin menus are rendered.
        add_action('admin_menu', [$this, 'register'], 10);
    }
    
    /**
     * Register options page
     *
     * @return void
     */
    public function register()
    {
        acf_add_options_page($this->args);
    }
}