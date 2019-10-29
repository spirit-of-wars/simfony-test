<?php

namespace App\Tests\Model;

use App\Model\Joke;
use PHPUnit\Framework\TestCase;

class JokeTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testModel($id, $text, $cat)
    {
        $joke = new Joke();

        $joke
            ->setId($id)
            ->setText($text)
            ->setCategory($cat);

        $this->assertEquals($id, $joke->getId());
        $this->assertEquals($text, $joke->getText());
        $this->assertEquals($cat, $joke->getCategory());
    }

    public function additionProvider()
    {
        return [
            [1, 'joke text', 'nerdy'],
        ];
    }
}