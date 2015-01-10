<?php
/**
 *
 * PiDeploy - magic php build machine
 *
 * carlo "blackout" denaro
 *
 */

include 'inc.config.php';

//
// exec -> svn
//
$cmd 	= '2>&1 svn update '.$path.'/'.$repo.' --non-interactive --config-dir '.$home.'/.subversion --username '.$user.' --password '.$pass;
$o	= shell_exec( $cmd ); 
//
// print
//
if( preg_match('/At revision/', $o ) ) {
	$rev = explode(' ',$o);
	echo '{ "status" : "revisioned", "version" : '.str_replace('.','',$rev[2]).', "url" : "'.$url.$repo.'/src/" }';
}else{
	echo '{ "status" : "updated", "version" : "", "message" : "'.$o.'" }';
}

$obj 	= json_decode( trim( file_get_contents( $path.'/'.$repo.'/build.json') ) );
$repo	= trim($repo);

//
// config replace from demo.FILE -> to -> FILE
//
foreach( $obj->$repo->config as $kk => $vv ) {
	if( !copy( $path.'/'.$repo.$vv.'demo.'.$kk, $path.'/'.$repo.$vv.$kk ) )
		echo 'non copiato';
}

//
// sass compile
//
/* #TODO
foreach( $obj->$repo->css as $kk => $vv ) {
	$cmd 	= 'sass '.$path.'/'.$repo.$vv.$kk. ' ' . $path.'/'.$repo.$vv.'compiled.'.$kk;
	//$o	= shell_exec( $cmd );
}
*/


// -- eof
?>
