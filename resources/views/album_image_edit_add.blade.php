@extends('voyager::master')


@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">

        #albumss{
            margin-top:20px;
        }

        #albums .page-title{
            background-image: linear-gradient(120deg, #478dc7 0%, #d21e29 100%);
            color:#fff;
            width:100%;
            border-radius:3px;
            margin-bottom:15px;
            overflow:hidden;

        }
        #albums .page-title small{
            margin-left:10px;
            color:rgba(255, 255, 255, 0.85);
        }

        #albums .page-title:after {
            content: '';
            width: 110%;
            background: rgba(255, 255, 255, 0.1);
            position: absolute;
            bottom: -24px;
            z-index: 9;
            display: block;
            transform: rotate(-2deg);
            height: 50px;
            right: 0px;
        }

        #albums .page-title:before {
            content: '';
            width: 110%;
            background: rgba(0, 0, 0, 0.04);
            position: absolute;
            top: -20px;
            z-index: 9;
            display: block;
            transform: rotate(2deg);
            height: 50px;
            left: 0px;
        }

        .albums_thumb{
            max-height: 200px;
            max-width: 200px;
            width: 100%;
            object-fit: contain;
            object-position: center;
        }

        .albums{
            border:1px solid #f1f1f1;
            border-radius:3px;
        }

        .albums_details{
            border-top: 1px solid #eaeaea;
            padding: 15px;
        }

        .albums_details:after{
            display:block;
            clear:both;
            content:'';
            width:100%;
        }

        .panel-body .albums_details h4{
            margin-top:10px;
            float:left;
        }

        .albums_details a i, .albums_details span i{
            position:relative;
            top:2px;
            margin-bottom:0px;
        }

        .albums_details a.btn{
            color:#79797f;
            border:1px solid #e1e1e1;
        }

        .albums_details a.btn:hover{
            background:#2ecc71;
            border-color:#2ecc71;
            color:#fff;
        }

        .albums_details span{
            cursor:default;
        }
        .albums-options{
            padding: 8px 10px;
            border: 1px solid #e1e1e1;
            border-radius: 3px;
            float: right;
            width: 36px;
            height: 36px;
            margin-top: 5px;
            margin-right: 10px;
            cursor: pointer;
            transition:all 0.3s ease;
        }
        .albums-options:hover{
            background: #cccccc;
            border: 1px solid #ddd;
        }

        .albums-options-trash{
            padding: 8px 10px;
            border: 1px solid #e1e1e1;
            border-radius: 3px;
            float: right;
            width: 36px;
            height: 36px;
            margin-top: 5px;
            margin-right: 10px;
            cursor: pointer;
            transition:all 0.3s ease;
        }
        .albums-options-trash:hover{
            background:#FA2A00;
            border: 1px solid #FA2A00;
            color:#fff;
        }

        .row>[class*=col-]{
            margin-bottom:0px;
        }

        h2{
            padding-top:10px;
        }
        .albums_details h4{
            position:relative;
        }
        .albums_details h4 span{
            font-size: 10px;
            position: absolute;
            right: 0px;
            bottom: -12px;
            color: #999;
            font-weight: lighter;
        }

        .add_btn{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        .add_btn2{

            display: block;
        }
        .add_btn i,.add_btn2 i{
            font-size: 35px;
        }
        .album_box{
            margin-bottom: 10px;
            margin-top: 10px;
            display: block;

        }
        .album-heading{
            margin-top: 5px !important;
        }
        @media (max-width : 768px) {
            .album-heading{

            }
        }


        .albums-prews- {
            width: 200px;
            height: 100px;
            margin: 0 -25px;
            position: relative;
            box-shadow: 0px 0px 110px -5px rgba(0, 0, 0, 0.21);
            background-size: cover;
            background-position: top;
            border-radius: 5px;
            -webkit-transition: .2s;
            transition: .2s;
            cursor: pointer;
        }
        .albums-prews-:hover {
            -webkit-transition: .2s;
            transition: .2s;
            -webkit-transform: translateZ(5px) translateY(-20px) scale(1.05);
            transform: translateZ(5px) translateY(-20px) scale(1.05);
        }

        .albums-prews--1,
        .albums-prews--4 {
            -webkit-transform: translateZ(1px);
            transform: translateZ(1px);
        }

        .albums-prews--2,
        .albums-prews--5 {
            -webkit-transform: translateZ(2px) translateY(-5px);
            transform: translateZ(2px) translateY(-5px);
        }

        .albums-prews--3 {
            -webkit-transform: translateZ(3px) translateY(-10px);
            transform: translateZ(3px) translateY(-10px);
        }

        .albums-prews--1:hover ~ .albums-prews--2 {
            -webkit-transform: translateZ(4px) translateY(-15px);
            transform: translateZ(4px) translateY(-15px);
            -webkit-transition: .2s;
            transition: .2s;
        }

        .albums-prews--4 {
            -webkit-box-ordinal-group: 6;
            -ms-flex-order: 5;
            order: 5;
        }
        .albums-prews--4:hover ~ .albums-prews--5 {
            -webkit-transform: translateZ(3px) translateY(-15px);
            transform: translateZ(3px) translateY(-15px);
            -webkit-transition: .1s;
            transition: .1s;
        }

        .shelf {
            background: none;
            height: 100px;
            width: 100%;
            position: absolute;
            bottom: -75px;
            left: 0;
            -webkit-transform: translateZ(10px);
            transform: translateZ(10px);
        }
        .containert {
            margin-top: 25px;
            margin-bottom: 25px;
            width: 100%;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-perspective: 1000;
            perspective: 1000;
            position: relative;
        }
.preview-img{
    max-width: 200px;
    max-height: 200px;
}

.tool-box{
    padding-left: 5px;
    position: absolute;
    left: -1px;
    top: -1px;
    border-radius: 5px 0px 5px 0px;
    background-color: rgba(255, 255, 255, 0.79);
    padding-right: 6px;
}
    </style>
@endsection
@section('page_title')
    @if(isset($dataTypeContent->id))
        {!! strip_tags(__('albums_lang.form.image_edit_heading')) !!}
    @else
        {!! strip_tags(__('albums_lang.form.image_add_heading',['album' => $album->name ])) !!}
    @endif
@endsection


@section('page_header')
    <div id="albums">
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        @if(isset($dataTypeContent->id))
            {!! __('albums_lang.form.image_edit_heading') !!}
        @else
            {!! __('albums_lang.form.image_add_heading',['album' => $album->name ]) !!}
        @endif
    </h1>
    </div>
    @include('voyager::multilingual.language-selector')

@stop

@section('content')


    <div class="page-content edit-add container-fluid">
          <div class="row">

            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->

                    <form role="form"
                            class="form-edit-add"
                            action="@if(isset($dataTypeContent->id)){{ route('voyager.albums_images.update',[$album->id,$dataTypeContent->id] ) }}@else {{ route('voyager.albums_images.store',$id) }}@endif"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->


                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">


                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                            @endphp





                                @if(@count($album->images)>0)
                                <div class="col-md-12">
                                    <div class='containert'>

                                        @php $i=0; @endphp
                                        <div>
                                            @if(@isset($dataTypeContent->image))

                                                <div    title="{!! $dataTypeContent->name !!}" class='albums-prews- albums-prews-0 aktif' style="color:black;border: 1px solid black;background-image:url({{ filter_var($dataTypeContent->image, FILTER_VALIDATE_URL) ? $dataTypeContent->image : Voyager::image( $dataTypeContent->image ) }})"><small class="tool-box">{!! __('albums_lang.album_image_post.edited_picture') !!}</small></div>

                                            @endif
                                        </div>
                                        @if(@isset($dataTypeContent->image))
                                            @foreach($album->images->where('id','!=',$dataTypeContent->id) as $image)
                                                @if($i<5)
                                                    <div title="{!! $image->name !!}" class='albums-prews- albums-prews-{!! $i++ !!}' style="background-image:url({!! url('/storage/'.$image->image) !!})"></div>
                                                @endif

                                            @endforeach
                                        @else
                                            @foreach($album->images as $image)
                                                @if($i<5)
                                                    <div title="{!! $image->name !!}" class='albums-prews- albums-prews-{!! $i++ !!}' style="background-image:url({!! url('/storage/'.$image->image) !!})"></div>
                                                @endif

                                            @endforeach
                                        @endif






                                                @if(count($album->images)>5)
                                                        <div   class='albums-prews- albums-prews-6' style="text-align: center;
    font-size: 60px;"> +{!! count($album->images)-5 !!} </div>


                                                    @endif



                                        <div class='shelf'></div>

                                    </div>
                                    <div style="text-align: right">
                                        <small>
                                        {!! __('albums_lang.album_image_post.prew_images_list',['album'=>$album->name]) !!}
                                        </small>
                                    </div>
<hr><h3>{!!  __('albums_lang.album_image_post.'.(isset($dataTypeContent->id) ? 'edit' : 'add' ),['album'=>@$album->name] ) !!}  </h3>

                                </div>
                                @endif


                                <div class="col-md-6">

                                    <div id="albums" >

                                        <div class="panel-heading">
                                            <div>


                                            </div>

                                        </div>
                                        <div class="panel-body">

                                            <input type="hidden" class="form-control" id="voyager_albums_id" name="voyager_albums_id" placeholder="{{ __('albums_lang.album_image_post.voyager_albums_id') }}" value="@if(isset($dataTypeContent->voyager_albums_id)){{ $dataTypeContent->voyager_albums_id }}@else {!! $album->id !!}@endif">
                                        </div>
                                    </div>
                                    <div id="name" >

                                        <div class="panel-heading">
                                            <label for="name">{{ __('albums_lang.album_image_post.album_name') }}</label>

                                        </div>
                                        <div class="panel-body">
                                            @include('voyager::multilingual.input-hidden', [
                                                '_field_name'  => 'name',
                                                '_field_trans' => get_field_translations($dataTypeContent, 'name')
                                            ])
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('albums_lang.album_image_post.album_name') }}" value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                                        </div>
                                    </div>
                                    <div class="image">

                                        <div class="panel-heading">
                                            <label for="cover_image">{{ __('albums_lang.album_image_post.album_image') }}</label>

                                        </div>
                                        <div class="panel-body">

                                            <input {!! (isset($dataTypeContent->id) ? ' ' : 'required') !!} type="file" id="album_images" @if(isset($dataTypeContent->id)) name="image[]"  @else name="image[]" multiple="multiple" @endif  >



                                        </div>
                                        <div id="prew-image2"  >


                                        </div>
                                    </div>
                                    <div id="sort" >
                                        <div class="panel-heading"> <label for="sort">{{ __('albums_lang.album_image_post.sort') }}</label></div>
                                        <div class="panel-body">




                                            <input type="text" class="form-control" id="sort" name="sort"
                                                   placeholder="{{ __('albums_lang.album_image_post.sort') }}"
                                                   {!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "sort") !!}
                                                   value="@if(isset($dataTypeContent->sort)){{ $dataTypeContent->sort }} @else 1 @endif">
                                        </div>
                                    </div>
                                    <div id="ohter-input">
                                        @php
                                            $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                            $exclude = ['name', 'image', 'sort','voyager_albums_id'];
                                        @endphp

                                        @foreach($dataTypeRows as $row)
                                            @if(!in_array($row->field, $exclude))
                                                @php
                                                    $options = json_decode($row->details);
                                                    $display_options = isset($options->display) ? $options->display : NULL;
                                                @endphp
                                                @if ($options && isset($options->formfields_custom))
                                                    @include('voyager::formfields.custom.' . $options->formfields_custom)
                                                @else
                                                    <div class="form-group @if($row->type == 'hidden') hidden @endif @if(isset($display_options->width)){{ 'col-md-' . $display_options->width }}@else{{ '' }}@endif" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                                        {{ $row->slugify }}
                                                        @if(__('albums_lang.album_image_post.'.$row->field))

                                                            <label for="name">{!! __('albums_lang.album_image_post.'.$row->field) !!}</label>
                                                        @else
                                                            <label for="name">{{ $row->display_name }}</label>
                                                        @endif
                                                        @include('voyager::multilingual.input-hidden-bread-edit-add')
                                                        @if($row->type == 'relationship')
                                                            @include('voyager::formfields.relationship')
                                                        @else
                                                            {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                                        @endif

                                                        @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                                            {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>


                                </div>
                                <div class="col-md-6">

                                    <div id="prew-image" class="prew-image">


                                    </div>

                                </div>












                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('voyager.generic.save') }}</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.albums.image.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="albums_images">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager.generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager.generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager.generic.delete') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager.generic.delete_confirm') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')

    <script>
        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img class="preview-img">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };
            var error_image = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    var b=0;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<input type="hidden" disabled style="display: none"   >')).attr('name', "image."+b++).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };
            $('#album_images').on('change', function() {
                $('div.prew-image').html("");
                $('div#prew-image2').html("");
                error_image(this,'div#prew-image2');
                imagesPreview(this,'div.prew-image');
            });
        });
    </script>

    <script>
        var params = {}
        var $image

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.type != 'date' || elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', function (e) {
                $image = $(this).siblings('img');

                params = {
                    slug:   '{{ $dataType->slug }}',
                    image:  $image.data('image'),
                    id:     $image.data('id'),
                    field:  $image.parent().data('field-name'),
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text($image.data('image'));
                $('#confirm_delete_modal').modal('show');
            });

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $image.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing image.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
