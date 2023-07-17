<?php

    $ftp_server = 'ftp.dlptest.com';
    $ftp_username = 'dlpuser';
    $ftp_password = 'rNrKYTX9g7z3RgJRmxWuGHbeu';
    
    $connection = ftp_connect($ftp_server);
    $login_result = ftp_login($connection, $ftp_username, $ftp_password);

    $remote_directory = '/wwwroot';
    $local_directory = '/home/faheem/Documents/Downloaded from filezilla';
    
    $admin3_local_directory = '/home/faheem/Documents/Downloaded from filezilla/admin3';
    $admin3_remote_directory = '/wwwroot/admin3';

    $mobi_local_directory = '/home/faheem/Documents/Downloaded from filezilla/mobi';
    $mobi_remote_directory = '/wwwroot/mobi';

    if ($connection && $login_result) {
        echo 'Connected to the FTP server.<br>';

        downloadDirectory($connection, $remote_directory, $local_directory);
        downloadAdmin3($connection , $admin3_remote_directory , $admin3_local_directory);
        downloadMobi($connection , $mobi_remote_directory , $mobi_local_directory);

    } else {
        echo 'Failed to connect to the FTP server.';
        exit;
    }

    function downloadDirectory($connection, $remote_directory, $local_directory)
    {
        

        $files = ftp_nlist($connection, $remote_directory);
        
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {

                
                $file_name = file_name($file);
                

                if (strval($file_name) == "autopub" || strval($file_name) == "includes" || strval($file_name) == "cfcs") {

                    print_r('<br>directory: ' .$file_name ."<br>");

                    if (!is_dir($local_directory."/".$file_name)) {
                        mkdir($local_directory."/".$file_name, 0777, true);
                    }

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


    function downloadAdmin3($connection, $remote_directory, $local_directory){

        if (!is_dir($local_directory)) {
            mkdir($local_directory, 0777, true);
        }
        $files = ftp_nlist($connection, $remote_directory);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                
                $file_name = file_name($file);
                

                if (strval($file_name) == "cfcs" || strval($file_name) == "js" || strval($file_name) == "pages" || strval($file_name) == "print" || strval($file_name) == "reports" || strval($file_name) == "template") {

                    print_r('<br>directory: ' .$file_name ."<br>");
                    if (!is_dir($local_directory."/".$file_name)) {
                        mkdir($local_directory."/".$file_name, 0777, true);
                    }
                    
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

    function downloadMobi($connection, $remote_directory, $local_directory){

        if (!is_dir($local_directory)) {
            mkdir($local_directory, 0777, true);
        }
        $files = ftp_nlist($connection, $remote_directory);

        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                
                $file_name = file_name($file);
                

                if (strval($file_name) == "cfcs" ) {

                    print_r('<br>directory: ' .$file_name ."<br>");
                    if (!is_dir($local_directory."/".$file_name)) {
                        mkdir($local_directory."/".$file_name, 0777, true);
                    }
                    
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
    
?>