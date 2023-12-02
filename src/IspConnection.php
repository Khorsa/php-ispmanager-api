<?php

namespace IspManagerApi;

class IspConnection
{
    public function call(string $url): string
    {
        $handler = curl_init();
        curl_setopt($handler, CURLOPT_URL, $url);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        curl_close($handler);

        if (is_bool($response)) {
            throw new \RuntimeException();
        }

        return $response;
    }
}
