<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::namespace('Client')->middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});

// dashboard
Route::prefix('dashboard')->namespace('Admin')->middleware(['auth', 'CheckAdmin'])->group(function () {

    Route::get('/', 'AdminController@index')->name('admin');


    Route::get('changemyinfo', 'AdminController@getmyinfo')->name('changemyinfo');
    Route::post('getmyinfo', 'AdminController@getmyinfos')->name('get.myinfo');
    Route::post('savemyinfo', 'AdminController@savemyinfo')->name('savemy.info');


    Route::post('upload/{id}/{flag}', 'VideoController@uploadvideo')->name('upload.video');
    Route::post('getvideos', 'VideoController@getvideos')->name('get.video');
    Route::post('deletevideo', 'VideoController@deletevideo')->name('delete.video');
    Route::post('deletefilemanager', 'ArticleController@deletefilemanager')->name('delete.filemanager');




    Route::group(['middleware' => 'CheckUseradmin'], function () {
        // user
        Route::get('user', 'UserController@index')->name('user.list');
        Route::post('users', 'UserController@getusers')->name('get.users');
        Route::post('saveuser', 'UserController@saveuser')->name('save.user');
        Route::post('deleteuser', 'UserController@deleteuser')->name('delete.user');
        Route::post('saveuseraccess', 'UserController@saveuseraccess')->name('saveuser.access');
        Route::get('user/{id}', 'UserController@userinfo')->name('user.info');
        Route::post('getuserinfo', 'UserController@getuserinfo')->name('getuser.info');
        Route::post('saveuserinfo', 'UserController@saveuserinfo')->name('saveuser.info');
        Route::post('savestoreinfo', 'UserController@savestoreinfo')->name('savestore.info');


    });


    Route::group(['middleware' => 'CheckSuperadmin'], function () {

        Route::get('superadmininfo', 'AdminController@superadmininfo')->name('superadmin.info');



        Route::get('posts', 'PostController@index')->name('posts');
        Route::post('getposts', 'PostController@getposts')->name('get.posts');



        Route::get('setting', 'SettingController@index')->name('setting');
        Route::post('getsetting', 'SettingController@getsetting')->name('get.setting');
        Route::post('savelogoimage', 'SettingController@savelogoimage')->name('save.logoimage');
        Route::post('savebannerimage', 'SettingController@savebannerimage')->name('save.bannerimage');
        Route::post('savesetting', 'SettingController@savesetting')->name('save.setting');
        Route::post('savecompanycatalog', 'SettingController@savecompanycatalog')->name('save.companycatalog');


        // role
        Route::get('role', 'RoleController@index')->name('role.list');
        Route::post('roles', 'RoleController@getroles')->name('get.roles');
        Route::post('saverole', 'RoleController@saverole')->name('save.roles');
        Route::post('savepermission', 'RoleController@savepermission')->name('save.permission');
        Route::post('deleterole', 'RoleController@deleterole')->name('delete.role');



        // slider
        Route::get('slider', 'SliderController@index')->name('slider');
        Route::post('getslider', 'SliderController@getslider')->name('getslider');
        Route::post('savesliderimage', 'SliderController@savesliderimage')->name('save.sliderimage');
        Route::post('deletesliderimage', 'SliderController@deletesliderimage')->name('delete.sliderimage');
        Route::post('deleteslider', 'SliderController@deleteslider')->name('delete.slider');
        Route::post('changepublishslider', 'SliderController@changepublishslider')->name('changepublish.slider');
        Route::post('saveimagedetails', 'SliderController@saveimagedetails')->name('saveimage.details');
        Route::post('sliderchange', 'SliderController@sliderchange')->name('sliderchange');


        Route::get('menugroup', 'MenuController@index')->name('menu.list');
        Route::post('getmenugroups', 'MenuController@getmenugroups')->name('get.menugroups');
        Route::post('getmenus', 'MenuController@getmenus')->name('get.menus');
        Route::post('getsubmenus', 'MenuController@getsubmenus')->name('get.submenus');


    });


    Route::group(['middleware' => 'CheckWriteradmin'], function () {
        // article
        // group
        Route::get('article', 'ArticleController@index')->name('article.group.list');
        Route::post('getarticlegroups', 'ArticleController@getarticlegroups')->name('get.articlegroups');
        Route::post('savegroup', 'ArticleController@savegroup')->name('save.articlegroup');
        Route::post('deletegroup', 'ArticleController@deletegroup')->name('delete.articlegroup');
        // article
        Route::get('articles/{id}', 'ArticleController@articles')->name('articles');
        Route::post('getarticles', 'ArticleController@getarticles')->name('get.articles');
        Route::post('savearticle', 'ArticleController@savearticle')->name('save.article');
        Route::post('savearticleimage', 'ArticleController@savearticleimage')->name('save.articleimage');
        Route::post('changeorder', 'ArticleController@changeorder')->name('changeorder.article');
        Route::post('deletearticle', 'ArticleController@deletearticle')->name('delete.article');
        Route::post('savearticlepdf', 'ArticleController@savearticlepdf')->name('save.articlepdf');
        Route::post('savearticleattr', 'ArticleController@savearticleattr')->name('save.articleattr');
        Route::post('changepublisharticle', 'ArticleController@changepublisharticle')->name('changepublish.article');

        //content
        Route::get('articles/articles-content/{id}', 'ArticleController@articlecontent')->name('get.articlecontent');
        Route::post('getarticlecontent', 'ArticleController@getarticlecontent')->name('get.articlecontent');
        Route::post('savearticlecontent', 'ArticleController@savearticlecontent')->name('save.articlecontent');
        Route::post('deletecontent', 'ArticleController@deletecontent')->name('delete.content');
        Route::post('changecontentorder', 'ArticleController@changecontentorder')->name('change.contentorder');
        Route::post('savefile', 'ArticleController@savefile')->name('save.file');
        Route::post('savegallery', 'ArticleController@savegallery')->name('save.gallery');
        Route::post('deletegalleryimage', 'ArticleController@deletegalleryimage')->name('delete.galleryimage');
        Route::post('changepublishcontent', 'ArticleController@changepublishcontent')->name('changepublish.content');
        Route::post('savecontentimage', 'ArticleController@savecontentimage')->name('save.contentimage');
        Route::post('editcol', 'ArticleController@editcol')->name('edit.col');


        // content new
        Route::get('newcontent', 'ArticleController@newcontent')->name('new.content');
        Route::post('newcontentreload', 'ArticleController@newcontentreload')->name('new.content.reload');

    });


    Route::group(['middleware' => 'CheckStoreadmin'], function () {

        // category
        Route::get('category', 'CategoryController@index')->name('category.list');
        Route::post('categories', 'CategoryController@getcategories')->name('get.categories');
        Route::post('savecategory', 'CategoryController@savecategory')->name('save.category');
        Route::post('getsubcategorys', 'CategoryController@getsubcategorys')->name('get.subcategories');
        Route::post('getattributegroup', 'CategoryController@getattributegroup')->name('get.attribute.group');
        Route::post('saveattrgroup', 'CategoryController@saveattrgroup')->name('save.attribute.group');
        Route::post('deletecategory', 'CategoryController@deletecategory')->name('delete.category');


        // Attribute
        Route::get('attribute', 'AttributeController@index')->name('attribute.list');
        Route::post('getattribute', 'AttributeController@getattribute')->name('get.attribute');
        Route::post('saveattribute', 'AttributeController@saveattribute')->name('save.attribute');
        Route::post('getsubattribute', 'AttributeController@getsubattribute')->name('get.sub.attribute');
        Route::post('deletesubattribute', 'AttributeController@deletesubattribute')->name('delete.sub.attribute');
        Route::post('getsubvalue', 'AttributeController@getsubvalue')->name('get.sub.value');
        Route::post('savesubattributevalue', 'AttributeController@savesubattributevalue')->name('save.sub.attribute.value');


        // color
        Route::get('color', 'ColorController@index')->name('color.list');
        Route::post('getcolors', 'ColorController@getcolors')->name('get.colors');
        Route::post('getcolor', 'ColorController@getcolor')->name('get.color');
        Route::post('savecolor', 'ColorController@savecolor')->name('save.color');
        Route::post('deletecolor', 'ColorController@deletecolor')->name('delete.color');



        // guarantee
        Route::get('guarantee', 'GuaranteeController@index')->name('guarantee.list');
        Route::post('getguarantees', 'GuaranteeController@getguarantees')->name('get.guarantees');
        Route::post('saveguarantee', 'GuaranteeController@saveguarantee')->name('save.guarantee');


        // brand
        Route::get('brand', 'BrandController@index')->name('brand.list');
        Route::post('getbrands', 'BrandController@getbrands')->name('get.brands');
        Route::post('savebrand', 'BrandController@savebrand')->name('save.brand');



        // product
        Route::get('product', 'ProductController@index')->name('product.list');
        Route::post('getproducts', 'ProductController@getproducts')->name('get.products');
        Route::post('saveproduct', 'ProductController@saveproduct')->name('save.product');
//        Route::post('deleteproduct', 'ProductController@deleteproduct')->name('delete.product');
        Route::post('deleteproduct', 'ProductController@deleteproduct')->name('delete.product');
        Route::post('getattributes', 'ProductController@getattributes')->name('get.attributes');
        Route::post('saveattrvalue', 'ProductController@saveattrvalue')->name('save.attributes');
        Route::post('saveproimage', 'ProductController@saveproimage')->name('save.proimage');
        Route::post('saveprogallery', 'ProductController@saveprogallery')->name('save.progallery');
        Route::post('getprogallery', 'ProductController@getprogallery')->name('get.progallery');
        Route::post('deleteprogallery', 'ProductController@deleteprogallery')->name('delete.progallery');
        Route::post('savenaghd', 'ProductController@savenaghd')->name('save.naghd');
        Route::post('getfilemanager', 'ProductController@getfilemanager')->name('get.filemanager');
        Route::post('getprobyfilters', 'ProductController@getprobyfilters')->name('get.probyfilters');


        // comment
        Route::get('productcomment/{id}', 'ProductController@productcomment')->name('product.comment');
        Route::post('getproductcomment', 'ProductController@getproductcomment')->name('get.product.comment');
        Route::post('savecomment', 'ProductController@savecomment')->name('save.comment');
        Route::post('deletecomment', 'ProductController@deletecomment')->name('delete.comment');
        Route::post('changepublish', 'ProductController@changepublish')->name('changepublish.comment');


        // add product
        Route::get('addproduct', 'ProductController@addproduct')->name('add.product');
        Route::post('getproductinfo', 'ProductController@getproductinfo')->name('get.product.info');
        Route::post('getproductoptions', 'ProductController@getproductoptions')->name('get.product.options');
        Route::post('saveproductoptions', 'ProductController@saveproductoptions')->name('save.product.options');


        // comment list
        Route::get('comment', 'ProductController@comment')->name('comment.list');
        Route::post('getcomments', 'ProductController@getcomments')->name('get.comments');



        // customer
        Route::get('customer', 'CustomerController@index')->name('customer.list');
        Route::post('getcustomer', 'CustomerController@getcustomer')->name('get.customer');
        Route::post('savecustomer', 'CustomerController@savecustomer')->name('save.customer');
        Route::post('deletecustomer', 'CustomerController@deletecustomer')->name('delete.customer');


    });


    Route::group(['middleware' => ['CheckStoreadmin' or 'CheckWriteradmin']], function () {

        // tag
        Route::get('tag', 'TagController@index')->name('tag.list');
        Route::post('gettags', 'TagController@gettags')->name('get.tags');
        Route::post('savetag', 'TagController@savetag')->name('save.tag');


    });

});
