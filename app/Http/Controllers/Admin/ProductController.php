<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Color;
use App\Comment;
use App\Filemanager;
use App\Gallery;
use App\Guarantee;
use App\Http\Controllers\Permissions;
use App\Product_subattribute;
use App\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{

    use Permissions;

    public function index()
    {
        return view('admin.product');
    }

    public function getproducts()
    {
        $getall = false;

        $per = $this->getpermission(auth()->user()->roles()->get());
        for ($i = 0; $i < count($per); $i++) {
            if ($per[$i] == 'permission_access') {
                $getall = true;
            }
        }

        if ($getall) {
            $product = Product::with('category', 'colors', 'guarantees', 'brand', 'gallery')->get();
        } else {
            $store = Store::where('user_id', auth()->user()->id)->first();
            $product = Product::where('store_id', $store['id'])->with('category', 'colors', 'guarantees', 'brand', 'gallery')->get();
        }


        $categories = Category::where([['last', 1], ['hidden', 0]])->with('parent')->get();
        foreach ($categories as $category) {
            $category['parentname'] = $category['parent']['name'] . ' > ' . $category['name'];
            unset($category['parent']);
        }
        $guarantees = Guarantee::all();
        $colors = Color::all();
        $brands = Brand::all();

        return [$product, $categories, $colors, $brands, $guarantees];

    }


    public function saveproduct(Request $request)
    {
        $this->validate($request, [
            'product_faname' => 'required',
            'categoryid' => 'required',
            'price' => 'required | numeric | between:0,999999999999',
            'discount' => 'numeric | between:0,70',
        ]);


        $store = Store::where('user_id', auth()->user()->id)->first();


        if ($request->editflag != false) {
            $save = Product::where('id', $request->productid)->first();
        } else {
            $save = new Product();

        }

        $save->faname = $request->product_faname;
        $save->enname = $request->product_enname;
        $save->category_id = $request->categoryid;
        $save->store_id = $store['id'];
        $save->brand_id = $request->brand['id'];
        $save->publish = $request->publish;
        $save->special = $request->special;
        $save->price = $request->price;
        $save->discount = $request->discount;
        $save->tedad = $request->tedad;
        $save->save();

        $colorids = array();
        if (isset($request->colors[0])) {
            foreach ($request->colors as $color) {
                array_push($colorids, $color['id']);
            }
            $save->colors()->sync($colorids);
        }
        $guaranteeids = array();
        if (isset($request->guarantees[0])) {
            foreach ($request->guarantees as $guarantee) {
                array_push($guaranteeids, $guarantee['id']);
            }
            $save->guarantees()->sync($guaranteeids);
        }


        if ($request->editflag == false) {
            Storage::disk('media')->makeDirectory('product/' . $save['id']);
            Storage::disk('media')->makeDirectory('product/' . $save['id'] . '/gallery');
        }


        return $save->id;
    }

    public function deleteproduct(Request $request)
    {
        $keys = array();
        foreach ($request->products as $key => $product) {
            if ($product == true) {
                array_push($keys, $key);
                Storage::disk('media')->deleteDirectory('/product/' . $key);
                Storage::disk('media')->deleteDirectory('/filemanager/product/' . $key);
            }
        }
        Product::whereIn('id', $keys)->delete();
    }

    public function getattributes(Request $request)
    {
        $items = Category::where('id', $request->categoryid)->with('group_attributes.subattributes.attribute_values')->get();
        $values = Product_subattribute::where('product_id', $request->productid)->get();

        return [$items, $values];
    }

    public function saveattrvalue(Request $request)
    {
        $this->saveglobalproductattr($request->values, $request->productid);
    }


    public function saveproimage(Request $request)
    {
        $productid = $request->proid;

        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/product/' . $productid . '/original.png');
        $image->make($request->image->getRealPath())->resize('60', '60')->save(public_path() . '/media/product/' . $productid . '/small.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/product/' . $productid . '/medium.png');
        $image->make($request->image->getRealPath())->resize('200', '200')->save(public_path() . '/media/product/' . $productid . '/large.png');

        Product::where('id', $productid)->update(['image' => true]);

        return [rand(100, 999), $productid];
    }


    public function saveprogallery(Request $request)
    {

        if ($request->proid == 'null') {
            $lastproduct = Product::select('id')->orderBy('id', 'desc')->limit(1)->get();
            $productid = $lastproduct[0]['id'];
        } else {
            $productid = $request->proid;
        }
        $imagename = rand(10000, 99999);

        $image = new ImageManager();
        $image->make($request->image->getRealPath())->save(public_path() . '/media/product/' . $productid . '/gallery/original_' . $imagename . '.png');
        $image->make($request->image->getRealPath())->resize('120', '120')->save(public_path() . '/media/product/' . $productid . '/gallery/small_' . $imagename . '.png');

        $newimage = Gallery::create([
            'product_id' => $productid,
            'image' => $imagename,
        ]);

        return [$imagename, $newimage['id'], $productid];

    }

    public function getprogallery(Request $request)
    {
        return Gallery::where('product_id', $request->productid)->get();
    }

    public function deleteprogallery(Request $request)
    {
        $gallery = Gallery::where('id', $request->galleryid)->first();

        Storage::disk('media')->delete('product/' . $gallery->product_id . '/gallery/original_' . $gallery->image . '.png');
        Storage::disk('media')->delete('product/' . $gallery->product_id . '/gallery/small_' . $gallery->image . '.png');

        $gallery->delete();

    }


    public function savenaghd(Request $request)
    {
        Product::where('id', $request->productid)->update(['naghd' => $request->naghd]);
    }


    public function addproduct()
    {
        return view('admin.addproduct');
    }

    public function getproductinfo()
    {
        $categories = Category::where([['last', 1], ['hidden', 0]])->with('parent')->get();
        foreach ($categories as $category) {
            $category['parentname'] = $category['parent']['name'] . ' > ' . $category['name'];
            unset($category['parent']);
        }
        $guarantees = Guarantee::all();
        $colors = Color::all();
        $brands = Brand::all();

        return [$categories, $colors, $brands, $guarantees];
    }

    public function getproductoptions(Request $request)
    {
        $attrs = Category::where('id', $request->categoryid)->with('group_attributes.subattributes.attribute_values')->get();

        return $attrs;
    }

    public function saveproductoptions(Request $request)
    {
        $lastproduct = Product::select('id')->orderBy('id', 'desc')->limit(1)->get();
        $this->saveglobalproductattr($request->attrvalues, $lastproduct[0]['id']);
        Product::where('id', $lastproduct[0]['id'])->update(['naghd' => $request->naghd]);


    }

    public function saveglobalproductattr($myvalues, $productid)
    {
        $values = $myvalues;
        for ($i = 0; $i < count($myvalues); $i++) {
            if (isset($values[$i]['id'])) {
                unset($values[$i]['id']);
            }
            if ($myvalues[$i] == null) {
                unset($values[$i]);
            }
        }// delete form array if title value set null

        $sortedvalues = array();
        $counter = 0;
        foreach ($values as $key => $item) {
            $sortedvalues[$counter]['product_id'] = $productid;
            if (isset($item['subattribute_id'])) {
                $sortedvalues[$counter]['subattribute_id'] = $item['subattribute_id'];
                $sortedvalues[$counter]['value'] = $item['value'];
            } else {
                $sortedvalues[$counter]['subattribute_id'] = $key;
                $sortedvalues[$counter]['value'] = $item;
            }

            $counter++;
        }

        Product_subattribute::where('product_id', $productid)->delete();
        if (count($sortedvalues) > 0) {
            Product_subattribute::insert($sortedvalues);
        }
    }


    //   comment

    public function productcomment($id)
    {
        return view('admin.productcomment', compact('id'));
    }

    public function getproductcomment(Request $request)
    {
        $procomments = Product::where('id', $request->productid)->with('comments.user')->get();

        $basecomment = array();
        $childcomment = array();
        foreach ($procomments[0]['comments'] as $comment) {
            if ($comment['parent_id'] == 0) {
                array_push($basecomment, $comment);
            } else {
                array_push($childcomment, $comment);
            }
        }

        $childcomment = array_reverse($childcomment);


        return [$procomments, $basecomment, $childcomment];

    }

    public function savecomment(Request $request)
    {
        if ($request->answeredit == 'answer') {

            Comment::where('id', $request->commentid)->update(['answer_flag' => true]);
            Comment::create([
                'title' => $request->title,
                'comment' => $request->text,
                'parent_id' => $request->commentid,
                'user_id' => auth()->user()->id,
                'product_id' => $request->productid,
            ]);
        } else {
            Comment::where('id', $request->commentid)->update(['title' => $request->title, 'comment' => $request->text]);
        }
    }

    public function deletecomment(Request $request)
    {
        Comment::where('id', $request->commentid)->orWhere('parent_id', $request->commentid)->delete();

        $childs = Comment::where('parent_id', $request->parentid)->get();

        if (count($childs) == 0) {
            Comment::where('id', $request->parentid)->update(['answer_flag' => false]);
        }
    }

    public function changepublish(Request $request)
    {
        if ($request->publish == true) {
            Comment::where('id', $request->commentid)->update(['publish' => false]);
            if ($request->answerflag == true) {
                Comment::where('parent_id', $request->commentid)->update(['publish' => false]);
            }
        } else {
            Comment::where('id', $request->commentid)->update(['publish' => true]);
        }
    }

    public function comment()
    {
        return view('admin.comment');
    }

    public function getcomments()
    {
        $comments = Comment::with(['product', 'user'])->orderBy('created_at', 'desc')->get();

//        dd($comments);

        $basecomment = array();
        $childcomment = array();
        foreach ($comments as $comment) {
            if ($comment['parent_id'] == 0) {
                array_push($basecomment, $comment);
            } else {
                array_push($childcomment, $comment);
            }
        }

        $childcomment = array_reverse($childcomment);


        return [$basecomment, $childcomment];
    }

    public function getfilemanager(Request $request)
    {
        if (isset($request->productid)) {
            return Filemanager::where('product_id', $request->productid)->get();
        } else {
            return Filemanager::where('article_id', $request->articleid)->get();
        }
    }


    public function getprobyfilters(Request $request)
    {
        $getall = false;

        $per = $this->getpermission(auth()->user()->roles()->get());
        for ($i = 0; $i < count($per); $i++) {
            if ($per[$i] == 'permission_access') {
                $getall = true;
            }
        }

        if ($getall) {
            $product = Product::where([
                ['faname', 'like', '%' . $request->filtervalues['faname'] . '%'],
                ['enname', 'like', '%' . $request->filtervalues['enname'] . '%'],
                ['special', $request->filtervalues['special']],
            ])->with('category', 'colors', 'guarantees', 'brand', 'gallery')->get();
        } else {
            $store = Store::where('user_id', auth()->user()->id)->first();
            $product = Product::where([
                ['store_id', $store['id']],
                ['faname', 'like', '%' . $request->filtervalues['faname'] . '%'],
                ['enname', 'like', '%' . $request->filtervalues['enname'] . '%'],
                ['special', $request->filtervalues['special']],
            ])->with('category', 'colors', 'guarantees', 'brand', 'gallery')->get();
        }

        // filter by category, brand
        $received = ['cat', 'brand'];
        $database = ['category_id', 'brand_id'];
        for ($i = 0; $i < 2; $i++) {
            if (isset($request->filtervalues[$received[$i]])) {
                foreach ($product as $key => $pro) {
                    if ($pro[$database[$i]] != $request->filtervalues[$received[$i]]['id']) {
                        unset($product[$key]);
                    }
                }
            }
        }


        // filter by price , discount , mojodi
        $received1 = ['price', 'discount', 'mojod'];
        $database1 = ['price', 'discount', 'tedad'];
        for ($i = 0; $i < 3; $i++) {
            if (isset($request->filtervalues['top' . $received1[$i]]) or isset($request->filtervalues['less' . $received1[$i]])) {
                if (isset($request->filtervalues['top' . $received1[$i]]) and isset($request->filtervalues['less' . $received1[$i]])) {
                    foreach ($product as $key => $pro) {
                        if ($pro[$database1[$i]] > $request->filtervalues['top' . $received1[$i]] or $pro[$database1[$i]] < $request->filtervalues['less' . $received1[$i]]) {
                            unset($product[$key]);
                        }
                    }
                } else if (isset($request->filtervalues['top' . $received1[$i]])) {
                    foreach ($product as $key => $pro) {
                        if ($pro[$database1[$i]] > $request->filtervalues['top' . $received1[$i]]) {
                            unset($product[$key]);
                        }
                    }
                } else {
                    foreach ($product as $key => $pro) {
                        if ($pro[$database1[$i]] < $request->filtervalues['less' . $received1[$i]]) {
                            unset($product[$key]);
                        }
                    }
                }
            }
        }


        // filter by color, guarantee
        $received2 = ['colors', 'guaranties'];
        $database2 = ['colors', 'guarantees'];
        for ($z = 0; $z < 2; $z++) {
            if (count($request->filtervalues[$received2[$z]]) > 0) {
                $itemsid = array();
                foreach ($request->filtervalues[$received2[$z]] as $filter) {
                    array_push($itemsid, $filter['id']);
                }
                foreach ($product as $i => $pro) {
                    $find = false;
                    foreach ($pro[$database2[$z]] as $prooption) {
                        foreach ($itemsid as $itemid) {
                            if ($prooption['id'] == $itemid) {
                                $find = true;
                            }
                        }
                    }
                    if (!$find) {
                        unset($product[$i]);
                    }
                }
            }
        }

        // filter by publish
        if ($request->filtervalues['show'] == 'publish'){
            foreach ($product as $key => $pro) {
                if (!$pro['publish']) {
                    unset($product[$key]);
                }
            }
        }
        if ($request->filtervalues['show'] == 'hide'){
            foreach ($product as $key => $pro) {
                if ($pro['publish']) {
                    unset($product[$key]);
                }
            }
        }


        return $product;

    }


}
