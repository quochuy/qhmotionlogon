<?php
/**
 * QH Motion Logon extension for eZ Publish
 * Written by NGUYEN DINH Quoc-Huy <contact@quoc-huy.com>
 * Copyright (C) 2012, NGUYEN DINH Quoc-Huy.  All rights reserved.
 * http://www.quoc-huy.com/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 **/

// Define the name of datatype string
define( "EZ_DATATYPESTRING_QHMOTIONLOGON", "qhmotionlogon" );

class QHMotionLogonType extends eZDataType {
    /*!
     Construction of the class, note that the second parameter in eZDataType
     is the actual name showed in the datatype dropdown list.
     */
    function QHMotionLogonType( )
    {
        $this->eZDataType( EZ_DATATYPESTRING_QHMOTIONLOGON, "Gesture Password" );
    }

    /*!
     Validates the input and returns true if the input was valid for this
     datatype. Here you could add special rules for validating email.
     Parameter $http holds the class object eZHttpTool which has functions to
     fetch and check http input. Parameter $base holds the base name of http
     variable, in this case the base name will be 'ContentObjectAttribute'.
     Parameter $objectAttribute holds the attribue object.
     */
    function validateObjectAttributeHTTPInput( $http, $base, $objectAttribute )
    {

        if ( $http->hasPostVariable( $base . '_data_text_' . $objectAttribute->attribute( 'id' ) ) )
        {
            $unistrokeString = &$http->postVariable( $base . '_data_text_' . $objectAttribute->attribute( 'id' ) );
            $classAttribute = &$objectAttribute->contentClassAttribute( );

            if ( $unistrokeString == "" )
            {
                if ( $classAttribute->attribute( "is_required" ) == true )
                {
                    $objectAttribute->setValidationError( ezi18n( 'content/datatypes', 'You need to draw a password.', 'eZQHMotionLogonType' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
            else
            {
                $unistrokesCoordinates = explode( '/', $unistrokeString );

                foreach ( $unistrokesCoordinates as $k => $unistrokeCoordinate )
                {
                    list( $x, $y ) = explode( ',', $unistrokeCoordinate );
                    $unistrokePoints[$k]['x'] = $x;
                    $unistrokePoints[$k]['y'] = $y;
                }

                $recognizer = new phpDollar( );
                $result = $recognizer->recognizeStroke( $unistrokePoints );

                eZLog::write( var_export( $result, true ) );
            }

        }
        return eZInputValidator::STATE_ACCEPTED;
    }

    /*!
     Fetches the http post var string input and stores it in the data instance.
     */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $data = $http->postVariable( $base . "_data_text_" . $contentObjectAttribute->attribute( "id" ) );
            $contentObjectAttribute->setAttribute( "data_text", $data );
            return true;
        }
        return false;
    }

    /*!
     Store the content. Since the content has been stored in function
     fetchObjectAttributeHTTPInput(), this function is with empty code.
     */
    function storeObjectAttribute( $objectAttribute )
    {
    }

    /*!
     Returns the content.
     */
    function objectAttributeContent( $objectAttribute )
    {
        return $objectAttribute->attribute( "data_text" );
    }

    /*!
     Returns the meta data used for storing search indices.
     */
    function metaData( $objectAttribute )
    {
        return $objectAttribute->attribute( "data_text" );
    }

    /*!
     Returns the text.
     */
    function title( $objectAttribute, $name = null )
    {
        return $objectAttribute->attribute( "data_text" );
    }

}

eZDataType::register( EZ_DATATYPESTRING_QHMOTIONLOGON, "qhmotionlogontype" );
?>