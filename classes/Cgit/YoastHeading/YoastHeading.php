<?php

namespace Cgit\YoastHeading;

use WPSEO_Options;

class YoastHeading
{
    /**
     * Source string
     *
     * The desired replacement text if you would like to override both Yoast and the default use of the page title.
     *
     * @var string
     */
    private $content;
    
    /**
     * Constructor
     *
     * @param string $content
     */
    public function __construct($content = false)
    {
        $this->content = $content;
    }
    
    /**
     * Checks the different data sources in preference order to find a heading for the current page, post, or archive.
     *
     * @return bool|string
     */
    private function generate()
    {
        if ($this->content) {
            return $this->content;
        }
        
        global $fieldFetcher;
        if ($yoastTitle = $fieldFetcher->getHeading()) {
            return $yoastTitle;
        }
        global $post;
        if (
            (is_plugin_active('wordpress-seo/wp-seo.php') || is_plugin_active('wordpress-seo-premium/wp-seo-premium.php'))
            &&
            $yoastTitle = \WPSEO_Frontend::get_instance()->title(false)) {
            return $this->format($yoastTitle);
        } else {
            if (is_page() || is_singular()) {
                return get_the_title();
            }
    
            if (is_archive()) {
                return get_the_archive_title();
            }
            
            return get_the_title($post);
        }
    }
    
    /**
     * Formats a heading from the available data by breaking it with commas and spaces.
     *
     * @param $yoastTitle
     *
     * @return string The heading text ready for output.
     */
    private function format($yoastTitle)
    {
        if ($separatorKey = WPSEO_Options::get('separator', false)) {
            $separatorArray = \WPSEO_Option_Titles::get_instance()->get_separator_options();
            if (isset($separatorArray[$separatorKey])) {
                $separator       = $separatorArray[$separatorKey];
                $yoastTitleArray = explode($separator, $yoastTitle);
                $siteName        = get_bloginfo('name');
                foreach ($yoastTitleArray as $key => $fragment) {
                    if (trim($fragment) == $siteName) {
                        unset($yoastTitleArray[$key]);
                    } else {
                        $yoastTitleArray[$key] = trim($fragment);
                    }
                }
                $yoastTitle = implode(', ', $yoastTitleArray);
            }
        }
        
        return $yoastTitle;
    }
    
    /**
     * Returns the heading for echoing into your HTML.
     *
     * @return string
     */
    public function output()
    {
        return $this->generate();
    }
}