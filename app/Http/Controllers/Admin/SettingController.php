<?php

namespace App\Http\Controllers\Admin;

use App\Filemanager;
use App\Keyword;
use App\Lang;
use App\Setting;
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
        $flag = false;

        $filemanagerids = Filemanager::all();
        if ($request->lang['lang'] != null) {
            $setting = Setting::where('lang', $request->lang['lang'])->first();
            if (isset($setting['id'])) {
                $flag = true;
            }
        } else {
            $setting = Setting::first();
        }

        $keywords = Keyword::where([['setting_id', $setting['id']], ['setting', true]])->get();
        $keywordarray = array();
        if (count($keywords) > 0) {
            foreach ($keywords as $key => $value) {
                $keywordarray[$key] = $value['keyword'];
            }
        }

        $setting['keywords'] = $keywordarray;
        $langs = Lang::all();


        return [$setting, $filemanagerids, $langs, $flag];

    }


    public function savesetting(Request $request)
    {
        $setting = $request->setting;
        $save = Setting::where('lang', $request->langselect['lang'])->first();
        if (is_null($save)) {
            $save = new Setting();
        }
        $save->mobile = $setting['mobile'];
        $save->tellphone = $setting['tellphone'];
        $save->site_title = $setting['site_title'];
        $save->facebook = $setting['facebook'];
        $save->instagram = $setting['instagram'];
        $save->telegram = $setting['telegram'];
        $save->googleplus = $setting['googleplus'];
        $save->whatsup = $setting['whatsup'];
        $save->linkedin = $setting['linkedin'];
        $save->googlemap = $setting['googlemap'];
        $save->twitter = $setting['twitter'];
        $save->youtube = $setting['youtube'];
        $save->aparat = $setting['aparat'];
        $save->fax = $setting['fax'];
        $save->email = $setting['email'];
        $save->address = $setting['address'];
        $save->aboutus = $setting['aboutus'];
        $save->company_name = $setting['company_name'];
        $save->flag = $setting['flag'];
        $save->header_description = $setting['header_description'];
        $save->lang = $request->langselect['lang'];

        $save->save();

        $newkeywords = array();
        Keyword::where('setting_id', $save->id)->delete();

        if ($setting['keywords'] != null) {
            foreach ($setting['keywords'] as $key => $value) {
                $newkeywords[$key]['setting_id'] = $save->id;
                $newkeywords[$key]['setting'] = true;
                $newkeywords[$key]['keyword'] = $value;
            }
            Keyword::insert($newkeywords);
        }

    }


    public function savecompanycatalog(Request $request)
    {
        $id = $request->id;
        if ($id == 'null'){
            $save = new Setting();
            $save->lang = $request->lang;
            $save->catalog = true;
            $save->save();

            $id = $save['id'];
        }else{
            Setting::where('id', $id)->update(['catalog' => true]);
        }


        $file = $request->file('catalog');
        $file->move(public_path() . '/media/cite/catalog/', 'catalog_' . $request->lang . '.pdf');

        return $id;
    }



    public function savelogoimage(Request $request)
    {
        $id = $request->id;
        if ($id == 'null'){
            $save = new Setting();
            $save->lang = $request->lang;
            $save->logo_image = $request->lang.'_logo';
            $save->save();

            $id = $save['id'];
        }else{
            Setting::where('id', $id)->update(['logo_image' => $request->lang.'_logo']);
        }

        $image = new ImageManager();
        Storage::disk('media')->delete('/media/cite/logo/'.$request->lang.'_logo.png');
        $image->make($request->logoimage->getRealPath())->save(public_path() . '/media/cite/logo/'.$request->lang.'_logo.png');


        return [rand(100, 999), $id];
    }


}
