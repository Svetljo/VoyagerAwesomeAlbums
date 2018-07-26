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
				<i   class="voyager-images"></i>{!! __('albums_lang.panel.package_name') !!}
				<small>{!! __('albums_lang.panel.package_detail') !!}</small>
			</h1>


			@if(!config('albums'))
				<div class="alert alert-warning">
					<strong>{!! __('albums_lang.panel.warning_config_folder') !!}</strong>

				</div>
			@endif
		@if(count($albums) < 1)
				<div class="alert alert-warning">
					<strong>{!! __('albums_lang.panel.warning_title') !!}</strong>
					<p>{!! __('albums_lang.panel.no_album') !!}</p>
				</div>
			@endif

			<div>
				<a  href="{!! route('voyager.albums.create') !!}" class="btn btn-success btn-add-new">
					<i class="voyager-plus"></i> <span>{!! __('albums_lang.new_albums_btn') !!}</span>
				</a>
				<a href=" " style="float: none;" class="voyager-params albums-options"></a>

			</div>
			<div class="panel">
				<div class="panel-body">

					<div class="row">


						@if(count($albums) < 1)
							<div class="col-md-12">
								<h2 style="text-align: center;">{!! __('albums_lang.no_album_center') !!}</h2><br>
								<a  class="add_btn" title="{!! __('albums_lang.new_albums_btn') !!}"  href="{!! route('voyager.albums.create') !!}"><i   class="voyager-plus"></i></a>

							  </div>
						@endif

						@foreach($albums as $album)

							<div   class="col-md-3 col-lg-2  col-sm-4 album_box">
								<div style="" class="albums">

									<a href="{!! route('voyager.albums_images.index',$album->id) !!}">
									 <img class="albums_thumb img-responsive" src="@if($album->cover_image) {!! config('albums.image_folder')."/".$album->cover_image !!} @else {!!  voyager_asset('/images/folder.png') !!} @endif">
									</a>

									<div class="albums_detail">
										<h6 class="album-heading">&nbsp;&nbsp;{{ $album->name }}  </h6>
										@if($album->status)

											<a class="btn btn-success pull-right" href="{!! route('voyager.albums.deactivate',[$album->id]) !!}"><i class="voyager-check"></i>{!! __('albums_lang.panel.status_active') !!}</a>
										@else
											<a class="btn btn-warning pull-right" href="{!! route('voyager.albums.activate',[$album->id,]) !!}"><i class="voyager-check"></i>{!! __('albums_lang.panel.status_not_activate') !!}</a>
										@endif
										<a href="{!! route('voyager.albums.edit',[$album->id]) !!}" class="voyager-settings albums-options"></a>
										<div class="voyager-trash albums-options-trash" data-id="{{ $album->id }}"></div>


									</div>
								</div>
							</div>

						@endforeach
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
						<form action="{{ route('voyager.albums.delete') }}" id="delete_form" method="POST">
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
		<a style="    text-align: right;display: table;float: right; padding-right: 40px;" href="http://ademturker.com"><small >Packages By Trker </small></a>

	</div>


@endsection

@section('javascript')

	<script>
        $('document').ready(function(){
            var deleteFormAction;
            $('.albums_detail').on('click', '.albums-options-trash', function (e) {
                var form = $('#delete_form')[0];
                $('#delete_id').val($(this).data('id'));
                $('#delete_modal').modal('show');
            });
        });
	</script>

@endsection