<?php

class phpBrowserStack extends BrowserStack
{
    function __construct($username, $accessKey, $apiVersion = '3')
    {
        parent::__construct($username, $accessKey, $apiVersion);
    }

    public function test()
    {

    }
}

class BrowserStack
{
    protected $username;
    protected $accessKey;
    protected $apiVersion;

    protected static $apiURL = 'http://api.browserstack.com';

    function __construct($username, $accessKey, $apiVersion)
    {
        $this->username     = $username;
        $this->accessKey    = $accessKey;
        $this->apiVersion   = $apiVersion;
    }
}

?>