<?php

namespace App\Service\Storage;

use App\Model\Joke;
use Symfony\Component\Filesystem\Filesystem;

class JokeStorage
{
    protected $fileSystem;

    public function __construct(Filesystem $filesystem){
        $this->fileSystem = $filesystem;
    }

    public function saveJoke(Joke $joke)
    {
        $this->fileSystem->appendToFile('ololo.txt', $joke->getText() . PHP_EOL);
    }
}