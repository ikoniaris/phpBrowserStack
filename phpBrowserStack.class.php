<?php

class phpBrowserStack extends BrowserStack
{
    function __construct($username, $access_key, $api_version = '3')
    {
        parent::__construct($username, $access_key, $api_version);
    }

    public function getBrowsers($flat = FALSE, $all = FALSE)
    {
        $params = '';
        if ($flat && $all)
            $params .= '?flat=true' . '&all=true';
        elseif ($flat)
            $params .= '?flat=true';
        elseif ($all)
            $params .= '?all=true';

        return (json_decode($this->makeRequest($this->constructAPIEndpoint() . '/browsers' . $params)));
    }

    public function getBuilds()
    {
        return ($this->makeRequest($this->browserStackREST->constructBuildsEndpoint()));
    }

    public function getSessionsUnderBuild($build_id)
    {
        return ($this->makeRequest($this->browserStackREST->constructSessionsEndpoint($build_id)));
    }

    public function getStatsForSession($build_id, $session_id, $logs = FALSE)
    {
        return ($this->makeRequest($this->browserStackREST->constructSessionsEndpoint($build_id, $session_id, $logs)));
    }
}

class BrowserStack
{
    protected static $BASE_API_URL = 'http://api.browserstack.com';

    protected $username;
    protected $access_key;
    protected $api_version;

    protected $browserStackREST;

    function __construct($username, $access_key, $api_version = '3')
    {
        $this->username = $username;
        $this->access_key = $access_key;
        $this->api_version = $api_version;

        $this->browserStackREST = new BrowserStackREST($username, $access_key);
    }

    protected function constructAPIEndpoint()
    {
        return (BrowserStack::$BASE_API_URL . '/' . $this->api_version);
    }

    protected function makeRequest($url, $method = 'GET')
    {
        if (!function_exists('curl_init')) {
            die('cURL is not installed!');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->access_key);

        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'Expect:',
                'Content-Type: application/json'
            ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}

class BrowserStackREST
{
    protected static $REST_API_URL = 'https://www.browserstack.com/automate';
    protected $valid_statuses = array('running', 'done', 'failed');

    protected $username;
    protected $access_key;

    function __construct($username, $access_key)
    {
        $this->username = $username;
        $this->access_key = $access_key;
    }

    public function constructBuildsEndpoint()
    {
        return (BrowserStackREST::$REST_API_URL . '/builds.json');
    }

    public function constructSessionsEndpoint($build_id, $session_id = NULL, $logs = FALSE)
    {
        $baseURL = BrowserStackREST::$REST_API_URL . '/builds/' . $build_id;

        if ($session_id && $logs)
            return ($baseURL . '/sessions/' . $session_id . '/logs.json');
        else if ($session_id)
            return ($baseURL . '/sessions/' . $session_id . '.json');
        else
            return ($baseURL . '/sessions.json');
    }

    public function addLimitToEndpoint($endpoint_URL, $limit = NULL)
    {
        if ($limit > 0)
            return ($endpoint_URL . '?limit=' . $limit);

        return FALSE;
    }

    public function addStatusFilterToEndpoint($endpoint_URL, $status = NULL)
    {
        if (in_array($status, $this->valid_statuses))
            return ($endpoint_URL . '?status=' . $status);

        return FALSE;
    }

    /*
     * This method is not used. Only left here in case somebody wants to use just the REST class independently.
     */
    protected function makeRequest($url, $method = 'GET')
    {
        if (!function_exists('curl_init')) {
            die('cURL is not installed!');
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->access_key);

        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'Expect:',
                'Content-Type: application/json'
            ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}

?>