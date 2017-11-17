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
            min-height: 200px;
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
        .preview-img{
            max-width: 300px;
            max-height: 300px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
    </style>
@endsection
@section('page_title', __('voyager.generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('page_header')
    <div id="albums">
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        @if(isset($dataTypeContent->id))
            {!! __('albums_lang.form.album_edit_heading',['album' => $album->name]) !!}
        @else
            {!! __('albums_lang.form.album_add_heading') !!}
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
                            action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

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




                                <h3>{!!  __('albums_lang.album_post.'.(isset($dataTypeContent->id) ? 'edit' : 'add' ),['album'=>@$album->name] ) !!}  </h3>
                                <div class="col-md-6">


                                    <div id="name" >

                                        <div class="panel-heading">
                                            <label for="name">{{ __('albums_lang.album_post.album_name') }}</label>

                                        </div>
                                        <div class="panel-body">
                                            @include('voyager::multilingual.input-hidden', [
                                                '_field_name'  => 'name',
                                                '_field_trans' => get_field_translations($dataTypeContent, 'name')
                                            ])
                                            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('albums_lang.album_post.album_name') }}" value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                                        </div>
                                    </div>
                                    <div class="image">

                                            <div class="panel-heading">
                                               <label for="cover_image">{{ __('albums_lang.album_post.album_image') }}</label>

                                            </div>
                                            <div class="panel-body">

                                                <input  {!! (isset($dataTypeContent->id) ? ' ' : 'required') !!}  id="cover_image" type="file" onchange="loadFile(event)" name="cover_image">

                                        </div>

                                    </div>
                                    <div id="slug" >
                                        <div class="panel-heading"> <label for="slug">{{ __('albums_lang.album_post.slug') }}</label></div>
                                        <div class="panel-body">





                                            <input type="text" class="form-control" id="slug" name="slug"
                                                   placeholder="{{ __('albums_lang.album_post.slug') }}"
                                                   {!! isFieldSlugAutoGenerator($dataType, $dataTypeContent, "slug") !!}
                                                   value="@if(isset($dataTypeContent->slug)){{ $dataTypeContent->slug }}@endif">
                                        </div>
                                    </div>
                                   <div id="ohter-input">
                                       @php
                                           $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                           $exclude = ['name', 'cover_image', 'slug'];
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
                                                       @if(__('albums_lang.album_post.'.$row->field))

                                                           <label for="name">{!! __('albums_lang.album_post.'.$row->field) !!}</label>
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
                                        @if(isset($dataTypeContent->cover_image))
                                            <img class="preview-img" src="{{ filter_var($dataTypeContent->cover_image, FILTER_VALIDATE_URL) ? $dataTypeContent->cover_image : Voyager::image( $dataTypeContent->cover_image ) }}" style="width:100%" />
                                        @else
                                            <img class="preview-img" id="output" src="">
                                        @endif

                                    </div>

                                </div>




                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">{{ __('albums_lang.album_post.save') }}</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>
    <a style="    text-align: right;display: table;float: right; padding-right: 40px;" href="http://ademturker.com"><small >Packages By Trker </small></a>

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
        $('document').ready(function () {
            $('#slug').slugify();

            @if ($isModelTranslatable)
$('.side-body').multilingual({"editing": true});
            @endif
        });
    </script>
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
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
