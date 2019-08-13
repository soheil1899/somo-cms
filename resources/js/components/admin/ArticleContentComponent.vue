<template>

    <div id="articlecontentcomponent">
        <h4 class="admin-title py-3 px-4"> محتوی مربوط به مطلب
            {{articlename}}
        </h4>

        <div class="btn-group my-2" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                افزودن محتوی
            </button>
            <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop1">
                <input type="button" @click="addTitle" data-toggle="modal" data-target="#Modal" class="dropdown-item"
                       value="عنوان">
                <input type="button" @click="addText" data-toggle="modal" data-target="#Modal" class="dropdown-item"
                       value="متن">


            </div>
        </div>
        <input type="button" @click="reloadPage" class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <a :href="'../'+ articlegroup" class="back-btn btn btn-dark my-2 mr-1">برگشت</a>

        <div v-for="item in contentlist" :key="item.id">
            <div class="card mt-2">
                <div class="card-header row m-0 px-1">
                    <div class="col-6">
                        <i class="far fa-check-circle fa-lg ml-2 pointer" title="انتشار" @click="changepublish(item.id ,false)" v-if="item.publish == true"></i>
                        <i class="fas fa-ban fa-lg ml-2 pointer" title="عدم انتشار" @click="changepublish(item.id, true)" v-else></i>
                        {{item.article_type.type}}
                    </div>
                    <div class="col-6 icons">
                        <i title="ویرایش" @click="editcontent(item.id, item.text, item.publish, item.article_type_id, item.galleries)"
                           data-toggle="modal"
                           data-target="#Modal"
                           class="fas fa-edit ml-2 fa-lg"></i>
                        <i title="حذف" @click="deletecontent(item.id)" class="fas fa-times-circle ml-3 fa-lg"></i>
                        <i title="برو پایین"  @click="changeorder(item.id, item.ordered, 'down')"
                           v-if="item.id != contentlist[contentlistlength-1]['id']"
                           class="fas fa-arrow-circle-down ml-1 fa-lg"></i>
                        <i title="برو بالا"  @click="changeorder(item.id, item.ordered, 'up')" v-if="item.id != contentlist[0]['id']"
                           class="fas fa-arrow-circle-up fa-lg"></i>
                    </div>
                </div>
                <div class="card-body" v-if="item.article_type.type == 'متن' || item.article_type.type == 'عنوان'">
                    <h4 class="card-title" v-if="item.article_type.type == 'عنوان'"><strong>{{item.text}}</strong></h4>
                    <p class="card-text" v-else v-html="item.text"></p>
<!--                </div>-->
<!--                <div class="card-body" v-if="item.article_type.type == 'گالری تصاویر' || item.article_type.type == 'اسلایدر'">-->
<!--                    <div v-for="gallery in item.galleries" :key="gallery.id" class="m-1 float-right position-relative">-->
<!--                        <img :src="creategalleryurl(gallery.article_content_id, gallery.image)">-->
<!--                    </div>-->
                </div>
            </div>
        </div>


        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">{{modaltitle}}</h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>
                        <input v-if="actionflag == 'title'" type="text" v-model="newtitle" class="form-control"
                               placeholder="عنوان جدید">
                        <div class="row" v-if="actionflag == 'text'">
                            <div class="col-12 col-lg-9" dir="ltr">
                                <editor v-model="text" ref="editor"
                                        api-key="qc1sdre33bdx4lkj24aw4ffoeyx1rvbohr9ow2hzhjgfu2mi"
                                        :init="{plugins: 'wordcount','directionality': 'rtl','height':300}"></editor>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-header row m-0 p-1 pt-2">
                                        <div class="col-8">
                                            مدیریت فایل
                                        </div>
                                        <div class="col-4 icons">
                                            <i @click="browsefile" class="fas fa-plus-square fa-2x"></i>
                                        </div>
                                        <input type="file" class="d-none" id="browse" ref="imagetext"
                                               @change="selectimage" accept=".jpg, .png, .jpeg">
                                    </div>
                                    <div class="card-body p-2">
                                        <div v-for="file in filemanagerids" :key="file.id"
                                             class="m-1 float-right position-relative">
                                            <img :src="file.small" @click="selectImage(file.original)">
                                            <i class="fas fa-trash position-absolute delete-filemanager"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group mb-1 mt-3">
                                    <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-model="publish">
                                    <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>
                                </div>
                            </div>
                        </div>
<!--                        <div v-if="actionflag == 'gallery'">-->
<!--                            <div class="card">-->
<!--                                <div class="card-header row m-0 p-1 pt-2">-->
<!--                                    <div class="col-8">-->
<!--                                        تصاویر مربوط به گالری-->
<!--                                    </div>-->
<!--                                    <div class="col-4 icons">-->
<!--                                        <button type="button" @click="browsefile2" class="btn btn-success btn-sm">افزودن-->
<!--                                            تصویر-->
<!--                                        </button>-->
<!--                                    </div>-->
<!--                                    <input type="file" style="display: none" id="browse2" ref="gallery"-->
<!--                                           @change="selectgallery">-->
<!--                                </div>-->
<!--                                <div class="card-body p-2">-->
<!--                                    <div v-for="gallery in gallerylist" :key="gallery.id"-->
<!--                                         class="m-1 float-right position-relative">-->
<!--                                        <img :src="gallery.url">-->
<!--                                        <i @click="deletegalleryimage(gallery.id)"-->
<!--                                           class="fas fa-trash position-absolute delete-filemanager"></i>-->
<!--                                    </div>-->

<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->


<!--                        <div class="form-group mb-1 mt-3">-->
<!--                            <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-model="publish">-->
<!--                            <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>-->
<!--                        </div>-->
                    </div>

                    <div class="modal-footer">
                        <button type="button" v-if="actionflag == 'title' || actionflag == 'text'" @click="savecontent"
                                class="btn btn-primary">ذخیره
                        </button>
                        <button type="button" class="btn btn-secondary"
                                v-if="actionflag == 'title' || actionflag == 'text'" data-dismiss="modal">بستن
                        </button>
                        <button type="button" class="btn btn-secondary" v-else @click="closegallerymodal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>


<script>


    import Editor from '@tinymce/tinymce-vue';


    export default {
        name: "ArticleContentComponent",
        components: {
            'editor': Editor
        },

        data() {
            return {
                file: null,
                editflag: false,
                actionflag: null,
                contentlist: [],
                articlename: null,
                articleid: null,
                articlegroup: null,
                error: [],
                modaltitle: null,
                newtitle: null,
                contentid: null,
                publish: false,
                contentlistlength: null,

                text: '',
                filemanagerids: [],

            }
        },
        props: ['articlepropid'],


        methods: {

            changepublish(id ,changeto){
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

            closegallerymodal() {
                $('#Modal').modal('toggle');
                this.reloadPage();
            },

            creategalleryurl(id, image) {
                return '/media/gallery/' + id + '/gallerysmall_' + image + '.png';
            },
            selectImage(original) {
                let Imagetag = '<img src="' + original + '" width="200px">';
                this.text += Imagetag;
            },

            browsefile() {
                document.getElementById("browse").click();
            },
            browsefile2() {
                document.getElementById("browse2").click();
            },

            selectimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.imagetext.files[0]);
                axios.post('/dashboard/savefile'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['small'] = '/media/filemanager/itemsmall_' + response.data + '.png';
                        newfile['original'] = '/media/filemanager/item_' + response.data + '.png';
                        that.filemanagerids.push(newfile);
                    });
            },

            // selectgallery() {
            //
            //     let that = this;
            //     let formData = new FormData();
            //     formData.append('image', this.$refs.gallery.files[0]);
            //     axios.post('/dashboard/savegallery'
            //         , formData
            //         , {
            //             headers: {
            //                 'Content-Type': 'multipart/form-data'
            //             }
            //
            //         })
            //         .then(function (response) {
            //             let newfile = [];
            //             newfile['id'] = response.data[2];
            //             newfile['url'] = '/media/gallery/' + response.data[1] + '/gallerysmall_' + response.data[0] + '.png';
            //             that.gallerylist.push(newfile);
            //             // console.log(response.data);
            //         });
            // },
            //
            // deletegalleryimage(id) {
            //     let that = this;
            //     let data = {
            //         id: id,
            //     };
            //
            //     axios.post('/dashboard/deletegalleryimage', data)
            //         .then(function (response) {
            //
            //             for (var i = 0; i < that.gallerylist.length; i++) {
            //                 if (that.gallerylist[i]['id'] == id) {
            //                     that.gallerylist.splice(i, 1);
            //                 }
            //             }
            //
            //         });
            //
            // },


            changeorder(id, order, action) {
                let counter = 0;
                for (var i = 0; i < this.contentlist.length; i++) {
                    if (this.contentlist[i]['ordered'] == order) {
                        counter = i;
                    }
                }

                let replaceid;
                let replaceorder;

                if (action == 'up') {
                    replaceid = this.contentlist[counter - 1]['id'];
                    replaceorder = this.contentlist[counter - 1]['ordered'];
                } else {
                    replaceid = this.contentlist[counter + 1]['id'];
                    replaceorder = this.contentlist[counter + 1]['ordered'];
                }
                let that = this;
                let data = {
                    thisorder: order,
                    thisid: id,
                    replaceid: replaceid,
                    replaceorder: replaceorder,
                };
                axios.post('/dashboard/changecontentorder', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            editcontent(id, text, publish, article_type_id, galleries) {
                this.error = [];
                this.editflag = true;
                this.contentid = id;
                this.publish = publish;
                if (article_type_id == 1) {
                    this.newtitle = text;
                    this.actionflag = 'title';
                    this.modaltitle = 'ویرایش عنوان';
                } else if (article_type_id == 2) {
                    this.text = text;
                    this.actionflag = 'text';
                    this.modaltitle = 'ویرایش متن';
                } else if (article_type_id == 3) {
                    this.gallerylist = [];
                    for (var i = 0; i < galleries.length; i++) {
                        let newfile = [];
                        newfile['id'] = galleries[i]['id'];
                        newfile['url'] = '/media/gallery/' + galleries[i]['article_content_id'] + '/gallerysmall_' + galleries[i]['image'] + '.png';
                        this.gallerylist.push(newfile);
                    }
                    this.actionflag = 'gallery';
                    this.modaltitle = 'ویرایش گالری تصاویر';
                }
            },

            savecontent() {
                let that = this;

                let data = {

                    editflag: this.editflag,
                    action: this.actionflag,
                    newtitle: this.newtitle,
                    text: this.text,
                    contentid: this.contentid,
                    articleid: this.articleid,
                    publish: this.publish,

                };

                axios.post('/dashboard/savearticlecontent', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });

            },

            deletecontent(id) {
                let that = this;
                let data = {
                    contentid: id,
                };

                axios.post('/dashboard/deletecontent', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },


            addTitle() {
                this.error = [];
                this.editflag = false;
                this.actionflag = 'title';
                this.modaltitle = 'افزودن عنوان جدید';
                this.newtitle = null;
                this.text = null;
                this.gallery = [];
            },
            addText() {
                this.error = [];
                this.editflag = false;
                this.actionflag = 'text';
                this.modaltitle = 'افزودن متن جدید';
                this.newtitle = null;
                this.text = null;
                this.gallery = [];
            },
            // addGallery() {
            //     this.error = [];
            //     this.editflag = false;
            //     this.actionflag = 'gallery';
            //     this.modaltitle = 'افزودن گالری جدید';
            //     this.newtitle = null;
            //     this.text = null;
            //     this.gallery = [];
            //
            //     let data = {
            //         articleid: this.articleid,
            //     };
            //     axios.post('/dashboard/newgallery', data)
            //         .then(function (response) {
            //         });
            // },


            reloadPage() {
                let that = this;
                let data = {
                    articleid: this.articleid,
                };
                axios.post('/dashboard/getarticlecontent', data)
                    .then(function (response) {
                        that.articlename = response.data[0][0]['title'];
                        that.articleid = response.data[0][0]['id'];
                        that.articlegroup = response.data[0][0]['article_group_id'];
                        that.contentlist = response.data[2];
                        that.filemanagerids = [];
                        for (var i = 0; i < response.data[1].length; i++) {
                            let newfile = [];
                            newfile['small'] = '/media/filemanager/itemsmall_' + response.data[1][i]['randomnum'] + '.png';
                            newfile['original'] = '/media/filemanager/item_' + response.data[1][i]['randomnum'] + '.png';
                            that.filemanagerids.push(newfile);
                        }

                        that.contentlistlength = that.contentlist.length;
                    });
            },

        },

        mounted() {
            this.articleid = this.articlepropid;
            this.reloadPage();
        }


    }
</script>

<style scoped>

</style>
