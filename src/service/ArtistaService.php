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
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::artista->value . "?query=" . $_SERVER['QUERY_STRING'] . "&fmt=json&limit=100&inc=tags";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->artists as $artista) {
                echo "<a href=\"/api/artista/detalhar?" . $artista->id . "\">";
                echo $artista->name . (property_exists($artista, "country") ? " - " . $artista->country : null) . (property_exists($artista, "area") ? ", " . $artista->area->name : null) . "<br>";
                echo "</a>";
                if (property_exists($artista, "tags")) {
                    foreach ($artista->tags as $tag) {
                        echo "<a href=\"/api/genero/listar?" . $tag->name . "\">";
                        echo "- " . $tag->name . " ";
                        echo "</a>";
                    }
                }
                echo "<hr>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function detalhar($id)
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::artista->value . $id . "?fmt=json&inc=tags+releases+works+annotation";

            $response = Curl::getInstance()->get($url);

            $artista = json_decode($response);

            echo $artista->name . (property_exists($artista, "country") ? " - " . $artista->country : null) . (property_exists($artista, "area") ? ", " . $artista->area->name : null) . "<br>";
            echo $artista->annotation . "<br>";
            if (property_exists($artista, "tags")) {
                foreach ($artista->tags as $tag) {
                    echo "<a href=\"/api/genero/listar?" . $tag->name . "\">";
                    echo "- " . $tag->name . " ";
                    echo "</a>";
                }
            }
            if (property_exists($artista, "releases")) {
                echo "<ul>";
                foreach ($artista->releases as $release) {
                    echo "<a href=\"#" . $release->id . "\">";
                    echo "<li> " . $release->title . "</li> ";
                    echo "</a>";
                }
                echo "</ul>";
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
