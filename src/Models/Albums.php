<?php

namespace VoyagerAlbums\Models;

use TCG\Voyager\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Albums extends Model
{
    use Translatable;
    //
    protected $translatable = [ ];// 'name' album name multiple langueage
    protected $table = 'voyager_albums';

    public function save(array $options = [])
{
    // If no author has been assigned, assign the current user's id as the author of the post
    if (!$this->author && Auth::user()) {
        $this->author = Auth::user()->id;
    }

    parent::save();
}

    protected $fillable = ['name', 'slug', 'status','author'];

    public  function images(){
    	return $this->hasMany('\VoyagerAlbums\Models\AlbumsImage', 'voyager_albums_id');
    }
}
