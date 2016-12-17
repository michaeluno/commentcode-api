<?php

/**
 * A comentcode parser.
 * @since   0.1.0
 */
class CommentcodeAPI_Parser {

    private $___sString = '';

    /**
     * @param   string  $sString
     * @since   0.1.0
     */
    public function __construct( $sString ) {
        $this->___sString = $sString;
    }

    /**
     * Returns the contents with processed commentcodes.
     * @since       0.1.0
     * @return      array
     */
    public function get() {
        return preg_replace_callback(
            '/<!---\s*?(\w.*?)--->/',   // matches with text like `<!--- foo bar="abc" --->`.
            array( $this, '___replyToReplaceCommentCode' ),
            $this->___sString
        );
    }
        /**
         * @param       array   $aMatches
         * @since       0.1.0
         * @callback    function    preg_replace_callback
         * @return      string
         */
        private function ___replyToReplaceCommentCode( $aMatches ) {
            $_sCommentCode  = trim( $aMatches[ 1 ] );
            $_aParts        = $this->___getParts( $_sCommentCode );
            $_sAttributes   = $_aParts[ 'attributes' ];
            $_aArguments    = $this->___getArguments( $_sAttributes );
            $_sWPFilterName = 'commentcode_tag_' . $_aParts[ 'tag' ];
            return has_filter( $_sWPFilterName )
                ? apply_filters( $_sWPFilterName, $_aArguments, $_aParts[ 'tag' ] )
                : '';
        }
            /**
             * @since  0.1.0
             * @param  string $sCommentCode
             * @return array
             */
            private function ___getParts( $sCommentCode ) {
                $_aResult = array(
                    'tag'        => '',
                    'attributes' => '',
                );
                $_aParts                  = explode( ' ', $sCommentCode );
                $_aResult[ 'tag' ]        = array_shift( $_aParts );
                $_aResult[ 'attributes' ] = implode( ' ', $_aParts );
                return $_aResult;
            }

            /**
             * @since   0.1.0
             * @param   string      $sAttributes
             * @see     http://stackoverflow.com/questions/1017051/php-to-extract-a-string-from-double-quote/7123361#7123361
             * @return  array       An argument array.
             */
            private function ___getArguments( $sAttributes ) {

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
                 * @since       0.1.0
                 * @return      string
                 */
                private function ___replyToGetTemporaryReplacement( $aMatches ) {
                    $_sKey = '___TEMPORARY_REPLACEMENT_' . $this->___iReplacementIndex . '___';
                    $this->___aTemporaryReplacements[ $_sKey ] = $this->___getAttributeValueSanitized( $aMatches[ 1 ] );
                    $this->___iReplacementIndex++;
                    return $_sKey;
                }
                    /**
                     * @since       0.1.0
                     * @return      string
                     */
                    private function ___getAttributeValueSanitized( $sString ) {
                        return urlencode( $sString );
                    }

}