<?php

namespace trker\VoyagerAwesomeAlbums\Http\Controllers;

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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;


class AlbumsImageController extends Controller
{

    use BreadRelationshipParser;
    public function index($id){

       // album fast edit
        $slug = "albums";


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

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);


        $albums=Albums::whereid($id)->firstOrFail();



        return view("Albums::albums_image_index",compact('albums','dataType', 'dataTypeContent', 'isModelTranslatable'));
    }

    public function create(Request $request,$id)
    {




        $slug = "albums_image";

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
        $album= Albums::whereid($id)->firstOrFail();
      $id=$album->id;

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);




        return Voyager::view('Albums::album_image_edit_add', compact('dataType', 'dataTypeContent', 'isModelTranslatable','id','album'));


    }

    public function store(Request $request,$id)
    {
        $slug = "albums_image";

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validedBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = $this->insertUpdata($request, $slug, $dataType->addRows, $dataType);

            event(new BreadDataAdded($dataType, $data));
            $album=Albums::whereid($id)->firstOrFail();
            return redirect()
                ->route("voyager.albums_images.index",$id)
                ->with([
                    'message'    => __('albums_lang.message.album_new_image',['album'=>$album->name,'image_count'=>count($request->image)]),
                    'alert-type' => 'success',
                ]);
        }
    }



    public function edit(Request $request,$aid, $id)
    {

        $slug = "albums_image";


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
        $album= Albums::whereid($aid)->firstOrFail();
        $aid=$album->id;
        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);





        return Voyager::view('Albums::album_image_edit_add', compact('dataType', 'dataTypeContent', 'isModelTranslatable','aid','album'));
    }
    public function update(Request $request,$aid, $id)
    {
        $slug = "albums_image";



        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validedBread($request->all(), $dataType->editRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }
        $album=Albums::whereid($aid)->firstOrFail();
        if (!$request->ajax()) {
            $this->insertUpdata($request, $slug, $dataType->editRows, $data,'1');

            event(new BreadDataUpdated($dataType, $data));


            return redirect()
                ->route("voyager.albums_images.index",$aid)
                ->with([
                    'message'    => __('albums_lang.message.album_edit',['album'=>$album->name]),
                    'alert-type' => 'success',
                ]);
        }
    }
    public function destroy(Request $request,$aid)
    {
         $slug = "albums_image";
        $id=$request->id;
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('delete', app($dataType->model_name));
        $album=Albums::whereid($aid)->firstOrFail();
        // Init array of IDs
        $ids = [];
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
                'message'    =>__('albums_lang.message.album_image_delete',['album'=>$album->name]),
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('albums_lang.message.album_image_delete_error'),
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataDeleted($dataType, $data));
        }

        return redirect()->route("voyager.albums_images.index",$aid)->with($data);
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

    ///////////////////////////
    ///
    public function insertUpdata($request, $slug, $rows, $dataType,$edit=0)
    {
        $multi_select = [];




        foreach ($rows as $row) {
            if ($row->type=="multiple_images"){

                $image = $this->getContentBsdOnType($request, $slug, $row);
            }
        }


        if (count($image)>0)
        {
            foreach ($image as $img){

                if ($edit==1)
                {
                    $data=$dataType;
                }
                else
                {
                    $data= new $dataType->model_name();
                }

                $translations = is_bread_translatable($data)
                    ? $data->prepareTranslations($request)
                    : [];
                foreach ($rows as $row) {
                    $options = json_decode($row->details);

                    if ($row->type == 'relationship' && $options->type != 'belongsToMany') {
                        $row->field = @$options->column;
                    }

                    // if the field for this row is absent from the request, continue
                    // checkboxes will be absent when unchecked, thus they are the exception
                    if (!$request->has($row->field) && $row->type !== 'checkbox') {
                        continue;
                    }

                    $content = $this->getContentBsdOnType($request, $slug, $row);

                    /*
                     * merge ex_images and upload images
                     */
                    if ($row->type == 'multiple_images' && !is_null($content)) {
                        if (isset($data->{$row->field})) {
                            $ex_files = json_decode($data->{$row->field}, true);
                            if (!is_null($ex_files)) {
                                $content = json_encode(array_merge($ex_files, json_decode($content)));
                            }
                        }
                    }

                    if (is_null($content)) {

                        // If the image upload is null and it has a current image keep the current image
                        if ($row->type == 'image' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                            $content = $data->{$row->field};
                        }

                        // If the multiple_images upload is null and it has a current image keep the current image
                        if ($row->type == 'multiple_images' && is_null($request->input($row->field)) && isset($data->{$row->field})) {
                            $content = $data->{$row->field};
                        }

                        // If the file upload is null and it has a current file keep the current file
                        if ($row->type == 'file') {
                            $content = $data->{$row->field};
                        }

                        if ($row->type == 'password') {
                            $content = $data->{$row->field};
                        }
                    }

                    if ($row->type == 'relationship' && $options->type == 'belongsToMany') {
                        // Only if select_multiple is working with a relationship
                        $multi_select[] = ['model' => $options->model, 'content' => $content, 'table' => $options->pivot_table];
                    } else {
                        $data->{$row->field} = $content;
                    }
                }


                $data->image=$img;
                $data->save();

            }

        }
        else{
            //0 resim ise
        }



        // Save translations
        if (count($translations) > 0) {
            $data->saveTranslations($translations);
        }

        foreach ($multi_select as $sync_data) {
            $data->belongsToMany($sync_data['model'], $sync_data['table'])->sync($sync_data['content']);
        }

        return $data;
    }

    public function validedBread($request, $data)
    {
        $rules = [];
        $messages = [];

        foreach ($data as $row) {


            $options = json_decode($row->details);

            if (isset($options->validation)) {
                if (isset($options->validation->rule)) {
                    if (!is_array($options->validation->rule)) {

                        if ($row->type=="multiple_images"){
                            $rules[$row->field.".*"] = explode('|', $options->validation->rule);
                        }
                        else{
                            $rules[$row->field] = explode('|', $options->validation->rule);
                        }
                    } else {
                        if ($row->type=="multiple_images"){
                            $rules[$row->field.".*"] = $options->validation->rule;
                        }
                        else{
                            $rules[$row->field] = $options->validation->rule;
                        }

                    }
                }

                if (isset($options->validation->messages)) {
                    foreach ($options->validation->messages as $key => $msg) {

                        if ($row->type=="multiple_images"){
                            if ($row->field=="image")
                            {

                                $messages[$row->field.".*".'.'.$key] = $row->field." ".$msg;
                            }


                        }
                        else{
                            $messages[$row->field.'.'.$key] = $msg;
                        }

                    }
                }
            }
        }

        return Validator::make($request, $rules, $messages);
    }

    public function getContentBsdOnType(Request $request, $slug, $row)
    {
        $content = null;
        switch ($row->type) {
            /********** PASSWORD TYPE **********/
            case 'password':
                $pass_field = $request->input($row->field);

                if (isset($pass_field) && !empty($pass_field)) {
                    return bcrypt($request->input($row->field));
                }

                break;

            /********** CHECKBOX TYPE **********/
            case 'checkbox':
                $checkBoxRow = $request->input($row->field);

                if (isset($checkBoxRow)) {
                    return 1;
                }

                $content = 0;

                break;

            /********** FILE TYPE **********/
            case 'file':
                if ($files = $request->file($row->field)) {
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    $filesPath = [];
                    foreach ($files as $key => $file) {
                        $filename = Str::random(20);
                        $path = $slug.'/'.date('FY').'/';
                        $file->storeAs(
                            $path,
                            $filename.'.'.$file->getClientOriginalExtension(),
                            config('voyager.storage.disk', 'public')
                        );
                        array_push($filesPath, [
                            'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                            'original_name' => $file->getClientOriginalName(),
                        ]);
                    }

                    return json_encode($filesPath);
                }
            // no break
            /********** MULTIPLE IMAGES TYPE **********/
            case 'multiple_images':
                if ($files = $request->file($row->field)) {
                    /**
                     * upload files.
                     */
                    $filesPath = [];

                    $options = json_decode($row->details);

                    if (isset($options->resize) && isset($options->resize->width) && isset($options->resize->height)) {
                        $resize_width = $options->resize->width;
                        $resize_height = $options->resize->height;
                    } else {
                        $resize_width = 1800;
                        $resize_height = null;
                    }

                    foreach ($files as $key => $file) {
                        $filename = Str::random(20);
                        $path = $slug.'/'.date('FY').'/';
                        array_push($filesPath, $path.$filename.'.'.$file->getClientOriginalExtension());
                        $filePath = $path.$filename.'.'.$file->getClientOriginalExtension();

                        $image = Image::make($file)->resize($resize_width, $resize_height,
                            function (Constraint $constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })->encode($file->getClientOriginalExtension(), 75);

                        Storage::disk(config('voyager.storage.disk'))->put($filePath, (string) $image, 'public');

                        if (isset($options->thumbnails)) {
                            foreach ($options->thumbnails as $thumbnails) {
                                if (isset($thumbnails->name) && isset($thumbnails->scale)) {
                                    $scale = intval($thumbnails->scale) / 100;
                                    $thumb_resize_width = $resize_width;
                                    $thumb_resize_height = $resize_height;

                                    if ($thumb_resize_width != null) {
                                        $thumb_resize_width = $thumb_resize_width * $scale;
                                    }

                                    if ($thumb_resize_height != null) {
                                        $thumb_resize_height = $thumb_resize_height * $scale;
                                    }

                                    $image = Image::make($file)->resize($thumb_resize_width, $thumb_resize_height,
                                        function (Constraint $constraint) {
                                            $constraint->aspectRatio();
                                            $constraint->upsize();
                                        })->encode($file->getClientOriginalExtension(), 75);
                                } elseif (isset($options->thumbnails) && isset($thumbnails->crop->width) && isset($thumbnails->crop->height)) {
                                    $crop_width = $thumbnails->crop->width;
                                    $crop_height = $thumbnails->crop->height;
                                    $image = Image::make($file)
                                        ->fit($crop_width, $crop_height)
                                        ->encode($file->getClientOriginalExtension(), 75);
                                }

                                Storage::disk(config('voyager.storage.disk'))->put($path.$filename.'-'.$thumbnails->name.'.'.$file->getClientOriginalExtension(),
                                    (string) $image, 'public'
                                );
                            }
                        }
                    }

                    return $filesPath;
                }
                break;

            /********** SELECT MULTIPLE TYPE **********/
            case 'select_multiple':
                $content = $request->input($row->field);

                if ($content === null) {
                    $content = [];
                } else {
                    // Check if we need to parse the editablePivotFields to update fields in the corresponding pivot table
                    $options = json_decode($row->details);
                    if (isset($options->relationship) && !empty($options->relationship->editablePivotFields)) {
                        $pivotContent = [];
                        // Read all values for fields in pivot tables from the request
                        foreach ($options->relationship->editablePivotFields as $pivotField) {
                            if (!isset($pivotContent[$pivotField])) {
                                $pivotContent[$pivotField] = [];
                            }
                            $pivotContent[$pivotField] = $request->input('pivot_'.$pivotField);
                        }
                        // Create a new content array for updating pivot table
                        $newContent = [];
                        foreach ($content as $contentIndex => $contentValue) {
                            $newContent[$contentValue] = [];
                            foreach ($pivotContent as $pivotContentKey => $value) {
                                $newContent[$contentValue][$pivotContentKey] = $value[$contentIndex];
                            }
                        }
                        $content = $newContent;
                    }
                }

                return json_encode($content);

            /********** IMAGE TYPE **********/
            case 'image':
                if ($request->hasFile($row->field)) {
                    $file = $request->file($row->field);
                    $options = json_decode($row->details);

                    $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
                    $filename_counter = 1;

                    $path = $slug.'/'.date('FY').'/';

                    // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
                    while (Storage::disk(config('voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
                    }

                    $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

                    if (isset($options->resize) && isset($options->resize->width) && isset($options->resize->height)) {
                        $resize_width = $options->resize->width;
                        $resize_height = $options->resize->height;
                    } else {
                        $resize_width = 1800;
                        $resize_height = null;
                    }

                    $image = Image::make($file)->resize($resize_width, $resize_height,
                        function (Constraint $constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })->encode($file->getClientOriginalExtension(), 75);

                    if ($this->is_animated_gif($file)) {
                        Storage::disk(config('voyager.storage.disk'))->put($fullPath, file_get_contents($file), 'public');
                        $fullPathStatic = $path.$filename.'-static.'.$file->getClientOriginalExtension();
                        Storage::disk(config('voyager.storage.disk'))->put($fullPathStatic, (string) $image, 'public');
                    } else {
                        Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public');
                    }

                    if (isset($options->thumbnails)) {
                        foreach ($options->thumbnails as $thumbnails) {
                            if (isset($thumbnails->name) && isset($thumbnails->scale)) {
                                $scale = intval($thumbnails->scale) / 100;
                                $thumb_resize_width = $resize_width;
                                $thumb_resize_height = $resize_height;

                                if ($thumb_resize_width != null && $thumb_resize_width != 'null') {
                                    $thumb_resize_width = intval($thumb_resize_width * $scale);
                                }

                                if ($thumb_resize_height != null && $thumb_resize_height != 'null') {
                                    $thumb_resize_height = intval($thumb_resize_height * $scale);
                                }

                                $image = Image::make($file)->resize($thumb_resize_width, $thumb_resize_height,
                                    function (Constraint $constraint) {
                                        $constraint->aspectRatio();
                                        $constraint->upsize();
                                    })->encode($file->getClientOriginalExtension(), 75);
                            } elseif (isset($options->thumbnails) && isset($thumbnails->crop->width) && isset($thumbnails->crop->height)) {
                                $crop_width = $thumbnails->crop->width;
                                $crop_height = $thumbnails->crop->height;
                                $image = Image::make($file)
                                    ->fit($crop_width, $crop_height)
                                    ->encode($file->getClientOriginalExtension(), 75);
                            }

                            Storage::disk(config('voyager.storage.disk'))->put($path.$filename.'-'.$thumbnails->name.'.'.$file->getClientOriginalExtension(),
                                (string) $image, 'public'
                            );
                        }
                    }

                    return $fullPath;
                }
                break;

            /********** TIMESTAMP TYPE **********/
            case 'timestamp':
                $content = $request->input($row->field);
                if (in_array($request->method(), ['PUT', 'POST'])) {
                    if (empty($request->input($row->field))) {
                        $content = null;
                    } else {
                        $content = gmdate('Y-m-d H:i:s', strtotime($request->input($row->field)));
                    }
                }
                break;

            /********** COORDINATES TYPE **********/
            case 'coordinates':
                if (empty($coordinates = $request->input($row->field))) {
                    $content = null;
                } else {
                    //DB::connection()->getPdo()->quote won't work as it quotes the
                    // lat/lng, which leads to wrong Geometry type in POINT() MySQL constructor
                    $lat = (float) ($coordinates['lat']);
                    $lng = (float) ($coordinates['lng']);
                    $content = DB::raw('ST_GeomFromText(\'POINT('.$lat.' '.$lng.')\')');
                }
                break;

            case 'relationship':
                return $request->input($row->field);
                break;

            /********** ALL OTHER TEXT TYPE **********/
            default:
                $value = $request->input($row->field);
                $options = json_decode($row->details);
                if (isset($options->null)) {
                    return $value == $options->null ? null : $value;
                }

                return $value;
        }

        return $content;
    }





}
