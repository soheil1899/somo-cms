<template>

    <div id="articlecomponent">
        <h4 class="admin-title py-3 px-4"> لیست مطالب گروه
            {{groupname}}
        </h4>

        <input type="button" @click="addarticle" class="btn btn-success btn-sm my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن مطلب جدید">
        <input type="button" @click="reloadPage" class="btn btn-info btn-sm my-2 mr-1" value="بازخوانی">
        <v-select v-model="groupselect" class="select-group mr-3" :options="groups" label="name" @input="reloadPage"
                  :clearable="false" placeholder="یکی از گروه ها را انتخاب کنید"></v-select>

        <a :href="'../../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>

        <a :href="'../article'" class="back-btn btn btn-sm btn-dark my-2 mr-1">برگشت</a>
        <input type="button" class="back-btn btn btn-sm btn-danger my-2 mr-3" @click="deletearticle" value="حذف">

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col">عنوان مطلب</th>
                <th scope="col">نویسنده</th>
                <th scope="col">لینک</th>
                <th scope="col">انتشار</th>
                <th scope="col" class="p-0">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
                <th scope="col">محتوی</th>
                <th scope="col" width="5%"></th>
                <th scope="col" width="5%">حذف</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in this.articlelist" :key="item.id">
                <th class="py-2" scope="row">{{index+1}}</th>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2" v-if="item.user.userinfo">{{item.user.userinfo.firstname + ' '+
                    item.user.userinfo.lastname}}
                </td>
                <td class="py-2" v-else>{{item.user.name}}</td>
                <td class="py-2" dir="ltr">{{item.url}}</td>

                <td class="py-1 icons" v-if="item.publish">
                    <i class="far fa-check-circle fa-lg pointer mt-2" title="انتشار"
                       @click="changepublish(item.id ,false)"></i>
                </td>
                <td class="py-1 icons" v-else>
                    <i class="fas fa-ban fa-lg pointer mt-2" title="عدم انتشار"
                       @click="changepublish(item.id, true)"></i>
                </td>

                <td class="py-1 icons">
                    <i title="ویژگی ها" class="fab fa-steam fa-lg mx-1 mt-2"
                       @click="editattr(item.id, item.title, item.attributes)"></i>
                    <i title="گالری تصاویر" class="far fa-images fa-lg mx-1 mt-2"
                       @click="addGallery(item.id, item.title, item.galleries)"></i>

                    <i title="فایل pdf" class="far fa-file-pdf fa-lg mx-1 mt-2" @click="browsepdf(item.id)"></i>

                    <i title="تصویر مطلب" class="fas fa-camera fa-lg mx-1 mt-2"
                       @click="showpic(item.id, item.title, item.image)"></i>
                    <i title="آپلود ویدئو" @click="showvideo(item.id, item.title)"
                       class="fas fa-video fa-lg mx-1 mt-2"></i>
                    <i title="ویرایش" class="far fa-edit fa-lg mx-1 mt-2" data-toggle="modal"
                       data-target="#Modal"
                       @click="editarticle(item.id, item.title, item.url, item.description, item.minitext, item.publish, item.reference, item.keywords, item.articlevideo)"></i>
                </td>
                <td class="py-1 icons">
                    <a :href="'articles-content/'+item.id">
                        <i title="محتوی" class="fas fa-clipboard-list fa-lg mx-1 mt-2"></i>
                    </a>
                </td>
                <td class="py-1 icons">
                    <div class="row justify-content-center icons">
                        <i title="برو بالا" @click="changeorder(item.id, item.ordered, 'up')"
                           v-if="item.id != articlelist[0]['id']"
                           class="fas fa-arrow-circle-up fa-lg mt-2"></i>

                        <i title="برو پایین" @click="changeorder(item.id, item.ordered, 'down')"
                           v-if="item.id != articlelist[articlelistlength-1]['id']"
                           class="fas fa-arrow-circle-down fa-lg mt-2"></i>
                    </div>
                </td>
                <td>
                    <input type="checkbox" v-model="deleteart[item.id]" class="form-check-input mx-auto">
                </td>
            </tr>
            </tbody>
        </table>

        <input type="file" class="d-none" id="browsepdf" ref="mypdf"
               @change="savepdf" accept=".pdf">


        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش مطلب'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن مطلب جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <input type="text" v-model="articletitle" @keyup="changeurl"
                                           class="form-control mt-2" placeholder="عنوان مطلب">
                                    <textarea v-model="description" class="form-control mt-2"
                                              placeholder="توضیحات مربوط به مطلب..." rows="4"></textarea>
                                    <div class="input-group mt-2" dir="ltr">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">/</div>
                                        </div>
                                        <input type="url" v-model="articleurl" @keyup="changeurl2" class="form-control"
                                               placeholder="لینک مطلب">
                                    </div>
                                    <textarea v-model="articlereference" class="form-control mt-2 mb-2 mb-lg-0"
                                              placeholder="منابع مطلب..." rows="3"></textarea>
                                    <input type="text" v-model="articlevideo" class="form-control mt-2"
                                           placeholder="لینک ویدئو آپارات">

                                </div>
                                <div class="col-12 col-lg-6">
                                    <v-select class="mb-2" :multiple="true" v-model="keywords" :taggable="true"
                                              :no-drop="true"
                                              :clearable="false" placeholder="کلمات کلیدی" dir="rtl"></v-select>
                                    <v-select :multiple="true" v-model="articletags" :options="tags" label="tag"
                                              :clearable="false" placeholder="تگ" class="select-tag"></v-select>
                                    <textarea v-model="minitext" class="form-control mt-2" placeholder="متن کوتاه..."
                                              rows="9"></textarea>
                                    <div class="form-group mt-1">
                                        <input type="checkbox" v-model="publish"
                                               class="form-check-input publish-checkbox mr-2">
                                        <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savearticle" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- image Modal -->
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تصویر مطلب
                            {{articlename}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصویر مطلب
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile" class="btn btn-success btn-sm">
                                        انتخاب تصویر
                                    </button>
                                </div>
                                <input type="file" class="d-none" id="browse" ref="image"
                                       @change="selectimage" accept=".jpg, .png, .jpeg">
                            </div>
                            <div class="card-body p-2">
                                <img :src="articleoriginalimage">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-secondary" @click="closeimagemodal">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- video Modal -->
        <article-video :articleid="articleid" :articletitle="articletitle" v-if="videoflag" :key="componentid"></article-video>


        <!-- gallery Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">گالری تصاویر</h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <div class="card">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصاویر مربوط به گالری
                                    {{articletitle}}
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsegallery" class="btn btn-success btn-sm">افزودن
                                        تصویر
                                    </button>
                                </div>
                                <input type="file" class="d-none" id="browsegallery" ref="gallery"
                                       @change="selectgallery" accept=".jpg, .png, .jpeg">
                            </div>
                            <div class="card-body p-2">
                                <div v-for="gallery in gallerylist" :key="gallery.id"
                                     class="m-1 float-right position-relative">
                                    <img :src="gallery.url">
                                    <i @click="deletegalleryimage(gallery.id)"
                                       class="fas fa-trash position-absolute delete-filemanager"></i>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closegallerymodal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- SubAttr Modal -->
        <div class="modal fade" id="subAttr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ویژگی های
                            {{articletitle}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form id="subattr-form">


                            <div class="form-group mb-1 position-relative subattr icons" v-for="item in attrlist"
                                 :key="item.id">
                                <div class="row mb-2 position-relative">
                                    <div class="col-6 pl-1">
                                        <input type="text" class="form-control" v-model="item.title"
                                               placeholder="عنوان ویژگی">
                                    </div>
                                    <div class="col-6 pr-1">
                                        <input type="text" class="form-control" v-model="item.value"
                                               placeholder="مقدار ویژگی">
                                    </div>
                                </div>


                                <i title="حذف ویژگی" class="fas fa-times-circle position-absolute fa-lg"
                                   @click="deleterow(item.id)"></i>

                            </div>


                        </form>
                    </div>

                    <div class="modal-footer my-modal-footer m-0">
                        <div class="row pr-4">
                            <button type="button" @click="savesubattrvalue" class="btn btn-success">ذخیره</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بازگشت</button>

                            <button type="button" @click="newrow" class="btn btn-primary p-1 float-left">ویژگی
                                جدید
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>

    export default {
        name: "ArticleComponent",
        data() {
            return {
                groupid: null,
                editflag: false,
                articlelist: [],
                articlelistlength: null,
                groupname: null,
                articletitle: null,
                articleurl: null,
                description: null,
                minitext: null,
                articlereference: null,
                publish: null,
                keywords: [],
                tags: [],
                articletags: null,
                error: [],
                articleid: null,
                groups: [],
                groupselect: null,
                articleoriginalimage: null,
                articlename: null,

                gallerylist: [],
                articlevideo: null,

                attrlist: [],
                deleteart: [],

                videoflag: false,
                componentid: 0,
            }
        },
        props: ['articlegroupid'],

        methods: {
            showvideo(id, title) {
                this.componentid += 1;
                this.videoflag = true;
                this.articleid = id;
                this.articletitle = title;
            },
            changepublish(id, changeto) {
                let that = this;
                let data = {
                    id: id,
                    publish: changeto,
                };

                axios.post('/dashboard/changepublisharticle', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },
            changeurl() {
                this.articleurl = this.articletitle.replace(/\s+/g, '-').toLowerCase();
            },
            changeurl2() {
                this.articleurl = this.articleurl.replace(/\s+/g, '-').toLowerCase();
            },
            savesubattrvalue() {
                let that = this;
                let data = {
                    articleid: this.articleid,
                    attrlist: this.attrlist,
                };
                axios.post('/dashboard/savearticleattr', data)
                    .then(function (response) {
                        $('#subAttr').modal('hide');
                    });
            },

            newrow() {
                let length = this.attrlist.length;
                this.attrlist.push({
                    'id': Math.floor(Math.random() * 1000000) + 1000,
                    'article_id': this.articleid,
                    'title': null,
                    'value': null,
                });
            },

            deleterow(id) {
                for (let i = 0; i < this.attrlist.length; i++) {
                    if (this.attrlist[i].id == id) {
                        this.attrlist.splice(i, 1);
                    }
                }
            },
            editattr(id, title, attributes) {
                this.articleid = id;
                this.articletitle = title;
                this.attrlist = attributes;

                $('#subAttr').modal('toggle');
            },

            addGallery(id, title, galleries) {
                this.articleid = id;
                this.articletitle = title;

                this.gallerylist = [];

                for (var i = 0; i < galleries.length; i++) {
                    let newfile = [];
                    newfile['id'] = galleries[i]['id'];
                    newfile['url'] = '/media/article/' + id + '/gallery/gallerysmall_' + galleries[i]['image'] + '.png';
                    this.gallerylist.push(newfile);
                }

                $('#galleryModal').modal('toggle');
            },

            browsegallery() {
                document.getElementById("browsegallery").click();
            },

            selectgallery() {

                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.gallery.files[0]);
                formData.append('articleid', this.articleid);
                axios.post('/dashboard/savegallery'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['id'] = response.data[2];
                        newfile['url'] = '/media/article/' + response.data[1] + '/gallery/gallerysmall_' + response.data[0] + '.png';
                        that.gallerylist.push(newfile);
                    });
            },

            deletegalleryimage(id) {
                let that = this;
                let data = {
                    id: id,
                    articleid: this.articleid,
                };

                axios.post('/dashboard/deletegalleryimage', data)
                    .then(function (response) {

                        for (var i = 0; i < that.gallerylist.length; i++) {
                            if (that.gallerylist[i]['id'] == id) {
                                that.gallerylist.splice(i, 1);
                            }
                        }

                    });

            },
            closegallerymodal() {
                $('#galleryModal').modal('toggle');
                this.reloadPage();
            },


            browsepdf(id) {
                this.articleid = id;
                document.getElementById("browsepdf").click();
            },
            savepdf() {
                let that = this;
                let formData = new FormData();
                formData.append('pdf', this.$refs.mypdf.files[0]);
                formData.append('articleid', this.articleid);
                axios.post('/dashboard/savearticlepdf'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {

                    });

            },

            closeimagemodal() {
                $('#imagemodal').modal('hide');
                this.reloadPage();
            },
            browsefile() {
                document.getElementById("browse").click();
            },

            selectimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.image.files[0]);
                formData.append('articleid', this.articleid);

                axios.post('/dashboard/savearticleimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {

                        that.articleoriginalimage = '/media/article/' + that.articleid + '/medium.png?' + response.data[0];
                    });
            },

            showpic(id, articlename, image) {
                this.articlename = articlename;
                this.articleoriginalimage = null;
                if (image == true) {
                    this.articleoriginalimage = '/media/article/' + id + '/medium.png';
                }

                this.articleid = id;

                $('#imagemodal').modal('show');


            },

            deletearticle(id) {
                let that = this;
                let data = {
                    articles: this.deleteart,
                };
                axios.post('/dashboard/deletearticle', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            changeorder(id, order, action) {
                let counter = 0;
                for (var i = 0; i < this.articlelist.length; i++) {
                    if (this.articlelist[i]['ordered'] == order) {
                        counter = i;
                    }
                }

                let replaceid;
                let replaceorder;

                if (action == 'up') {
                    replaceid = this.articlelist[counter - 1]['id'];
                    replaceorder = this.articlelist[counter - 1]['ordered'];
                } else {
                    replaceid = this.articlelist[counter + 1]['id'];
                    replaceorder = this.articlelist[counter + 1]['ordered'];
                }
                let that = this;
                let data = {
                    thisorder: order,
                    thisid: id,
                    replaceid: replaceid,
                    replaceorder: replaceorder,
                };
                axios.post('/dashboard/changeorder', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            editarticle(id, title, url, description, minitext, publish, reference, keywords, articlevideo) {
                this.error = [];
                this.editflag = true;
                this.articletitle = title;
                this.articleurl = url;
                this.description = description;
                this.minitext = minitext;
                this.articlereference = reference;
                this.keywords = [];
                this.articleid = id;
                this.publish = publish;
                this.articlevideo = articlevideo;
                if (keywords.length > 0) {
                    for (var i = 0; i < keywords.length; i++) {
                        this.keywords.push(keywords[i]['keyword']);
                    }
                }
            },


            addarticle() {
                this.error = [];
                this.editflag = false;
                this.articletitle = null;
                this.articleurl = null;
                this.description = null;
                this.minitext = null;
                this.articlereference = null;
                this.keywords = [];
                this.articleid = null;
                this.publish = null;
                this.articlevideo = null;
            },


            reloadPage() {
                let that = this;
                let data;
                if (this.groupselect == null) {
                    data = {
                        groupid: this.articlegroupid,
                    };
                } else {
                    data = {
                        groupid: this.groupselect['id'],
                    };
                }
                axios.post('/dashboard/getarticles', data)
                    .then(function (response) {


                        that.groupname = response.data[0][0]['name'];
                        that.groupid = response.data[0][0]['id'];
                        that.articlelist = response.data[3];
                        that.orderflag = true;

                        that.groups = response.data[1];
                        that.tags = response.data[2];

                        that.articlelistlength = that.articlelist.length;

                        for (var i = 0; i < response.data[1].length; i++) {
                            if (that.groupid == response.data[1][i]['id']) {
                                that.groupselect = response.data[1][i];
                            }
                        }
                    });
            },


            savearticle() {
                let that = this;

                let data = {
                    editflag: this.editflag,
                    articleid: this.articleid,
                    groupid: this.groupid,
                    articletitle: this.articletitle,
                    url: this.articleurl,
                    minitext: this.minitext,
                    articlereference: this.articlereference,
                    description: this.description,
                    publish: this.publish,
                    keywords: this.keywords,
                    articlevideo: this.articlevideo,
                };

                axios.post('/dashboard/savearticle', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },


        },

        mounted() {

            this.groupid = this.articlegroupid;
            this.reloadPage();
        }


    }
</script>

<style scoped>

    .select-group {
        width: 250px;
        display: inline-block;
    }
</style>
