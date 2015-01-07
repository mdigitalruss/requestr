<?php
/*
 * requestr.php
 * Simple PHP request/inclusion system
 * Copyright (c) 2015 Russell Peterson & Daniel Evans - helical.io
 */

namespace helical\requestr;

class router
{
    private $_page_class;
    
    private $_page_foldername;
    private $_page_classname;
    private $_page_methodname;
    
    private $_page_status_code;
    private $_page_status_message;
    
    
    ########## Public functions ##########

    // __construct - preload the php script
    public function __construct($file, $method, $folder)
    {
        // Page classname - get class name from querystring or use 'homepage' if none provided.
        $this->_page_classname = ((isset($_GET[$file]) && $_GET[$file] != "")? $_GET[$file] : 'homepage');
        
        // Page method - get method name from querystring or use '_default' if none provided.
        $this->_page_methodname = ((isset($_GET[$method]) && $_GET[$method] != "")? $_GET[$method] : '_default');

        // Get folder for page
        $this->_page_foldername = $folder .'/'. $this->_page_classname .'/';
        
        // Check the requested file exists
        $this->preloadPage($this->_page_classname,$this->_page_methodname);
    }
    
    // getAttributes - return attributes array from php class
    public function getAttributes()
    {
        return $this->_page_class->requestr_attributes;
    }

    // run - run the specified method
    public function run()
    {
        $methodname = $this->_page_methodname;

        if(method_exists($this->_page_class,$methodname)){
            $this->_page_class->$methodname();
            $this->_page_status_code = 200;
            return true;
        }
        else{
            $this->_page_status_code = 500;
            $this->_page_status_message = 'Public method <b>'. $methodname .'</b> not found in class <b>\helical\requestr\page\\'. $this->_page_classname.'</b><br/>';
            return false;
        }
    }
    
    public function statusCode(){
        return $this->_page_status_code;
    }
    
    public function statusMessage(){
        return $this->_page_status_message;
    }
    
    ########## Private functions ##########
    
    // preloadPage - include and instantiate the desired class.
    private function preloadPage($class_name,$method)
    {
        // CHeck the file/folder exists
        if(file_exists($this->_page_foldername . $this->_page_classname .'.php'))
        {
            // Include the class
            include($this->_page_foldername . $this->_page_classname .'.php');

            $full_class_name = '\helical\requestr\page\\'.$this->_page_classname;
            
            // Check the class exists in the file
            if(class_exists($full_class_name)){
                // If the class exists, init the class
                $this->_page_class = new $full_class_name;
                $this->_page_status_code = 200;
            }
            else{
                $this->_page_status_code = 500;
                $this->_page_status_message = 'Page class <b>\helical\requestr\page\\' . $this->_page_classname . '</b> not found in script <b>'. $this->_page_foldername . $this->_page_classname .'.php</b>';
            }
        }
        else 
        {
            $this->_page_status_code = 404;
            $this->_page_status_message = 'Page script <b>'. $this->_page_classname .'.php</b> not found in folder <b>'. $this->_page_foldername.'</b><br/>';
        }
    }
}
?>