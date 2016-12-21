<?php

/**
 * Stores callabcks for commentcodes.
 * @since       0.3.0
 * @deprecated
 */
class CommentcodeAPI_Callable {

    static private $___aCallables = array();

    /**
     * @since 0.3.0
     * @param string     $sTag
     * @param callable   $aosCallable
     * @rturn void
     */
    static public function add( $sTag, $aosCallable ) {
        self::$___aCallables[ $sTag ] = $aosCallable;
    }

    /**
     * @since   0.3.0
     * @param   string    $sTag
     * @return  callable|null
     */
    static public function get( $sTag ) {
        return isset( self::$___aCallables[ $sTag ] )
            ? self::$___aCallables[ $sTag ]
            : null;
    }

}