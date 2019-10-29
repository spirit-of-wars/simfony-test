<?php

namespace App\Service\Http\Connector;

interface ConnectorInterface
{
    public function get($url, $headers = []);

    public function post($url, $headers = [], $body = null);
}