<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{

    public function index()
    {
        $companies = SiteSetting::latest()->get();
        return view('admin.site_settings.index', compact('companies'));
    }


    public function create()
    {
        return view('admin.site_settings.create');
    }


public function store(Request $request)
{
    $data = $request->all();

    if($request->hasFile('company_logo')){
        $file = $request->file('company_logo');
        $name = time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/company'), $name);
        $data['company_logo'] = 'uploads/company/'.$name;
    }

    if($request->id){
        SiteSetting::find($request->id)->update($data);
    }else{
        SiteSetting::create($data);
    }

    return response()->json(['status'=>true]);
}





    public function destroy($id)
    {
        SiteSetting::findOrFail($id)->delete();
        return back()->with('success','Deleted');
    }

}
