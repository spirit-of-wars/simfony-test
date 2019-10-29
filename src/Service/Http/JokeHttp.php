<?php

namespace App\Service\Http;

use App\Service\Http\Connector\ConnectorInterface;

class JokeHttp
{
    const BASE_URI = 'http://api.icndb.com/';

    const JOKE_CATEGORY_NERDY = 'nerdy';
    const JOKE_CATEGORY_EXPLICIT = 'explicit';

    /**
     * @var ConnectorInterface
     */
    protected $connector;

    /**
     * Http constructor.
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param $category
     * @return mixed
     */
    public function getRandomJokeFromCategory($category)
    {
        $url = self::BASE_URI . 'jokes/random?limitTo=[' . $category . ']';

        return $this->get($url);
    }

    /**
     * @return array
     */
    public function getJokeCategory()
    {
        return [
            self::JOKE_CATEGORY_EXPLICIT,
            self::JOKE_CATEGORY_NERDY,
        ];
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function get($url)
    {
        return json_decode($this->connector->get($url));
    }
}