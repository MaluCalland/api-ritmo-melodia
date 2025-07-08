<?php

namespace App\service;

use App\infra\http\Curl;
use App\model\enum\MusicBrainzEnum;
use Exception;

class ArtistaService
{
    public function listar()
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::artista->value . "?query=" . $_SERVER['QUERY_STRING'] . "&fmt=json&limit50";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->artists as $artista) {
                echo "<a href=\"/api/artista/detalhar?" . $artista->id . "\">";
                echo $artista->name . (property_exists($artista, "country") ? " - " . $artista->country : null) . (property_exists($artista, "area") ? ", " . $artista->area->name : null) . "<br>";
                echo "</a>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function detalhar($id)
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::artista->value . $id . "?fmt=json";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            var_dump($ob);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
