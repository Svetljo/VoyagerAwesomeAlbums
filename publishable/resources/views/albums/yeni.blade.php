
<style>

    body {
        padding-top: 54px;
    }

    @media (min-width: 992px) {
        body {
            padding-top: 56px;
        }
    }
</style>






<!-- Page Content -->
<div class="container">

    <h1 class="my-4 text-center text-lg-left">{!! $album->name !!}</h1>

    <div class="row text-center text-lg-left">
        @foreach($album->images as $image)
            <div class="col-lg-3 col-md-4 col-xs-6">
                <a title="{!! $image->name !!}" href="#" class="d-block mb-4 h-100">
                    <img title="{!! $image->name !!}" class="img-fluid img-thumbnail" src="{!! config('albums.image_folder')."/".$image->image !!}" alt="">
                </a>
            </div>

        @endforeach

    </div>

</div>
<!-- /.container -->



