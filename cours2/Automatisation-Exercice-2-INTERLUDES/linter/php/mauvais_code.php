<?php

namespace Cours2\AutomatisationExercice2Interludes\Linter\Php;

class MauvaisCode
{
    public string $message;

    public function __construct(?string $message = null)
    {
        if ($message) {
            $this->message = $message;
        } else {
            $this->message = 'Mauvais code';
        }
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Cette fonction n'est pas utilisée.
     */
    public function mauvaisCode(bool $inUpperCase): void
    {
        if ($inUpperCase) {
            echo strtoupper('mauvais code');
        } else {
            echo 'mauvais code';
        }
    }
}
