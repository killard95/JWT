<?php

class JWToken
{

    public function generate(array $header, array $payload, string $secret, int $validity = 86400)
    {

        if ($validity > 0) {
            $now = new DateTime();
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }


        $b64head = base64_encode(json_encode($header));
        $b64pay = base64_encode(json_encode($payload));
        $b64secret = base64_encode($secret);


        $b64head = str_replace(['+', '/', '='], ['-', '_', ''], $b64head);
        $b64pay = str_replace(['+', '/', '='], ['-', '_', ''], $b64pay);


        $signature = hash_hmac('sha256', $b64head . '.' . $b64pay, $b64secret, true);

        $b64signature = base64_encode($signature);
        $b64signature = str_replace(['+', '/', '='], ['-', '_', ''], $b64signature);

        $jwt = $b64head . '.' . $b64pay . '.' . $b64signature;

        return $jwt;
    }

    public function verifyToken(string $token, string $secret): bool
    {
        $head = $this->getHeader($token);
        $payload = $this->getPayload($token);
        $verif = $this->generate($head, $payload, $secret, 0);
        return $verif;
    }

    public function getHeader(string $token)
    {

        $tab = explode('.', $token);
        $header = json_decode(base64_decode($tab[0]), true);

        return $header;
    }

    public function getPayload(string $token)
    {

        $tab = explode('.', $token);
        $payload = json_decode(base64_decode($tab[1]), true);

        return $payload;
    }

    public function isExpired(string $token): bool
    {
        $now = new DateTime();
        $now = $now->getTimestamp();
        $pl = $this->getPayload($token);
        return $pl['exp'] < $now;
    }

    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }
}
