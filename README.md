# KABS
Kevin's Automatic Backup System
KABS is a php encoded file that is intended to allow for automatic backup of a website’s directories and files. During the first implementation of KABS in the website’s directory it will automatically create a backup directory of the website’s directories and files. Following the first implementation of the KABS file it will proceed to run a routine check of the website’s directories and files. Once the KABS file has been placed in the web page, refresh the webpage and the KABS file will proceed to automatically create a backup directory of the website’s directories and files. After the first initialization, KABS will be executed by visiting the site after 24hrs of the previous time that KABS was executed, any visits of the site within 24hrs of the previous checkup will not execute KABS. During the KABS routine checkup, KABS checks each of the directories and files of the website to see if it has been modified from the last checkup. For the files and directories that have been modified or changed, KABS updates the previous backup of the file with a more up to date version of the file.
##Instructions
Step 1. Add KABS.php file to web directory.

Step 2. Open KABS.php in an editor and change folder names on lines 4 and 5.

Step 3. Include the following JavaScript on every page of the website (Include jQuery before this code): 


$(function(){
   $.ajax('KABS.php'); 
}}; 

Step 4. Visit site and KABS will execute after 24hrs of the last visit.

Step 5. Enjoy!!!!
