<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Article_content;
use App\Article_group;
use App\Article_keyword;
use App\Articleattr;
use App\Filemanager;
use App\Gallery;
use App\Tag;
use App\Lang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ArticleController extends Controller
{

    // group

    public function index()
    {
        return view('admin.articlegroup');
    }

    public function getarticlegroups()
    {
        $langs = Lang::all();
        $articlegroups = Article_group::with('keywords', 'lang')->get();
        return [$langs, $articlegroups];
    }

    public function savegroup(Request $request)
    {
        $this->validate($request, [
            'groupname' => 'required',
            'grouptitle' => 'required',
            'groupurl' => 'required',
        ]);

        $keywords = array();

        if ($request->editflag != false) {
            $save = Article_group::where('id', $request->groupid)->first();


            Article_keyword::where('article_group_id', $request->groupid)->delete();

            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_group_id'] = $request->groupid;
                $keywords[$key]['keyword'] = $value;
            }
            Article_keyword::insert($keywords);

        } else {
            $save = new Article_group();

        }

        $save->name = $request->groupname;
        $save->title = $request->grouptitle;
        $save->lang_id = $request->lang['id'];
        $save->url = $request->groupurl;
        $save->description = $request->description;

        $save->save();

        if ($keywords == null) {
            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_group_id'] = $save->id;
                $keywords[$key]['keyword'] = $value;
            }
            Article_keyword::insert($keywords);
        }

    }














    // article

    public function articles($id)
    {
        $articlegroupid = $id;

        return view('admin.articles', compact('articlegroupid'));
    }


    public function getarticles(Request $request)
    {

        $article = Article_group::where('id', $request->groupid)->with('articles.user')->with('articles.keywords')->with('articles.galleries')->with('articles.attributes')->get();
        $myarticlelist = $article[0]['articles'];



        $accessall = false;
        $roles = auth()->user()->roles()->get();
        $permissions = array();
        foreach ($roles as $role){
            array_push($permissions, $role->permissions()->get());
        }
        for ($i=0; $i<count($permissions); $i++){
            for($j=0; $j<count($permissions[$i]);$j++){
                $per = $permissions[$i][$j]['permission'];
                if($per == 'super_article'){
                    $accessall = true;
                }
            }
        }




        if($accessall == false){
            $myarticles = array();

            foreach ($myarticlelist as $key=>$value){
                if($value['user_id'] == auth()->user()->id){
                    array_push($myarticles, $value );
                }
            }
            $myarticlelist = $myarticles;
        }

        $groups = Article_group::all();
        $tags = Tag::all();

        return [$article, $groups, $tags, $myarticlelist];
    }

    public function savearticle(Request $request)
    {


        $this->validate($request, [
            'groupid' => 'required',
            'articletitle' => 'required',
        ]);

        $keywords = array();
        $tags = array();

        if ($request->editflag != false) {
            $save = Article::where('id', $request->articleid)->first();


            Article_keyword::where('article_id', $request->articleid)->delete();

            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_id'] = $request->articleid;
                $keywords[$key]['keyword'] = $value;
            }
            Article_keyword::insert($keywords);

        } else {
            $save = new Article();
            $save->article_group_id = $request->groupid;
        }

        $save->title = $request->articletitle;
        $save->user_id = auth()->user()->id;
        $save->url = $request->articleurl;
        $save->minitext = $request->minitext;
        $save->reference = $request->articlereference;
        $save->description = $request->description;
        $save->articlevideo = $request->articlevideo;
        if ($request->publish == true) {
            $save->publish = true;
        } else {
            $save->publish = false;
        }

        if ($request->editflag == false) {
            $lastorder = Article::select('ordered')->orderBy('ordered', 'desc')->first();
            $save->ordered = $lastorder['ordered'] + 1;
        }

        $save->save();

        if ($keywords == null) {
            if ($request->keywords != null){
                foreach ($request->keywords as $key => $value) {
                    $keywords[$key]['article_id'] = $save->id;
                    $keywords[$key]['keyword'] = $value;
                }
                Article_keyword::insert($keywords);
            }
        }
        if ($tags == null) {
            if($request->tags != null) {
                foreach ($request->tags as $tag) {
                    array_push($tags, $tag['id']);
                }
                $save->tags()->sync($tags);
            }
        }



        Storage::disk('media')->makeDirectory('gallery/' . $save['id']);

        return $save['id'];
    }

    public function savearticleimage(Request $request)
    {

        $articleid = $request->articleid;

        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/article/'.$articleid.'_original.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/article/'.$articleid.'_medium.png');
        $image->make($request->image->getRealPath())->resize('300', '220')->save(public_path() . '/media/article/'.$articleid.'_large.png');

        Article::where('id', $articleid)->update(['image' => true]);

        return [rand(100,999)];
    }


    public function changeorder(Request $request)
    {
        Article::where('id', $request->replaceid)->update(['ordered' => $request->thisorder]);
        Article::where('id', $request->thisid)->update(['ordered' => $request->replaceorder]);
    }

    public function deletearticle(Request $request)
    {
        Article::where('id', $request->id)->delete();
    }

    public function savearticlepdf(Request $request)
    {

        $file =$request->file('pdf');
        $file->move(public_path() . '/media/pdfs/','pdf_'.$request->articleid. '.pdf');

        $save = Pdf::where('article_id', $request->articleid)->first();
        if (is_null($save)){
            $save = new Pdf();
            $save->article_id = $request->articleid;
        }
        $save->name = 'pdf_'.$request->articleid.'.pdf';
        $save->save();

    }

    public function savearticleattr(Request $request)
    {
        $addflag = false;
        foreach ($request->attrlist as $key=>$value){
            if($value['title']!= null and $value['value']!=null){
                $addflag = true;
            }
        }

        if ($addflag == true){
            Articleattr::where('article_id', $request->articleid)->delete();
            foreach ($request->attrlist as $key=>$value){
                if($value['title']!= null and $value['value']!=null){
                    $save = new Articleattr();
                    $save->article_id = $request->articleid;
                    $save->title = $value['title'];
                    $save->value = $value['value'];

                    $save->save();
                }
            }
        }
    }









    // article content

    public function articlecontent($id)
    {
        $articleid = $id;
        return view('admin.articlecontents', compact('articleid'));
    }


    public function getarticlecontent(Request $request)
    {
        $article = Article::where('id', $request->articleid)->with('contents.article_type')->get();

        $mycontent = array();

        foreach ($article[0]['contents'] as $key => $content) {
            array_push($mycontent, $content);
            if ($content['article_type_id'] == 3 || $content['article_type_id'] == 4) {
                $galleries = Gallery::where('article_content_id', $content['id'])->get();
                $mycontent[$key]['galleries'] = $galleries;
                if (count($galleries) == 0) {
                    array_splice($mycontent, $key, 1);
                }
            }
        }

        $filemanager = Filemanager::all();

        return [$article, $filemanager, $mycontent];

    }


    public function savearticlecontent(Request $request)
    {
        if ($request->action == 'title') {

            $this->validate($request, [
                'newtitle' => 'required',
            ]);

        } elseif ($request->action == 'text') {

            $this->validate($request, [
                'text' => 'required',
            ]);

        }

        if ($request->editflag != false) {
            $save = Article_content::where('id', $request->contentid)->first();
        } else {
            $save = new Article_content();

            $lastorder = Article_content::select('ordered')->orderBy('ordered', 'desc')->first();
            $save->ordered = $lastorder['ordered'] + 1;

        }

        $save->article_id = $request->articleid;
        $save->publish = $request->publish;

        if ($request->action == 'title') {
            $save->text = $request->newtitle;
            $save->article_type_id = 1;

        } elseif ($request->action == 'text') {
            $save->text = $request->text;
            $save->article_type_id = 2;
        }

        $save->save();

    }


    public function deletecontent(Request $request)
    {
        $content = Article_content::where('id', $request->contentid)->first();

        $content->delete();
    }


    public function changecontentorder(Request $request)
    {
        Article_content::where('id', $request->replaceid)->update(['ordered' => $request->thisorder]);
        Article_content::where('id', $request->thisid)->update(['ordered' => $request->replaceorder]);
    }

    public function savefile(Request $request)
    {
        $randomnum = rand(1000, 9999);
        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/filemanager/item_' . $randomnum . '.png');
        $image->make($request->image->getRealPath())->resize('70', '70')->save(public_path() . '/media/filemanager/itemsmall_' . $randomnum . '.png');

        Filemanager::insert([
            'randomnum' => $randomnum,
        ]);

        return $randomnum;
    }


//    public function newgallery(Request $request)
//    {
//        $deleteids = array();
//        $contents = Article_content::where([['article_id', $request->articleid], ['article_type_id', '3']])->with('galleries')->get();
//        foreach ($contents as $content) {
//            if (count($content['galleries']) == 0) {
//                array_push($deleteids, $content['id']);
//                Storage::disk('media')->deleteDirectory('gallery/' . $content['id']);
//            }
//        }
//        Article_content::whereIn('id', $deleteids)->delete();
//
//
//        $lastorder = Article_content::select('order')->orderBy('order', 'desc')->first();
//
//        $newgallery = Article_content::create([
//            'order' => $lastorder['order'] + 1,
//            'article_id' => $request->articleid,
//            'article_type_id' => 3,
//        ]);
//
//        Storage::disk('media')->makeDirectory('gallery/' . $newgallery['id']);
//    }


    public function savegallery(Request $request)
    {

        $randomnum = rand(1000, 9999);
        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/gallery/' . $request->articleid . '/gallery_' . $randomnum . '.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/gallery/' . $request->articleid . '/gallerysmall_' . $randomnum . '.png');

        $gallery = Gallery::create([
            'article_id' => $request->articleid,
            'image' => $randomnum,
        ]);

        return [$randomnum, $request->articleid, $gallery['id']];
    }


    public function deletegalleryimage(Request $request)
    {
        $gallery = Gallery::where('id', $request->id)->first();

        Storage::disk('media')->delete('gallery/' . $request->articleid . '/gallery_' . $gallery['image'] . '.png');
        Storage::disk('media')->delete('gallery/' . $request->articleid . '/gallerysmall_' . $gallery['image'] . '.png');

        Gallery::where('id', $request->id)->delete();



    }

    public function changepublisharticle(Request $request)
    {
        Article_content::where('id', $request->id)->update(['publish'=> $request->publish]);
    }













    // new content

    public function newcontent()
    {
        return view('admin.articlecontentnew');
    }

    public function newcontentreload()
    {
        $groups = Article_group::all();
        $tags = Tag::all();
        return [$groups, $tags];
    }


































}
