<?php

namespace VoyagerAlbums\Models;

use TCG\Voyager\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AlbumsImage extends Model
{
    use Translatable;
    //
    protected $translatable = [ ];// 'name' album name multiple langueage
	protected $table = 'voyager_albums_image';


    protected $fillable = ['voyager_albums_id', 'name', 'image', 'thumbnail', 'sort'];

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author && Auth::user()) {
            $this->author = Auth::user()->id;
        }

        parent::save();
    }


    public function exif(){


        if (config('albums.image_exif_data')== true)
        {
            return $exif_data = exif_read_data(public_path('/storage/'.$this->image));
        }
        else{
            return "this function is disabled!";
        }


    }
}
