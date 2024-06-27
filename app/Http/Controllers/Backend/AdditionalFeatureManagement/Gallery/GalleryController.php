<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Backend\Gallery\Gallery;
use App\Models\Backend\Gallery\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    //    permission seed done
    protected $gallery;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.gallery.index', ['galleries' => Gallery::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required']);
        Gallery::createOrUpdateGallery($request);
        if ($request->ajax())
        {
            return response()->json('Gallery Created Successfully.');
        }else{
            return back()->with('success', 'Gallery Created Successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(Gallery::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(Gallery::find($id));
//        return view('backend.additional-features-management.advertisement.edit', ['advertisement' => Advertisement::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['title' => 'required']);
        Gallery::createOrUpdateGallery($request, $id);
        return back()->with('success', 'Gallery Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-gallery'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->gallery = Gallery::find($id);
        if (file_exists($this->gallery->banner))
        {
            unlink($this->gallery->image);
        }
        $this->gallery->delete();
        return back()->with('success', 'Gallery Deleted Successfully.');
    }

    public function addImages (Request $request)
    {
        abort_if(Gate::denies('add-gallery-images'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate(['images' => 'required']);
        try {
            GalleryImage::addGalleryImages($request);
            return back()->with('success', 'Gallery Images Added Successfully.');
        } catch (\Exception $exception)
        {
            return response()->json($exception->getMessage());
        }
    }

    public function getImages ($galleryId)
    {
        abort_if(Gate::denies('get-gallery-images'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.gallery.get-images', ['galleryImages' => Gallery::find($galleryId)->galleryImages, 'requestFor' => 'show']);
    }

    public function deleteImage ($galleryImageId)
    {
        abort_if(Gate::denies('delete-gallery-images'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $galleryImage = GalleryImage::find($galleryImageId);
        $galleryId = $galleryImage->gallery->id;
        if (file_exists($galleryImage->banner))
        {
            unlink($galleryImage->banner);
        }
        $galleryImage->delete();
        return view('backend.additional-features-management.gallery.get-images', ['galleryImages' => Gallery::find($galleryId)->galleryImages]);
    }
}
