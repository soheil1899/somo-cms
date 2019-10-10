<template>

    <div>
        <h4 class="admin-title py-3 px-4">
            افزودن محصول جدید
        </h4>

        <div class="card mt-2" id="add-card" v-if="showcard">
            <div class="card-header row m-0 px-3">
                <strong>
                    اطلاعات مربوط به محصول جدید
                </strong>

            </div>
            <div class="card-body row">
                <div class="col-12">
                    <error :error="error"></error>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="form-group ">
                        <input type="text" v-model="product_faname" class="form-control" placeholder="نام فارسی"
                               name="title">
                    </div>
                    <div class="form-group ">
                        <input type="text" v-model="product_enname" id="english-text"
                               placeholder="نام انگلیسی" class="form-control" name="title">
                    </div>
                    <div class="form-group ">
                        <v-select v-model="category" :options="categories" label="parentname"
                                  :clearable="false" placeholder="دسته بندی" style="direction: rtl"></v-select>
                    </div>
                    <div class="form-group ">
                        <v-select v-model="colors_selected" :options="colors" label="name"
                                  :multiple="true" :clearable="false" placeholder="رنگ"
                                  style="direction: rtl"></v-select>
                    </div>
                    <div class="form-group ">
                        <v-select v-model="brand" :options="brands" label="name"
                                  :clearable="false" placeholder="برند" style="direction: rtl"></v-select>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group ">
                        <v-select v-model="selectedguarantees" :options="guarantees" label="label"
                                  :multiple="true" :clearable="false" placeholder="گارانتی"
                                  style="direction: rtl"></v-select>
                    </div>
                    <div class="form-group row">
                        <div class="col-4 col-sm-3">
                            <label style="line-height: 29px">قیمت:</label>
                        </div>
                        <div class="col-8 col-sm-9">
                            <input type="number" v-model.number="price" class="form-control" placeholder="قیمت">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4 col-sm-3">
                            <label style="line-height: 29px">درصد تخفیف:</label>
                        </div>
                        <div class="col-8 col-sm-9">
                            <input type="number" v-model.number="discount" class="form-control"
                                   placeholder="درصد تخفیف">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4 col-sm-3">
                            <label style="line-height: 29px">تعداد:</label>
                        </div>
                        <div class="col-8 col-sm-9">
                            <input type="number" v-model.number="tedad" class="form-control" placeholder="تعداد">
                        </div>
                    </div>
                    <div class="form-group mb-1 mt-3">
                        <input type="checkbox" @change="specialcheck" class="form-check-input publish-checkbox mr-2"
                               v-model="publish">
                        <label class="form-check-label pr-2 mt-1 mr-4">نمایش</label>

                    </div>
                    <div class="form-group mb-1 ">
                        <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-if="publish == true"
                               v-model="special">
                        <input type="checkbox" class="form-check-input publish-checkbox mr-2" v-else disabled
                               v-model="special">
                        <label class="form-check-label pr-2 mt-1 mr-4">پیشنهاد ویژه</label>

                    </div>
                    <input type="button" @click="saveproduct" class="btn btn-primary float-left" value="ذخیره و ادامه">
                </div>

            </div>
        </div>


        <div class="accordion" id="accordionExample" v-else>
            <div class="row">
                <div class="col">
                    <strong class="my-4 mr-3 d-block" style="color: #049c1c">
                        * محصول {{product_faname}} با موفقیت اضافه شده است.
                    </strong>
                </div>
                <div class="col">
                    <input type="button" @click="saveproductoptions" class="back-btn btn btn-primary my-2 mr-1 px-5" value="ذخیره نهایی">
                </div>
            </div>

            <div class="card">
                <div class="card-header py-1" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" style="text-decoration: none" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong>
                                ویژگی های مربوط به محصول {{product_faname}}
                            </strong>
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body px-5 pb-5 pt-2">
                        <form id="subattr-form">


                            <div class="form-group mb-1 mb-2 position-relative subattr" v-for="item in this.attrlist"
                                 :key="item.id">
                                <label class="col-form-label group-title px-3 mt-3">{{item.title}}</label>

                                <div class="row border-bottom mx-3 mt-1" v-for="attr in item.subattributes"
                                     :key="attr.id">
                                    <div class="col-5 col-md-3">
                                        <label class="col-form-label">{{attr.title}}:</label>
                                    </div>
                                    <div class="col-7 col-md-9">
                                        <v-select v-if="attr.attribute_values[0]" v-model="selectedattr[attr.id]"
                                                  :options="attr.attribute_values" :taggable="true"
                                                  label="value"></v-select>
                                        <input v-else type="text" v-model="selectedattr[attr.id]"
                                               class="form-control english-text">
                                    </div>

                                </div>

                            </div>


                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header py-1" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                            <strong>
                                تصاویر مربوط به محصول {{product_faname}}
                            </strong>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="card mt-3">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصویر اصلی محصول
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile1" class="btn btn-success btn-sm">
                                        انتخاب تصویر
                                    </button>
                                </div>
                                <input type="file" style="display: none" id="browse1" ref="image"
                                       @change="selectimage">
                            </div>
                            <div class="card-body p-2">
                                <img :src="prooriginalimage" v-if="prooriginalimage != null">

                            </div>
                        </div>
                        <div class="card mt-3 mb-5">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    تصاویر مربوط به گالری
                                </div>
                                <div class="col-4 icons">
                                    <button type="button" @click="browsefile2" class="btn btn-success btn-sm">افزودن
                                        تصویر
                                    </button>
                                </div>
                                <input type="file" style="display: none" id="browse2" ref="gallery"
                                       @change="selectgallery">
                            </div>
                            <div class="card-body p-2 icons">
                                <div v-for="gallery in gallerylist" :key="gallery.id" class="m-1 float-right position-relative">
                                    <img :src="gallery.image">
                                    <i title="پاک کردن" @click="deletegalleryimage(gallery.id)"
                                       class="fas fa-trash position-absolute delete-filemanager"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header py-1" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                            <strong>
                                نقد و بررسی مربوط به محصول {{product_faname}}
                            </strong>
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body row">
                        <div class="col-12 col-lg-9" style="direction: ltr">
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
                                        <i @click="browsefile" class="fas fa-plus-square fa-2x"
                                           style="color: #5BB760"></i>
                                    </div>
                                    <input type="file" style="display: none" id="browse" ref="imagetext"
                                           @change="selecttextimage">
                                </div>
                                <div class="card-body p-2">
                                    <div v-for="file in filemanagerids" :key="file.id"
                                         class="m-1 float-right position-relative icons">
                                        <img :src="file.small" @click="selectImage(file.original)">
                                        <i title="پاک کردن" class="fas fa-trash position-absolute delete-filemanager"></i>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>


<script>
    import vSelect from 'vue-select';
    import Editor from '@tinymce/tinymce-vue';

    Vue.component('v-select', vSelect);

    export default {
        name: "AddProductComponent",
        components: {
            'editor': Editor
        },

        data() {
            return {

                error: [],

                productid: null,
                product_faname: null,
                product_enname: null,
                categories: [],
                category: null,
                colors: [],
                colors_selected: null,
                brands: [],
                brand: null,
                guarantees: [],
                selectedguarantees: null,
                price: 0,
                discount: 0,
                tedad: 0,
                publish: false,
                special: false,
                showcard: true,
                attrlist: [],
                selectedattr:[],

                gallerylist: [],
                prooriginalimage: null,

                text: '',
                filemanagerids: [],
            }
        },


        methods: {

            browsefile() {
                document.getElementById("browse").click();
            },

            selectImage(original) {
                let Imagetag = '<img src="' + original + '" width="200px">';
                this.text += Imagetag;
            },

            selecttextimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.imagetext.files[0]);
                formData.append('productid', this.productid);
                axios.post('/dashboard/savefile'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }

                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['small'] = '/media/filemanager/product/'+ that.productid +'/itemsmall_' + response.data + '.png';
                        newfile['original'] = '/media/filemanager/product/'+ that.productid +'/item_' + response.data + '.png';
                        that.filemanagerids.push(newfile);
                    });
            },

            browsefile1() {
                document.getElementById("browse1").click();
            },
            browsefile2() {
                document.getElementById("browse2").click();
            },

            selectimage() {
                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.image.files[0]);
                formData.append('proid', this.productid);

                axios.post('/dashboard/saveproimage'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {

                        that.prooriginalimage = '/media/product/'+ response.data[1] +'/medium.png?'+ response.data[0];
                    });
            },
            selectgallery() {

                let that = this;
                let formData = new FormData();
                formData.append('image', this.$refs.gallery.files[0]);
                formData.append('proid', 'null');

                axios.post('/dashboard/saveprogallery'
                    , formData
                    , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        let newfile = [];
                        newfile['id'] = response.data[1];
                        newfile['image'] = '/media/product/' + response.data[2] + '/gallery/small_' + response.data[0] + '.png';
                        that.gallerylist.push(newfile);
                    });
            },

            deletegalleryimage(id){
                let that = this;
                let data = {
                    galleryid: id,
                };
                axios.post('/dashboard/deleteprogallery', data)
                    .then(function (response) {
                        for (var i = 0; i < that.gallerylist.length; i++) {
                            if (that.gallerylist[i]['id'] == id) {
                                that.gallerylist.splice(i, 1);
                            }
                        }
                    });
            },


            saveproductoptions(){
                let that = this;
                let data = {
                    attrvalues: this.selectedattr,
                    naghd: this.text,
                };
                axios.post('/dashboard/saveproductoptions', data)
                    .then(function (response) {
                        window.location = 'http://127.0.0.1:8000/dashboard/addproduct';
                    });

            },

            getproductoptions() {
                let that = this;
                let data = {
                    categoryid: this.category['id'],
                };
                axios.post('/dashboard/getproductoptions', data)
                    .then(function (response) {

                        that.attrlist = response.data[0]['group_attributes'];

                    });

                this.getfilemanager();
                this.showcard = false;
            },

            getfilemanager(){
                let that = this;
                let data = {
                    productid: this.productid,
                };
                axios.post('/dashboard/getfilemanager', data)
                    .then(function (response) {
                        try {
                            that.filemanagerids = [];
                            for (var i = 0; i < response.data.length; i++) {
                                let newfile = [];
                                newfile['small'] = '/media/filemanager/product/' + that.productid + '/itemsmall_' + response.data[i]['randomnum'] + '.png';
                                newfile['original'] = '/media/filemanager/product/' + that.productid + '/item_' + response.data[i]['randomnum'] + '.png';
                                that.filemanagerids.push(newfile);
                            }
                        }catch (e) {

                        }
                    });
            },

            saveproduct() {
                let that = this;
                let categoryID = null;

                if (this.category == null) {
                    categoryID = null;
                } else {
                    categoryID = this.category['id'];
                }

                let data = {
                    categoryid: categoryID,
                    product_enname: this.product_enname,
                    product_faname: this.product_faname,
                    publish: this.publish,
                    special: this.special,
                    price: this.price,
                    discount: this.discount,
                    colors: this.colors_selected,
                    guarantees: this.selectedguarantees,
                    brand: this.brand,
                    tedad: this.tedad,
                    editflag: false,
                };
                axios.post('/dashboard/saveproduct', data)
                    .then(function (response) {
                        that.productid = response.data;
                        that.getproductoptions();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },

            specialcheck() {
                if (this.publish == false) {
                    this.special = false;
                }
            },


            loadPage() {
                let that = this;
                axios.post('/dashboard/getproductinfo')
                    .then(function (response) {
                        that.categories = response.data[0];
                        that.colors = response.data[1];
                        that.brands = response.data[2];
                        that.guarantees = response.data[3];


                    });
            },

        },

        mounted() {
            this.loadPage();
        }


    }
</script>

<style scoped>

</style>
