@extends('voyager::master')

@section('css')
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
			min-height: 200px;
			width: 100%;
			object-fit: contain;
			object-position: center;
			margin-left: auto;
			margin-right: auto;
		}

		.albums{
			border:1px solid #f1f1f1;
			border-radius:3px;
		}
		.albums .preview-img-a:hover:before{
			content: attr(data-value);
			position: absolute;
			white-space: pre;
			display: inline;
			font-weight: bold;
			font-family: monospace;
			top: 34%;
			left: 50%;
			background-color: #ffffffa8;
			transform: translate(-50%, -24px);
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 5px 5px 5px 5px;
		}

		.albums .preview-img-a:hover:after{
			font-family: voyager!important;
			font-style: normal!important;
			font-weight: 400!important;
			font-variant: normal!important;
			text-transform: none!important;
			content: "\e044";
			position: absolute;
			white-space: pre;
			display: inline;
			width: 40px;
			font-size: 22px;
			height: 40px;
			line-height: 40px;
			text-align: center;
			color: black;
			top: 45%;
			left: 50%;
			background-color: #ffffff8a;
			transform: translate(-50%, -24px);
			/* padding-left: 10px; */
			/* padding-right: 10px; */
			border-radius: 70px;
		}
		.image-select-input:hover:after{
			content: attr(data-value);
			position: absolute;
			white-space: pre;
			display: inline;
			color: black;
			font-weight: bold;
			font-family: monospace;
			top: 34%;
			left: 50%;
			background-color: #ffffffa8;
			transform: translate(-50%, -24px);
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 5px 5px 5px 5px;
		}
		.albums-options-trash:hover:after{
			content: attr(data-value);
			position: absolute;
			white-space: pre;
			display: inline;
			color: black;
			font-weight: bold;
			font-family: monospace;
			top: 34%;
			left: 50%;
			background-color: #ffffffa8;
			transform: translate(-50%, -24px);
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 5px 5px 5px 5px;
		}
		.albums-options-trash:hover:after{
			content: attr(data-value);
			position: absolute;
			white-space: pre;
			display: inline;
			color: black;
			font-weight: bold;
			font-family: monospace;
			top: 34%;
			left: 50%;
			background-color: #ffffffa8;
			transform: translate(-50%, -24px);
			padding-left: 10px;
			padding-right: 10px;
			border-radius: 5px 5px 5px 5px;
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
		}#lightbox .modal-content {
			 display: inline-block;
			 text-align: center;
		 }

		#lightbox .close {
			opacity: 1;
			color: rgb(255, 255, 255);
			background-color: rgb(25, 25, 25);
			padding: 5px 8px;
			border-radius: 30px;
			border: 2px solid rgb(255, 255, 255);
			position: absolute;
			top: -15px;
			right: -55px;

			z-index:1032;
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
		.image-select-input{
			padding: 8px 10px;
			border: 1px solid #e1e1e1;
			border-radius: 3px;
			float: left;
			width: 36px;
			height: 36px;
			margin-top: 5px;
			margin-right: 10px;
			cursor: pointer;
			transition:all 0.3s ease;
		}
		.image-select-input:hover{
			background: #cccccc;
			border: 1px solid #ddd;
		}
		.image-select-input:checked{
		color: black;
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
			.page-title{
				font-size: 12px !important;
			}
			.page-title span{
				font-size: 15px !important;
			}
			.pull-right
			{
				float: none !important;
			}
		}
		@media (max-width : 525px) {
			.album-heading{

			}
			.page-title{
				font-size: 12px !important;
			}
			.page-title span{
				font-size: 15px !important;
			}
			.page-title small{
				display: block;
			}
			.pull-right
			{
				float: none !important;
			}
		}
		.icon-select:before{
			font-family: voyager!important;
			font-style: normal!important;
			content: "\e052";
			margin-left: auto;
			margin-right: auto;
			display: table;
			font-size: 20px;
			line-height: 35px;
			z-index: 0;
			color: rgba(0, 0, 0, 0.24);
		}




		.icon-select:hover:before{

			color: rgba(0, 0, 0, 0.76);
		}
		.icon-select:checked:before{

			color: rgba(0, 0, 0, 0.76);
		}
		.actions-menu .dropdown-menu>li>a{

			padding: 5px 5px;
		}
		.actions-menu .dropdown-menu>li:hover{

			background-color: #00acee;
		}
		.preview-img{
			max-width: 250px;
			max-height: 250px;
			margin-left: auto;
			margin-right: auto;
			display: block;
		}
.form-group .toggle{
	width: 50% !important;
}
		.modal-body .panel-body{
			width: 100%;
			overflow: hidden;
		}
	</style>
@endsection

@section('content')

	<div id="albums">

		<div class="container-fluid">

			<h1 class="page-title">
				<i   class="voyager-images"></i>{!! __('albums_lang.panel.Album_name_text', ['album_name' => $albums->name])  !!}
				<small>{!! __('albums_lang.panel.Album_name_detail', ['album_name' => $albums->name,'image_count' => count($albums->images) ]) !!}</small>
			</h1>



		@if(count($albums->images) < 1)
				<div class="alert alert-warning">
					<strong>{!! __('albums_lang.panel.warning_title') !!}</strong>
					<p>{!! __('albums_lang.panel.no_images') !!}</p>
				</div>
			@endif

			<div>
				<a  href="{!! route('voyager.albums.create') !!}" class="btn btn-success btn-add-new">
					<i class="voyager-plus"></i> <span style="display: inline-block !important;">{!! __('albums_lang.new_albums_btn') !!}</span>
				</a>
				<a  href="{!! route('voyager.albums_images.create',$albums->id) !!}" class="btn btn-success btn-add-new">
					<i class="voyager-plus"></i> <span style="display: inline-block !important;">{!! __('albums_lang.new_image_btn') !!}</span>
				</a>
				@if($albums->status)

					<a class="btn btn-success pull-right" href="{!! route('voyager.albums.deactivate',[$albums->id]) !!}"><i class="voyager-check"></i>{!! __('albums_lang.panel.status_active') !!}</a>
				@else
					<a class="btn btn-warning pull-right" href="{!! route('voyager.albums.activate',[$albums->id,]) !!}"><i class="voyager-check"></i>{!! __('albums_lang.panel.status_not_activate') !!}</a>
				@endif

				<div style="display: -webkit-inline-box;" class="dropdown actions-menu">
					<button class="btn btn-info dropdown-toggle voyager-wand" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						{!! __('albums_lang.panel.Actions') !!}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<li ><a style="cursor: pointer;"  onclick="SelectAllImage();" >{!! __('albums_lang.panel.AllSelect') !!}</a></li>
						<li><a style="cursor: pointer;"  data-toggle="modal" data-target="#albumfastedit" >{!! __('albums_lang.panel.album_fastedit') !!}</a></li>
						<li><a style="cursor: pointer;"  data-toggle="modal" data-target="#album-info"  >{!! __('albums_lang.panel.album_info') !!}</a></li>
						<li style="margin: 0px !important;" role="separator" class="divider"></li>
						<li><a  style="cursor: pointer;"  data-toggle="modal" data-target="#album-editorcode">{!! __('albums_lang.panel.album_shortcode_info') !!}</a></li>

						<li style="margin: 0px !important;" role="separator" class="divider"></li>

					</ul>
				</div>
				<div style="display: -webkit-inline-box;" class="dropdown actions-menu ">
					<button  class="btn btn-info dropdown-toggle voyager-wand" type="button" id="select-image-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						 {!! __('albums_lang.panel.Selected') !!} (<span id="selected_count">0</span>)
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu select_image_menu" aria-labelledby="select-image-menu">
						<li><a style="cursor: pointer;"  class="select-delete" >{!! __('albums_lang.panel.delete_selected') !!}</a></li>
						<li><a style="cursor: pointer;"  onclick="select_image_shortcute();"  data-toggle="modal" data-target="#album-image-editorcode">{!! __('albums_lang.panel.select-image-special-shortcut') !!}</a></li>

					</ul>
				</div>
			</div>
			<div class="panel">
				<div class="panel-body">

					<div class="row">

						@if(count($albums->images) < 1)
							<div class="col-md-12">
								<h2 style="text-align: center;">{!! __('albums_lang.no_image_center') !!}</h2><br>
								<a  class="add_btn" title="{!! __('albums_lang.new_albums_btn') !!}"  href="{!! route('voyager.albums_images.create',$albums->id) !!}"><i   class="voyager-plus"></i></a>

							  </div>
						@endif

						@foreach($albums->images as $album)

							<div   class="col-md-3 col-lg-2  col-sm-4 col-xs-6 album_box">
								<div style="" class="albums">

									<a class="preview-img-a" href="#" data-value="{!! __('albums_lang.panel.preview_img') !!}" data-toggle="modal" data-target="#lightbox">
									 <img data-toggle="tooltip" title="{{ $album->name }}" class="albums_thumb img-responsive" src="@if($album->image) {!! config('albums.image_folder')."/".$album->image !!} @else {!!  voyager_asset('/images/no-image.jpg') !!} @endif">
									</a>

									<div class="albums_detail">
										<h6 class="album-heading">&nbsp;&nbsp;{!! substr($album->name,0,23) !!} @if(strlen($album->name)>=23)... @endif  </h6>

										<input title="{!! __('albums_lang.panel.select_title') !!}" type="checkbox" class="icon-select image-select-input" data-value="{!! __('albums_lang.panel.select') !!}" name="image-select" value="{{ $album->id }}">
										<a data-value="{!! __('albums_lang.panel.edit_hover') !!}" href="{!! route('voyager.albums_images.edit',[$albums->id,$album->id]) !!}" class="voyager-pen albums-options"></a>
										<div data-value="{!! __('albums_lang.panel.delete_hover') !!}" class="voyager-trash albums-options-trash" data-id="{{ $album->id }}"></div>


									</div>
								</div>
							</div>

						@endforeach
						<div style="clear: both;"></div>
					</div>

				</div>
			</div>

		</div>




		{{-- lightbox modal --}}

		<div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
				<div class="modal-content">
					<div class="modal-body">
						<img src="" alt="" />
					</div>
				</div>
			</div>
		</div>
		<div id="album-info" class="modal fade" tabindex="-1" role="dialog"   aria-hidden="true">
			<div class="modal-dialog">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
				<div class="modal-content">
					<div class="modal-body">


						<div class="col-md-8">


							<div id="name" >

								<div class="panel-heading">
									<label for="name">{{ __('albums_lang.album_post.album_name') }}</label>

								</div>
								<div class="panel-body">
								{!! $albums->name !!}
								</div>
							</div>

							<div id="slug" >
								<div class="panel-heading"> <label for="slug">{{ __('albums_lang.album_post.slug') }}</label></div>
								<div class="panel-body">
									{!! $albums->slug !!}
								</div>

							</div>
							<div id="slug" >
								<div class="panel-heading"> <label for="Shortcut">{{ __('albums_lang.album_post.editor_shortcode') }}</label></div>
								<div class="panel-body">
									<code>{!! "[album('".$albums->slug."');]" !!}</code>
									<br>
									<i>{{ __('albums_lang.album_post.editor_shortcode_description') }}</i>
								</div>

							</div>
							<div id="create_date" >
								<div class="panel-heading"> <label for="created">{{ __('albums_lang.album_post.created_at') }}</label></div>
								<div class="panel-body">
									{!!  \Carbon\Carbon::parse($albums->created_at)->format('d-m-Y H-i') !!}
								</div>
							</div>
							<div id="last update" >
								<div class="panel-heading"> <label for="Update">{{ __('albums_lang.album_post.updated_at') }}</label></div>
								<div class="panel-body">
									{!!  \Carbon\Carbon::parse($albums->updated_at)->format('d-m-Y H-i') !!}
								</div>
							</div>
							<div id="last update" >
								<div class="panel-heading"> <label for="image_count">{{ __('albums_lang.album_post.image_count') }}</label></div>
								<div class="panel-body">
									{!! __('albums_lang.panel.Album_name_detail', ['album_name' => $albums->name,'image_count' => count($albums->images) ]) !!}
								</div>

							</div>
							@if(count($albums->images)>0)
								<div id="last update" >
									<div class="panel-heading"> <label for="image_count">{{ __('albums_lang.album_post.album_last_imagedate') }}</label></div>
									<div class="panel-body">
										{!! __('albums_lang.panel.album_last_image_date', [ 'last_date' => \Carbon\Carbon::parse($albums->images->last()->created_at)->format('d-m-Y H:i') ]) !!}
									</div>
								</div>
							@endif
						</div>

						<div class="col-md-4">
							<div id="prew-image" class="prew-image">

								{!! __('albums_lang.panel.cover_image')  !!}
									<img   class="preview-img" src="{!! config('albums.image_folder')."/".$albums->cover_image !!}" style="width:100%" />


							</div>

						</div>
						<div style="clear: both;"></div>

					</div>
				</div>
			</div>
		</div>

		<div id="album-editorcode" class="modal fade" tabindex="-1" role="dialog"   aria-hidden="true">
			<div class="modal-dialog">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
				<div class="modal-content">
					<div class="modal-body">


						<div class="col-md-12">


							<h2> {{ __('albums_lang.album_post.editor_shortcode_heading') }}</h2>

							<div id="slug" >
								<div class="panel-heading"> <label for="Shortcut">{{ __('albums_lang.album_post.editor_shortcode') }}</label></div>
								<div class="panel-body">
									<label class="label label-info">{{ __('albums_lang.album_post.slug_shortecode') }}</label><br>
									<code id="slug_shortcode">{!! "[album('".$albums->slug."');]" !!}</code>

									 <br>
									@if(@config('albums.slug_shortcut')==false)
										<i class="voyager-info-circled"></i>&nbsp;{{ __('albums_lang.album_post.slug_shortecut_disable') }}
									@endif
									<br>
									<br>
									<label class="label label-info">{{ __('albums_lang.album_post.id_shortecode') }}</label><br>
									<code id="id_shorcode">{!! "[album(".$albums->id.");]" !!}</code>

									<br>
									@if(@config('albums.id_shortcut')==false)
										<i class="voyager-info-circled"></i>&nbsp;{{ __('albums_lang.album_post.id_shortecut_disable') }}
									@endif
								</div>
								{{ __('albums_lang.album_post.shortecut_developer_area') }}

								<img width="100%" src="{!! voyager_asset('images/shortcutinfo.jpg') !!}">
							</div>

						</div>


						<div style="clear: both;"></div>

					</div>
				</div>
			</div>
		</div>
		<div id="album-image-editorcode" class="modal fade" tabindex="-1" role="dialog"   aria-hidden="true">
			<div class="modal-dialog">
				<button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
				<div class="modal-content">
					<div class="modal-body">


						<div class="col-md-12">


							<h2> {{ __('albums_lang.album_post.editor_shortcode_heading') }}</h2>

							<div id="slug" >
								<div class="panel-heading"> <label for="Shortcut">{{ __('albums_lang.album_post.editor_shortcode') }}</label></div>
								<div class="panel-body">
									<label class="label label-info">{{ __('albums_lang.album_post.slug_shortecode') }}</label><br>
									<code id="slug_special_shortcode">{!! "[album('".$albums->slug."');]" !!}</code>

									<br>
									@if(@config('albums.slug_shortcut')==false)
										<i class="voyager-info-circled"></i>&nbsp;{{ __('albums_lang.album_post.slug_shortecut_disable') }}
									@endif
									<br>
									<br>
									<label class="label label-info">{{ __('albums_lang.album_post.id_shortecode') }}</label><br>
									<code id="id_special_shorcode">{!! "[album(".$albums->id.");]" !!}</code>

									<br>
									@if(@config('albums.id_shortcut')==false)
										<i class="voyager-info-circled"></i>&nbsp;{{ __('albums_lang.album_post.id_shortecut_disable') }}
									@endif
								</div>
								{{ __('albums_lang.album_post.shortecut_developer_area') }}

								<img width="100%" src="{!! voyager_asset('images/shortcutinfo.jpg') !!}">
							</div>

						</div>


						<div style="clear: both;"></div>

					</div>
				</div>
			</div>
		</div>

		{{-- Single delete modal --}}
		<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager.generic.close') }}"><span
									aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="voyager-trash"></i> {!! __('albums_lang.panel.album_trash_title') !!}</h4>
					</div>
					<div class="modal-footer">
						<form action="{{ route('voyager.albums_images.delete',[$albums->id]) }}" id="delete_form" method="POST">
							{{ method_field("DELETE") }}
							{{ csrf_field() }}
							<input type="hidden" name="id" value="0" id="delete_id">
							<input type="submit" class="btn btn-danger pull-right delete-confirm"
								   value="{!! __('albums_lang.panel.album_trash_yes_btn') !!}">
						</form>
						<button type="button" class="btn btn-default pull-right" data-dismiss="modal">{!! __('albums_lang.panel.album_trash_no_btn') !!}</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="modal modal-danger fade" tabindex="-1" id="delete_multi_modal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager.generic.close') }}"><span
									aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><i class="voyager-trash"></i> {!! __('albums_lang.panel.album_multi_image_delete') !!}</h4>
					</div>
					<div class="modal-footer">
						<form action="{{ route('voyager.albums_images.delete',[$albums->id]) }}" id="delete_multi_form" method="POST">
							{{ method_field("DELETE") }}
							{{ csrf_field() }}
							<input type="hidden" name="ids" value="0" id="delete_multi_modal_id">
							<input type="submit" class="btn btn-danger pull-right delete-confirm"
								   value="{!! __('albums_lang.panel.album_trash_yes_btn') !!}">
						</form>
						<button type="button" class="btn btn-default pull-right" data-dismiss="modal">{!! __('albums_lang.panel.album_trash_no_btn') !!}</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->




		<a style="    text-align: right;display: table;float: right; padding-right: 40px;" href="http://ademturker.com"><small >Packages By Trker </small></a>


		{{--  album fast edit modal --}}
		<div id="albumfastedit" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<form id="album-edit-form" role="form"
						  class="form-edit-add"
						  action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
						  method="POST" enctype="multipart/form-data">
						<!-- PUT Method if we are editing -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<h3 class="modal-title">{!!  __('albums_lang.album_post.'.(isset($dataTypeContent->id) ? 'edit' : 'add' ),['album'=>@$dataTypeContent->name] ) !!}  </h3>
					</div>
					<div class="modal-body">


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





								<div class="col-md-8">
									@include('voyager::multilingual.language-selector')
									<input type="hidden" name="pgs" value="1">


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
								<div class="col-md-4">
									<div id="prew-image" class="prew-image">
										@if(isset($dataTypeContent->cover_image))
											<img id="output" class="preview-img" src="{{ filter_var($dataTypeContent->cover_image, FILTER_VALIDATE_URL) ? $dataTypeContent->cover_image : Voyager::image( $dataTypeContent->cover_image ) }}" style="width:100%" />
										@else
											<img class="preview-img" id="output" src="">
										@endif

									</div>

								</div>




							</div><!-- panel-body -->

							<div class="panel-footer">

							</div>


					</div>
					<div class="modal-footer">

						<button type="submit" class="btn btn-primary save">{{ __('albums_lang.album_post.save') }}</button>
					</div>
					</form>
				</div>

			</div>
		</div>



	</div>


@endsection

@section('javascript')

	<script>

		function select_image_shortcute(){
            var checkboxes = document.querySelectorAll('input[name="image-select"]:checked'), values = [];
            Array.prototype.forEach.call(checkboxes, function(el) {
                values.push(el.value);
            });

            var a="[album(slug:'{!! $albums->slug !!}'),ids('"+values+"');]";
            var b="[album(id:{!! $albums->id !!}),ids('"+values+"');]";
            $('#slug_special_shortcode').html(a)
            $('#id_special_shorcode').html(b)

        }


        function SelectAllImage() {
            $('#albums :checkbox:enabled').prop('checked', true);
            $('#select-image-menu').prop('disabled', $("input[name='image-select']:checked").length == 0);
            $('#selected_count').html($("input[name='image-select']:checked").length);

        }


        function getCheckedCheckboxesFor(checkboxName) {
            var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
            Array.prototype.forEach.call(checkboxes, function(el) {
                values.push(el.value);
            });
            return values;
        }
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
        $('document').ready(function(){

            //lightbox
            var $lightbox = $('#lightbox');

            $('[data-target="#lightbox"]').on('click', function(event) {
                var $img = $(this).find('img'),
                    src = $img.attr('src'),
                    alt = $img.attr('alt'),
                    css = {
                        'maxWidth': $(window).width() - 100,
                        'maxHeight': $(window).height() - 100
                    };

                $lightbox.find('.close').addClass('hidden');
                $lightbox.find('img').attr('src', src);
                $lightbox.find('img').attr('alt', alt);
                $lightbox.find('img').css(css);
            });

            $lightbox.on('shown.bs.modal', function (e) {
                var $img = $lightbox.find('img');

                $lightbox.find('.modal-dialog').css({'width': $img.width()});
                $lightbox.find('.close').removeClass('hidden');
            });


            //
            $('[data-toggle="tooltip"]').tooltip();


            $('#select-image-menu').attr('disabled', true); //disable input
            $('#selected_count').html($("input[name='image-select']:checked").length);
            $("input[name='image-select']").click(function () {
                $('#selected_count').html($("input[name='image-select']:checked").length);
                $('#select-image-menu').prop('disabled', $("input[name='image-select']:checked").length == 0);
            });
            var deleteFormAction;
            $('.albums_detail').on('click', '.albums-options-trash', function (e) {
                var form = $('#delete_form')[0];
                $('#delete_id').val($(this).data('id'));
                $('#delete_modal').modal('show');
            });
            $('.select-delete').click(function(){

                var checkboxes = document.querySelectorAll('input[name="image-select"]:checked'), values = [];
                Array.prototype.forEach.call(checkboxes, function(el) {
                    values.push(el.value);
                });

                var form = $('#delete_multi_form')[0];
                $('#delete_multi_modal_id').val(values);
                $('#delete_multi_modal').modal('show');
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
@endsection