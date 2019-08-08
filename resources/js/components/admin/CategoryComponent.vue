<template>

    <div>
        <h4 class="admin-title py-3 px-4"> مدیریت دسته ها </h4>

        <input type="button" @click="addcategory" class="btn btn-success my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن دسته جدید">
        <input type="button" @click="getsubcategorys(parentid)" class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <input v-if="this.backbtn" @click="goback" type="button" class="back-btn btn btn-dark my-2 mr-1" value="برگشت">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="15%">عنوان دسته</th>
                <th scope="col" width="50%">توضیحات</th>
                <th scope="col" class="p-0" width="25%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.categorylist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.description}}</td>
                <td class="icons py-1">
                    <i title="زیردسته" class="fas fa-sitemap fa-2x m-1" style="color: #EB3E37;" @click="getsubcategorys(item.id)"></i>
                    <i title="ویژگی" class="fab fa-steam-square fa-2x m-1" style="color: #5BB760;" v-if="item.last == 1" @click="getattr(item.id)"></i>
                    <i title="ویرایش" class="far fa-edit fa-2x m-1" style="color: #00B2C9;" @click="editcategory(item.id, item.name, item.description)" data-toggle="modal" data-target="#Modal"></i>

                    <!--<input type="button" @click="deletecategory(item.id)" class="btn-change btn btn-danger p-1 mb-1 ml-1"
                           value="حذف">-->
                </td>
            </tr>
            </tbody>
        </table>


        <!-- Add & Edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش دسته'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن دسته جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="category" class="form-control" placeholder="عنوان دسته بندی" name="title">
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="description" placeholder="توضیحات..." v-model="description" class="form-control" cols="30"
                                          rows="3"></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savecategory" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- SubAttr Modal -->
        <div class="modal fade" id="Attribute" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">گروه های ویژگی
                            <!--                            {{attributename}}-->
                        </h5>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col border-left">
                                <div class="form-group mb-1">
                                    <label>گروه های ویژگی مربوط به این دسته بندی را انتخاب کنید:</label>
                                    <v-select @input="changeSelect" v-model="selected" :options="allattrgroups"
                                              label="title" :clearable="false"></v-select>
                                </div>
                            </div>
                            <div class="col">
                                <label>گروه های ویژگی انتخاب شده:</label>
                                <table class="table table-sm">
                                    <tbody>
                                    <tr v-for="item in thisattrgroups" :key="item.id">
                                        <td class="px-5">{{item.title}}</td>
                                        <td class="pl-3 icons">
                                            <i title="حذف" class="fas fa-times-circle position-absolute fa-lg" style="color: #d6312c" @click="deleteattr(item.id)"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer row m-0">
                        <button type="button" @click="saveattr" class="btn btn-success">ذخیره</button>
                        <button type="button" @click="getattr(categoryid)" class="btn btn-secondary">بازخوانی</button>
                        <button type="button" class="btn btn-secondary mr-1" data-dismiss="modal">بازگشت</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delete Modal -->
        <!--<div class="modal fade" id="errorDelete" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">اخطار</h5>
                    </div>
                    <div class="modal-body">
                        <p>                     
       قصد پاک کردن دسته را دارید که خود شامل زیردسته یا ویژگی می باشد.
                        </p>     
                        <p>
                            آیا می خواهید این دسته را به همراه تمامی زیر دسته ها و وِیژگی هایش پاک کنید؟
                        </p> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">خیر</button>
                        <button type="button" @click="deleteall" class="btn btn-primary">بله</button>
                    </div>
                </div>
            </div>
        </div>-->


    </div>


</template>

<script>
    import vSelect from 'vue-select';

    Vue.component('v-select', vSelect);

    export default {
        name: "CategoryComponent",
        data() {
            return {
                allattrgroups: [],
                thisattrgroups: [],
                categorylist: [],
                selected: null,
                error: [],
                editflag: false,
                categoryid: null,
                category: null,
                description: null,
                backbtn: false,
                backarray: [],
                parentid: null,
            }
        },
        methods: {
            saveattr() {
                let that = this;
                let data = {
                    id: this.categoryid,
                    attrgroups: this.thisattrgroups,
                };
                axios.post('/dashboard/saveattrgroup', data)
                    .then(function (response) {
                        $('#Attribute').modal('hide');
                    });
            },

            deleteattr(id) {
                for (let i = 0; i < this.thisattrgroups.length; i++) {
                    if (this.thisattrgroups[i].id == id) {
                        // console.log(this.thisattrgroups);
                        this.thisattrgroups.splice(i, 1);
                    }
                }
            },

            changeSelect() {
                let find = false;
                for (let i = 0; i < this.thisattrgroups.length; i++) {
                    if (this.thisattrgroups[i].id == this.selected.id) {
                        find = true;
                    }
                }
                if (find == false) {
                    let newitem = {'id': this.selected.id, 'title': this.selected.title};
                    this.thisattrgroups.push(newitem);
                }
            },

            loadPage() {
                this.allowdelete = false;
                let that = this;
                this.backarray = [];
                axios.post('/dashboard/categories')
                    .then(function (response) {
                        that.categorylist = response.data;
                        that.backbtn = false;
                        that.parentid = 0;
                    });
            },

            addcategory() {
                this.error = [];
                this.editflag = false;
                this.categoryid = null;
                this.category = null;
                this.description = null;
            },

            editcategory(id, name, description) {
                this.error = [];
                this.editflag = true;
                this.categoryid = id;
                this.category = name;
                this.description = description;
            },

            savecategory() {
                let that = this;
                let data = {
                    id: this.categoryid,
                    category: this.category,
                    description: this.description,
                    editflag: this.editflag,
                    parentid: this.parentid,
                };
                axios.post('/dashboard/savecategory', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.getsubcategorys(that.parentid, 'reload');
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },

            /* deletecategory(id){
                 let that = this;
                 this.deleteid = id;
                 let data = {
                     id: id,
                     allowdelete: this.allowdelete,
                     parentid: this.parentid,
                 };
                 axios.post('/dashboard/deletecategory', data)
                     .then(function (response) {
                         that.getsubcategorys(that.parentid, 'reload');
                     }).catch((error) => {
                         $('#errorDelete').modal('toggle');
                 });
             },

             deleteall(){
                 this.allowdelete = true;
                 $('#errorDelete').modal('toggle');
                 this.deletecategory(this.deleteid);
             },*/

            getsubcategorys(id, back = '') {
                this.allowdelete = false;
                let that = this;
                if (back == '') {
                    this.backarray.push(this.parentid);
                    this.parentid = id;
                }
                let data = {
                    parentid: id,
                };
                axios.post('/dashboard/getsubcategorys', data)
                    .then(function (response) {
                        that.categorylist = response.data;
                        that.parentid == 0 ? that.backbtn = false : that.backbtn = true;
                    });
            },

            goback() {
                if (this.backarray.length == 1) {
                    this.loadPage();
                    this.parentid = 0;
                } else {
                    let last = this.backarray[this.backarray.length-1];
                    this.backarray.pop();
                    this.parentid = last;
                    this.getsubcategorys(last, 'back');
                }
            },

            getattr(catid) {
                let that = this;
                this.categoryid = catid;
                let data = {
                    categoryid: catid,
                };
                axios.post('/dashboard/getattributegroup', data)
                    .then(function (response) {
                        console.log(response.data);
                        that.allattrgroups = response.data[0];
                        that.thisattrgroups = response.data[1]['group_attributes'];
                        $('#Attribute').modal('show');
                    });
            },

        }
        ,

        mounted() {
            this.loadPage();

        }


    }


</script>

<style scoped>

</style>