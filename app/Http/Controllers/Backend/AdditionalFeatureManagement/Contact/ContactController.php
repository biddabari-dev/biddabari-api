<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\Contact;

use App\Http\Controllers\Controller;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    //    permission seed done
    public $contactMessage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.contact.index', ['contacts' => ContactMessage::latest()->orderBy('is_seen', 'DESC')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->contactMessage = ContactMessage::find($id);
        if ($this->contactMessage->is_seen == 0)
        {
            $this->contactMessage->update(['is_seen' => 1]);
        } elseif ($this->contactMessage->is_seen == 1)
        {
            $this->contactMessage->update(['is_seen' => 0]);
        }
        return response()->json($this->contactMessage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-contact'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        ContactMessage::find($id)->delete();
        return back()->with('success', 'Contact Info Deleted successfully.');
    }
}
