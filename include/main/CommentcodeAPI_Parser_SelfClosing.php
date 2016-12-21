<?php

/**
 * A self-closing commentcode parser.
 *
 * ```
 * <!--- my_commentcode color="#FFF" name="white" --->
 * ```
 *
 * @since   0.1.0
 */
class CommentcodeAPI_Parser_SelfClosing extends CommentcodeAPI_Parser_Base {

    /**
     * @since       0.3.0
     * @return      string
     */
    protected function _getRegularExpressionPattern() {
        return '/<!---\s*?(?P<tag>\w+)\s*(?P<attr>.*?)\s*?--->/';
    }

    /**
     * @param       array   $aMatches
     * @since       0.3.0
     * @callback    function    preg_replace_callback
     * @return      string
     */
    protected function _replyToReplaceCommentcode( $aMatches ) {
        return apply_filters(
            'commentcode_tag_' . $aMatches[ 'tag' ],        // filter hook name
            '',                                             // 1st parameter: string to be filtered
            $this->_getArguments( $aMatches[ 'attr' ] ),    // 2st parameter - attributes
            $aMatches[ 'tag' ]                              // 3rd parameter - the commentcode tag
        );
    }

}