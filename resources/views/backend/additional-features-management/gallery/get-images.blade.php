<div class="row">
    @foreach($galleryImages as $key => $galleryImage)
        <div class="col-md-2 mt-2">
            <div class="">
                <img src="{{ asset($galleryImage->image_url) }}" alt="{{ $key }}" class="w-100" style="height: 150px">
                @if(isset($requestFor) && $requestFor != 'show')
                    <span></span>
                @else
                    <span class="position-absolute text-white btn btn-sm translate-middle p-2 bg-danger border border-light rounded-circle delete-gallery-image" style="right: 0px; top: 20px" data-gallery-image-id="{{ $galleryImage->id }}">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>
