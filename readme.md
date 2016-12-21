# [Commentcode API](http://wordpress.org/plugins/commentcode-api/)

## Abstract

Commentcode API lets you generate custom outputs with HTML comment-like codes.  

It is similar to the [Shortcode API](https://codex.wordpress.org/Shortcode_API) except it takes a form of HTML comments and a few features.

Since it takes a form of HTML comments, even the user disables your plugin, the embedded code will not be visible, on contrary to shortcodes that remain in posts when their plugins are deactivated. 

### Features

<h4>Does not leave a mess in posts</h4>
Say, you have been using a plugin that converts a plugin specific shortcode into custom outputs. Later you found something else that is more useful and uninstalled it.

But the shortcodes used by that plugin remained in hundreds of posts and it was too much work to manually delete them so you have to ask somebody to run SQL commands.

That's a problem. What if the shortcode takes a form of an HTML comment? It won't leave such a mess.

<h4>Syntax</h4>
It looks like this.

```php
<!--- tag foo="bar" --->
```

```php
<!--- tag color="#333" ---><p>Some outputs.</p><!--- /tag --->
```

Notice that tripe dashes are used in the both opening and closing part. So it won't hardly conflict with generic HTML comments.

<h4>Supports Multi-dimensional Array Arguments</h4>
The shortcode cannot pass multi-dimensional arguments to the callback function.

The below attributes won't be parsed.

```php
[my_shortcode foo[1]="one" foo[2]="two"]
```

However, commentcode can handle it.

```php
<!---my_shortcode foo[1]="one" foo[2]="two" --->
```

The attributes are interpreted as

```php
array(
    'foo'   => array(
        1 => 'one',
        2 => 'two',
    )
)
```

<h4>Preserved Letter Cases</h4>
The shortcode does not allow capitalized attribute names.

```php
[my_shortcode CapitalName="I need it to be capitalized"]
```

The attribute is interpreted as

```php
array(
    'capitalname' => 'I need it to be capitalized',
)
```

This is not useful when you need to perform remote API requests which require argument names with capital letters.

However, the commentcode API preserves those argument names.

```php
<!--- my_shortcode CapitalName="Please keep capitalization!" --->
```

will be

```php
array(
    'CapitalName'   => 'Please keep capitalization!',
)
```

## Installation

- The latest development version can be found [here](https://github.com/michaeluno/commentcode-api/branches). 
- The latest stable version can be downloaded [here](http://downloads.wordpress.org/plugin/commentcode-api.latest-stable.zip).

1. Upload **`commentcode-api.php`** and other files compressed in the zip folder to the **`/wp-content/plugins/`** directory.,
2. Activate the plugin through the `Plugins` menu in WordPress.

## Usage 
<h4>Register a Commentcode</h4>

Use the `add_commentcode()` function. It accepts two parameters.

1. (string) the commentcode tag.
2. (callable) a callback function which gets called when the commentcode of the specified tag is processed.

The callback function receives three parameters.

1. (string) The filtered text, usually an empty string.
2. (array) The attributes set in the commentcode.
3. (string) The commentcode tag name.

```php
function get_my_commentcode( $text, $arguments, $tag ) {
    return "<pre>" . htmlspecialchars( print_r( $arguments, true ) ) . "</pre>";
}
add_commentcode( 'my_commentcode', 'get_my_commentcode' );
```

For a test, while running the above code, try inserting `<!---my_commentcode Foo="bar" numbers[ 1 ]="one" numbers[ 2 ]="two"--->` in a post.

It will produce this output,
```php
Array
(
    [Foo] => bar
    [numbers] => Array
        (
            [1] => one
            [2] => two
        )

)
```

## Bugs ##
If you find an issue, let us know [here](https://github.com/michaeluno/commentcode-api/issues)!

## Support ##
This is a developer's portal for Commentcode API and should _not_ be used for support. Please visit the [support forums](http://wordpress.org/support/plugin/commentcode-api).

## Contributions ##
Anyone is welcome to contribute to Commentcode API.

There are various ways you can contribute:

1. Raise an [Issue](https://github.com/michaeluno/commentcode-api/issues) on GitHub.
2. Send us a Pull Request with your bug fixes and/or new features.
3. Provide feedback and suggestions on [enhancements](https://github.com/michaeluno/commentcode-api/issues?direction=desc&labels=Enhancement&page=1&sort=created&state=open).

## Supporting Future Development ##

If you like it, please rate and review it in the [WordPress Plugin Directory](http://wordpress.org/support/view/plugin-reviews/commentcode-api?filter=5). Also donation would be greatly appreciated. Thank you!

[![Donate with PayPal](https://www.paypal.com/en_US/i/btn/x-click-but04.gif)](http://en.michaeluno.jp/donate) 

## Copyright and License ##

### Commentcode API ###
Released under the [GPL v2](./LICENSE.txt) or later.
Copyright © 2015 [COPYRIGHT_HOLDER]

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.