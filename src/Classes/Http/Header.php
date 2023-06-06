<?php

namespace App\Classes\Http;

class Header
{

    public function __construct(
        private string $key,
        private string $value,
    )
    {
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

}