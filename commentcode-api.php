<?php
/**
 * Plugin Name:     Commentcode API
 * Plugin URI:      http://en.michaeluno.jp/commentcode-api
 * Description:     A shortcode alternative API.
 * Version:         0.3.0
 * Author:          Michael Uno
 * Author URI:      http://en.michaeluno.jp
 * License:         GPL2 or Later
 */

/**
 * Provides the basic information about the plugin.
 *
 * @since    0.1.0
 */
class CommentcodeAPI_Registry_Base {

    const VERSION        = '0.3.0';    // <--- DON'T FORGET TO CHANGE THIS AS WELL!!
    const NAME           = 'Commentcode API';
    const DESCRIPTION    = 'A shortcode alternative API.';
    const URI            = 'http://en.michaeluno.jp/commentcode-api';
    const AUTHOR         = 'Michael Uno';
    const AUTHOR_URI     = 'http://en.michaeluno.jp/';
    const PLUGIN_URI     = 'http://en.michaeluno.jp/commentcode-api';
    const COPYRIGHT      = 'Copyright (c) 2016, Michael Uno';
    const LICENSE        = 'GPLv2 or later';
    const CONTRIBUTORS   = '';

}

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

/**
 * Provides the common data shared among plugin files.
 *
 * To use the class, first call the setUp() method, which sets up the necessary properties.
 *
 * @package     Commentcode API
 * @since       0.0.1
 */
final class CommentcodeAPI_Registry extends CommentcodeAPI_Registry_Base {

    const TEXT_DOMAIN               = 'commentcode-api';
    const TEXT_DOMAIN_PATH          = '/language';

    /**
     * The hook slug used for the prefix of action and filter hook names.
     *
     * @remark      The ending underscore is not necessary.
     */
    const HOOK_SLUG                 = 'ccapi';    // without trailing underscore

    /**
     * The transient prefix.
     *
     * @remark      This is also accessed from uninstall.php so do not remove.
     * @remark      Up to 8 characters as transient name allows 45 characters or less ( 40 for site transients ) so that md5 (32 characters) can be added
     */
    const TRANSIENT_PREFIX          = 'CCAPI';

    /**
     *
     * @since       0.0.1
     */
    static public $sFilePath;

    /**
     *
     * @since       0.0.1
     */
    static public $sDirPath;

    /**
     * @since    0.0.1
     */
    static public $aOptionKeys = array(
        'setting'           => 'commentcode_api',
    );

    /**
     * Represents the plugin options structure and their default values.
     * @var         array
     * @since       0.0.3
     */
    static public $aOptions = array(
    );

    /**
     * Used admin pages.
     * @since    0.0.1
     */
    static public $aAdminPages = array(
    );

    /**
     * Used post types.
     */
    static public $aPostTypes = array(
    );

    /**
     * Used post types by meta boxes.
     */
    static public $aMetaBoxPostTypes = array(
    );

    /**
     * Used taxonomies.
     * @remark
     */
    static public $aTaxonomies = array(
    );

    /**
     * Used shortcode slugs
     */
    static public $aShortcodes = array(
    );

    /**
     * Stores custom database table names.
     * @remark      The below is the structure
     * array(
     *      'slug (part of database wrapper class file name)' => array(
     *          'version'   => '0.1',
     *          'name'      => 'table_name',    // serves as the table name suffix
     *      ),
     *      ...
     * )
     * @since       0.0.3
     */
    static public $aDatabaseTables = array(
    );

    /**
     * Sets up class properties.
     * @return      void
     */
    static function setUp( $sPluginFilePath ) {
        self::$sFilePath = $sPluginFilePath;
        self::$sDirPath  = dirname( self::$sFilePath );
    }

    /**
     * @return      string
     */
    public static function getPluginURL( $sRelativePath='' ) {
        if ( isset( self::$_sPluginURLCache ) ) {
            return self::$_sPluginURLCache . $sRelativePath;
        }
        self::$_sPluginURLCache = trailingslashit( plugins_url( '', self::$sFilePath ) );
        return self::$_sPluginURLCache . $sRelativePath;
    }
    /**
     * @since    0.0.1.1.6
     */
    static private $_sPluginURLCache;

    /**
     * Requirements.
     * @since    0.0.1
     */
    static public $aRequirements = array(
        'php' => array(
            'version'   => '5.2.4',
            'error'     => 'The plugin requires the PHP version %1$s or higher.',
        ),
        'wordpress'         => array(
            'version'   => '3.4',
            'error'     => 'The plugin requires the WordPress version %1$s or higher.',
        ),
        // 'mysql'             => array(
        // 'version'   => '5.0.3', // uses VARCHAR(2083) 
        // 'error'     => 'The plugin requires the MySQL version %1$s or higher.',
        // ),
        'functions'     => '', // disabled
        // array(
        // e.g. 'mblang' => 'The plugin requires the mbstring extension.',
        // ),
        // 'classes'       => array(
        // 'DOMDocument' => 'The plugin requires the DOMXML extension.',
        // ),
        'constants'     => '', // disabled
        // array(
        // e.g. 'THEADDONFILE' => 'The plugin requires the ... addon to be installed.',
        // e.g. 'APSPATH' => 'The script cannot be loaded directly.',
        // ),
        'files'         => '', // disabled
        // array(
        // e.g. 'home/my_user_name/my_dir/scripts/my_scripts.php' => 'The required script could not be found.',
        // ),
    );

}
CommentcodeAPI_Registry::setUp( __FILE__ );

/**
 * Loads plugin components.
 * @since   0.1.0
 */
class CommentcodeAPI_Bootstrap {
    /**
     * Performs necessary set-ups.
     * @since       0.1.0
     */
     public function __construct() {
         include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Callable.php' );
         include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Main.php' );
         include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Parser_Base.php' );
         include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Parser_SelfClosing.php' );
         include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Parser_Enclosing.php' );
         include( dirname( __FILE__ ) . '/include/function/functions.php' );
         new CommentcodeAPI_Main;
         add_action( 'plugins_loaded', array( $this, 'replyToLoadPluginComponents' ) );
     }

    /**
     * @callback    action      plugins_loaded
     * @since       0.1.0
     */
     public function replyToLoadPluginComponents() {

         if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
             include( dirname( __FILE__ ) . '/include/main/CommentcodeAPI_Sample.php' );
             new CommentcodeAPI_Sample( 'commentcode_selfclosing' );
             new CommentcodeAPI_Sample( 'commentcode_enclosing' );
         }
     }

}
new CommentcodeAPI_Bootstrap;
