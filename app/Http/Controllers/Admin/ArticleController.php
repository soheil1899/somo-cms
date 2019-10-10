<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Article_content;
use App\Article_group;
use App\Articleattr;
use App\Filemanager;
use App\Gallery;
use App\Http\Controllers\Permissions;
use App\Keyword;
use App\Pdf;
use App\Tag;
use App\Lang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;


class ArticleController extends Controller
{
    use Permissions;

    // group

    public function index()
    {
        return view('admin.articlegroup');
    }

    public function getarticlegroups()
    {
        $langs = Lang::all();
        $articlegroups = Article_group::with('articles', 'keywords', 'lang')->get();
        return [$langs, $articlegroups];
    }

    public function savegroup(Request $request)
    {
        if ($request->editflag != false) {
            if ($request->groupname != null and $request->grouptitle != null) {
                if ($request->url != null) {
                    Article_group::where('id', $request->groupid)->update(['url' => '']);
                }
            }
        }
        $this->validate($request, [
            'groupname' => 'required',
            'grouptitle' => 'required',
            'url' => 'required | unique:article_groups',
        ]);

        $keywords = array();

        if ($request->editflag != false) {
            $save = Article_group::where('id', $request->groupid)->first();


            Keyword::where('article_group_id', $request->groupid)->delete();

            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_group_id'] = $request->groupid;
                $keywords[$key]['keyword'] = $value;
            }
            Keyword::insert($keywords);

        } else {
            $save = new Article_group();

        }

        $save->name = $request->groupname;
        $save->title = $request->grouptitle;
        $save->lang_id = $request->lang['id'];
        $save->url = $request->url;
        $save->description = $request->description;

        $save->save();

        if ($keywords == null) {
            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_group_id'] = $save->id;
                $keywords[$key]['keyword'] = $value;
            }
            Keyword::insert($keywords);
        }

    }

    public function deletegroup(Request $request)
    {
        $keys = array();
        foreach ($request->groups as $key => $group) {
            if ($group == true) {
                array_push($keys, $key);
            }
        }
        Article_group::whereIn('id', $keys)->delete();
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
        $per = $this->getpermission(auth()->user()->roles()->get());

        for ($i = 0; $i < count($per); $i++) {
            if ($per[$i] == 'super_article') {
                $accessall = true;
            }

        }


        if ($accessall == false) {
            $myarticles = array();

            foreach ($myarticlelist as $key => $value) {
                if ($value['user_id'] == auth()->user()->id) {
                    array_push($myarticles, $value);
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
        if ($request->editflag != false) {
            if ($request->groupid != null and $request->articletitle != null) {
                if ($request->url != null) {
                    Article::where('id', $request->articleid)->update(['url' => '']);
                }
            }
        }

        $this->validate($request, [
            'groupid' => 'required',
            'articletitle' => 'required',
            'url' => 'required | unique:articles',
        ]);

        $keywords = array();
        $tags = array();

        if ($request->editflag != false) {
            $save = Article::where('id', $request->articleid)->first();


            Keyword::where('article_id', $request->articleid)->delete();

            foreach ($request->keywords as $key => $value) {
                $keywords[$key]['article_id'] = $request->articleid;
                $keywords[$key]['keyword'] = $value;
            }
            Keyword::insert($keywords);

        } else {
            $save = new Article();
            $save->article_group_id = $request->groupid;
        }

        $save->title = $request->articletitle;
        $save->user_id = auth()->user()->id;
        $save->url = $request->url;
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
            if ($request->keywords != null) {
                foreach ($request->keywords as $key => $value) {
                    $keywords[$key]['article_id'] = $save->id;
                    $keywords[$key]['keyword'] = $value;
                }
                Keyword::insert($keywords);
            }
        }
        if ($tags == null) {
            if ($request->tags != null) {
                foreach ($request->tags as $tag) {
                    array_push($tags, $tag['id']);
                }
                $save->tags()->sync($tags);
            }
        }


        Storage::disk('media')->makeDirectory('article/' . $save['id']);
        Storage::disk('media')->makeDirectory('article/' . $save['id'] . '/gallery');
        Storage::disk('media')->makeDirectory('article/' . $save['id'] . '/pdf');
        Storage::disk('media')->makeDirectory('article/' . $save['id'] . '/content');
        Storage::disk('media')->makeDirectory('article/' . $save['id'] . '/video');

        return $save['id'];
    }

    public function savearticleimage(Request $request)
    {

        $articleid = $request->articleid;

        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/article/' . $articleid . '/original.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/article/' . $articleid . '/medium.png');

        Article::where('id', $articleid)->update(['image' => true]);

        return [rand(100, 999)];
    }


    public function changeorder(Request $request)
    {
        Article::where('id', $request->replaceid)->update(['ordered' => $request->thisorder]);
        Article::where('id', $request->thisid)->update(['ordered' => $request->replaceorder]);
    }

    public function deletearticle(Request $request)//////////////////////////////////////
    {
        $keys = array();
        foreach ($request->articles as $key => $article) {
            if ($article == true) {
                array_push($keys, $key);
                Storage::disk('media')->deleteDirectory('/article/' . $key);
                Storage::disk('media')->deleteDirectory('/filemanager/article/' . $key);
            }
        }
        Article::whereIn('id', $keys)->delete();

    }


    public function savearticlepdf(Request $request)
    {
//        dd($request->all());
        $file = $request->file('pdf');
        $rand = rand(1000, 9999);
        $file->move(public_path() . '/media/article/' . $request->articleid . '/pdf/', $rand . '.pdf');

        $save = Pdf::where('article_id', $request->articleid)->first();
        if (is_null($save)) {
            $save = new Pdf();
            $save->article_id = $request->articleid;
        }
        $save->name = $rand . '.pdf';
        $save->save();

    }

    public function savearticleattr(Request $request)
    {
        $addflag = false;
        foreach ($request->attrlist as $key => $value) {
            if ($value['title'] != null and $value['value'] != null) {
                $addflag = true;
            }
        }

        if ($addflag == true) {
            Articleattr::where('article_id', $request->articleid)->delete();
            foreach ($request->attrlist as $key => $value) {
                if ($value['title'] != null and $value['value'] != null) {
                    $save = new Articleattr();
                    $save->article_id = $request->articleid;
                    $save->title = $value['title'];
                    $save->value = $value['value'];

                    $save->save();
                }
            }
        }
    }

    public function savegallery(Request $request)
    {

        $randomnum = rand(1000, 9999);
        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/article/' . $request->articleid . '/gallery/gallery_' . $randomnum . '.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/article/' . $request->articleid . '/gallery/gallerysmall_' . $randomnum . '.png');

        $gallery = Gallery::create([
            'article_id' => $request->articleid,
            'image' => $randomnum,
        ]);

        return [$randomnum, $request->articleid, $gallery['id']];
    }


    public function deletegalleryimage(Request $request)
    {
        $gallery = Gallery::where('id', $request->id)->first();

        Storage::disk('media')->delete('article/' . $request->articleid . '/gallery/gallery_' . $gallery['image'] . '.png');
        Storage::disk('media')->delete('article/' . $request->articleid . '/gallery/gallerysmall_' . $gallery['image'] . '.png');

        Gallery::where('id', $request->id)->delete();
    }

    public function changepublisharticle(Request $request)
    {
        Article::where('id', $request->id)->update(['publish' => $request->publish]);
    }




























    // article content

    public function articlecontent($id)
    {
        $articleid = $id;
        return view('admin.articlecontents', compact('articleid'));
    }


    public function getarticlecontent(Request $request)
    {
        $article = Article::where('id', $request->articleid)->with('contents.article_type')->first();

        return $article;

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

        if ($content['article_type_id'] == 3) {
            Storage::disk('media')->delete('article/' . $content['article_id'] . '/content/' . $content['text'] . '_medium.png');
            Storage::disk('media')->delete('article/' . $content['article_id'] . '/content/' . $content['text'] . '_original.png');
        }
        $content->delete();
    }


    public function savecontentimage(Request $request)
    {
        $articleid = $request->articleid;
        $contentid = $request->contentid;

        $reterndata = null;
        if ($contentid == 'null') {
            $rand = rand(100000, 999999);
            $reterndata = $rand;

            $image = new ImageManager();
            $image->make($request->image->getRealPath())->save(public_path() . '/media/article/' . $articleid . '/content/' . $rand . '_original.png');
            $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/article/' . $articleid . '/content/' . $rand . '_medium.png');

            $lastorder = Article_content::select('ordered')->orderBy('ordered', 'desc')->first();

            $save = new Article_content();
            $save->text = $rand;
            $save->article_id = $articleid;
            $save->article_type_id = 3;
            $save->ordered = $lastorder['ordered'] + 1;

            $save->save();


        } else {
            $content = Article_content::where('id', $contentid)->first();
            $reterndata = $content->text;

            $image = new ImageManager();
            $image->make($request->image->getRealPath())->save(public_path() . '/media/article/' . $articleid . '/content/' . $content->text . '_original.png');
            $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/article/' . $articleid . '/content/' . $content->text . '_medium.png');

        }

        return $reterndata;

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
        if (isset($request->articleid)){
            $path = 'filemanager/article/';
            $newfolder = $request->articleid;
        }else if (isset($request->productid)){
            $path = 'filemanager/product/';
            $newfolder = $request->productid;
        }else{
            $path = 'filemanager/setting/';
            $newfolder = $request->settingid;
        }
        Storage::disk('media')->makeDirectory($path . $newfolder);

        $image->make($request->image->getRealPath())->save(public_path() . '/media/'. $path . $newfolder . '/item_' . $randomnum . '.png');
        $image->make($request->image->getRealPath())->resize('70', '70')->save(public_path() . '/media/'. $path . $newfolder . '/itemsmall_' . $randomnum . '.png');

        $save = new Filemanager();
        $save->randomnum = $randomnum;
        if (isset($request->articleid)){
            $save->article_id = $request->articleid;
        }else{
            $save->product_id = $request->productid;
        }
        $save->save();

        return $randomnum;
    }


    public function changepublishcontent(Request $request)
    {
        Article_content::where('id', $request->id)->update(['publish' => $request->publish]);
    }

    public function deletefilemanager(Request $request)
    {
        $path = explode('/', $request->original);
        $folder = $path[count($path)-2];
        $filename = substr($path[count($path)-1],5, 4);

        if ($request->flag == 'article') {
            Filemanager::where([['article_id', $folder], ['randomnum', $filename]])->delete();
            Storage::disk('media')->delete('filemanager/article/'. $folder . '/item_' . $filename . '.png');
            Storage::disk('media')->delete('filemanager/article/'. $folder . '/itemsmall_' . $filename . '.png');
        }else{
            Filemanager::where([['product_id', $folder], ['randomnum', $filename]])->delete();
            Storage::disk('media')->delete('filemanager/product/'. $folder . '/item_' . $filename . '.png');
            Storage::disk('media')->delete('filemanager/product/'. $folder . '/itemsmall_' . $filename . '.png');
        }

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

    public function editcol(Request $request)
    {
        Article_content::where('id', $request->id)->update(['col' => $request->col]);
    }


}
