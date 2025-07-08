<?php
namespace App\model\enum;

enum MusicBrainzEnum: string
{
    case path = 'https://musicbrainz.org/ws/2/';
    case artista = 'artist/';
    case generos = 'genre/';
    case genero = 'tag/';
}