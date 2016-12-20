=== Commentcode API ===
Contributors:       [COPYRIGHT_HOLDER], miunosoft
Donate link:        http://en.michaeluno.jp/donate
Tags:               template, plugin
Requires at least:  3.4
Tested up to:       4.7.0
Stable tag:         1.0.0
License:            GPLv2 or later
License URI:        http://www.gnu.org/licenses/gpl-2.0.html

A shortcode API alternative.

== Description ==

<h4>Generate Custom Outputs with HTML Comments</h4>
Commentcode API is an open source WordPress plugin that lets you generate custom outputs with HTML comment-like codes.

It is similar to the [shortcode API](https://codex.wordpress.org/Shortcode_API) except it takes a form of HTML comments.

This way even the user disables your plugin, the embedded code will not be visible, on contrary to shortcodes that remain in posts when their plugins are deactivated.

<h4>Does not leave a mess in posts</h4>
Say, you have been using a plugin that converts a plugin specific shortcode into custom outputs. Later you found something else that is more useful and uninstalled it.

But the shortcodes used by that plugin remained in hundreds of posts and it was too much work to manually delete them so you have to ask somebody to run SQL commands.

That's a problem. What if the shortcode takes a form of a HTML comment? It won't leave such a mess.

<h4>Simple</h4>
It looks like this.
`
<!--- tag foo="bar" --->
`

Notice that tripe dashes are used in the both opening and closing part. So it won't hardly conflict with generic HTML comments.

<h4>Supports Multi-dimensional Array Arguments</h4>
The shortcode cannot pass multi-dimensional arguments to the callback function.

`
[my_shortcode foo[1]="one" foo[2]="two"]
`

However, commentcode can handle it.
`
<!---my_shortcode foo[1]="one" foo[2]="two" --->
`
The arguments are interpreted as
`
array(
    'foo'   => array(
        1 => 'one',
        2 => 'two',
    )
)
`

<h4>Preserved Cases</h4>
The shortcode does not allow capitalized argument names.

`
[my_shortcode CapitalName="I need it to be capitalized"]
`
The argument is interpreted as
`
array(
    'capitalname' => 'I need it to be capitalized',
)
`
This is not useful when you need to perform remote API requests which require argument names with capital letters.

However, the commentcode API preserves those argument names.

`
<!--- my_shortcode CapitalName="Please keep capitalization!" --->
`
will be
`
array(
    'CapitalName'   => 'Please keep capitalization!',
)
`

== Installation ==

1. Upload **`commentcode-api.php`** and other files compressed in the zip folder to the **`/wp-content/plugins/`** directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently asked questions ==
<h4>The commentcode inserted in a post does not get converted. What's the problem?</h4>
Double check you insert it in the `View` panel of the editor.

== Other Notes ==

<h4>Register a Commentcode</h4>

Use the `add_commentcode()` function. It accepts two parameters.
1. (string) the commentcode tag.
2. (callable) a callback function which gets called when the commentcode of the specified tag is processed.

The callback function receives two parameters.
1. (string) The filtered text, usually an empty string.
2. (array) The attributes set in the commentcode.
`
function get_my_commentcode( $text, $arguments ) {
    return "<pre>" . htmlspecialchars( print_r( $arguments, true ) ) . "</pre>";
}
add_commentcode( 'my_commentcode', 'get_my_commentcode' );
`

Or use the `add_filter()` function with the filter name of `commentcode_tag_{your commentcode tag name}`.

The callback function receives two parameters.
1. (string) The filtered text, usually an empty string.
2. (array) The attributes set in the commentcode.
`
function get_my_commentcode( $text, $arguments ) {
    return "<pre>" . htmlspecialchars( print_r( $arguments, true ) ) . "</pre>";
}
add_filter( 'commentcode_tag_' . 'my_commentcode', 'get_my_commentcode', 10, 2 );
`

For a test, while running the above code, try inserting `<!---my_commentcode Foo="bar" numbers[ 1 ]="one" numbers[ 2 ]="two"--->` in a post.

It will produce this output,
`
Array
(
    [Foo] => bar
    [numbers] => Array
        (
            [1] => one
            [2] => two
        )

)
`

== Changelog ==

= 1.0.0 =
- Released. 
