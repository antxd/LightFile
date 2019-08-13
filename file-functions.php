<?php

/********************************
Simple LightFile
Copyright Jose Marin (antxd)
Liscense: MIT

Based on:
https://github.com/jcampbell1/simple-file-manager/
Simple PHP File Manager
Copyright John Campbell (jcampbell1)
Liscense: MIT
********************************/

//echo dirname(__FILE__);

//Disable error report for undefined superglobals
error_reporting( error_reporting() & ~E_NOTICE );

//Security options
$allow_delete = true; // Set to false to disable delete button and delete POST request.
$allow_upload = true; // Set to true to allow upload files
$allow_create_folder = true; // Set to false to disable folder creation
$allow_direct_link = true; // Set to false to only allow downloads and not direct link
$allow_show_folders = true; // Set to false to hide all subdirectories
$url_base = 'http://localhost:8888/LightFile/';

$disallowed_extensions = ['php'];  // must be an array. Extensions disallowed to be uploaded
$hidden_extensions = ['php']; // must be an array of lowercase file extensions. Extensions hidden in directory index

$PASSWORD = '';  // Set the password, to access the file manager... (optional)

// Add own security with MediaBack Logic

/*if($PASSWORD) {

	session_start();
	if(!$_SESSION['_sfm_allowed']) {
		// sha1, and random bytes to thwart timing attacks.  Not meant as secure hashing.
		$t = bin2hex(openssl_random_pseudo_bytes(10));
		if($_POST['p'] && sha1($t.$_POST['p']) === sha1($t.$PASSWORD)) {
			$_SESSION['_sfm_allowed'] = true;
			header('Location: ?');
		}
		echo '<html><body><form action=? method=post>PASSWORD:<input type=password name=p autofocus/></form></body></html>';
		exit;
	}
}
*/

// must be in UTF-8 or `basename` doesn't work
setlocale(LC_ALL,'en_US.UTF-8');

$tmp_dir = dirname($_SERVER['SCRIPT_FILENAME']);
if(DIRECTORY_SEPARATOR==='\\') $tmp_dir = str_replace('/',DIRECTORY_SEPARATOR,$tmp_dir);
$tmp = get_absolute_path($tmp_dir . '/' .$_REQUEST['file']);

if($tmp === false)
	err(404,'File or Directory Not Found');
if(substr($tmp, 0,strlen($tmp_dir)) !== $tmp_dir)
	err(403,"Forbidden");
if(strpos($_REQUEST['file'], DIRECTORY_SEPARATOR) === 0)
	err(403,"Forbidden");


if(!$_COOKIE['_sfm_xsrf'])
	setcookie('_sfm_xsrf',bin2hex(openssl_random_pseudo_bytes(16)));
if($_POST) {
	if($_COOKIE['_sfm_xsrf'] !== $_POST['xsrf'] || !$_POST['xsrf'])
		err(403,"XSRF Failure");
}

$file = $_REQUEST['file'] ?: '.';
//var_dump($file);
//var_dump($_REQUEST['file']);
if($_GET['do'] == 'list') {
	if (is_dir($file)) {
		$directory = $file;
		$result = [];
		//$files = array_diff(scandir($directory), ['.','..']);
		$files = array_diff(preg_grep('/^([^.])/', scandir($directory)), ['.','..']);
		foreach ($files as $entry) if (!is_entry_ignored($entry, $allow_show_folders, $hidden_extensions)) {
		$i = $directory . '/' . $entry;
		$stat = stat($i);
	        $result[] = [
	        	'mtime' => $stat['mtime'],
	        	'mtype' => mime_content_type($i),
	        	'size' => $stat['size'],
	        	'name' => basename($i),
	        	//'path' => preg_replace('@^\./@', '', $i),
	        	'path' => $entry,
	        	'url' => $url_base.$i,
	        	'urlenc' => urlencode($i),
	        	'is_dir' => is_dir($i),
	        	'is_deleteable' => $allow_delete && ((!is_dir($i) && is_writable($directory)) ||
                                                           (is_dir($i) && is_writable($directory) && is_recursively_deleteable($i))),
	        	'is_readable' => is_readable($i),
	        	'is_writable' => is_writable($i),
	        	'is_executable' => is_executable($i),
	        ];
	    }
	    echo "
	      <h4 class='lf_title'>Carpetas</h4>
	      <div class='lf_folders'>";

	            foreach ($result as $key => $lf_item) {
	                if ($lf_item['is_dir']) {
	                  echo '<div class="lf_folder" data-path="'.$lf_item['path'].'" data-folfer="'.$lf_item['urlenc'].'">
	                          <i class="lf_folder_icon fa fa-folder-o" aria-hidden="true"></i><span class="lf_folder_name">'.$lf_item['name'].'</span>
	                        </div>';
	                }
	            }
	        
	      echo "</div>
	      <h4 class='lf_title'>Archivos</h4>
	      <div class='lf_files'>";
	          foreach ($result as $key => $lf_item) {
	                if (!$lf_item['is_dir']) {
	                	$mime_images = array('image/png','image/jpeg','image/jpeg','image/jpeg','image/gif','image/bmp','image/vnd.microsoft.icon','image/tiff','image/tiff','image/svg+xml','svgz' => 'image/svg+xml');
	                	if(in_array($lf_item['mtype'],$mime_images)) {
	                		echo '
			                      <div class="lf_file" data-path="'.$lf_item['path'].'" data-fileurl="'.$lf_item['url'].'">
			                          <div class="lf_file_preview file_type" style="background-image: url('.$lf_item['url'].');"></div>
			                          <div class="lf_file_name_holder">
			                            <i class="lf_file_icon fa fa-file-o" aria-hidden="true"></i><span class="lf_file_name">'.$lf_item['name'].'</span>
			                          </div>
			                      </div>';
	                	}else{
	                		echo '
	                      <div class="lf_file" data-path="'.$lf_item['path'].'" data-fileurl="'.$lf_item['url'].'">
	                          <div class="lf_file_name_holder">
	                            <i class="lf_file_icon fa fa-file-o" aria-hidden="true"></i><span class="lf_file_name">'.$lf_item['name'].'</span>
	                          </div>
	                      </div>';
	                	}
	                  
	                }
	            }
	       
	    echo "</div>";
	} else {
		err(412,"Not a Directory");
	}
	//echo json_encode(['success' => true, 'is_writable' => is_writable($file), 'results' => $result]);
	exit;
} elseif ($_POST['do'] == 'delete') {
	if($allow_delete) {
		rmrf($file);
	}
	exit;
} elseif ($_POST['do'] == 'mkdir' && $allow_create_folder) {
	// don't allow actions outside root. we also filter out slashes to catch args like './../outside'
	$dir = $_POST['name'];
	$dir = str_replace('/', '', $dir);
	if(substr($dir, 0, 2) === '..')
	    exit;
	chdir($file);
	@mkdir($_POST['name']);
	exit;
} elseif ($_POST['do'] == 'upload' && $allow_upload) {
	foreach($disallowed_extensions as $ext)
		if(preg_match(sprintf('/\.%s$/',preg_quote($ext)), $_FILES['file_data']['name']))
			err(403,"Files of this type are not allowed.");

	$res = move_uploaded_file($_FILES['file_data']['tmp_name'], $file.'/'.$_FILES['file_data']['name']);
	exit;
} elseif ($_GET['do'] == 'download') {
	$filename = basename($file);
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	header('Content-Type: ' . finfo_file($finfo, $file));
	header('Content-Length: '. filesize($file));
	header(sprintf('Content-Disposition: attachment; filename=%s',
		strpos('MSIE',$_SERVER['HTTP_REFERER']) ? rawurlencode($filename) : "\"$filename\"" ));
	ob_flush();
	readfile($file);
	exit;
}

function is_entry_ignored($entry, $allow_show_folders, $hidden_extensions) {
	if ($entry === basename(__FILE__)) {
		return true;
	}

	if (is_dir($entry) && !$allow_show_folders) {
		return true;
	}

	$ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
	if (in_array($ext, $hidden_extensions)) {
		return true;
	}

	return false;
}

function rmrf($dir) {
	if(is_dir($dir)) {
		$files = array_diff(scandir($dir), ['.','..']);
		foreach ($files as $file)
			rmrf("$dir/$file");
		rmdir($dir);
	} else {
		unlink($dir);
	}
}
function is_recursively_deleteable($d) {
	$stack = [$d];
	while($dir = array_pop($stack)) {
		if(!is_readable($dir) || !is_writable($dir))
			return false;
		$files = array_diff(scandir($dir), ['.','..']);
		foreach($files as $file) if(is_dir($file)) {
			$stack[] = "$dir/$file";
		}
	}
	return true;
}

// from: http://php.net/manual/en/function.realpath.php#84012
function get_absolute_path($path) {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $parts = explode(DIRECTORY_SEPARATOR, $path);
        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

function err($code,$msg) {
	http_response_code($code);
	echo json_encode(['error' => ['code'=>intval($code), 'msg' => $msg]]);
	exit;
}

function asBytes($ini_v) {
	$ini_v = trim($ini_v);
	$s = ['g'=> 1<<30, 'm' => 1<<20, 'k' => 1<<10];
	return intval($ini_v) * ($s[strtolower(substr($ini_v,-1))] ?: 1);
}
$MAX_UPLOAD_SIZE = min(asBytes(ini_get('post_max_size')), asBytes(ini_get('upload_max_filesize')));

