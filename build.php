<?php
/**
 * magic php build machine
 *
 * carlo "blackout" denaro
 *
 *
 */

// parameters
//
$user 	= 'dabsvn';
$pass 	= '\$svn11';
$home 	= '/home/pro_dab/';
$path 	= $home.'dev.dab.name';
$repo 	= addslashes( $_GET['r'] );
//
// exec
//
$cmd 	= '2>&1 svn update '.$path.'/'.$repo.' --non-interactive --config-dir '.$home.'/.subversion --username '.$user.' --password '.$pass;
$o	= shell_exec( $cmd ); 
//
// print
//
if( preg_match('/At revision/', $o ) ) {
	$rev = explode(' ',$o);
	echo '{ "status" : "revisioned", "version" : '.str_replace('.','',$rev[2]).' }';
}else{
	echo '{ "status" : "updated", "version" : "", "message" : "'.$o.'" }';
}
	$obj 	= json_decode( trim( file_get_contents( $path.'/'.$repo.'/build.json') ) );
	$repo	= trim($repo);

	foreach( $obj->$repo as $k=>$v) {
		if( !copy( $path.'/'.$repo.$v.'demo.'.$k, $path.'/'.$repo.$v.$k ) )
			echo 'non copiato';
	}
//
// -- eof
?>
