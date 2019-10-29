<?php

namespace App\Service\Http\Connector;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

class GuzzleAdapter implements ConnectorInterface
{
    const POST_METHOD = 'POST';
    const GET_METHOD = 'GET';
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $url string
     * @param array $headers
     * @return string
     */
    public function get($url, $headers = [])
    {
        $request = new Request(self::GET_METHOD, $url, $headers);

        return $this->sendRequest($request);
    }

    /**
     * @param $url string
     * @param array $headers
     * @param null $body
     * @return string
     */
    public function post($url, $headers = [], $body = null)
    {
        $request = new Request(self::POST_METHOD, $url, $headers, $body);

        return $this->sendRequest($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function sendRequest(Request $request) {
        try{
            $response = $this->client->send($request);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage());
        }

        return $response->getBody()->getContents();
    }
}