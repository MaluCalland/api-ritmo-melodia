<?php

namespace App\service;

use App\infra\http\Curl;
use App\model\enum\MusicBrainzEnum;
use Exception;

class AlbumService
{
    public function listar($name)
    {
        try {
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::artista->value . "?query=" . $name . "&fmt=json&limit=100&inc=tags";

            $response = Curl::getInstance()->get($url);

            $ob = json_decode($response);

            foreach ($ob->artists as $artista) {
                echo "Artista: <a href=\"/api/artista/detalhar?id=" . $artista->id . "\">";
                echo $artista->name . (property_exists($artista, "country") ? " - " . $artista->country : null) . (property_exists($artista, "area") ? ", " . $artista->area->name : null) . "<br>";
                echo "</a> Generos:";
                if (property_exists($artista, "tags")) {
                    foreach ($artista->tags as $tag) {
                        echo "<a href=\"/api/genero/listar?tag=" . $tag->name . "\">";
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
            $url = MusicBrainzEnum::path->value . MusicBrainzEnum::album_release->value . $id . "?fmt=json&inc=artists+labels+collections";

            $response = Curl::getInstance()->get($url);

            $album = json_decode($response);

            /*
            echo $artista->name . (property_exists($artista, "country") ? " - " . $artista->country : null) . (property_exists($artista, "area") ? ", " . $artista->area->name : null) . "<br>";
            echo $artista->annotation . "<br>";
            if (property_exists($artista, "tags")) {
                foreach ($artista->tags as $tag) {
                    echo "<a href=\"/api/genero/listar?tag=" . $tag->name . "\">";
                    echo "- " . $tag->name . " ";
                    echo "</a>";
                }
            }
            if (property_exists($album, "works")) {
                echo "<ul>";
                foreach ($artista->works as $work) {
                    echo "<a href=\"#" . $work->id . "\">";
                    echo "<li> " . $work->title . "</li> ";
                    echo "</a>";
                }
                echo "</ul>";
            }
            */
            echo "<pre>";
            var_dump($album);
            echo "</pre>";
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
