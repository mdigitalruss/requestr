<?php
/*
 * 	homepage.php
 * 	Example homepage for requestr
 *  Copyright (c) 2015 Russell Peterson & Daniel Evans - helical.io
 */

namespace helical\requestr\page;

class homepage
{
    public $requestr_attributes = array('message' => 'hello world');

    public function _default()
    {
        echo "Hello World 123";
    }
}
?>