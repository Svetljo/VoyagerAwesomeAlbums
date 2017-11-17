<?php

/*
 *
if (!function_exists(album_find)){

    function album_find($string,$path=null){


     $albums = \VoyagerAlbums\Models\Albums::all();
     foreach ($albums as $album)
     {
         $func_name="album('".$album->slug."');";

         $query= strpos($string, $func_name );
         if ($query !== false ){
             // function var
             ob_start();

             $replace = $path;


             $string = str_replace($func_name, $replace, $string);


         }
     }
        return $string;
    }

}
if (!function_exists(theme_field)){

	function theme_field($type, $key, $title, $content = '', $details = '', $placeholder = '', $required = 1){
		
		$theme = \VoyagerThemes\Models\Theme::where('folder', '=', ACTIVE_THEME_FOLDER)->first();

		$option_exists = $theme->options->where('key', '=', $key)->first();

		if(isset($option_exists->value)){
			$content = $option_exists->value;
		}

		$row = (object)['required' => $required, 'field' => $key, 'type' => $type, 'details' => $details, 'display_name' => $placeholder];
		$dataTypeContent = (object)[$key => $content];
		$label = '<label for="'. $key . '">' . $title . '<span class="how_to">You can reference this value with <code>theme(\'' . $key . '\')</code></span></label>';
		$details = '<input type="hidden" value="' . $details . '" name="' . $key . '_details__theme_field">';
		$type = '<input type="hidden" value="' . $type . '" name="' . $key . '_type__theme_field">';
		return $label . app('voyager')->formField($row, '', $dataTypeContent) . $details . $type . '<hr>';
	}

}



if(!function_exists(theme_folder)){
	function theme_folder($folder_file = ''){

		if(defined('VOYAGER_THEME_FOLDER') && VOYAGER_THEME_FOLDER){
			return 'themes/' . VOYAGER_THEME_FOLDER . $folder_file;
		}

		$theme = \VoyagerThemes\Models\Theme::where('active', '=', 1)->first();
		define('VOYAGER_THEME_FOLDER', $theme->folder);
		return 'themes/' . $theme->folder . $folder_file;
	}
}

if(!function_exists(theme_folder_url)){
	function theme_folder_url($folder_file = ''){

		if(defined('VOYAGER_THEME_FOLDER') && VOYAGER_THEME_FOLDER){
			return url('themes/' . VOYAGER_THEME_FOLDER . $folder_file);
		}

		$theme = \VoyagerThemes\Models\Theme::where('active', '=', 1)->first();
		define('VOYAGER_THEME_FOLDER', $theme->folder);
		return url('themes/' . $theme->folder . $folder_file);
	}
}

*/