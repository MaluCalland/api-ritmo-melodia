<?php

namespace App\service;

class ArtistaService
{
    public function listar()
    {
        $url = "https://musicbrainz.org/ws/2/artist/?query=" . $_SERVER['QUERY_STRING'] . "&area=f45b47f8-5796-386e-b172-6c31b009a5d8&country=BR&fmt=json";

        // Inicializa o cURL
        $ch = curl_init();

        // Configurações da requisição
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["User-Agent: App/1.0 (contato@meusite.com)"]);

        // Executa a requisição
        $response = curl_exec($ch);

        if ($response === false) {
            var_dump($ch);
        }

        // Fecha a conexão cURL
        curl_close($ch);

        $ob = json_decode($response);

        /* echo "<pre>";
        var_dump($ob->artists);
        echo "</pre>"; */
        foreach ($ob->artists as $artista) {
            echo $artista->name . (method_exists($artista, "country") ?? " - " . $artista->country) . "<br>";
        }

    }
}
