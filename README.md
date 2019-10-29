# Castlegate IT WP Yoast Headings #

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
$yoastHeading = new \Cgit\Obfuscator\YoastHeading('My heading here');
echo $yoastHeading->output(); // Comma-and-space separated string.
~~~

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.
