<?php

class phpBrowserStack extends BrowserStack
{
    function __construct($username, $access_key, $api_version = '3')
    {
        parent::__construct($username, $access_key, $api_version);
    }

    public function test()
    {

    }
}

class BrowserStack
{
    protected static $BASE_API_URL = 'http://api.browserstack.com';
    protected static $REST_API_URL = 'https://www.browserstack.com/automate';

    protected $username;
    protected $access_key;
    protected $api_version;

    protected $valid_statuses = array('running', 'done', 'failed');

    function __construct($username, $access_key, $api_version)
    {
        $this->username = $username;
        $this->access_key = $access_key;
        $this->api_version = $api_version;
    }

    protected function constructBuildsEndpoint()
    {
        return (BrowserStack::$REST_API_URL . '/builds.json');
    }

    protected function constructSessionsEndpoint($build_id, $session_id = NULL, $logs = FALSE)
    {
        $baseURL = BrowserStack::$REST_API_URL . '/builds/' . $build_id;

        if (!empty($session_id) && !empty($logs))
            return ($baseURL . '/sessions/' . $session_id . '/logs.json');
        else if (!empty($session_id))
            return ($baseURL . '/sessions/' . $session_id . '.json');
        else
            return ($baseURL . '/sessions.json');
    }

    protected function addLimitToEndpoint($endpoint_URL, $limit = NULL)
    {
        if ($limit > 0)
            return ($endpoint_URL . '?limit=' . $limit);

        return FALSE;
    }

    protected function addStatusFilterToEndpoint($endpoint_URL, $status = NULL)
    {
        if (in_array($status, $this->valid_statuses))
            return ($endpoint_URL . '?status=' . $status);

        return FALSE;
    }

}

?>