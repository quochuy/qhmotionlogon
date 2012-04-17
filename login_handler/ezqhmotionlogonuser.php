<?php
//
// Created on: <16-Apr-2012 12:14:36>
//
// ## BEGIN COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
// SOFTWARE NAME: QH Motion Logon for eZ Publish
// COPYRIGHT NOTICE: Copyright (C) 2012-2013 NGUYEN DINH Quoc-Huy
// SOFTWARE LICENSE: GNU General Public License v2.0
// NOTICE: >
// This program is free software; you can redistribute it and/or
// modify it under the terms of version 2.0 of the GNU General
// Public License as published by the Free Software Foundation.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of version 2.0 of the GNU General
// Public License along with this program; if not, write to the Free
// Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
// MA 02110-1301, USA.
//
//
// ## END COPYRIGHT, LICENSE AND WARRANTY NOTICE ##
//

class eZQHMotionLogonUser extends eZUser {

	/*!
	 \static
	 Logs in the user if applied username and password is valid.
	 \return The user object (eZContentObject) of the logged in user or \c false if it failed.
	 */
	static function loginUser($login, $password, $authenticationMatch = false) {
		$debugOutput = true;
		$UnistrokePoints = array();
		$unistrokeString = $password;
		$unistrokesCoordinates = explode('/', $unistrokeString);

		foreach ($unistrokesCoordinates as $k => $unistrokeCoordinate) {
			list($x, $y) = explode(',', $unistrokeCoordinate);
			$UnistrokePoints[$k]['x'] = $x;
			$UnistrokePoints[$k]['y'] = $y;
		}

		if ($debugOutput)
			eZLog::write("Login handler, UnistrokePoints: {$UnistrokePoints}");

		$recognizer = new phpDollar();

		$user = eZUser::fetchByName($login);
		$userContentObject = eZContentObject::fetch($user -> attribute('contentobject_id'));
		$userDatamap = $userContentObject -> dataMap();
		list($userUnistrokePointString) = explode('&', $userDatamap['unistroke']->attribute('data_text'));
		//echo $userUnistrokePointString;
		
		$userUnistrokePointsCoordinates = explode('/', $userUnistrokePointString);
		$userUnistrokePoints = array();
		foreach($userUnistrokePointsCoordinates as $k=>$userUnistrokePointCoordinates) {
			list($x, $y) = explode(',', $userUnistrokePointCoordinates);
			$userUnistrokePoints[$k]['x'] = $x;
			$userUnistrokePoints[$k]['y'] = $y;
		}
		$recognizer->addTemplate(
						$login,
						$userUnistrokePoints
					 );
					 
		$result = $recognizer -> recognizeStroke($UnistrokePoints);
		
		//var_export($result); exit;
		
		if ($result['strokeName'] != $login || $result['strokeScore'] < 3.1)
		{
			$user = false;
			eZLog::write("QH Motion Login: gesture password doesn't match");
		}

		return $user;
	}

}
?>