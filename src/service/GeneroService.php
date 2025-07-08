<?php
namespace App\service;

use App\infra\http\Curl;
use App\model\enum\MusicBrainzEnum;

class GeneroService
{
    public function listar()
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::generos->value . "all?fmt=json";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->genres as $genero) {
                echo "<a href=\"/api/genero/detalhar?" . $genero->id . "\">";
                echo $genero->name . "<br>";
                echo "</a>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}