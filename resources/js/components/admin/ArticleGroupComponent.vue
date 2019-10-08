<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست گروه های مطالب </h4>

        <input type="button" @click="addgroup" class="btn btn-success btn-sm my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن گروه جدید">
        <input type="button" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">

        <a :href="'../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>
        <input type="button" class="back-btn btn btn-danger btn-sm my-2 mr-3" @click="deletearticle" value="حذف">



        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col">نام گروه</th>
                <th scope="col">عنوان گروه</th>
                <th scope="col">زبان</th>
                <th scope="col">آدرس</th>
                <th scope="col" class="p-0">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
                <th scope="col" width="10%">حذف</th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in this.articlelist" :key="item.id">
                <th class="py-2" scope="row">{{index+1}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2">{{item.lang.lang}}</td>
                <td class="py-2" dir="ltr">{{item.url}}</td>
                <td class="py-1 icons">
                    <a :href="'articles/'+item.id">
                        <i title="مطالب" class="fas fa-stream fa-lg mt-2 mx-1"></i>
                    </a>
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1"
                       @click="editgroup(item.id, item.name, item.title, item.url, item.description, item.keywords, item.lang)"
                       data-toggle="modal" data-target="#Modal"></i>
                </td>
                <td class="py-1 text-center">
                    <input v-if="item.articles.length == 0" type="checkbox" v-model="deleteart[item.id]" class="form-check-input mx-auto">
                    <small v-else>
                        شامل مطلب
                    </small>
                </td>
            </tr>
            </tbody>
        </table>


        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش گروه'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن گروه جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" @keyup="changeurl" v-model="groupname" class="form-control"
                                       placeholder="نام گروه">
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" v-model="grouptitle" class="form-control" placeholder="عنوان گروه">
                            </div>
                            <v-select v-model="langselect" :options="langs" label="title"
                                      :clearable="false"
                                      placeholder="یکی از زبان ها را انتخاب کنید" class="mb-2"></v-select>
                            <div class="form-group mb-1">
                                <div class="input-group" style="direction: ltr">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">/</div>
                                    </div>
                                    <input type="url" @keyup="changeurl2" v-model="groupurl" class="form-control"
                                           placeholder="آدرس گروه">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <textarea v-model="description" class="form-control" rows="3"
                                          placeholder="توضیحات..."></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <v-select v-model="keywords" placeholder="کلمات کلیدی..." :multiple="true"
                                          :taggable="true" :no-drop="true" :clearable="false"></v-select>
                            </div>


                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savegroup" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
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
        name: "ArticleGroupComponent",
        data() {
            return {
                editflag: false,
                articlelist: [],
                groupname: null,
                grouptitle: null,
                groupurl: null,
                description: null,
                keywords: [],
                error: [],
                groupid: null,


                langs: [],
                langselect: {
                    'id': 1,
                    'title': 'فارسی',
                    'lang': 'fa',
                },
                deleteart: [],
            }
        },

        methods: {
            deletearticle(){
                let that = this;
                let data = {
                    groups: this.deleteart,
                };
                axios.post('/dashboard/deletegroup', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },
            changeurl() {
                this.groupurl = this.groupname.replace(/\s+/g, '-').toLowerCase();
            },
            changeurl2() {
                this.groupurl = this.groupurl.replace(/\s+/g, '-').toLowerCase();
            },
            reloadPage() {
                let that = this;
                axios.post('/dashboard/getarticlegroups')
                    .then(function (response) {
                        that.articlelist = response.data[1];
                        that.langs = response.data[0];
                    });
            },

            addgroup() {
                this.error = [];
                this.editflag = false;
                this.groupname = null;
                this.grouptitle = null;
                this.groupurl = null;
                this.description = null;
                this.keywords = [];
                this.groupid = null;


                this.langselect['id'] = 1;
                this.langselect['title'] = 'فارسی';
                this.langselect['lang'] = 'fa';
            },

            editgroup(id, name, title, url, description, keywords, lang) {
                this.error = [];
                this.editflag = true;
                this.groupname = name;
                this.grouptitle = title;
                this.groupurl = url;
                this.description = description;
                this.groupid = id;
                this.keywords = [];
                if (keywords.length > 0) {
                    for (var i = 0; i < keywords.length; i++) {
                        this.keywords.push(keywords[i]['keyword']);
                    }
                }

                this.langselect['id'] = lang['id'];
                this.langselect['title'] = lang['title'];
                this.langselect['lang'] = lang['lang'];
            },

            savegroup() {
                let that = this;
                let data = {
                    editflag: this.editflag,
                    groupid: this.groupid,
                    groupname: this.groupname,
                    grouptitle: this.grouptitle,
                    url: this.groupurl,
                    description: this.description,
                    keywords: this.keywords,
                    lang: this.langselect,
                };
                axios.post('/dashboard/savegroup', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },
            //
            // deletecolor(id){
            //     let that = this;
            //     let data = {
            //         id: id,
            //     };
            //     axios.post('/dashboard/deletecolor', data)
            //         .then(function (response) {
            //             that.reloadPage();
            //         })
            // },

        },

        mounted() {
            this.reloadPage();
        }


    }
</script>

<style scoped>

</style>
