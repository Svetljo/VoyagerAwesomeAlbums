<?php

namespace trker\VoyagerAwesomeAlbums;

use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class VoyagerAwesomeAlbumsServiceProvider extends ServiceProvider
{
    private $models = [
        'Albums',
        'AlbumsImage'
    ];

    public function boot(){
        $this->registerPublishableResources();
    }

    public function register()
    {
        if(request()->is(config('voyager.prefix')) || request()->is(config('voyager.prefix').'/*')){
            $this->addAlbumsTable();

            app(Dispatcher::class)->listen('voyager.menu.display', function ($menu) {
                $this->addAlbumsMenuItem($menu);
            });

            app(Dispatcher::class)->listen('voyager.admin.routing', function ($router) {
                $this->addAlbumsRoutes($router);
            });
            $this->registerPublishableResources();

        }



        // load helpers
        @include(__DIR__.'/helpers.php');

        $this->loadModels();
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'Albums');






    }

    public function addAlbumsRoutes($router)
    {
        $namespacePrefix = '\\trker\\VoyagerAwesomeAlbums\\Http\\Controllers\\';


        $router->post('albums/upload', ['uses' => $namespacePrefix.'AlbumsImageController@upload',     'as' => 'albums.image.upload']);//+

        $router->get('albums', ['uses' => $namespacePrefix.'AlbumsController@index',   'as' => 'albums.index']);//+
        $router->get('albums/create', ['uses' => $namespacePrefix.'AlbumsController@create',     'as' => 'albums.create']);//+
        $router->post('albums', ['uses' => $namespacePrefix.'AlbumsController@store',     'as' => 'albums.store']);//+
        $router->get('albums/{id}/activate', ['uses' => $namespacePrefix.'AlbumsController@activate_album',     'as' => 'albums.activate']);//+
        $router->get('albums/{id}/deactivate', ['uses' => $namespacePrefix.'AlbumsController@deactivate_album',     'as' => 'albums.deactivate']);//+
        $router->get('albums/{id}/edit', ['uses' => $namespacePrefix.'AlbumsController@edit', 'as' => 'albums.edit']);//+
        $router->post('albums/{id}/edit', ['uses' => $namespacePrefix.'AlbumsController@update', 'as' => 'albums.update']);//+
        $router->delete('albums/delete', ['uses' => $namespacePrefix.'AlbumsController@destroy', 'as' => 'albums.delete']);//+

        $router->get('albums/{id}', ['uses' => $namespacePrefix.'AlbumsImageController@index',   'as' => 'albums_images.index']);//+
        $router->post('albums/{id}', ['uses' => $namespacePrefix.'AlbumsImageController@store',   'as' => 'albums_images.store']);//+
        $router->get('albums/{id?}/create', ['uses' => $namespacePrefix.'AlbumsImageController@create', 'as' => 'albums_images.create']);

        $router->get('albums/{id}/{image_id}/edit', ['uses' => $namespacePrefix.'AlbumsImageController@edit', 'as' => 'albums_images.edit']);
        $router->post('albums/{id}/{image_id}/edit', ['uses' => $namespacePrefix.'AlbumsImageController@update', 'as' => 'albums_images.update']);
        $router->delete('albums/{aid}/image_delete', ['uses' => $namespacePrefix.'AlbumsImageController@destroy', 'as' => 'albums_images.delete']);
        $router->get('albums/options', function(){ return redirect( route('voyager.albums.index') ); });

    }

    public function addAlbumsMenuItem(Menu $menu)
    {

        if ($menu->name == 'admin') {
            $url = route('voyager.albums.index', [], false);
            $menuItem = $menu->items->where('url', $url)->first();
            if (is_null($menuItem)) {
                $menu->items->add(MenuItem::create([
                    'menu_id'    => $menu->id,
                    'url'        => $url,
                    'title'      => 'Albums',
                    'target'     => '_self',
                    'icon_class' => 'voyager-paint-bucket',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 98,
                ]));

                $this->ensurePermissionExist();
                return redirect()->back();
            }
        }

    }

    private function loadModels(){
        foreach($this->models as $model){
            @include(__DIR__ . '/Models/' . $model . '.php');
        }
    }
    protected function ensurePermissionExist()
    {
        $table_name="voyager_albums";
        $table_name2="voyager_albums_image";

        $permission[0]= Permission::firstOrNew(['key' => 'browse_'.$table_name, 'table_name' => $table_name]);
        $permission[1]= Permission::firstOrNew(['key' => 'read_'.$table_name, 'table_name' => $table_name]);
        $permission[2]= Permission::firstOrNew(['key' => 'edit_'.$table_name, 'table_name' => $table_name]);
        $permission[3]= Permission::firstOrNew(['key' => 'add_'.$table_name, 'table_name' => $table_name]);
        $permission[4]= Permission::firstOrNew(['key' => 'delete_'.$table_name, 'table_name' => $table_name]);

        $permission2[0]= Permission::firstOrNew(['key' => 'browse_'.$table_name2, 'table_name' => $table_name2]);
        $permission2[1]= Permission::firstOrNew(['key' => 'read_'.$table_name2, 'table_name' => $table_name2]);
        $permission2[2]= Permission::firstOrNew(['key' => 'edit_'.$table_name2, 'table_name' => $table_name2]);
        $permission2[3]= Permission::firstOrNew(['key' => 'add_'.$table_name2, 'table_name' => $table_name2]);
        $permission2[4]= Permission::firstOrNew(['key' => 'delete_'.$table_name2, 'table_name' => $table_name2]);

        foreach ($permission as $key => $value ){
            if (!$permission[$key]->exists) {
                $permission[$key]->save();
                $role = Role::where('name', 'admin')->first();
                if (!is_null($role)) {
                    $role->permissions()->attach($permission[$key]);
                }

            }
        }
        foreach ($permission2 as $key => $value ){
            if (!$permission2[$key]->exists) {
                $permission2[$key]->save();
                $role = Role::where('name', 'admin')->first();
                if (!is_null($role)) {
                    $role->permissions()->attach($permission2[$key]);
                }
            }

        }


/*

      $permission = Permission::firstOrNew([
            'key'        => 'browse_albums',
            'table_name' => 'admin',
        ]);

        if (!$permission->exists) {
            $permission->save();
            $role = Role::where('name', 'admin')->first();
            if (!is_null($role)) {
                $role->permissions()->attach($permission);
            }
        }
*/
    }

    private function addAlbumsTable(){

        if(!Schema::hasTable('voyager_albums')){
            Schema::create('voyager_albums', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('author')->nullable()->default(0);
                $table->string('cover_image');
                $table->string('slug')->unique();
                $table->tinyInteger('status')->default(0);

                $table->timestamps();
            });

            Schema::create('voyager_albums_image', function (Blueprint $table) {
                $table->increments('id');
                $table->string('author')->nullable()->default(0);
                $table->integer('voyager_albums_id')->unsigned()->index();
                $table->foreign('voyager_albums_id')->references('id')->on('voyager_albums')->onDelete('cascade');
                $table->string('name')->nullable();
                $table->text('image');
                $table->integer('sort')->default(1);
                $table->timestamps();
            });

            //voyager adaptive bread
            $this->VoyagerBreadAdaptive();


            $migration=DB::table('migrations')->max('batch');
            DB::table('migrations')->insert(
                ['migration' => "2017_11_04_181207_CreateVoyagerAwesomeAlbumDB", 'batch' => $migration]
            );



        }
    }

    private function VoyagerBreadAdaptive(){


    //Voyager_Albums Table DataType and RowType Add
        $datatype = DB::table('data_types')->insertGetId(
            [
                'name' => "voyager_albums",
                'slug' => "albums",
                'display_name_singular' => "Image Album",
                'display_name_plural' => "Image Albums",
                'icon' => "voyager-images",
                'model_name' => "VoyagerAlbums\Models\Albums",
                'policy_name' => null,
                'controller' => '\trker\VoyagerAwesomeAlbums\Http\Controllers\AlbumsController',
                'description' => 'Voyager Admin Image Albums',
                'generate_permissions' => true,
                'server_side' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        $name='{"validation":{"rule":"required|max:25","messages":{"required":"This :attribute field is a must.","max":"This :Maximum 25 Char."}}}';
        $cover_image='{"validation":{"rule":"image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=1000,max_height=1000,min_width=250,min_height=250,ratio=1/1","messages":{"image":"This: Picture Only.","mimes":"This: jpeg,png,jpg,gif and max 2048kb Only","max":"This: Max 2048kb   ","dimensions":"minimum 250x250 maximum 1000x1000 aspect ratio 1/1","dimensions.ratio":"This :aspect ratio 1/1 only."}}}';
        $slug='{"slugify":{"origin":"name"}}';
        $status='{"on":"Active","off":"Passive","checked":"true"}';
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype,
                'field' => "name",
                'type' => "text",
                'display_name' => "name",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
                'required' =>true,
                'details'=>$name]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype,
                'field' => "id",
                'type' => "hidden",
                'display_name' => "id",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
                'required' =>true,
                'details'=>null]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype,
                'field' => "cover_image",
                'type' => "image",
                'display_name' => "Cover Image",
                'browse' => 0,
                'read' => 0,
                'edit' => 1,
                'add' => 1,
                'delete' => 0,
                'order' => 2,
                'required' =>false,
                'details'=>$cover_image]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype,
                'field' => "slug",
                'type' => "text",
                'display_name' => "Slug",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 0,
                'order' => 3,
                'required' =>true,
                'details'=>$slug]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype,
                'field' => "status",
                'type' => "checkbox",
                'display_name' => "Status",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 0,
                'order' => 4,
                'required' =>true,
                'details'=>$status]
        );
    //Voyager_Albums_Image Table DataType and RowType Add
        $datatype2 = DB::table('data_types')->insertGetId(
            [
                'name' => "voyager_albums_image",
                'slug' => "albums_image",
                'display_name_singular' => "Image Album",
                'display_name_plural' => "Image Albums",
                'icon' => "voyager-images",
                'model_name' => "VoyagerAlbums\Models\AlbumsImage",
                'policy_name' => null,
                'controller' => '\trker\VoyagerAwesomeAlbums\Http\Controllers\AlbumsImageController',
                'description' => 'Voyager Admin Image Albums',
                'generate_permissions' => true,
                'server_side' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        $name2='{"validation":{"rule":"max:55","messages":{"max":"This :Maximum 55 Char."}}}';
        $image='{"validation":{"rule":"image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:max_width=1600,max_height=1600,min_width=250,min_height=250","messages":{"image":"This: Picture Only.","mimes":"This: jpeg,png,jpg,gif and max 2048kb Only","max":"This: Max 2048kb   ","dimensions":"minimum 250x250 maximum 1600x1600","dimensions.ratio":"This :aspect ratio 1/1 only."}}}';
        $sort='';
        $voyager_albums_id='';
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype2,
                'field' => "name",
                'type' => "text",
                'display_name' => "name",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
                'required' =>false,
                'details'=>$name2]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype2,
                'field' => "voyager_albums_id",
                'type' => "text",
                'display_name' => "Albums id",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
                'required' =>true,
                'details'=>$voyager_albums_id]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype2,
                'field' => "id",
                'type' => "hidden",
                'display_name' => "id",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 1,
                'order' => 1,
                'required' =>true,
                'details'=>null]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype2,
                'field' => "image",
                'type' => "multiple_images",
                'display_name' => "Image",
                'browse' => 0,
                'read' => 0,
                'edit' => 1,
                'add' => 1,
                'delete' => 0,
                'order' => 2,
                'required' =>false,
                'details'=>$image]
        );
        DB::table('data_rows')->insert(
            [
                'data_type_id'=>$datatype2,
                'field' => "sort",
                'type' => "text",
                'display_name' => "Sort",
                'browse' => 1,
                'read' => 1,
                'edit' => 1,
                'add' => 1,
                'delete' => 0,
                'order' => 3,
                'required' =>false,
                'details'=>$sort]
        );




    }
    private function registerPublishableResources()
    {
        $publishablePath = __DIR__.'/../publishable';

        $publishable = [

            'migrations' => [
                "{$publishablePath}/database/migrations/" => database_path('migrations'),
            ],
            'lang' => [
                "{$publishablePath}/lang/" => base_path('resources/lang/'),
            ],
            'config' => [
                "{$publishablePath}/config/" => base_path('config'),
            ],
            'resources' => [
                "{$publishablePath}/resources/" => base_path('resources'),
            ],
        ];

        //folder image
        $this->publishes([
            "{$publishablePath}/images/" =>  base_path('public/'.config('voyager.assets_path').'/images'),
        ]);
        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }



}


