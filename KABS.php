<?php /* 
KABS (Kevin's Automatic Backup System) see also: http://blog.hirephp.com/php/files-copy-from-one-folder-to-another-folder-using-php.html

Copyright 2015, Median Koding MIT & GPL
*/

$Source = getcwd(); // Change this to folder that will be backed up (no trailing slash)
$KABS = '../backup'; // Change this to folder that holds backed up content (no trailing slash)

// Automatically creates the .txt time file
if (!file_exists('KABS_time.txt')){
    file_put_contents('KABS_time.txt', null);
	chmod('KABS_time.txt', 0755);
}

// Automatically creates the JSON file with file/folder timestamps
if (!file_exists('KABS_array.json')){
    file_put_contents('KABS_array.json','[]');
	chmod('KABS_array.json', 0755);
}

// Automatically creates the backup folder
if (!is_dir($KABS)){
    mkdir($KABS,null);
	chmod($KABS, 0755);
} 


$Past = file_get_contents('KABS_time.txt',true); 
$JD = json_decode(file_get_contents("KABS_array.json"),true);

if ( time() >= $Past+(60*1440) ){ // Checks to see if the timestamp is older than a day
	echo 'Backing up';
    copyfiles($Source,$KABS);
    $A_arr=json_encode($arr); 
    file_put_contents('KABS_time.txt',time()); // Replaces the old timestamp
    file_put_contents('KABS_array.json',$A_arr); // Replaces the old JSON 
}
 
function copyfiles($source,$backup){
    global $arr;
    global $JD;
    if (is_dir($source)){
        $dh = opendir($source);
        $file = readdir($dh);
        while (($file = readdir($dh)) !==false){
            if ($file==".")continue; // skipping
            if ($file=="..")continue; // skipping
            if ($file=="desktop.ini")continue; // skipping               
            if (preg_match("/\./",$file)){ // This is a file
                $arr[$source.'/'.$file] = filemtime($source.'/'.$file); 
                if ($arr[$source.'/'.$file] == $JD[$source.'/'.$file]){ // Compares the current files' modified time to the JSON recorded modified times
                    continue;
                } else {
                    copy ("$source/$file","$backup/$file"); 
                }
            } else { // This is a folder
                if (!file_exists($backup."/". $file)){
                    mkdir($backup."/". $file); // Creates a directory in the back-up folder
                }
                copyfiles($source ."/". $file, $backup."/". $file);// Starts function over again, goes deeper into directory.
            }
        }
        closedir($dh);
    } 
}   
?>
