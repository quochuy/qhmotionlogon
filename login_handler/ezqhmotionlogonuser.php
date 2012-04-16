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

		//echo 'Points: ' . var_export($UnistrokePoints, true);
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
		
		//var_export($recognizer->)
		
		//echo $userUnistrokePoints;
		//exit;

		if ($result['strokeName'] != $login)
		{
			$user = false;
			eZLog::write("QH Motion Login: gesture password doesn't match");
		}
		/*

		 if( isset( $userDatamap['yubikeys'] )) {
		 $matrix = new eZMatrix( '' );
		 $matrix->decodeXML( $userDatamap['yubikeys']->attribute('data_text'));
		 $userRecordedUnistrokePointsOTPArray = $matrix->Matrix['columns']['sequential'][1]['rows'];
		 }

		 $userUseOTP4MultiFactor = $userDatamap['multifactor']->attribute('data_int');

		 $UnistrokePointsPrefix = substr($UnistrokePoints, 0, 12);

		 $recordedMatchedPrefixes = array();
		 foreach( $userRecordedUnistrokePointsOTPArray as $key => $userRecordedUnistrokePointsOTP ) {
		 if( $debugOutput ) eZLog::write( "Yubikey{$key}: {$userRecordedUnistrokePointsOTP}");
		 $recordedUnistrokePointsPrefix = substr( $userRecordedUnistrokePointsOTP, 0, 12 );
		 if( $UnistrokePointsPrefix == $recordedUnistrokePointsPrefix) {
		 if( $debugOutput ) eZLog::write( "key {$key}'s prefix matches" );
		 $recordedMatchedPrefixes[] = $key;
		 }
		 }

		 switch(true) {
		 // if the use's set to use OTP as multifactor
		 case ($userUseOTP4MultiFactor == 1):
		 if( $debugOutput ) eZLog::write("Multifactor: {$userUseOTP4MultiFactor}");
		 // if no key was submitted then don't allow login
		 if(empty($UnistrokePoints)) $user = self::REQUIRE_MULTIFACTOR;
		 // else return false to continue with the next login handler
		 else $user = false;
		 break;

		 // if there is an OTP recorded and not set to multifactor but no UnistrokePoints submitted then don't allow login
		 case (count($userRecordedUnistrokePointsOTPArray) && empty($UnistrokePoints)):
		 if( $debugOutput ) eZLog::write("OTP set, no multifactor, no UnistrokePoints received");
		 $user = self::REQUIRE_YUBIKEY_OTP;
		 break;

		 case (empty($UnistrokePoints)):
		 case (empty($recordedMatchedPrefixes)):
		 case (!count($userRecordedUnistrokePointsOTP)):
		 if( $debugOutput ) eZLog::write("Auth denied");
		 $user = false;
		 break;

		 default:
		 if( $debugOutput ) eZLog::write("Looks OK!");
		 break;
		 }
		 */

		return $user;
	}

}
?>
