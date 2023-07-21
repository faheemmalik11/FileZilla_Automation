# FileZilla_Automation by Faheem Malik

Firstly, The script makes a connection with fileZilla serve.  Then we have two main functions to do our work.
* downloadRoot
* downloadFolders

Both of these functions accept connection, remote_directory and local_directory's path and folders within them to download. First we have executed the downloadRoot function. 

## downloadRoot 
parameters: connection, remote_directory, local_directory, folders = ["includes","cfcs"];

Firstly, it lists all the file and folders paths that are in server. Then, it starts a loop on each file. After entering the loop we:
* extract the filename from file path.
* check for the folders in the parameter using if condition
### true condition
* In case of true condition, we will first make the directory in our local directory's path named as given folder. 
* Then we list all the files in that given folder in remote server. 
* We execute the loop on all the files of folder and download them.

### else 
* The file would be downloaded that is in loop


## downloadFolders

For admin3: parameters: connection, remote_directory, local_directory, folders = ["cfcs","js","pages","print","reports","template"];
For mobi: parameters: connection, remote_directory, local_directory, folders = ["cfcs"];
For autopub : parameters: connection, remote_directory, local_directory, folders = ["cfcs"];

Firstly we make a directory on root named by folder eg admin3, mobi etc. Then, we list all the files in it. Then, a loop starts over these files:
* extract the filename from file path.
* check for the folders in the parameter using if condition
### true condition
* In case of true condition, we will first make the directory in our local directory's path named as given folder. 
* Then we list all the files in that given folder in remote server. 
* We execute the loop on all the files of folder and download them.

### else 
* The file would be downloaded that is in loop


