<?php
namespace App\service;

use App\infra\http\Curl;
use App\model\enum\MusicBrainzEnum;

class GeneroService
{
    public function listar()
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::generos->value . $_SERVER['QUERY_STRING'] . "&fmt=json&limit=100";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->artists as $artista) {
                echo "<a href=\"/api/artista/detalhar?" . $artista->id . "\">";
                echo $artista->name . "<br>";
                echo "</a>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}