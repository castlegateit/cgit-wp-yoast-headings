# Castlegate IT WP Yoast Headings #

**This plugin is no longer maintained. The [SEO Headings](https://github.com/castlegateit/cgit-wp-seo-headings) plugin is now recommended instead.**

***

Castlegate IT WP Yoast Headings is a WordPress plugin that provides functionality to output text retrieved from Yoast's
generated title tag and converted into comma-and-space separated text.

The preference order for the generated heading is:

1.  Any string passed to the function.
2.  The SEO heading custom field contents, if present.
3.  The Yoast Title for the page, if one exists.
4.  The page title.

The plugin provides a function that can be used in your plugin or theme:

*   `cgit_yoast_heading($str)` returns the title tag generated as above, or the override `$str` if provided.

You can also use the `YoastHeading` class directly:

~~~ php
$yoastHeading = new \Cgit\YoastHeading\YoastHeading('My heading here');
echo $yoastHeading->output(); // Comma-and-space separated string.
~~~

## License

Released under the [MIT License](https://opensource.org/licenses/MIT). See [LICENSE](LICENSE) for details.
