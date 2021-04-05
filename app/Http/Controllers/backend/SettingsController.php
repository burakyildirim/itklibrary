<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $data['adminSettings'] = Settings::all()->sortBy('settings_order');
        return view('backend.settings.index', compact('data'));
    }

    public function sortable()
    {
//        print_r($_POST['item']);

        foreach ($_POST['item'] as $key => $value) {
            $settings = Settings::find(intval($value));
            $settings->settings_order = intval($key);
            $settings->save();
        }
    }

    public function delete($id)
    {
//        dd($id);
        $settings = Settings::find($id);
        if ($settings->delete()) {
            return back()->with('success', 'İşlem başarılı!');
        }

        return back()->with('error', 'İşlem başarısız!');
    }

    public function edit($id)
    {
        $settings = Settings::where('id', $id)->first();

        return view('backend.settings.edit')->with('settings', $settings);
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('settings_value')) {
            $request->validate([
                'settings_value' => 'required|image|mimes:jpeg,jpg,png|max:2048'
            ]);

            $fileName = uniqid().'.'.$request->settings_value->getClientOriginalExtension();
            $request->settings_value->move(public_path('images/settings'),$fileName);
            $request->settings_value=$fileName;
        }

        $settings = Settings::where('id', $id)->update(
            [
                "settings_value" => $request->settings_value
            ]);
        if ($settings) {
            $path = 'images/settings/'.$request->old_file;
            if (file_exists($path)){
                @unlink(public_path($path));
            }
            return back()->with("success", "Güncelleme başarılı!");
        }

        return back()->with("error", "Güncelleme başarısız!");
    }
}
