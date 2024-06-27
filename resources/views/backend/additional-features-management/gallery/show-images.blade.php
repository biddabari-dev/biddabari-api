<div class="row">
    @foreach($galleryImages as $key => $galleryImage)
        <div class="col-md-2 mt-2">
            <div class="">
                <img src="{{ asset($galleryImage->image_url) }}" alt="{{ $key }}" class="w-100" style="height: 150px">

            </div>
        </div>
    @endforeach
</div>
