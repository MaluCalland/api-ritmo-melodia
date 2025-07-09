<?php
namespace App\model\enum;

enum MusicBrainzEnum: string
{
    case path = 'https://musicbrainz.org/ws/2/';
    case artista = 'artist/';
    case generos = 'artist?query=tag:';
    case album_release = 'release/';
    case album_work = 'work/';
}