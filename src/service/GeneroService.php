<?php
namespace App\service;

use App\infra\http\Curl;
use App\model\enum\MusicBrainzEnum;

class GeneroService
{
    public function listar($tag)
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::generos->value . $tag . "&fmt=json&limit=100";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->artists as $artista) {
                echo "<a href=\"/api/artista/detalhar?id=" . $artista->id . "\">";
                echo $artista->name . "<br>";
                echo "</a>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}