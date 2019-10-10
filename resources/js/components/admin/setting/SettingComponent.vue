<template>

    <div>
        <h4 class="admin-title py-3 px-4"> تنظیمات وب سایت </h4>



        <div class="col-12 col-lg-10 mr-auto ml-auto">


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
                <div class="col-3 text-left">عنوان سایت :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['site_title']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">فیسبوک :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['facebook']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">اینستاگرام :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['instagram']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">تلگرام :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['telegram']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">گوگل پلاس :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['googleplus']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">واتساپ :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['whatsup']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">لینکدین :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['linkedin']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">گوگل مپ :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['googlemap']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">توییتر :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['twitter']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">یوتیوب :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['youtube']">
                </div>
            </div>

            <div class="row pt-2">
                <div class="col-3 text-left">آپارات :</div>
                <div class="col-9">
                    <input class="form-control" type="text" v-model="settinglist['aparat']">
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
                        <button v-if="logoimage != null" type="button" @click="browselogo" class="btn btn-success btn-sm">تغییر تصویر لوگو
                        </button>
                        <button v-else type="button" @click="browselogo" class="btn btn-success btn-sm">انتخاب تصویر لوگو
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
                    <editor v-model="settinglist['aboutus']" ref="editor"
                            api-key="qc1sdre33bdx4lkj24aw4ffoeyx1rvbohr9ow2hzhjgfu2mi"
                            :init="{plugins: 'wordcount','directionality': 'rtl','height':300}"></editor>
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
    import Swal from 'sweetalert2';


    export default {
        name: "SettingComponent",
        components: {
            'editor': Editor
        },
        data() {
            return {
                settinglist: {
                    'mobile': null,
                    'tellphone': null,
                    'fax': null,
                    'email': null,
                    'address': null,
                    'aboutus': null,
                    'company_name': null,
                    'flag': null,
                    'header_description': null,
                    'site_title': null,
                    'facebook': null,
                    'instagram': null,
                    'telegram': null,
                    'googleplus': null,
                    'whatsup': null,
                    'linkedin': null,
                    'googlemap': null,
                    'twitter': null,
                    'youtube': null,
                    'aparat': null,
                    'id': null,
                    'catalog': 0,
                    'keywords': null,
                    'lang': 'fa',
                    'logo_image': null,
                },
                error: [],
                keywords: [],
                logoimage: null,

                langs: [],
                langselect: {
                    'id': 1,
                    'title': 'فارسی',
                    'lang': 'fa',
                },
            }
        },
        comments:{
            Swal,
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
                        Swal.fire({
                            text: 'اطلاعات شما با موفقیت ثبت شد!',
                            type: 'success',
                            confirmButtonText: 'بستن'
                        });
                        that.reloadPage();
                    });

            },


            selectImage(original) {
                let Imagetag = '<img src="' + original + '" width="200px">';
                this.settinglist['aboutus_all'] += Imagetag;
            },

            reloadPage() {
                let that = this;
                let data={
                    lang: this.langselect,
                };
                axios.post('/dashboard/getsetting', data)
                    .then(function (response) {

                        if(response.data[3] == true) {
                            that.settinglist['mobile'] = response.data[0]['mobile'];
                            that.settinglist['tellphone'] = response.data[0]['tellphone'];
                            that.settinglist['fax'] = response.data[0]['fax'];
                            that.settinglist['email'] = response.data[0]['email'];
                            that.settinglist['address'] = response.data[0]['address'];
                            that.settinglist['aboutus'] = response.data[0]['aboutus'];
                            that.settinglist['company_name'] = response.data[0]['company_name'];
                            that.settinglist['flag'] = response.data[0]['flag'];
                            that.settinglist['header_description'] = response.data[0]['header_description'];
                            that.settinglist['site_title'] = response.data[0]['site_title'];
                            that.settinglist['facebook'] = response.data[0]['facebook'];
                            that.settinglist['instagram'] = response.data[0]['instagram'];
                            that.settinglist['telegram'] = response.data[0]['telegram'];
                            that.settinglist['googleplus'] = response.data[0]['googleplus'];
                            that.settinglist['whatsup'] = response.data[0]['whatsup'];
                            that.settinglist['linkedin'] = response.data[0]['linkedin'];
                            that.settinglist['googlemap'] = response.data[0]['googlemap'];
                            that.settinglist['twitter'] = response.data[0]['twitter'];
                            that.settinglist['youtube'] = response.data[0]['youtube'];
                            that.settinglist['aparat'] = response.data[0]['aparat'];
                            that.settinglist['id'] = response.data[0]['id'];
                            that.settinglist['catalog'] = response.data[0]['catalog'];
                            that.settinglist['keywords'] = response.data[0]['keywords'];
                            that.settinglist['lang'] = response.data[0]['lang'];
                            that.settinglist['logo_image'] = response.data[0]['logo_image'];
                        }
                        else if(response.data[3] == false){
                            that.settinglist['mobile'] = null;
                            that.settinglist['tellphone'] = null;
                            that.settinglist['fax'] = null;
                            that.settinglist['email'] = null;
                            that.settinglist['address'] = null;
                            that.settinglist['aboutus'] = null;
                            that.settinglist['company_name'] = null;
                            that.settinglist['flag'] = null;
                            that.settinglist['header_description'] = null;
                            that.settinglist['site_title'] = null;
                            that.settinglist['facebook'] = null;
                            that.settinglist['instagram'] = null;
                            that.settinglist['telegram'] = null;
                            that.settinglist['googleplus'] = null;
                            that.settinglist['whatsup'] = null;
                            that.settinglist['linkedin'] = null;
                            that.settinglist['googlemap'] = null;
                            that.settinglist['twitter'] = null;
                            that.settinglist['youtube'] = null;
                            that.settinglist['aparat'] = null;
                            that.settinglist['id'] = null;
                            that.settinglist['catalog'] = null;
                            that.settinglist['keywords'] = null;
                            that.settinglist['lang'] = null;
                            that.settinglist['logo_image'] = null;
                        }


                        that.langs = response.data[2];
                        for (var i=0; i<that.langs.length; i++){
                            if(that.langs[i]['lang'] == that.settinglist['lang']){
                                that.langselect['id'] = that.langs[i]['id'];
                                that.langselect['title'] = that.langs[i]['title'];
                                that.langselect['lang'] = that.langs[i]['lang'];
                            }
                        }

                        if(that.settinglist['logo_image'] != null){
                            that.logoimage = '/media/cite/logo/' + that.settinglist['logo_image'] + '.png';
                        }else{
                            that.logoimage = null;
                        }

                    });
            },

            browselogo() {
                document.getElementById("browse").click();
            },

            selectlogo() {
                let that = this;
                let formData = new FormData();
                formData.append('id', this.settinglist['id']);
                formData.append('lang', this.langselect['lang']);
                formData.append('logoimage', this.$refs.logo.files[0]);

                axios.post('/dashboard/savelogoimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        that.logoimage = '/media/cite/logo/'+ that.langselect['lang'] +'_logo.png?'+ response.data[0];
                        that.settinglist['id'] = response.data[1];
                        that.settinglist['logo_image'] = that.langselect['lang'] +'_logo.png';
                        that.settinglist['lang'] = that.langselect['lang'];
                        Swal.fire({
                            text: 'تصویر لوگو با موفقیت ذخیره شد!',
                            type: 'success',
                            confirmButtonText: 'بستن'
                        });
                    });
            },
            browsepdf() {
                document.getElementById("browsepdf").click();
            },

            selectpdf() {
                let that = this;
                let formData = new FormData();
                formData.append('id', this.settinglist['id']);
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
                        that.settinglist['id'] = response.data;
                        that.settinglist['lang'] = that.langselect['lang']
                        Swal.fire({
                            text: 'کاتالوگ شرکت با موفقیت ذخیره شد!',
                            type: 'success',
                            confirmButtonText: 'بستن'
                        });
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
