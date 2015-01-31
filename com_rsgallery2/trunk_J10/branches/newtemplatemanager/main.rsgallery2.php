<?php
/**
* Main task switch for RSGallery2
* @version $Id$
* @package RSGallery2
* @copyright (C) 2003 - 2006 RSGallery2
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* RSGallery is Free Software
*/
defined( '_VALID_MOS' ) or die( 'Access Denied.' );

/**
 * this is the primary and default function
 * it loads a template to run
 * that template's rsgDisplay has a switch for $page to handle various features
 */
function template(){
	global $rsgConfig;

	//Set template selection
	$template = preg_replace( '#\W#', '', rsgInstance::getVar( 'rsgTemplate', $rsgConfig->get('template') ));
	$template = strtolower( $template );

	$templateLocation = RSG2_PATH_SITE . DS . 'templates' . DS . $template . DS . 'index.php';

	if( !file_exists( $templateLocation ))
		echo "rsgTemplate $template does not exist.<br/>Please select an existing template in the RSGallery2 Template Manager." ;
	else
		require( $templateLocation );
}

function xmlFile(){
	$template = preg_replace( '#\W#', '', rsgInstance::getVar( 'xmlTemplate', 'meta' ) );
	$template = strtolower( $template );
	
	// require generic template which all other templates should extend
	require_once( RSG2_PATH_SITE . DS . 'templates' . DS . 'meta' . DS . 'xml.php' );
	// require the template specified to be used
	require_once( RSG2_PATH_SITE . DS . 'templates' . DS . $template . DS . 'xml.php' );
	
	// prepare and output xml
	$xmlTemplate = "rsgXmlGalleryTemplate_$template";
	$xmlTemplate = new $xmlTemplate( rsgInstance::getGallery() );
	
	ob_start();
	$xmlTemplate->prepare();
	$output = ob_get_flush();
	
	$xmlTemplate->printHead();
	echo $output;
	
	// support older xml templates:
	$xmlTemplate->printGallery();	
	
	die();// quit now so that only the xml is sent and not the joomla template
}

/**
 * Forces a download box to download single images
 * Thanks to Rich Malak <rmalak@fuseideas.com>for his invaluable contribution
 * to this very important feature!
 * @param int Id of the file to download
 */
function downloadFile($id) {
	global $rsgConfig;
	//Clean and delete current output buffer 
	ob_end_clean();
	
	$gallery = rsgGalleryManager::getGalleryByItemID();
	$item = $gallery->getItem();
	$original = $item->original();
	$file = $original->filePath();
	
	//Open up the file
	if ( $fd = fopen($file, "r") ) {
	    $fsize 		= filesize($file);
	    $path_parts = pathinfo($file);
	    $ext 		= strtolower($path_parts["extension"]);
	    
	    //Check the extension and provide the right headers for the file
	    switch ($ext) {
	        case "pdf":
	        	header("Content-type: application/pdf"); // add here more headers for diff. extensions
	        	header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachement' to force a download
	        	break;
	        case "jpg":
	        	header("Content-type: image/jpeg");
	        	header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
	        	break;
	        case "gif":
	        	header("Content-type: image/gif");
	        	header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
	        	break;
	        case "png":
	        	header("Content-type: image/png");
	        	header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
	        	break;
	    	default:
	        	header("Content-type: application/octet-stream");
	        	header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
	    }
	    header("Content-length: $fsize");
	    header("Cache-control: private");
	    //Read the contents of the file
	    while(!feof($fd)) {
	        $buffer = fread($fd, 4096);
	        echo $buffer;
	    }
	}
	//Close file after use!
	fclose ($fd);
}
