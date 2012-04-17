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

class YubiKeyOTPInfo
{
    static function info()
    {
        return array(
            'Name' => "QH Motion Logon",
            'Version' => "1.0alpha02",
            'Author' => "<a href='http://www.quoc-huy.com/'>Quoc-Huy</a>",
            'Copyright' => "Copyright (C) 2012, Quoc-Huy NGUYEN DINH",
            'License' => "GNU General Public License v2.0",
            'Includes the following third-party software' => array(
            													array(
            														'Name' => 'phpDollar',
                                                                    'Version' => '',
                                                                    'License' => "",
                                                                    'For more information' => 'http://codebringer.net/projects/phpdollar/'
                                                                ),
                                                                
																array(
            														'Name' => 'jQuery Motion Captcha',
                                                                    'Version' => '0.2',
                                                                    'License' => "",
                                                                    'For more information' => 'http://www.josscrowcroft.com/projects/motioncaptcha-jquery-plugin/'
                                                                )
                                                             )
        );
    }
}
?>