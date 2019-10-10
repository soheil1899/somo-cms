<template>

    <div>
        <h4 class="admin-title py-3 px-4">
            مدیریت ویژگی ها
            <span v-if="backbtn">{{attributename}}</span>
        </h4>


        <input type="button" @click="addattr" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن ویژگی جدید">
        <input type="button" @click="loadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>

        <input v-if="backbtn" @click="goback" type="button" class="back-btn btn btn-dark btn-sm my-2 mr-1" value="برگشت">

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="15%">عنوان ویژگی</th>
                <th scope="col" width="50%">توضیحات</th>
                <th scope="col" class="p-0" width="25%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="item in attrlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2">{{item.description}}</td>
                <td class="py-1 icons">
                    <i title="زیر ویژگی" class="fab fa-steam fa-lg mt-2 mx-1"  @click="showsubattr(item.id, item.title)" v-if="subbutton"></i>
                    <i title="تعریف مقادیر" class="fas fa-th-list fa-lg mt-2 mx-1"  v-if="backbtn" @click="getsubvalue(item.id, item.title)"></i>
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1"  @click="editattr(item.id, item.title, item.description)" data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1" v-if="backbtn" @click="deleteattr(item.id)"  ></i>

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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش ویژگی'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن ویژگی جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="attribute" class="form-control" name="title" placeholder="عنوان ویژگی">
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="description" v-model="description" placeholder="توضیحات..." class="form-control" cols="30"
                                          rows="3"></textarea>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saveattr" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- SubAttr Modal -->
        <div class="modal fade" id="subAttr" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">مقادیر پیش فرض
                            {{attributename}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form id="subattr-form">


                            <div class="form-group mb-1 position-relative subattr icons" v-for="item in subattrvaluelist"
                                 :key="item.id">

                                <input type="text" class="form-control" v-model="item.value" placeholder="مقدار جدید">
                                <i class="fas fa-times-circle position-absolute fa-lg" @click="deleterow(item.id)"></i>

                            </div>


                        </form>
                    </div>

                    <div class="modal-footer my-modal-footer m-0">
                        <div class="row">
                            <div class="col-8 m-0">
                                <button type="button" @click="savesubattrvalue" class="btn btn-success btn-sm px-3">ذخیره</button>
                                <button type="button" @click="refresh" class="btn btn-secondary btn-sm px-3">بازخوانی</button>
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-dismiss="modal">بازگشت</button>
                            </div>
                            <div class="col-4 m-0">
                                <button type="button" @click="newrow" class="btn btn-outline-primary float-left btn-sm px-3">سطر
                                    جدید
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>

    export default {
        name: "AttributeComponent",
        data() {
            return {
                attrlist: [],
                flag: false,
                subattrvaluelist: [],
                attributename: null,
                subbutton: true,
                backbtn: false,
                error: [],
                editflag: false,
                attrid: null,
                attribute: null,
                description: null,
                subattrid: null,
                // allowdelete: false,
                // deleteid: null,
                parentid: 0,
            }
        },
        methods: {

            getsubvalue(id, title) {
                let that = this;
                this.attributename = title;
                this.subattrid = id;
                let data = {
                    id: id,
                };
                axios.post('/dashboard/getsubvalue', data)
                    .then(function (response) {
                        $('#subAttr').modal('show');
                        that.subattrvaluelist = response.data;
                        that.newrow();
                    });
            },


            refresh() {
                this.getsubvalue(this.subattrid, this.attributename);
            },

            savesubattrvalue() {
                let that = this;
                let data = {
                    subattrvalues: this.subattrvaluelist,
                    subattrid: this.subattrid,
                };
                axios.post('/dashboard/savesubattributevalue', data)
                    .then(function (response) {
                        $('#subAttr').modal('hide');
                    });
            },


            deleteattr(id) {
                let that = this;
                this.backbtn == true ? this.flag = true : this.flag = false;
                let data = {
                    id: id,
                };
                axios.post('/dashboard/deletesubattribute', data)
                    .then(function (response) {
                        that.loadPage();
                    });
            },
            goback() {
                this.flag = false;
                this.parentid = 0;
                this.loadPage();
            },

            showsubattr(id, title) {
                let that = this;
                this.attributename = title;
                this.parentid = id;
                let data = {
                    parentid: id,
                };
                axios.post('/dashboard/getsubattribute', data)
                    .then(function (response) {
                        that.attrlist = response.data;
                        that.subbutton = false;
                        that.backbtn = true;
                        // $('#subAttr').modal('show');
                        // that.newrow();
                    });
            },

            deleterow(id) {
                for (let i = 0; i < this.subattrvaluelist.length; i++) {
                    if (this.subattrvaluelist[i].id == id) {
                        this.subattrvaluelist.splice(i, 1);
                    }
                }
            },

            newrow() {
                let length = this.subattrvaluelist.length;
                this.subattrvaluelist.push({
                    'id': Math.floor(Math.random() * 1000000) + 1000,
                    'subattribute_id': this.subattrid,
                    'value': null
                });
            },

            addattr() {
                this.error = [];
                this.editflag = false;
                this.attrid = null;
                this.attribute = null;
                this.description = null;
            },

            editattr(id, title, description) {
                this.error = [];
                this.editflag = true;
                this.attrid = id;
                this.attribute = title;
                this.description = description;
            },

            saveattr() {
                let that = this;
                this.backbtn == true ? this.flag = true : this.flag = false;

                let data = {
                    subattr: this.backbtn,
                    id: this.attrid,
                    attribute: this.attribute,
                    description: this.description,
                    editflag: this.editflag,
                    parentid: this.parentid,
                };
                axios.post('/dashboard/saveattribute', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.loadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },

            loadPage() {
                if (this.flag == false) {
                    this.subbutton = true;
                    this.backbtn = false;
                    let that = this;
                    axios.post('/dashboard/getattribute')
                        .then(function (response) {
                            that.attrlist = response.data;
                            // console.log(response.data);
                        });
                } else {
                    this.showsubattr(this.parentid, this.attributename);
                }
            },
        },

        mounted() {
            this.flag = false;
            this.loadPage();
        }


    }


</script>

<style scoped>


</style>
