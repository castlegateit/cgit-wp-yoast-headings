<?php


namespace Cgit\YoastHeading;


class Plugin
{
    
   
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        new OptionsPageMaker();
        new CustomFieldMaker();
        global $fieldFetcher;
        $fieldFetcher = new FieldFetcher();
    }
    
    /**
     * Automatically obfuscate email addresses in content
     *
     * @param string $content
     *
     * @return string
     */
    public function generateHeading($content)
    {
        return (new YoastHeading($content))->output();
    }
}