<?php

namespace trker\VoyagerAwesomeAlbums\Http\Controllers;

use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Http\Controllers\Controller;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use Validator;
use Voyager;
use VoyagerAlbums\Models\Albums;
use VoyagerAlbums\Models\AlbumsRow;
use VoyagerThemes\Models\Theme;
use VoyagerThemes\Models\ThemeOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illumniate\Http\File;


class AlbumsController extends Controller
{

    use BreadRelationshipParser;
    public function index(Request $request){
        $albums=Albums::all();

// Check permission
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $this->authorize('browse', app($dataType->model_name));
        return view("Albums::index",compact('albums'));


    }

    public function create(Request $request)
    {


        $slug = "albums";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();



        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->addRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }


// Check permission
        $this->authorize('add', app($dataType->model_name));
        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view('Albums::edit-add', compact('dataType', 'dataTypeContent', 'isModelTranslatable'));


    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

            event(new BreadDataAdded($dataType, $data));

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('albums_lang.message.new_album',['album'=>$request->name]),
                    'alert-type' => 'success',
                ]);
        }
    }

    public function activate_album(Request $request){
        $slug = "albums";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

         $data=Albums::whereid($request->id)->firstOrFail();
         $data->status=1;
         $data->save();

        return redirect()->back()->with([
            'message'    => __('albums_lang.message.active_album',['album'=>$data->name]),
            'alert-type' => 'success',
        ]);

    }
    public function deactivate_album(Request $request){
        $slug = "albums";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

         $data=Albums::whereid($request->id)->firstOrFail();
         $data->status=0;
        $data->save();
        return redirect()
            ->back()
            ->with([
                'message'    => __('albums_lang.message.deactive_album',['album'=>$data->name]),
                'alert-type' => 'success',
            ]);

    }

    public function edit(Request $request, $id)
    {
        $slug = $this->getSlug($request);


        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $relationships = $this->getRelationships($dataType);

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? app($dataType->model_name)->with($relationships)->findOrFail($id)
            : DB::table($dataType->name)->where('id', $id)->first(); // If Model doest exist, get data from table name

        foreach ($dataType->editRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->editRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);
        $album=Albums::whereid($id)->firstOrFail();
        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);



        return Voyager::view('Albums::edit-add', compact('dataType', 'dataTypeContent', 'isModelTranslatable','album'));
    }
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }
        $album=Albums::whereid($request->id)->firstOrFail();
        if (!$request->ajax()) {
            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

            event(new BreadDataUpdated($dataType, $data));

            if (@$request->pgs==1){
                //fast upload return album image page

                //albüm image index redirect
                return redirect()
                    ->route("voyager.albums_images.index",$id)
                    ->with([
                        'message'    => __('albums_lang.message.album_edit',['album'=>$album->name]),
                        'alert-type' => 'success',
                    ]);
            }
            else{
                //albüm index redirect
                return redirect()
                    ->route("voyager.{$dataType->slug}.index")
                    ->with([
                        'message'    => __('albums_lang.message.album_edit',['album'=>$album->name]),
                        'alert-type' => 'success',
                    ]);
            }

        }
    }
    public function destroy(Request $request)
    {
        $slug = $this->getSlug($request);
        $id=$request->id;
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));

        // Init array of IDs
        $ids = [];
        $album=Albums::whereid($request->id)->firstOrFail();
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL or Model Binding
            $ids[] = $id instanceof Model ? $id->{$id->getKeyName()} : $id;
        }
        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
            $this->cleanup($dataType, $data);
        }

        $displayName = count($ids) > 1 ? $dataType->display_name_plural : $dataType->display_name_singular;

        $res = $data->destroy($ids);
        $data = $res
            ? [
                'message'    => __('albums_lang.message.album_delete',['album'=>$album->name]),
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('albums_lang.message.album_delete_error',['album'=>$displayName]),
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }



    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->where('type', 'image'));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            $files = json_decode($data->{$row->field});
            if ($files) {
                foreach ($files as $file) {
                    $this->deleteFileIfExists($file->download_link);
                }
            }
        }
    }

    public function deleteBreadImages($data, $rows)
    {
        foreach ($rows as $row) {
            $this->deleteFileIfExists($data->{$row->field});

            $options = json_decode($row->details);

            if (isset($options->thumbnails)) {
                foreach ($options->thumbnails as $thumbnail) {
                    $ext = explode('.', $data->{$row->field});
                    $extension = '.'.$ext[count($ext) - 1];

                    $path = str_replace($extension, '', $data->{$row->field});

                    $thumb_name = $thumbnail->name;

                    $this->deleteFileIfExists($path.'-'.$thumb_name.$extension);
                }
            }
        }

        if ($rows->count() > 0) {
            event(new BreadImagesDeleted($data, $rows));
        }
    }


}
