<?
/*
 * requestr.php
 * Simple PHP request/inclusion system
 * Copyright (c) 2013 Razor Studios
 */
 
	class requestr
	{
		private $_page_class;
		private $_page_classname;
		private $_page_methodname;
		
		public function __construct($file, $method, $folder)
		{
			// Check if the GET exists for the class
			if(isset($_GET[$file]) && $_GET[$file] != "")
			{
				$this->_page_classname = $file . '_' . $_GET[$file];
			}
			else 
			{
				$this->_page_classname  = $file . '_default';
			}
			
			// Check if the GET exists for the method
			if(isset($_GET[$method]) && $_GET[$method] != "")
			{
				$this->_page_methodname = $method . '_' . $_GET[$method];
			}
			else 
			{
				$this->_page_methodname  = $method . '_default';
			}
			
			// Check the requested file exists
			if(file_exists($folder . '/'. $this->_page_classname .'.php'))
			{
				// Include the class
				include($folder . '/'. $this->_page_classname .'.php');
				
				// If the class exists, init the class
				if(class_exists($this->_page_classname))
				{
					$this->_page_class = new $this->_page_classname;
				}
				else 
				{
					echo '<br/>Requestr Error: Class ' . $this->_page_classname . ' not found in '. $folder . '/'. $this->_page_classname .'.php';
				}
			}
			else 
			{
				echo '<br/>Requestr Error: File '. $this->_page_classname .'.php not found in folder '. $folder;
			}
		}

		public function getAttributes()
		{
			return $this->_page_class->requestr_attributes;
		}
		
		public function run()
		{
			$methodname = $this->_page_methodname;
			
			if(method_exists($this->_page_class,$methodname))
			{
				$this->_page_class->$methodname();
			}
			else
			{
				echo '<br/>Requestr Error: Method '. $methodname .' not found in class '. $this->_page_classname;
			}
		}
	}
?>