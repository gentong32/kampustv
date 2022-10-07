<?php
//require_once "global.php";
//error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
$arg4 = $_GET['ver'];
$idMateri = $_GET['idmateri'];

ini_set("display_errors",0);

//$mp_basedir = $_SERVER['DOCUMENT_ROOT']."/file_storage/materi_pokok";
//$mp_basedir = "../file_storage/materi_pokok";
$mp_basedir = "../file_storage/pengetahuan_populer";
//$mp_basedir ="E:/XAMPP/htdocs/rumahbelajar/file_storage/pengetahuan_populer";
//echo $mp_basedir;
// ---------------------------------------------------------------------

if (empty($idMateri)) exit;

$mp_dir = "$mp_basedir/PP_$idMateri";
if (!is_dir($mp_dir)) 
{
mkdir($mp_dir, 0755);
//exit;
}
// check for zip dir
// if exists, remove all files and directories
// if not, create
$zip_dir = "$mp_dir/zip";
if (is_dir($zip_dir)) deleteAllFilesInFolder($zip_dir);
else mkdir($zip_dir, 0777);

// make '_files' directory in zip folder
$_files_dir = "$zip_dir/PP_files";
mkdir($_files_dir, 0777);



// populate all files in 'images' or 'flash' directory in mp_dir
// copy the files to '_files' directory in zip folder

$dh = opendir($mp_dir);
if($dh=="")
die();
while (false !== $file = readdir($dh)) {
  if (in_array($file, array('.', '..', 'zip'))) continue;
  $ekstensi=explode(".",$file);
  	if ($ekstensi[1]=="html") continue; 
	if (!is_dir("$mp_dir/$file"))
    copy("$mp_dir/$file", "$_files_dir/$file");
	
  if (is_dir("$mp_dir/$file"))
  { 
  $dh2 = opendir("$mp_dir/$file");
  while (false !== $file2 = readdir($dh2)) {
	$ekstensi=explode(".",$file2);
  	if ($ekstensi[1]=="html") continue; 
    if (in_array($file2, array('.','..'))) continue;
	if (!is_dir("$mp_dir/$file/$file2"))
    copy("$mp_dir/$file/$file2", "$_files_dir/$file2");
	
	if (is_dir("$mp_dir/$file/$file2"))
  	{ 
	$_files_dir2 = "$_files_dir/$file2";
	mkdir($_files_dir2, 0777);
  	$dh3 = opendir("$mp_dir/$file/$file2");
  	while (false !== $file3 = readdir($dh3)) {
		$ekstensi=explode(".",$file3);
  		if ($ekstensi[1]=="html") continue; 
    	if (in_array($file3, array('.','..'))) continue;
		if (!is_dir("$mp_dir/$file/$file2/$file3"))
    	copy("$mp_dir/$file/$file2/$file3", "$_files_dir2/$file3");
  	}
  	closedir($dh3);
	}
  }
  closedir($dh2);
  }
}

//copy("$mp_dir/$file/$file2", "$_files_dir/$file2");
copy("ajar.js","$_files_dir/ajar.js");
copy("special.css","$_files_dir/special.css");
copy("line_title.png","$_files_dir/line_title.png");
copy("logo_rumah_belajar.png","$_files_dir/logo_rumah_belajar.png");
copy("logoOER70.png","$_files_dir/logoOER70.png");
closedir($dh);


////////////////////////////////////////////////// JUDUL //////////////////////////////////////////////
if ($arg4=='11')
{
$database->query("SELECT NMmateripokok as judul FROM tmateripokok 
WHERE IDmateripokok=:fid");
}
else if ($arg4=='21')
{
$database->query("SELECT topik as judul FROM daftarmapok2 
WHERE iddaftarmapok=:fid"); 
}
else if ($arg4=='12')
{
$database->query("SELECT NMmodulonline as judul FROM tmodulonline 
WHERE IDmodulonline=:fid");
}
else if (($arg4=='22') || ($arg4=='32'))
{
$database->query("SELECT topik as judul FROM daftarmol2 
WHERE iddaftarmol=:fid");
}
else if ($arg4=='99')
{
$database->query("SELECT NMpengpop as judul FROM tpengpop 
WHERE IDpengpop=:fid");
}

$database->bind(':fid', $arg5);
$rows = $database->resultset();

$judul=$rows[0]['judul'];

/////////////////////////////////////////////////////////////////////////////



$content="ISI";

$html_content = $isizip;
$html_document = "$zip_dir/index.html";
$fh = fopen($html_document, 'w');
fputs($fh, $html_content);
fclose($fh);

for ($a=1;$a<=$jumlahbaris;$a++)
{
$html_content2 = $isizipx[$a-1];
$html_document2 = "$zip_dir/PP_files/konten".$a.".html";
$fh2 = fopen($html_document2, 'w');
fputs($fh2, $html_content2);
fclose($fh2);
};



// zip it up!!
// http://devzone.zend.com/article/2105

// create object
$zip = new ZipArchive();

// open archive 
if ($zip->open("$zip_dir/PP_".$idMateri."_files.zip", ZIPARCHIVE::CREATE) !== TRUE) {
    die ("Could not open archive");
}




// list of files to add
$fileList[] = array('full_path' => $html_document, 'local_path' => "index.html");
$dh = opendir($_files_dir);
while (false !== $file = readdir($dh)) {
  if (in_array($file, array('.', '..'))) continue;
  if (!is_dir("$_files_dir/$file"))
  $fileList[] = array('full_path' => "$_files_dir/$file", 'local_path' => "PP_files/$file");
  if (is_dir("$_files_dir/$file"))
  {
	  
	  $dh2 = opendir($_files_dir2);
		while (false !== $file2 = readdir($dh2)) {
  		if (in_array($file2, array('.', '..'))) continue;
		 if (!is_dir("$_files_dir2/$file2"))
  		$fileList[] = array('full_path' => "$_files_dir2/$file2", 'local_path' => "PP_files/$file/$file2");
		}
	closedir($dh2);
  }
}
closedir($dh);


// add files
foreach ($fileList as $id => $arr) {
    $zip->addFile($arr['full_path'], $arr['local_path']) or die ("ERROR: Could not add file: $f");   
}


// close and save archive
$zip->close();

//DELETE TEMP FOLDER and FILES
define('PATH', $mp_basedir.'/PP_'.$idMateri."/zip/PP_files/");
destroy(PATH);
rmdir($mp_basedir.'/PP_'.$idMateri."/zip/PP_files/");
unlink($mp_basedir.'/PP_'.$idMateri."/zip/index.html");

//LINK BACK PAGE
//echo "<p align=center>Archive created successfully. <a href='javascript:history.back()'>Go back</a>...</p>";    



// ---------------------------------------------------------------------
function destroy($dir) {
    $mydir = opendir($dir);
    while(false !== ($file = readdir($mydir))) {
        if($file != "." && $file != "..") {
            chmod($dir.$file, 0777);
            if(is_dir($dir.$file)) {
                chdir('.');
                destroy($dir.$file.'/');
                rmdir($dir.$file) or DIE("couldn't delete $dir$file<br />");
            }
            else
                unlink($dir.$file) or DIE("couldn't delete $dir$file<br />");
        }
    }
    closedir($mydir);
}

function deleteAllFilesInFolder($dir) {
  $dh = opendir($dir);
  while (false !== $file = readdir($dh)) {
    if (!in_array($file, array('.', '..'))) {
      if (is_dir("$dir/$file")) {
        deleteAllFilesInFolder("$dir/$file");
        rmdir("$dir/$file");
      } else {
        unlink("$dir/$file");
      }
    }
  }
  closedir($dh);
}

function cleanHTML($str) {
 $pattern = "/(style|class)=[\'\"](.*?)[\'\"]/i";
 $result = preg_match_all($pattern, $str, $match);
 $str = str_replace($match[0], "", $str);

 return $str;
}

function slug($str)
{
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}
?>