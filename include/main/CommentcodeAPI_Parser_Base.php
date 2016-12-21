<?php

/**
 * A base class of comentcode parsers.
 *
 * @since   0.3.0
 */
abstract class CommentcodeAPI_Parser_Base {

    protected $_sRegularExpressionPattern = '//';

    protected $_sString = '';

    /**
     * @param   string  $sString
     * @since   0.3.0
     */
    public function __construct( $sString ) {
        $this->_sString                   = $sString;
        $this->_sRegularExpressionPattern = $this->_getRegularExpressionPattern();
    }

    /**
     * @since       0.3.0
     * @return      string
     */
    protected function _getRegularExpressionPattern() {
        return '//';
    }

    /**
     * @since       0.3.0
     */
    public function hasCommentcode( $sTag ) {
        if ( false === strpos( $this->_sString, '<!---' ) ) {
       		return false;
       	}
        if ( ! has_filter( 'commentcode_tag_' . $sTag ) ) {
            return false;
        }
        preg_match_all( $this->_getRegularExpressionPattern(), $this->_sString, $_aMatches, PREG_SET_ORDER );
        if ( empty( $_aMatches ) ) {
            return false;
        }
        return $_aMatches[ 'tag' ] === $sTag;
    }

    /**
     * Returns the contents with processed commentcodes.
     * @since       0.3.0
     * @return      array
     */
    public function get() {
        return $this->_getTextParsed( $this->_sString );
    }

    /**
     * @param       string  $sText
     * @return      string
     * @since       0.3.0
     */
    protected function _getTextParsed( $sText ) {
        $sText = preg_replace_callback(
            $this->_sRegularExpressionPattern,
            array( $this, '_replyToReplaceCommentcode' ),
            $sText
        );
        return $sText;
    }

    /**
     * @param       array   $aMatches
     * @since       0.3.0
     * @callback    function    preg_replace_callback
     * @return      string
     */
    protected function _replyToReplaceCommentcode( $aMatches ) {
        return $aMatches[ 0 ];
    }

    /**
     * @since   0.3.0
     * @param   string      $sAttributes
     * @see     http://stackoverflow.com/questions/1017051/php-to-extract-a-string-from-double-quote/7123361#7123361
     * @return  array       An argument array.
     */
    protected function _getArguments( $sAttributes ) {

        // Replace values enclosed in quotes.
        $sAttributes = preg_replace_callback(
            "/(?:(?:\"((?:\\\\\"|[^\"])*)\")|(?:'((?:\\\'|[^'])*)'))/",
            array( $this, '___replyToGetTemporaryReplacement' ),
            $sAttributes
        );

        // Divide the string attributes into pieces.
        $_aKeyValuePairs = preg_split(
            '/(?<!\=)\s+(?!\=)/', // regex pattern
            $sAttributes,  // subject
            -1, // limit - no limit
            PREG_SPLIT_NO_EMPTY     // flags - omit empty elements
        );

        // Sanitize the construct. a = abc -> a=abc
        foreach( $_aKeyValuePairs as &$_sKeyValuePairs ) {
            $_sKeyValuePairs = preg_replace(
                '/(\s+)?\=(\s+)?/', // search
                '=',    // replace
                $_sKeyValuePairs    // subject
            );
        }

        // Restore the evacuated values.
        $_aKeyValuePairs = str_replace(
            array_keys( $this->___aTemporaryReplacements ), // search
            $this->___aTemporaryReplacements,
            $_aKeyValuePairs
        );

        // Pretend it like a url query string and leave it to `parse_str()`.
        parse_str( implode( '&', $_aKeyValuePairs ), $_aArguments );
        return stripslashes_deep( $_aArguments );

    }
        private $___iReplacementIndex = 0;
        private $___aTemporaryReplacements = array();
        /**
         * @since       0.3.0
         * @return      string
         */
        private function ___replyToGetTemporaryReplacement( $aMatches ) {
            $_sKey = '___TEMPORARY_REPLACEMENT_' . $this->___iReplacementIndex . '___';
            $this->___aTemporaryReplacements[ $_sKey ] = $this->___getAttributeValueSanitized( $aMatches[ 1 ] );
            $this->___iReplacementIndex++;
            return $_sKey;
        }
            /**
             * @since       0.3.0
             * @return      string
             */
            private function ___getAttributeValueSanitized( $sString ) {
                return urlencode( $sString );
            }

}