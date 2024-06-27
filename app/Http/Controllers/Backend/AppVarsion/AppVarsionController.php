<?php

namespace App\Http\Controllers\Backend\AppVarsion;

use App\Http\Controllers\Controller;
use App\Models\AppVarsion;
use Illuminate\Http\Request;

class AppVarsionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.app-varsion.index',[
            'apps' => AppVarsion::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request;
        AppVarsion::createorupdatappvarsion($request);
        return redirect()->back()->with('success', 'New Version Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $app=AppVarsion::find($id);
        return response()->json($app);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        AppVarsion::createorupdatappvarsion($request,$id);
        return redirect()->back()->with('success', 'Version Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $app = AppVarsion::find($id);
       $app->delete();
       return redirect()->back();
    }

    public function checkVersion()
    {
        $currentVersion = AppVarsion::where('status', 1)->select('varsion')->first();
//        return response()->json(['version' => '1.7.4']);
        return response()->json($currentVersion);
    }
}
