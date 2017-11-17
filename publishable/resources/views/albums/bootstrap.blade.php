
<style>
    .voyager-gallery {


        -webkit-column-count: 3; /* Chrome, Safari, Opera */
        -moz-column-count: 3; /* Firefox */
        column-count: 3;


    }
    .voyager-gallery a{ width: 100%; padding: 7px 0;}
    @media (max-width: 500px) {

        .voyager-gallery {


            -webkit-column-count: 1; /* Chrome, Safari, Opera */
            -moz-column-count: 1; /* Firefox */
            column-count: 1;


        }

    }
</style>


    <h1>{!! $album->name !!}</h1>
    <div class="col-md-12">
        <div class="row">
            <hr>

            <div class="voyager-gallery">




                @foreach($album->images as $image)
                    <div  ><a title="{!! $image->name !!}" href="#"><img class="thumbnail img-responsive" src="{!! config('albums.image_folder')."/".$image->image !!}"></a></div>

                @endforeach

            </div>

        </div>
    </div>

    <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

            </div>

        </div>
    </div>
</div>



@php
/*

For faster operation, add a style sheet and delete the top style tag.

<style>
    .voyager-gallery {


        -webkit-column-count: 3;
        -moz-column-count: 3;
        column-count: 3;


    }
    .voyager-gallery a{ width: 100%; padding: 7px 0;}
    @media (max-width: 500px) {

        .voyager-gallery {


            -webkit-column-count: 1;
            -moz-column-count: 1;
            column-count: 1;


        }

    }
</style>

bootstrap lightbox
stick to the footer to use it.
<script>
    $(document).ready(function() {
        $('.thumbnail').click(function(){
            $('.modal-body').empty();
            var title = $(this).parent('a').attr("title");
            $('.modal-title').html(title);
            $($(this).parents('div').html()).appendTo('.modal-body');
            $('#myModal').modal({show:true});
        });
    });
</script>

*/


@endphp

