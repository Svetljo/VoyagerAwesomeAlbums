@extends('voyager::master')

@section('css')

	<style type="text/css">

		#theme_options .page-title small{
			margin-left:10px;
			color:rgba(0, 0, 0, 0.55);
		}

		#theme_options label{
			font-weight: normal;
		    font-size: 16px;
		    width: 100%;
		    margin-bottom: 10px;
		    position: relative;
		    left: 1px;
		}

		#theme_options span.how_to {
		    font-size: 12px;
		    margin-left: 10px;
		    background: #fff;
		    padding: 5px 14px;
		    border-radius: 15px;
		    display: inline-block;
		    margin-top: 10px;
		    border: 1px solid #f1f1f1;
		    position: relative;
		    top: -1px;
		}

		#theme_options span.how_to code{
			background: none;
    		border: 0px;
		}

	</style>

@endsection

@section('content')


	

@endsection

@section('javascript')
	<script>
		$('document').ready(function(){
			
		});
	</script>
@endsection