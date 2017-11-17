<style >

    header h1 {
        color: white;
        text-shadow: 1px 3px 4px rgba(0, 0, 0, 0.4);
        text-align: center;
        font-size: 40px;
        letter-spacing: 0.4px;
        font-family: "Raleway", sans-serif;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: center;
        padding: 0 30px;
    }
    .container .thumbex {
        margin: 10px 20px 30px;
        width: 100%;
        min-width: 250px;
        max-width: 435px;
        height: 300px;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        border-radius: 6px;
        overflow: hidden;
        outline: 2px solid white;
        outline-offset: -15px;
        background-color: blue;
        box-shadow: 5px 10px 40px 5px rgba(0, 0, 0, 0.5);
    }
    .container .thumbex .thumbnail {
        overflow: hidden;
        min-width: 250px;
        height: 300px;
        position: relative;
        border-radius: 6px;
        opacity: 0.88;
        backface-visibility: hidden;
        transition: all 0.4s ease-out;
    }
    .container .thumbex .thumbnail img {
        position: absolute;
        z-index: 1;
        border-radius: 6px;
        left: 50%;
        top: 50%;
        height: 115%;
        width: auto;
        transform: translate(-50%, -50%);
        backface-visibility: hidden;
    }
    .container .thumbex .thumbnail span {
        position: absolute;
        z-index: 2;
        top: calc(150px - 20px);
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 50px;
        margin: 0 45px;
        text-align: center;
        font-size: 24px;
        color: white;
        font-weight: 300;
        font-family: "Raleway", sans-serif;
        letter-spacing: 0.2px;
        transition: all 0.3s ease-out;
    }
    .container .thumbex .thumbnail:hover {
        backface-visibility: hidden;
        transform: scale(1.15, 1.15);
        opacity: 1;
    }
    .container .thumbex .thumbnail:hover span {
        opacity: 0;
    }
</style>


    <h1>{!! $album->name !!}</h1>


<div class="container">

    @foreach($album->images as $image)


        <div class="thumbex">
            <div class="thumbnail"><a href="#"> <img src="{!! config('albums.image_folder')."/".$image->image !!}"/>
                    @if(!empty($image->name)) <span>{!! $image->name !!}</span>@endif
                </a></div>
        </div>
    @endforeach
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
----------------------------------------------------------------------
<style >

    header h1 {
        color: white;
        text-shadow: 1px 3px 4px rgba(0, 0, 0, 0.4);
        text-align: center;
        font-size: 40px;
        letter-spacing: 0.4px;
        font-family: "Raleway", sans-serif;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: center;
        padding: 0 30px;
    }
    .container .thumbex {
        margin: 10px 20px 30px;
        width: 100%;
        min-width: 250px;
        max-width: 435px;
        height: 300px;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        border-radius: 6px;
        overflow: hidden;
        outline: 2px solid white;
        outline-offset: -15px;
        background-color: blue;
        box-shadow: 5px 10px 40px 5px rgba(0, 0, 0, 0.5);
    }
    .container .thumbex .thumbnail {
        overflow: hidden;
        min-width: 250px;
        height: 300px;
        position: relative;
        border-radius: 6px;
        opacity: 0.88;
        backface-visibility: hidden;
        transition: all 0.4s ease-out;
    }
    .container .thumbex .thumbnail img {
        position: absolute;
        z-index: 1;
        border-radius: 6px;
        left: 50%;
        top: 50%;
        height: 115%;
        width: auto;
        transform: translate(-50%, -50%);
        backface-visibility: hidden;
    }
    .container .thumbex .thumbnail span {
        position: absolute;
        z-index: 2;
        top: calc(150px - 20px);
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        padding: 10px 50px;
        margin: 0 45px;
        text-align: center;
        font-size: 24px;
        color: white;
        font-weight: 300;
        font-family: "Raleway", sans-serif;
        letter-spacing: 0.2px;
        transition: all 0.3s ease-out;
    }
    .container .thumbex .thumbnail:hover {
        backface-visibility: hidden;
        transform: scale(1.15, 1.15);
        opacity: 1;
    }
    .container .thumbex .thumbnail:hover span {
        opacity: 0;
    }
</style>

-------------------------------------------------




------------------------------------------------
*/


@endphp

