<?php

namespace App\Http\Controllers\Backend\AdditionalFeatureManagement\PopupNotification;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class PopupNotificationsController extends Controller
{
    //    permission seed done
    protected $popupNotification;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('manage-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('backend.additional-features-management.popup-notifications.index', [
            'popupNotifications'    => PopupNotification::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('create-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('store-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        PopupNotification::saveOrUpdatePopupNotification($request);
        return back()->with('success', 'Popup Notification Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('show-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('edit-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(PopupNotification::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('update-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        PopupNotification::saveOrUpdatePopupNotification($request, $id);
        return back()->with('success', 'Popup Notification Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete-notification'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->popupNotification = PopupNotification::find($id);
        if (file_exists($this->popupNotification->image))
        {
            unlink($this->popupNotification->image);
        }
        $this->popupNotification->delete();
        return back()->with('success', 'Popup Notification Deleted Successfully.');
    }
}
