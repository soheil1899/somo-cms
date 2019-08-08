<template>

    <div>
        <h4 class="admin-title py-3 px-4"> تنظیمات وب سایت </h4>



        <div class="col-8 mr-auto ml-auto">


            <div class="row pt-5">
                <div class="col-3 text-left">زبان سایت :</div>
                <div class="col-9">
                    <v-select v-model="langselect" @input="reloadPage" :options="langs" label="title"
                              :clearable="false"
                              placeholder="یکی از زبان ها را انتخاب کنید" class="mb-2"></v-select>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">موبایل :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['mobile']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">تلفن :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['tellphone']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">فکس :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['fax']">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-3 text-left">ایمیل :</div>
                <div class="col-9">
                    <input class="form-control text-left" type="text" v-model="settinglist['email']">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-3 text-left">آدرس :</div>
                <div class="col-9">
                    <textarea class="form-control" rows="3" v-model="settinglist['address']"></textarea>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">نام شرکت :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['company_name']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">شعار شرکت :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['flag']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">توضیحات سایت :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['header_description']">
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-3 text-left">کلیدواژه سایت :</div>
                <div class="col-9">
                    <v-select :multiple="true" v-model="settinglist['keywords']" :taggable="true" :no-drop="true"
                              :clearable="false" dir="rtl"></v-select>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">کاتالوگ شرکت :</div>
                <div class="row col-9">
                    <div class="col-6">
                        <button v-if="settinglist['catalog']" type="button" @click="browsepdf" class="btn btn-success btn-sm">تغییر کاتالوگ
                        </button>
                        <button v-else type="button" @click="browsepdf" class="btn btn-success btn-sm">انتخاب کاتالوگ
                        </button>
                        <input type="file" class="d-none" id="browsepdf" ref="pdf"
                               @change="selectpdf" accept=".pdf">
                    </div>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">لوگو سایت :</div>
                <div class="row col-9">
                    <div class="col-6">
                        <button type="button" @click="browselogo" class="btn btn-success btn-sm">تغییر تصویر لوگو
                        </button>
                        <input type="file" class="d-none" id="browse" ref="logo"
                               @change="selectlogo" accept=".jpg, .png, .jpeg">
                    </div>
                    <div class="col-6 text-left">
                        <img :src="logoimage" width="70%" height="70%" alt="">
                    </div>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">درباره ما :</div>
                <div class="col-9">
                    <textarea class="form-control" rows="7" v-model="settinglist['aboutus']"></textarea>
                </div>
            </div>
        </div>



        <div class="row pt-2 mt-3">
            <div class="col-2 mb-2 text-left">متن کامل درباره ما :</div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-lg-9" dir="ltr">
                        <editor v-model="settinglist['aboutus_all']" ref="editor"
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
                                    <i @click="browsefile3" class="fas fa-plus-square fa-2x"></i>
                                </div>
                                <input type="file" class="d-none" id="browse3" ref="imagetext"
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
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8 mx-auto my-5">
            <input type="button" class="btn btn-primary btn-block btn-lg" @click="savesetting" value="ذخیره تنظیمات">
        </div>
    </div>


</template>

<script>


    import Editor from '@tinymce/tinymce-vue';

    export default {
        name: "SettingComponent",
        components: {
            'editor': Editor
        },
        data() {
            return {
                settinglist: [],
                error: [],
                keywords: [],
                filemanagerids: [],
                logoimage: null,

                langs: [],
                langselect: {
                    'id': null,
                    'title': null,
                    'lang': null,
                },
            }
        },
        methods: {

            savesetting(){
                let that = this;
                let data = {
                    setting: this.settinglist,
                    langselect: this.langselect,
                };
                axios.post('/dashboard/savesetting', data)
                    .then(function (response) {
                        that.reloadPage();
                    });

            },


            selectImage(original) {
                let Imagetag = '<img src="' + original + '" width="200px">';
                this.settinglist['aboutus_all'] += Imagetag;
            },

            browsefile3() {
                document.getElementById("browse3").click();
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

            reloadPage() {
                let that = this;
                let data={
                    lang: this.langselect,
                };
                axios.post('/dashboard/getsetting', data)
                    .then(function (response) {

                        that.settinglist = response.data[0];

                        that.langs = response.data[2];
                        for (var i=0; i<that.langs.length; i++){
                            if(that.langs[i]['lang'] == that.settinglist['lang']){
                                that.langselect['id'] = that.langs[i]['id'];
                                that.langselect['title'] = that.langs[i]['title'];
                                that.langselect['lang'] = that.langs[i]['lang'];
                            }
                        }

                        that.logoimage = '/media/cite/' + that.settinglist['logo_image'] + '.png';

                        that.filemanagerids = [];
                        for (var i = 0; i < response.data[1].length; i++) {
                            let newfile = [];
                            newfile['small'] = '/media/filemanager/itemsmall_' + response.data[1][i]['randomnum'] + '.png';
                            newfile['original'] = '/media/filemanager/item_' + response.data[1][i]['randomnum'] + '.png';
                            that.filemanagerids.push(newfile);
                        }

                    });
            },

            browselogo() {
                document.getElementById("browse").click();
            },

            selectlogo() {
                let that = this;
                let formData = new FormData();
                formData.append('logoimage', this.$refs.logo.files[0]);

                axios.post('/dashboard/savelogoimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        that.logoimage = '/media/cite/logo.png?'+ response.data;
                    });
            },
            browsepdf() {
                document.getElementById("browsepdf").click();
            },

            selectpdf() {
                let that = this;
                let formData = new FormData();
                formData.append('catalog', this.$refs.pdf.files[0]);
                formData.append('lang', this.langselect['lang']);

                axios.post('/dashboard/savecompanycatalog'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {

                    });
            },


        }
        ,

        mounted() {
            this.reloadPage();
        }


    }


</script>

<style scoped>


</style>
