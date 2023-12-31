<?php

    $ftp_server = 'ftp.dlptest.com';
    $ftp_username = 'dlpuser';
    $ftp_password = 'rNrKYTX9g7z3RgJRmxWuGHbeu';
    
    $connection = ftp_connect($ftp_server);
    $login_result = ftp_login($connection, $ftp_username, $ftp_password);

    $remote_directory = '/wwwroot';
    $local_directory = '/home/faheem/Documents/Downloaded from filezilla';

    $autopub_local_directory = '/home/faheem/Documents/Downloaded from filezilla/autopub';
    $autopub_remote_directory = '/wwwroot/autopub';
    
    $admin3_local_directory = '/home/faheem/Documents/Downloaded from filezilla/admin3';
    $admin3_remote_directory = '/wwwroot/admin3';

    $mobi_local_directory = '/home/faheem/Documents/Downloaded from filezilla/mobi';
    $mobi_remote_directory = '/wwwroot/mobi';

    $root_folders = ["includes","cfcs"];
    $autopub_folders = ["cfcs"];
    $admin3_folders = ["cfcs","js","pages","print","reports","template"];
    $mobi_folders = ["cfcs"];


    if ($connection && $login_result) {
        echo 'Connected to the FTP server.<br>';

        downloadRoot($connection, $remote_directory, $local_directory,$root_folders);
        downloadFolders($connection , $autopub_remote_directory , $autopub_local_directory, $autopub_folders);
        downloadFolders($connection , $admin3_remote_directory , $admin3_local_directory,$admin3_folders);
        downloadFolders($connection , $mobi_remote_directory , $mobi_local_directory, $mobi_folders);

    } else {
        echo 'Failed to connect to the FTP server.';
        exit;
    }

    function downloadRoot($connection, $remote_directory, $local_directory,$folders)
    {
        

        $files = ftp_nlist($connection, $remote_directory);
        
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {

                $file_name = file_name($file);
                

                if (in_array(strval($file_name),$folders)) {

  

                    makeDir($local_directory,$file_name);
  
                    $files = ftp_nlist($connection, $file);
  
                    foreach ($files as $file) {
     
                        $sub_dir_file_name = file_name($file);
                        $remote_file = $file;
                        $local_file = $local_directory."/".$file_name."/".$sub_dir_file_name;
                    
                        download_file($connection, $local_file, $remote_file);
                    }
                    continue;
                    
                }else{
                    
                }

                $remote_file = $file;
                $local_file = $local_directory ."/". $file_name;
               
                download_file($connection, $local_file, $remote_file);
            
            }
        }
    }


    function downloadFolders($connection, $remote_directory, $local_directory,$folders){

        makeDir($local_directory);
        $files = ftp_nlist($connection, $remote_directory);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                
                $file_name = file_name($file);
                

                if (in_array(strval($file_name),$folders)) {

                  
                    makeDir($local_directory,$file_name);
                    
                    $files = ftp_nlist($connection, $file);
        
                    foreach ($files as $file) {
                        
                        $sub_dir_file_name = file_name($file);
                        $remote_file = $file;
                        $local_file = $local_directory."/".$file_name."/".$sub_dir_file_name;
                    
                        download_file($connection, $local_file, $remote_file);
                    }
                    continue;
                    
                }

                
                $remote_file = $file;
                $local_file = $local_directory ."/". $file_name;
               
                download_file($connection, $local_file, $remote_file);
            }
        }

    }

    

ftp_close($connection);



function file_name($file){
    $last_slash_position = strrpos($file, '/');
    $file_name = substr($file, $last_slash_position + 1);

    return $file_name;
}


function download_file($connection, $local_file, $remote_file){
    if (ftp_get($connection, $local_file, $remote_file, FTP_BINARY)) {
        echo 'File downloaded: ' . $local_file . PHP_EOL."<br>";
        print_r(error_get_last());
    } else {
        echo 'Failed to download the file: ' . $remote_file . PHP_EOL."<br>";
        print_r(error_get_last());
    }
}


function makeDir($local_directory, $file_name=null){
    if($file_name == null){
        if (!is_dir($local_directory)) {
            mkdir($local_directory, 0777, true);
        }
    }else{
        if (!is_dir($local_directory."/".$file_name)) {
            mkdir($local_directory."/".$file_name, 0777, true);
        }
    }
}
    
?>