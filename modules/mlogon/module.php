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

$Module = array( 'name' => 'QH Motion Logon',
                 'variable_params' => true );

$ViewList = array();

$ViewList['login'] = array(
    'functions' => array( 'login' ),
    'script' => 'login.php',
    'ui_context' => 'authentication',
    'default_action' => array( array( 'name' => 'Login',
                                      'type' => 'post',
                                      'parameters' => array( 'Login',
                                                             'Password' ) ) ),
    'single_post_actions' => array( 'LoginButton' => 'Login' ),
    'post_action_parameters' => array( 'Login' => array( 'UserLogin' => 'Login',
                                                         'UserPassword' => 'Password',
                                                         'UniStroke' => 'UniStroke',
                                                         'UserRedirectURI' => 'RedirectURI' ) ),
    'params' => array( ) );
	
$ViewList['test'] = array(
    'functions' => array( 'login' ),
    'script' => 'test.php',
    'ui_context' => 'authentication',
    'params' => array( ) );
	
$ViewList['testprocess'] = array(
    'functions' => array( 'login' ),
    'script' => 'testprocess.php',
    'ui_context' => 'authentication',
    'default_action' => array( array( 'name' => 'Login',
                                      'type' => 'post',
                                      'parameters' => array( 'Login',
                                                             'Password' ) ) ),
    'single_post_actions' => array( 'LoginButton' => 'Login' ),
    'post_action_parameters' => array( 'Login' => array( 'UserLogin' => 'Login',
                                                         'UserPassword' => 'Password',
                                                         'UniStroke' => 'UniStroke',
                                                         'UserRedirectURI' => 'RedirectURI' ) ),
    'params' => array( ) );


$SiteAccess = array(
    'name'=> 'SiteAccess',
    'values'=> array(),
    'path' => 'classes/',
    'file' => 'ezsiteaccess.php',
    'class' => 'eZSiteAccess',
    'function' => 'siteAccessList',
    'parameter' => array()
    );

$FunctionList = array();
$FunctionList['login'] = array( 'SiteAccess' => $SiteAccess );

?>
