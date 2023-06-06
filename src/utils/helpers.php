<?php

use App\Classes\Http\Header;
use App\Classes\Http\Response;

/**
 * @param string $path
 * @param array $sessionData eg. ['key1' => 'val1', 'key2' => 'val2', ...]
 * @return void
 */
function check24Redirect(string $path, array $sessionData = []): void {
    $response = new Response(302, '', [new Header('Location', $path)]);

    foreach($sessionData as $key => $value) {
        $response->with($key, $value);
    }

    $response->send();
}

function check24UserIsLoggedIn(): bool {
    if(isset($_SESSION['is_logged_in'])) {
        if($_SESSION['is_logged_in']) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function shortenText($text, $limit) {
    if (strlen($text) <= $limit) {
        return $text; // Return the text as it is if it's already within the limit
    }

    // Shorten the text and add ellipsis (...) to indicate that the text has been shortened
    return substr($text, 0, $limit) . '...';
}

function parseQueryString(): array
{
    $queryString = [];
    if(isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING'], $queryString);
    }

    return $queryString;
}

function cleanRequestBody(array $body)
{
    $cleaned = [];
    foreach($body as $key => $value) {
        $cleaned[$key] = htmlentities($value);
    }

    return $cleaned;
}