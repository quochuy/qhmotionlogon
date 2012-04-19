QH Motion Logon extension for eZ Publish
========================================

#Introduction
Inspired by the recently released Stride app for Jailbroken iPhone, QH Motion Logon allows you to login into your eZ Publish backend by drawing your password with the mouse instead of typing. It is using some code from jQuery Motion Captcha and phpDollar a PHP implementation of $1 Unistroke Recognizer algorithm.

# The idea
If you have a jailbroken iPhone, you can try to install Stride from Cydia. It overrides the lockscreen numeric pad and allows you to unlock your device by drawing a doodle.

I thought this could be useful for login into eZ Publish or at least fun to implement. The extension could be use to allow access to the CMS on mobile devices. For desktop terminals I'm not sure if this should be used as a replacement to the standard login handler.

# Security
I haven't done any security analysis on the use of a Unistroke recognizer as a login process.

On a mobile device this should be fairly good but on a desktop, because the doodle is visible to anyone seeing the computer monitor, the security is not as good. Maybe by using white ink on white background this could improve the thing. But one could definitely use it in combination with the standard login handler or my other extension QH YubiKey, but this is not yet supported as per the current version of QH Motion Logon.

# Installation
1. Install the ezpackage
2. Edit 'user' class and add a new Gesture Password attribute with identifier=unistroke
3. Enable the extension in site.ini
4. Generate autoloads
5. Clear caches

# Suggestions for installation
For security, unless you have already done an audit and it is safe for your use, it is currently wiser to use this
authentication method for mobile access only.

You could create a siteaccess, if not already done, for mobile access and enable the extension inside
your siteaccess' site.ini.append.php via ActiveAccessExtensions[]
