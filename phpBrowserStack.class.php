<?php

class phpBrowserStack
{
    private $username;
    private $accessKey;

    function __construct($username, $accessKey)
    {
        $this->username     = $username;
        $this->accessKey    = $accessKey;
    }
}

?>