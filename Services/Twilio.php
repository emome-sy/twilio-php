<?php

function Services_Twilio_autoload($className) {
    if (substr($className, 0, 15) != 'Services_Twilio') {
        return false;
    }
    $file = str_replace('_', '/', $className);
    $file = str_replace('Services/', '', $file);
    return include dirname(__FILE__) . "/$file.php";
}

spl_autoload_register('Services_Twilio_autoload');

/**
 * Twilio API client interface.
 *
 * @category Services
 * @package  Services_Twilio
 * @author   Neuman Vong <neuman@twilio.com>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 * @link     http://pear.php.net/package/Services_Twilio
 */
class Services_Twilio extends Services_Twilio_Resource
{
    const USER_AGENT = 'twilio-php/3.5.2';

    protected $http;
    protected $version;
    protected $versions = array('2008-08-01', '2010-04-01');

    /**
     * Constructor.
     *
     * @param string               $sid      Account SID
     * @param string               $token    Account auth token
     * @param string               $version  API version
     * @param Services_Twilio_Http $_http    A HTTP client
     */
    public function __construct(
        $sid,
        $token,
        $version = null,
        Services_Twilio_TinyHttp $_http = null
    ) {
        $this->version = in_array($version, $this->versions) ?
                $version : end($this->versions);

        if (null === $_http) {
            if (!in_array('curl', get_loaded_extensions())) {
                trigger_error("It looks like you do not have curl installed.\n". 
                    "Curl is required to make HTTP requests using the twilio-php\n" .
                    "library. For install instructions, visit the following page:\n" . 
                    "http://php.net/manual/en/curl.installation.php",
                    E_USER_WARNING
                );
            }
            $_http = new Services_Twilio_TinyHttp(
                "https://api.twilio.com",
                array("curlopts" => array(
                    CURLOPT_USERAGENT => self::USER_AGENT,
                    CURLOPT_HTTPHEADER => array('Accept-Charset: utf-8'),
                    CURLOPT_CAINFO => dirname(__FILE__) . "/twilio_ssl_certificate.crt",
                ))
            );
        }
        $_http->authenticate($sid, $token);
        $this->http = $_http;
        $this->accounts = new Services_Twilio_Rest_Accounts($this, "/{$this->version}/Accounts");
        $this->account = $this->accounts->get($sid);
    }

    /**
     * Get the api version used by the rest client
     *
     * @return string the API version in use
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Construct a URI based on initial path, query params, and paging 
     * information
     *
     * We want to use the query params, unless we have a next_page_uri from the 
     * API.
     *
     * @param string $path The request path (may contain query params if it's 
     *      a next_page_uri)
     * @param array $params Query parameters to use with the request
     * @param boolean $full_uri Whether the $path contains the full uri
     *
     * @retun string the URI that should be requested by the library
     */
    public static function getRequestUri($path, $params, $full_uri = false) {
        $json_path = $full_uri ? $path : "$path.json";
        if (!$full_uri && !empty($params)) {
            $query_path = $json_path . '?' . http_build_query($params, '', '&');
        } else {
            $query_path = $json_path;
        }
        return $query_path;
    }

    /**
     * GET the resource at the specified path.
     *
     * @param string $path   Path to the resource
     * @param array  $params Query string parameters
     *
     * @return object The object representation of the resource
     */
    public function retrieveData($path, array $params = array(), 
        $full_uri = false
    ) {
        $uri = self::getRequestUri($path, $params, $full_uri);
        $response = $this->http->get($uri);
        return $this->_processResponse($response);
    }

    /**
     * DELETE the resource at the specified path.
     *
     * @param string $path   Path to the resource
     * @param array  $params Query string parameters
     *
     * @return object The object representation of the resource
     */
    public function deleteData($path, array $params = array())
    {
        $uri = self::getRequestUri($path, $params);
        $response = $this->http->delete($uri);
        return $this->_processResponse($response);
    }

    /**
     * POST to the resource at the specified path.
     *
     * @param string $path   Path to the resource
     * @param array  $params Query string parameters
     *
     * @return object The object representation of the resource
     */
    public function createData($path, array $params = array())
    {
        $path = "$path.json";
        $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
        $response = $this->http->post(
            $path, $headers, http_build_query($params, '', '&')
        );
        return $this->_processResponse($response);
    }

    /**
     * Convert the JSON encoded resource into a PHP object.
     *
     * @param array $response 3-tuple containing status, headers, and body
     *
     * @return object PHP object decoded from JSON
     * @throws DomainException (if response lacks Content-Type)
     * @throws Services_Twilio_RestException (Response in 300-500 class)
     */
    private function _processResponse($response)
    {
        list($status, $headers, $body) = $response;
        if ($status == 204) {
            return TRUE;
        }
        return $this->_processJsonResponse($status, $headers, $body);
    }

    private function _processJsonResponse($status, $headers, $body) {
        $decoded = json_decode($body);
        if ($decoded === null) {
            throw new Services_Twilio_RestException(
                $status,
                'Could not decode response body as JSON. ' . 
                'This likely indicates a 500 server error'
            );
        }
        if (200 <= $status && $status < 300) {
            return $decoded;
        }
        throw new Services_Twilio_RestException(
            (int)$decoded->status,
            $decoded->message,
            isset($decoded->code) ? $decoded->code : null,
            isset($decoded->more_info) ? $decoded->more_info : null
        );
    }

}
