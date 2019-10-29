<?php

use \Cgit\YoastHeading\YoastHeading;

/**
 * Return a Yoast title tag converted to a comma-separated heading, an overridden replacement, or a default.
 *
 * @param string $str
 * @return string
 */
function cgit_yoast_heading($str = false)
{
    return (new YoastHeading($str))->output();
}
