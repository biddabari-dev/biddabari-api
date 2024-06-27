<?php

namespace App\Models\Backend\Gallery;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryImage extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'gallery_id',
        'image_url',
        'image_type',
        'image_size',
        'description',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'gallery_images';

    public static function addGalleryImages($request)
    {
        foreach ($request->file('images') as $item)
        {
            GalleryImage::create([
                'gallery_id'    => $request->gallery_id,
                'image_url'     => imageUpload($item, 'gallery/gallery-images/', 'gallery-image-', 800, 600),
                'image_type'    => $item->getClientMimeType(),
                'description'   => $request->description,
                'status'        => 1,
            ]);
        }
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
