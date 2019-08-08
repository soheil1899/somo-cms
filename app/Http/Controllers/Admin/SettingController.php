<?php

namespace App\Http\Controllers\Admin;

use App\Article_keyword;
use App\Filemanager;
use App\Lang;
use App\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting');
    }
    public function getsetting(Request $request)
    {
        $filemanagerids = Filemanager::all();
        if($request->lang['lang'] != null){
            $setting = Setting::where('lang', $request->lang['lang'])->first();
        }else{
            $setting = Setting::first();
        }

        $keywords = Article_keyword::where('setting_id', $setting['id'])->get();
        $keywordarray = array();
        if(count($keywords) > 0) {
            foreach ($keywords as $key => $value) {
                $keywordarray[$key] = $value['keyword'];
            }
        }

        $setting['keywords'] = $keywordarray;
        $langs = Lang::all();

        return [$setting , $filemanagerids, $langs];

    }

    public function savelogoimage(Request $request)
    {

        $image = new ImageManager();
        Storage::disk('media')->delete('/media/cite/logo.png');
        $image->make($request->logoimage->getRealPath())->save(public_path() . '/media/cite/logo.png');


        return [rand(100,999)];
    }

    public function savebannerimage(Request $request)
    {

        $image = new ImageManager();
        Storage::disk('media')->delete('/media/cite/banner.png');
        $image->make($request->bannerimage->getRealPath())->save(public_path() . '/media/cite/banner.png');


        return [rand(100,999)];
    }

    public function savesetting(Request $request)
    {
        $setting = $request->setting;
        $save = Setting::where('lang', $request->langselect['lang'])->first();
        if(is_null($save)){
            $save = new Setting();
        }
        $save->mobile = $setting['mobile'];
        $save->tellphone = $setting['tellphone'];
        $save->fax = $setting['fax'];
        $save->email = $setting['email'];
        $save->address = $setting['address'];
        $save->aboutus = $setting['aboutus'];
        $save->company_name = $setting['company_name'];
        $save->flag = $setting['flag'];
        $save->header_description = $setting['header_description'];
        $save->aboutus_all = $setting['aboutus_all'];
        $save->lang = $request->langselect['lang'];

        $save->save();

        $newkeywords = array();
        Article_keyword::where('setting_id', $save->id)->delete();

        if ($setting['keywords'] != null){
            foreach ($setting['keywords'] as $key => $value) {
                $newkeywords[$key]['setting_id'] = $save->id;
                $newkeywords[$key]['keyword'] = $value;
            }
            Article_keyword::insert($newkeywords);
        }

    }


    public function savecompanycatalog(Request $request)
    {
        $file =$request->file('catalog');
        if ($request->lang == 'fa'){
            $file->move(public_path() . '/media/cite/','TABAMACHINE_fa.pdf');
        }
        if ($request->lang == 'en'){
            $file->move(public_path() . '/media/cite/','TABAMACHINE_en.pdf');
        }
        else{
            $file->move(public_path() . '/media/cite/','TABAMACHINE_ar.pdf');
        }

        $save = Setting::where('lang', $request->lang)->first();
        if ($save->catalog == false){
            $save->catalog = true;
        }
        $save->save();
    }

}
