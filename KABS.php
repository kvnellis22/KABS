<?php // KABS (Kevin's Automatic Backup System)
// cited from: http://blog.hirephp.com/php/files-copy-from-one-folder-to-another-folder-using-php.html
// copyright 2015, Median Koding MIT & GPL
$Source='Source';// Change variable name to folder that will be backed up
$KABS='Backup';// Change variable name to folder that hold backed up content
if (!file_exists('KABS_time.txt')){//Automatically creates the 'KABS_time.txt' file.
    file_put_contents('KABS_time.txt', null);
}
if (!file_exists('KABS_array.json')){//Automatically creates the 'KABS_array.json' file. 
    file_put_contents('KABS_array.json',null);
}
if (!is_dir($KABS)){//automatically creates the backup folder.
    mkdir($KABS,null);
}
$Past= file_get_contents('KABS_time.txt',true); //Retrieves timestamp that's stored in the Time.txt file.
$JD=json_decode(file_get_contents("KABS_array.json"),true);//Retrieves the array.
if (time() >=$Past+(60*1440)){//checks to see if the timestamps is older than a day
    copyfiles($Source,$KABS);
    $A_arr=json_encode($arr);//Changes the associative array into JSON format.
    file_put_contents('KABS_time.txt',time());//saves and replaces the old KABS.PHP saved filetime with an up to date filetime.
    file_put_contents('KABS_array.json',$A_arr);//saves and replaces the old JSON associative array with an up to date JSON associative array.
} 
function copyfiles($source,$backup){
    global $arr;
    global $JD;
    if (is_dir($source)){
        $dh = opendir($source);
        $file = readdir($dh);
        while (($file = readdir($dh)) !==false){
            if ($file==".")continue;// skipping
            if ($file=="..")continue;// skipping
            if ($file=="desktop.ini")continue;//skipping desktop.ini file                
            if (preg_match("/\./",$file)){ //This is a file
                $arr[$source.'/'.$file]=filemtime($source.'/'.$file);// creates an associative array
                if ($arr[$source.'/'.$file] == $JD[$source.'/'.$file]){//compares the current files' modified time to the JSON files' modified times
                    continue;
                } else {
                    copy ("$source/$file","$backup/$file"); 
                }
            } else { // This is a folder
                if (!file_exists($backup."/". $file)){
                    mkdir($backup."/". $file);
                }//creates a directory in back-up folder
                copyfiles($source ."/". $file, $backup."/". $file);// starts function over again, goes deeper into directory.
            }
        }
        closedir($dh);
    } 
}   
?>
