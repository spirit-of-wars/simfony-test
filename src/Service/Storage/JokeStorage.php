<?php

namespace App\Service\Storage;

use App\Model\Joke;
use Symfony\Component\Filesystem\Filesystem;

class JokeStorage
{

    const FILE_NAME = 'jokes.txt';
    protected $fileSystem;

    public function __construct(Filesystem $filesystem){
        $this->fileSystem = $filesystem;
    }

    public function saveJoke(Joke $joke)
    {
        $this->fileSystem->appendToFile(self::FILE_NAME, $joke->getText() . PHP_EOL);
    }
}