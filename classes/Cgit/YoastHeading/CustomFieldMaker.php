<?php


namespace Cgit\YoastHeading;


class CustomFieldMaker
{
    /**
     * Default custom field parameters
     *
     * @var array
     */
    private $args = [
        'key' => 'cgit_seo',
        'title' => 'SEO',
        'location' => [],
        'fields' => [
            [
                'key' => 'seo_heading',
                'name' => 'seo_heading',
                'label' => 'SEO heading',
                'type' => 'text',
            ],
        ],
    ];
    
    /**
     * Parameters for custom fields on the SEO options page
     *
     * @var array
     */
    private $optionsPageArgs = [];
    
    /**
     * Post types that should have SEO fields
     *
     * @var array
     */
    private $types = [];
    
    /**
     * Taxonomies that should have SEO fields
     *
     * @var array
     */
    private $taxonomies = [];
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register'], 20);
    }
    
    /**
     * Register custom fields
     *
     * This should happen after any custom post types have been defined, which
     * should happen during "init", and after the SEO options page has been
     * defined, at "admin_menu" 10. It should also happen before the options
     * page has been rendered by ACF, which happens during "admin_menu" 99.
     *
     * @return void
     */
    public function register()
    {
        $this->updateArgs();
        $this->updateOptionsPageArgs();
        
        // Register post and page fields
        acf_add_local_field_group($this->args);
        
        // Register options page fields for each post type and taxonomy
        foreach ($this->optionsPageArgs as $args) {
            acf_add_local_field_group($args);
        }
    }
    
    
    /**
     * Update custom field parameters
     *
     * Adds all public post types and taxonomies to the custom field parameters
     * and applies custom filters. Therefore, this should be run after any
     * custom post types and taxonomies have been defined.
     *
     * @return void
     */
    private function updateArgs()
    {
        $this->updatePostTypes();
        $this->updateTaxonomies();
        
        foreach ($this->types as $type) {
            $this->args['location'][] = [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $type,
                ],
            ];
        }
        
        foreach ($this->taxonomies as $taxonomy) {
            $this->args['location'][] = [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => $taxonomy,
                ],
            ];
        }
        
        $this->args = apply_filters('cgit_seo_field_args', $this->args);
    }
    
    /**
     * Update list of post types
     *
     * @return void
     */
    private function updatePostTypes()
    {
        $forbidden = apply_filters('cgit_seo_post_types_hidden', [
            'attachment',
            'revision',
            'nav_menu_item',
            'custom_css',
            'customize_changeset',
            'acf-field-group',
            'acf-field',
        ]);
        
        if($this->isPostsArchivePage()) {
            $forbidden[] = 'page';
        }
        
        $types = array_diff(get_post_types(), $forbidden);
        $types = apply_filters('cgit_seo_post_types', $types);
        
        $this->types = $types;
    }
    
    /**
     * Update list of taxonomies
     *
     * @return void
     */
    private function updateTaxonomies()
    {
        $forbidden = apply_filters('cgit_seo_taxonomies_hidden', [
            'nav_menu',
            'link_category',
            'post_format',
        ]);
        
        $taxonomies = array_diff(get_taxonomies(), $forbidden);
        $taxonomies = apply_filters('cgit_seo_taxonomies', $taxonomies);
        
        $this->taxonomies = $taxonomies;
    }
    
    /**
     * Update options page field parameters
     *
     * @return void
     */
    private function updateOptionsPageArgs()
    {
        // Create a set of SEO fields for the archive for each post type, except
        // pages, which do not have archives.
        foreach ($this->types as $type_name) {
            if ($type_name == 'page') {
                continue;
            }
            
            $type = get_post_type_object($type_name);
            $args = $this->createOptionsPageGroupArgs($type_name, $type->label);
            $this->optionsPageArgs[] = $args;
        }
    }
    
    /**
     * Create and return options page field group parameters
     *
     * @param string $key
     * @param string $label
     * @return array
     */
    private function createOptionsPageGroupArgs($key, $label)
    {
        $fields = $this->args['fields'];
        $args = [
            'key' => $key . '_cgit_seo_options',
            'title' => $label,
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'seo_options',
                    ],
                ],
            ],
            'fields' => [],
        ];
        
        foreach ($fields as $field) {
            $field['key'] = $key . '_' . $field['key'];
            $field['name'] = $key . '_' . $field['name'];
            $args['fields'][] = $field;
        }
        
        return $args;
    }
    
    /**
     * Checks if the currently-edited page is being used as the posts archive page.
     *
     * @return bool
     */
    public function isPostsArchivePage() {
        if(is_admin() && isset($_GET['post'])) {
            if ((int)$_GET['post'] == get_option('page_for_posts')) {
                return true;
            }
        }
        return false;
    }
}