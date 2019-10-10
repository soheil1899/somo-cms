<template>
    <div>
        <h4 class="admin-title py-3 px-4"> مدیریت اسلایدر </h4>
        <input type="button" class="btn btn-success btn-sm my-2 mr-1" @click="addslider" data-toggle="modal" data-target="#addModal" value="افزودن اسلایدر جدید">
        <a :href="'../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>


        <div class="card mt-2" v-for="slider in sliderlist" :key="slider.id" >
            <div class="card-header row m-0 px-1">
                <div class="col-6">
                    <i class="far fa-check-circle fa-lg ml-2 pointer" title="انتشار" @click="changepublish(slider.id ,false)" v-if="slider.publish == true"></i>
                    <i class="fas fa-ban fa-lg ml-2 pointer" title="عدم انتشار" @click="changepublish(slider.id, true)" v-else></i>
                    {{slider.title}}
                </div>
                <div class="col-6 icons">
                    <label class="ml-3">
                        زبان :
                        {{slider.lang}}
                    </label>
                    <i title="ویرایش" @click="editslider(slider.id, slider.images, slider.title, slider.lang_id)"
                       class="fas fa-edit ml-2 fa-lg"></i>
                    <i title="حذف" @click="deleteslider(slider.id)" class="fas fa-times-circle ml-3 fa-lg"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="m-1 float-right position-relative" v-for="image in slider.images" :key="image.id">
                    <div class="position-relative icons">
                        <img :src="createsliderurl(image.image, slider.id)">
                        <i title="ویرایش" @click="details(image.id, image.link, image.subtext, image.title)"
                           class="fas fa-edit slidercomponent ml-2 position-absolute p-2"></i>
                    </div>
                </div>
            </div>
        </div>








        <!-- Add & Edit Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">افزودن اسلایدر جدید</h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group ">
                                    <input type="text" class="form-control" v-model="slidertitle" placeholder="عنوان اسلایدر" name="title">
                                </div>
                            </div>
                            <div class="col-6">
                                <v-select v-model="langselect" :options="langs" label="title"
                                          :clearable="false"
                                          placeholder="یکی از زبان ها را انتخاب کنید" class="mb-2"></v-select>
                            </div>
                        </div>



                        <div class="card" v-if="slidertitle != null && slidertitle != ''">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصاویر مربوط به اسلایدر: {{slidertitle}}
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile" class="btn btn-success btn-sm px-4">افزودن
                                        تصویر
                                    </button>
                                </div>
                                <input type="file" class="d-none" id="browse" ref="slider"
                                       @change="selectgallery" accept=".jpg, .png, .jpeg">
                            </div>
                            <div class="card-body p-2">
                                <div v-for="image in imagelist" :key="image.id"
                                     class="m-1 float-right position-relative">
                                    <img :src="createsliderurl(image.image, image.slider_id)">
                                    <i @click="deletesliderimage(image.id)"
                                       class="fas fa-trash position-absolute delete-filemanager"></i>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-sm px-4" @click="closeslidermodal">ذخیره</button>
                    </div>
                </div>
            </div>
        </div>





        <!-- Add & Edit Modal -->
        <div class="modal fade" id="detailsmodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">اطلاعات مربوط به تصویر</h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <input class="form-control mb-2" type="text" v-model="imagetitle" placeholder="عنوان تصویر">
                        <input class="form-control mb-2" type="text" v-model="imagesubtext" placeholder="زیرنوشت تصویر">


                        <label class="mt-3">مطلب مربوطه :</label>
                        <v-select v-model="articleselect" :options="articles" label="title" :clearable="false"></v-select>

                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saveimagedetails" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>




<script>
    export default {
        name: "SliderComponent",

        data() {
            return {
                error: [],
                sliderlist: [],
                slidertitle: null,
                editflag: false,
                sliderid: null,
                imagelist: [],
                publish: false,
                articles: [],
                articleselect: {'id': null, 'title': null},

                imageid: null,
                imagesubtext: null,
                imagelink: null,
                imagetitle: null,

                langselect: {
                    'id': 1,
                    'title': 'فارسی',
                    'lang': 'fa',
                },
                langs: [],


                oldslidertitle: null,
                oldlangselectid: null,
            }
        },

        methods: {

            saveimagedetails(){
                let that = this;
                let data = {
                    imageid: this.imageid,
                    articleselect: this.articleselect,
                    imagesubtext: this.imagesubtext,
                    imagetitle: this.imagetitle,
                };

                axios.post('/dashboard/saveimagedetails', data)
                    .then(function (response) {
                        that.reloadpage();

                        $('#detailsmodal').modal('hide');
                    });
            },

            details(id, link, subtext, title){
                this.imageid = id;
                this.imagesubtext = subtext;
                this.imagetitle = title;


                this.articleselect['id'] = null;
                this.articleselect['title'] = null;

                for (var i=0; i<this.articles.length; i++){
                    if(this.articles[i]['id'] == link){
                        this.articleselect['id'] = this.articles[i]['id'];
                        this.articleselect['title'] = this.articles[i]['title'];
                    }
                }
                $('#detailsmodal').modal('show');
            },

            changepublish(id ,changeto){
                let that = this;
                let data = {
                    id: id,
                    publish: changeto,
                };

                axios.post('/dashboard/changepublishslider', data)
                    .then(function (response) {
                        that.reloadpage();
                    });
            },

            deleteslider(id){
                let that = this;
                let data = {
                    id: id,
                };

                axios.post('/dashboard/deleteslider', data)
                    .then(function (response) {
                        that.reloadpage();

                    });
            },

            createsliderurl(image, sliderid) {
                return '/media/slider/'+ sliderid +'/small_' + image + '.png';
            },

            reloadpage() {
                let that = this;
                axios.post('/dashboard/getslider')
                    .then(function (response) {
                        that.sliderlist = response.data[0];
                        that.articles = response.data[1];
                        that.langs = response.data[2];

                        for (var i=0; i<that.sliderlist.length; i++){
                            for (var j=0; j<that.langs.length; j++){
                                if(that.sliderlist[i]['lang_id'] == that.langs[j]['id']){
                                    that.sliderlist[i]['lang'] = that.langs[j]['title'];
                                }
                            }

                        }



                    });
            },


            browsefile() {
                document.getElementById("browse").click();
            },

            selectgallery() {
                let that = this;
                let formData = new FormData();
                formData.append('title', this.slidertitle);
                formData.append('image', this.$refs.slider.files[0]);
                formData.append('editflag', this.editflag);
                formData.append('sliderid', this.sliderid);
                formData.append('lang', this.langselect['id']);

                axios.post('/dashboard/savesliderimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['slider_id'] = response.data[0];
                        that.sliderid = response.data[0];
                        newfile['image'] = response.data[1];
                        newfile['id'] = response.data[2];
                        newfile['title'] = null;
                        newfile['link'] = null;
                        newfile['subtext'] = null;

                        that.oldlangselectid = that.langselect['id'];
                        that.oldslidertitle = that.slidertitle;

                        that.imagelist.push(newfile);


                    });
            },
            addslider(){
                this.error = [];
                this.sliderid = null;
                this.slidertitle = null;
                this.imagelist = [];

                this.langselect['id'] = 1;
                this.langselect['title'] = 'فارسی';
                this.langselect['lang'] = 'fa';

            },

            editslider(id, images, title, lang){
                this.sliderid = id;
                this.imagelist = images;
                this.slidertitle = title;

                for (var i=0; i<this.langs.length; i++){
                    if(lang == this.langs[i]['id']){
                        this.langselect['id'] = lang;
                        this.langselect['title'] = this.langs[i]['title'];
                        this.langselect['lang'] = this.langs[i]['lang'];
                    }
                }

                this.oldlangselectid = lang;
                this.oldslidertitle = title;
                $('#addModal').modal('show');
            },

            closeslidermodal(){
                $('#addModal').modal('toggle');

                if(this.oldslidertitle != this.slidertitle || this.oldlangselectid != this.langselect['id']){
                    let data = {
                        'sliderid': this.sliderid,
                        'title': this.slidertitle,
                        'lang': this.langselect['id'],
                    };
                    axios.post('/dashboard/sliderchange', data)
                        .then(function (response) {

                        });
                }

                this.reloadpage();
            },


            deletesliderimage(id) {
                let that = this;
                let data = {
                    id: id,
                };

                axios.post('/dashboard/deletesliderimage', data)
                    .then(function (response) {

                        for (var i = 0; i < that.imagelist.length; i++) {
                            if (that.imagelist[i]['id'] == id) {
                                that.imagelist.splice(i, 1);
                            }
                        }

                    });

            },
        },

        mounted() {
            this.reloadpage();
        }

    }
</script>

<style scoped>

</style>
