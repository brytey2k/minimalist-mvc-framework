<?php

namespace App\Classes\Http;

use App\Classes\SessionHelper;

class Response
{

    private array $sessionData = []; // array of key => value pair, eg. ['key1' => 'val1', 'key2' => 'val2', ...]

    public function __construct(
        private readonly int    $httpResCode = 200,
        private readonly string $content = '',
        private readonly array  $headers = [],
    )
    {
    }

    public function send(): void
    {
        http_response_code($this->httpResCode);

        if(!empty($this->headers)) {
            foreach($this->headers as $header) {
                /**
                 * @var $header Header
                 */
                header($header->getKey() . ' : ' . $header->getValue());
            }
        }

        $this->setSessionData();

        if(str_starts_with((string) $this->httpResCode, '3')) {
            // exit early since this is a redirect
            exit;
        }

        echo $this->content;
        exit;
    }

    /**
     * Add session data to be displayed after redirect
     */
    public function with(?string $key, $value): static
    {
        if(is_null($key) || trim($key) === '') {
            return $this;
        }
        SessionHelper::set($key, $value);
        return $this;
    }

    private function setSessionData(): void
    {
        foreach($this->sessionData as $key => $value) {
            SessionHelper::set($key, $value);
        }
    }

}