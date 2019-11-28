<template>

    <div>
        <h4 class="admin-title py-3 px-4"> مدیریت منو </h4>

        <input type="button" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن منو جدید">
        <input type="button" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-dark btn-sm my-2 mr-1">داشبورد</a>
        <input v-if="this.backbtn" @click="goback" type="button" class="back-btn btn btn-sm btn-dark my-2 mr-1"
               value="برگشت">


        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">منو</th>
                <th scope="col">آدرس</th>
                <th scope="col">توضیحات</th>
                <th scope="col" class="p-0">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in menulist" :key="item.id">
                <th class="py-2" scope="row">{{inedx +1}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.url}}</td>
                <td class="py-2">{{item.description}}</td>
                <td class="py-1 icons">
                    <i title="زیرمنو" class="fas fa-sitemap fa-lg mx-1 mt-2" @click="getsubmenus(item.id)"></i>
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1" style="color: #00B2C9;"
                       data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1" style="color: #EB3E37;"></i>
                </td>
            </tr>
            </tbody>
        </table>


        <!--         Add & Edit Modal-->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش تگ'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن تگ جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>


                        <div class="form-group mb-1">
                            <input type="text" v-model="menu" class="form-control" placeholder="نام منو">
                        </div>
                        <div class="form-group mb-1">
                            <input type="checkbox" @change="changearticleflag" v-model="articleflag"
                                   class="form-check-input publish-checkbox mr-2">
                            <label class="form-check-label pr-2 mt-1 mr-4">مربوط به مطلب خاصی می باشد</label>
                        </div>
                        <div class="form-group mb-1" v-if="articleflag">
                            <v-select @input="changegroup" v-model="selectgroup" :options="articlegroups"
                                      label="name" :clearable="false" placeholder="انتخاب گروه مطالب"></v-select>
                        </div>
                        <div class="form-group mb-1" v-if="articleflag">
                            <v-select v-model="selectarticle" :options="articles"
                                      label="title" :clearable="false" placeholder="انتخاب مطلب"></v-select>
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" v-model="url" class="form-control" placeholder="لینک">
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>

    import vSelect from 'vue-select';

    Vue.component('v-select', vSelect);

    export default {
        name: "MenuComponent",
        data() {
            return {
                menulist: [],
                articlegroups: [],
                allarticles: [],
                articles: [],
                error: [],
                editflag: false,
                menuid: null,
                menu: null,
                url: null,

                articleflag: false,

                selectgroup: null,
                selectarticle: null,

                backbtn: false,
                backarray: [],
                parentid: null,
            }
        },
        methods: {
            changearticleflag(){
                if (this.articleflag == false){
                    this.selectgroup = null;
                    this.selectarticle = null;
                }
            },
            changegroup() {
                this.articles = [];
                this.selectarticle = null;
                for (var i = 0; i < this.allarticles.length; i++) {
                    if (this.allarticles[i]['article_group_id'] == this.selectgroup['id']) {
                        this.articles.push(this.allarticles[i]);
                    }
                }
            },
            goback() {
                if (this.backarray.length == 1) {
                    this.reloadPage();
                    this.parentid = 0;
                } else {
                    let last = this.backarray[this.backarray.length - 1];
                    this.backarray.pop();
                    this.parentid = last;
                    this.getsubmenus(last, 'back');
                }
            },
            getsubmenus(id, back = '') {
                // this.allowdelete = false;
                let that = this;
                if (back == '') {
                    this.backarray.push(this.parentid);
                    this.parentid = id;
                }
                let data = {
                    parentid: id,
                };
                axios.post('/dashboard/getsubmenus', data)
                    .then(function (response) {
                        that.menulist = response.data;
                        that.parentid == 0 ? that.backbtn = false : that.backbtn = true;
                    });
            },

            reloadPage() {
                // this.allowdelete = false;
                let that = this;
                this.backarray = [];

                axios.post('/dashboard/getmenus')
                    .then(function (response) {
                        that.menulist = response.data[0];
                        that.articlegroups = response.data[1];
                        that.allarticles = response.data[2];
                        that.backbtn = false;
                        that.parentid = 0;
                    });
            },


        },

        mounted() {
            this.reloadPage();
        }


    }


</script>

<style scoped>


</style>
