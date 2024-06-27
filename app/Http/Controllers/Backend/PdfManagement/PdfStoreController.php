<?php

namespace App\Http\Controllers\Backend\PdfManagement;

use App\Http\Controllers\Controller;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use App\Models\Backend\PdfManagement\PdfStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PdfStoreController extends Controller
{
    //    permission seed done
    protected $pdfStore, $pdfStores = [];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($_GET['cat-id']))
        {
            $this->pdfStores = PdfStore::where('pdf_store_category_id', $_GET['cat-id'])->get();
        } else {
            $this->pdfStores = PdfStore::all();
        }
        return view('backend.pdf-management.pdf-store.index', [
            'pdfStoreCategories'    => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title', 'parent_id')->whereParentId(0)->get(),
            'pdfStores'             => $this->pdfStores,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'pdf_store_category_id' => 'required',
            'file' => 'required',
        ]);
        PdfStore::saveOrUpdatePdfStore($request);
        if ($request->ajax())
        {
            return response()->json('Pdf Created Successfully.');
        }
        return back()->with('success', 'Pdf Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.pdf-management.pdf-store.edit', [
            'pdfStoreCategories'    => PdfStoreCategory::whereStatus(1)->where('parent_id', 0)->select('id', 'title')->get(),
            'pdfStore'             => PdfStore::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'title' => 'required',
            'pdf_store_category_id' => 'required',
        ]);
        PdfStore::saveOrUpdatePdfStore($request, $id);
        if ($request->ajax())
        {
            return response()->json('Pdf Created Successfully.');
        }
        return back()->with('success', 'Pdf Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->blog = PdfStore::find($id)->delete();
        return back()->with('success', 'Pdf Deleted Successfully.');
    }

    public function getPdfStoreFile($id)
    {
//        abort_if(Gate::denies('manage-pdf'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        works as show method
        return response()->json(PdfStore::find($id));
    }
}
