<?php

namespace trker\VoyagerAwesomeAlbums;

use Validator;
use Voyager;
use VoyagerAlbums\Models\Albums;
use VoyagerAlbums\Models\AlbumsRow;
use Illuminate\View\View;
use function GuzzleHttp\Psr7\str;


class VoyagerAlbums{





    public static function shortcode($string,$path=null)
    {

        if(config('albums.albums_shortcode')== false)
        {
            return $string;
        }

        if ($path==null)
        {
           $tmp=config('albums.default_album_template');
           $path=config('albums.template_folder.'.$tmp);
        }
        else{
            if(!empty(config('albums.template_folder.'.$path))){
                $path=config('albums.template_folder.'.$path);
            }

        }



        if (config('albums.slug_shortcut')==true)
        {
            //slug ile shortcut arama // Shortcut search with slug
            //album('deneme-albums');]
            $find_album_fnk = VoyagerAlbums::ikiStringArasiniAl($string,"[album('","');]");
            //[album(slug:'deneme-albums'),ids('1,5,3,66,32,12,32,66');]
            $find_album_img_fnk = VoyagerAlbums::ikiStringArasiniAl($string,"[album(slug:'","'),ids('");

            //functions
            if ($find_album_fnk)
            {
                //albüm
                foreach($find_album_fnk as $string_val)
                {
                    if (!empty($string_val))
                    {
                        $func_name="[album('".$string_val."');]";
                        $album= Albums::whereslug($string_val)->wherestatus(1)->first();

                        if ($album)
                        {
                            $replace= \view($path,compact('album'));
                            @$string =  str_replace($func_name, " ".$replace, $string);
                        }


                    }

                }
            }
            if ($find_album_img_fnk)
            {

                $album="";
                foreach($find_album_img_fnk as $string_val)
                {
                    //  1,4,5,2,3,15
                    $album_img_ids_field = VoyagerAlbums::ikiStringArasiniAl($string,"[album(slug:'".$string_val."'),ids('","');]");

                    $img_ids = explode(",",$album_img_ids_field[0]);
                    if ($img_ids and !empty($string_val))
                    {



                        $func_name="[album(slug:'".$string_val."'),ids('".$album_img_ids_field[0]."');]";



                        $album= Albums::whereslug($string_val)->wherestatus(1)->first();

                        if (!empty($album))
                        {
                            foreach ($album->images as $key => $value)
                            {

                                if (array_search($value->id,$img_ids) === false){


                                    unset($album->images[$key]);

                                }


                            }

                            if ($album)
                            {


                                $replace= \view($path,compact('album'));
                                @$string =  str_replace($func_name, " ".$replace." ", $string);
                            }
                        }



                    }


                }
            }


        }
        if (config('albums.slug_shortcut')==true)
        {
            //id ile shortcut arama // Shortcut search with id
            //[album(1);]
            $find_album_id_fnk = VoyagerAlbums::ikiStringArasiniAl($string,"[album(",");]");
            //[album(id:1),ids('1,5,3,66,32,12,32,66');]
            $find_album_img_id_fnk = VoyagerAlbums::ikiStringArasiniAl($string,"[album(id:","),ids('");

            //functions

            if ($find_album_id_fnk)
            {
                $album="";
                foreach($find_album_id_fnk as $string_val)
                {
                    if (!empty($string_val))
                    {
                        $func_name="[album(".$string_val.");]";
                        $album= Albums::whereid($string_val)->wherestatus(1)->first();

                        if ($album)
                        {
                            $replace= \view($path,compact('album'));
                            @$string =  str_replace($func_name, $replace, $string);
                        }


                    }

                }
            }
            if ($find_album_img_id_fnk)
            {

                $album="";

                foreach($find_album_img_id_fnk as $string_val)
                {

                    $album_img_ids_field = VoyagerAlbums::ikiStringArasiniAl($string,"[album(id:".$string_val."),ids('","');]");

                    $img_ids = explode(",",$album_img_ids_field[0]);
                    if ($img_ids and !empty($string_val))
                    {



                        $func_name="[album(id:".$string_val."),ids('".$album_img_ids_field[0]."');]";



                        $album= Albums::whereid($string_val)->wherestatus(1)->first();

                        if (!empty($album))
                        {
                            foreach ($album->images as $key => $value)
                            {

                                if (array_search($value->id,$img_ids) === false){


                                    unset($album->images[$key]);

                                }


                            }

                            if ($album)
                            {


                                $replace= \view($path,compact('album'));
                                @$string =  str_replace($func_name, " ".$replace." ", $string);
                            }
                        }



                    }


                }
            }

        }






        return  $string;




    }


private static function ikiStringArasiniAl($myStr, $startStr, $endStr)
{
    $myArr = explode($endStr,$myStr);

    foreach($myArr as $myVal)
    {
        $myVal = $myVal."[endOfString]";
        $returnArr[] = VoyagerAlbums::BetweenStr($myVal,$startStr,'[endOfString]');
    }

    return  $returnArr;
}

private static function BetweenStr($InputString, $StartStr, $EndStr=0, $StartLoc=0) {
    if (($StartLoc = strpos($InputString, $StartStr, $StartLoc)) === false) { return; }
    $StartLoc += strlen($StartStr);
    if (!$EndStr) { $EndStr = $StartStr; }
    if (!$EndLoc = strpos($InputString, $EndStr, $StartLoc)) { return; }
    return substr($InputString, $StartLoc, ($EndLoc-$StartLoc));
}
}

