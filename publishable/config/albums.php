<?php

return [

    'albums_shortcode' => true, //albums shortcode

    'slug_shortcut'=> true, //editor slug search album

    'id_shortcut'=> true, //editor id search album

    'image_exif_data'=> true, //Album image exif data return array | $image->exif(); | $image->exif()['FileName'];

    'default_album_template'=> "default", //default - bootstrap - special

    'template_folder' => [
        'default' => 'albums.default',
        'bootstrap' => 'albums.bootstrap',
        'special' => 'albums.special',
    ],
//it should not be used this way  " image_folder'=>url(/storage"), otherwise the console will give the error."
    'image_folder'=>config('app.url')."/storage",
];

