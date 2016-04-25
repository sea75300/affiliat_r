<?php
    /**
     * Base functions
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    /**
     * Class autoloader
     * @param string $class
     */
    function autoLoader($class) {

        $class = str_replace('\\', '/', $class);
        $includePath = base_config::$baseDir.'/inc/'.$class.'.php';

        if(file_exists($includePath)) {
            include_once $includePath;            
        } else {
            $paths = array('/inc/contrl/','/inc/model/', '/inc/dashcontainers/', '/inc/class/', '/install/', '/update/');        
            foreach ($paths AS $path) {            
                $includePath = base_config::$baseDir.$path.$class.'.php';
                if(file_exists($includePath)) {
                    include_once $includePath;
                    break;
                }
            }            
        }
    }

    /**
     * Error Handler
     * @param string $ecode
     * @param string $etext
     * @param string $efile
     * @param string $eline
     */
    function errorHandler($ecode, $etext, $efile, $eline) {     
        if(strpos($efile, base_config::$baseDir) === false) return;
        
        $LogLine = json_encode(array('time' => time(),'text' => "$etext<br>File: $efile @ line $eline<br>Error Code $ecode"));
        file_put_contents(base_config::$logfiles['errors'], $LogLine.PHP_EOL, FILE_APPEND);

        if($ecode != 2 && $ecode != 8 && $ecode != 2048 && $ecode != 8192) {
            die("An error occured. See error log for more informations.");
        }        
    }      

    /**
     * Dump ausgabe
     * @param mixed $data
     */
    function varDump($data) {
        print "<pre>";
        var_dump($data);
        print "</pre>";        
    }    
    
?>