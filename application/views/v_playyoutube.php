<?php
defined('BASEPATH')OR exit('No direct script access allowed');

$youtube_url = 'https://www.youtube.com/watch?v=dh-oY7nNIxU';
$id = youtube_id($youtube_url);
$thumbs = youtube_thumbs($youtube_url, 1);
echo youtube_embed($youtube_url);
