<template>
    <div id="articlecontentcomponent">
        <h4 class="admin-title py-3 px-4"> محتوی مربوط به مطلب
            {{articlename}}
        </h4>

        <input type="button" class="btn btn-sm btn-success" value="افزودن عنوان" @click="addTitle" data-toggle="modal"
               data-target="#Modal">
        <input type="button" class="btn btn-sm btn-success" value="افزودن متن" @click="addText" data-toggle="modal"
               data-target="#Modal">
        <input type="button" class="btn btn-sm btn-success" value="افزودن تصویر" @click="browsefile3">
        <input type="file" class="d-none" id="browse3" ref="image"
               @change="selectimage2" accept=".jpg, .png, .jpeg">


        <input type="button" @click="reloadPage" class="btn btn-sm btn-info my-2 mr-1" value="بازخوانی">
        <a :href="'../../../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>

        <a :href="'../'+ articlegroup" class="back-btn btn-sm btn btn-dark my-2 mr-1">برگشت</a>

        <!--        < class="row mx-0">-->
        <div :class="contentclass(item.col)" v-for="item in contentlist" :key="item.id">
            <div class="card-header row m-0 px-1 py-1">
                <div class="col-4">
                    <i class="far fa-check-circle fa-lg ml-2 pointer mt-2" title="انتشار"
                       @click="changepublish(item.id ,false)" v-if="item.publish == true"></i>
                    <i class="fas fa-ban fa-lg ml-2 pointer mt-2" title="عدم انتشار"
                       @click="changepublish(item.id, true)" v-else></i>
                    {{item.article_type.type}}
                </div>
                <div class="col-8 icons">
                    <i title="ویرایش" v-if="item.article_type_id != 3"
                       @click="editcontent(item.id, item.text, item.publish, item.article_type_id)"
                       data-toggle="modal"
                       data-target="#Modal"
                       class="fas fa-edit ml-2 fa-lg"></i>
                    <i title="ویرایش" v-else
                       @click="editcontent(item.id, item.text, item.publish, item.article_type_id)"
                       class="fas fa-edit ml-2 fa-lg"></i>
                    <i title="حذف" @click="deletecontent(item.id, item.article_type_id, item.text)"
                       class="fas fa-times-circle ml-3 fa-lg"></i>
                    <i title="برو پایین" @click="changeorder(item.id, item.ordered, 'down')"
                       v-if="item.id != contentlist[contentlistlength-1]['id']"
                       class="fas fa-arrow-circle-down ml-1 fa-lg"></i>
                    <i title="برو بالا" @click="changeorder(item.id, item.ordered, 'up')"
                       v-if="item.id != contentlist[0]['id']"
                       class="fas fa-arrow-circle-up fa-lg"></i>
                    <select class="mr-3" v-model="item.col" @change="changecol(item.id, item.col)">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
            </div>
            <div class="card-body" v-if="item.article_type.type == 'متن' || item.article_type.type == 'عنوان'">
                <h4 class="card-title" v-if="item.article_type.type == 'عنوان'"><strong>{{item.text}}</strong>
                </h4>
                <p class="card-text" v-else v-html="item.text"></p>
            </div>
            <div class="card-body" v-if="item.article_type.type == 'تصویر'">
                <img :src="contentimage(item.text)">
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
                                        <div v-for="(file, index) in filemanagerids" :key="file.id"
                                             class="m-1 float-right position-relative">
                                            <img :src="file.small" @click="selectImage(file.original)">
                                            <i class="fas fa-trash position-absolute delete-filemanager" @click="deletefilemanager(file.small, file.original, index)"></i>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group mb-1 mt-3">
                                    <input type="checkbox" class="form-check-input publish-checkbox mr-2"
                                           v-model="publish">
                                    <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" v-if="actionflag == 'title' || actionflag == 'text'" @click="savecontent"
                                class="btn btn-primary">ذخیره
                        </button>
                        <button type="button" class="btn btn-secondary"
                                v-if="actionflag == 'title' || actionflag == 'text'" data-dismiss="modal">بستن
                        </button>
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
                publish: true,
                contentlistlength: null,

                text: '',
                filemanagerids: [],

                image: null,


            }
        },
        props: ['articlepropid'],


        methods: {
            deletefilemanager(small, original, index){
                let that = this;
                let data = {
                    flag: 'article',
                    small: small,
                    original: original,
                };
                axios.post('/dashboard/deletefilemanager', data)
                    .then(function (response) {
                        that.filemanagerids.splice(index, 1);
                        that.reloadPage();
                    });
            },
            contentclass(col) {
                if (col == 1) {
                    return 'col-12 card my-2 px-0';
                } else if (col == 2) {
                    return 'col-12 col-lg-6 card my-2 px-0';
                } else if (col == 3) {
                    return 'col-12 col-lg-4 card my-2 px-0';
                } else if (col == 4) {
                    return 'col-6 col-lg-3 card my-2 px-0';
                }
            },
            changecol(id, col) {
                let that = this;
                let data = {
                    id: id,
                    col: col,
                };
                axios.post('/dashboard/editcol', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },
            contentimage(text) {
                var random = Math.floor(Math.random() * (9999 - 1000)) + 1000;
                return '/media/article/' + this.articleid + '/content/' + text + '_medium.png?' + random;
            },
            browsefile3() {
                document.getElementById("browse3").click();

            },

            selectimage2() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.image.files[0]);
                formData.append('articleid', this.articleid);
                formData.append('contentid', this.contentid);
                formData.append('action', this.actionflag);

                axios.post('/dashboard/savecontentimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        that.reloadPage();
                    });
            },


            changepublish(id, changeto) {
                let that = this;
                let data = {
                    id: id,
                    publish: changeto,
                };

                axios.post('/dashboard/changepublishcontent', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
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
                formData.append('articleid', this.articleid);
                axios.post('/dashboard/savefile'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['small'] = '/media/filemanager/article/' + that.articleid + '/itemsmall_' + response.data + '.png';
                        newfile['original'] = '/media/filemanager/article/' + that.articleid + '/item_' + response.data + '.png';
                        that.filemanagerids.push(newfile);
                    });
            },


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

            editcontent(id, text, publish, article_type_id) {
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
                    let that = this;
                    let data = {
                        articleid: this.articleid,
                    };
                    axios.post('/dashboard/getfilemanager', data)
                        .then(function (response) {
                            try {
                                that.filemanagerids = [];
                                for (var i = 0; i < response.data.length; i++) {
                                    let newfile = [];
                                    newfile['small'] = '/media/filemanager/article/' + that.articleid + '/itemsmall_' + response.data[i]['randomnum'] + '.png';
                                    newfile['original'] = '/media/filemanager/article/' + that.articleid + '/item_' + response.data[i]['randomnum'] + '.png';
                                    that.filemanagerids.push(newfile);
                                }
                            }catch (e) {

                            }
                        });
                } else if (article_type_id == 3) {
                    document.getElementById("browse3").click();
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


            deletecontent(id, type, text) {
                let that = this;
                let data = {
                    contentid: id,
                    typeid: type,
                    text: text,
                    articleid: this.articleid,
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
                this.contentid = null;

            },
            addText() {
                this.error = [];
                this.editflag = false;
                this.actionflag = 'text';
                this.modaltitle = 'افزودن متن جدید';
                this.newtitle = null;
                this.text = null;
                this.contentid = null;

                let that = this;
                let data = {
                    articleid: this.articleid,
                };
                axios.post('/dashboard/getfilemanager', data)
                    .then(function (response) {
                        try {
                            that.filemanagerids = [];
                            for (var i = 0; i < response.data.length; i++) {
                                let newfile = [];
                                newfile['small'] = '/media/filemanager/article/' + that.articleid + '/itemsmall_' + response.data[i]['randomnum'] + '.png';
                                newfile['original'] = '/media/filemanager/article/' + that.articleid + '/item_' + response.data[i]['randomnum'] + '.png';
                                that.filemanagerids.push(newfile);
                            }
                        }catch (e) {

                        }
                    });
            },


            reloadPage() {
                let that = this;
                let data = {
                    articleid: this.articleid,
                };
                axios.post('/dashboard/getarticlecontent', data)
                    .then(function (response) {
                        that.articlename = response.data['title'];
                        that.articleid = response.data['id'];
                        that.articlegroup = response.data['article_group_id'];
                        that.contentlist = response.data['contents'];
                        // that.filemanagerids = [];
                        // try {
                        //     for (var i = 0; i < response.data[1].length; i++) {
                        //         let newfile = [];
                        //         newfile['small'] = '/media/filemanager/article/' + that.articleid + '/itemsmall_' + response.data[1][i]['randomnum'] + '.png';
                        //         newfile['original'] = '/media/filemanager/article/' + that.articleid + '/item_' + response.data[1][i]['randomnum'] + '.png';
                        //         that.filemanagerids.push(newfile);
                        //     }
                        // } catch (e) {
                        //
                        // }

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
