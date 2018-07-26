# VoyagerAwesomeAlbums
 
<h2>What does this package do</h2>
Easy to create image album for Voyager Admin<br>
<br>
<pre>
Voyage Admin image upload system
Voyage Admin permission system
Voyager Admin Bread System (Can set conditions on input values.)
Voyager Admin Multi language input system (optional use)
Multi Language Support (English and Turkish other languages need translation.)
Quick easy album sharing with editor (via shortcut code) (optional dependent)
Shortcut to share pictures selected from the album in writing.
3 Stock Gallery Design (possibility to choose design on different pages or make special design)
Quick and Easy to Use.
Upload multiple images.
Delete multiple pictures
Image Sequence Determination
----------TR--------------
Voyage Admin  resim yükleme sistemi
Voyage Admin  permission sistemi
Voyager Admin bread Sistemi( Giriş değerlerine koşul koyabilme.)
Voyager Admin Çoklu dil girişi Sistemi( istege bağlı kullanım)
Çoklu Dil Desteği( İngilizce ve türkçe Diğer dillere çeviri gerekir.)
Editör Aracılığı ile hızlı kolay albüm paylaşımı (kısayol kodu ile )( istege bağlı kullanım)
Kısayol ile albümden seçilen resimleri yazıda paylaşabilme.
3 Hazır Galeri Tasarımı (farklı sayfalarda tasarım seçebilme veya özel tasarım yapabilme imkanı)
Hızlı Kolay Kullanım.
Çoklu resim yükleme.
Çoklu resim silmek
Resim Sırası Belirleyebilme


</pre>
<h3>Required for:</h3>
Voyager Admin v1.1
 

<h2>Install</h2>
<pre>
composer require trker/voyager-awesome-albums
</pre>


Add Service Provider(config/app)

<br>
<pre>
trker\VoyagerAwesomeAlbums\VoyagerAwesomeAlbumsServiceProvider::class,
</pre>

Add Aliases
<br>
<pre>
'VoyagerAlbums' => trker\VoyagerAwesomeAlbums\VoyagerAlbums::class,
</pre>
 <h2>Run code in your directory.</h2>
<pre>
 php artisan vendor:publish --provider="trker\VoyagerAwesomeAlbums\VoyagerAwesomeAlbumsServiceProvider"
</pre>
<br>
Voyager automatically loads when you login to admin and gives admin permission to role play.

Query
<pre>
\Albums::all(); //all albums
//example
$albums=\Albums::wherestatus(1)->first(); //status 1 get

$albums->images //all images in the album from

//All images

\AlbumsImage::all(); //all image
</pre>


<h2>Shortcut Usage(optional)</h2>

The shortcut displays pictures with the shortcut you have specified in the album you created.
must be enabled without configuring the shortcut. (Default enabled)
<pre>
{!!  \VoyagerAlbums::shortcode(article,template) !!}

{!!  \VoyagerAlbums::shortcode($post->body,'bootstrap') !!}

</pre>

<pre>
standard templates
"default"
"bootstrap"
"special"
------Add or call a new template--------
Path 1: albums config add new template
    albums config add
      'template_folder' => [
                'test_template' => 'albums.test' //example
             'template name' => 'path' // add album template
         ],
call

{!! \VoyagerAlbums::shortcode(article,'test_template') !!} 
Path 2: direct template calling with calling code
{!! \VoyagerAlbums::shortcode(article,'albums.test_template') !!}
</pre>


<h2>Config file</h3> 
<pre>
    'albums_shortcode' => true, //albums shortcut enable | disable  

    'slug_shortcut'=> true, //editor slug search album | [album('%slug%');] or [album(slug:'%slug%'),ids('%image ids% 5,3,2');]

    'id_shortcut'=> true, //editor id search album | [album(%album id%);] or [album(id:1),ids('3,7');]

    'image_exif_data'=> true, //Album image exif data return array |$image->exif(); | $image->exif()['FileName'];

    'default_album_template'=> "default", //default - bootstrap - special | default template

    'template_folder' => [
        'default' => 'albums.default',
        'bootstrap' => 'albums.bootstrap',
        'special' => 'albums.special',
    ],
    
    'image_folder'=>url('/storage'), // image storage folder //example www.webname.app/storage / for paths within the package.
 
</pre>
 <img width="100%" src="https://github.com/trker/VoyagerAwesomeAlbums/blob/master/publishable/images/1.jpg?raw=true">
  <img width="100%" src="https://github.com/trker/VoyagerAwesomeAlbums/blob/master/publishable/images/2.jpg?raw=true">
