<?php
//
// title
//
define( TITLE, 'PiDeploy' );
//
// parameters
//
$user 	= 'username';	// svn username
$pass 	= 'password';	// svn password
$home 	= '/home/user/';// your home
$path 	= $home.'path';	// your svn path
$url	= 'http://your.repo/'; // your repo url
//
//
//
$repo 	= addslashes( $_GET['r'] );

// -- eof
?>
