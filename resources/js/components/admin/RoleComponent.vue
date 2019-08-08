<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست وظایف </h4>

        <input type="button" class="btn btn-success my-2" data-toggle="modal" @click="addRole"
               data-target="#Modal" value="افزودن وظیفه جدید">
        <input type="button" class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="50%" colspan="2">عنوان وظیفه</th>
                <th scope="col" class="p-0" width="40%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.rolelist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2">{{item.role}}</td>
                <td class="py-1 icons">
                    <i title="دسترسی" class="fas fa-universal-access fa-2x m-1" style="color: #12c908;" @click="permissionchange(item.id, item.title, item.permissions)"></i>
                    <i title="ویرایش" class="far fa-edit fa-2x m-1" style="color: #00B2C9;" @click="editRole(item.id, item.title, item.role)"  data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" @click="deleteRole(item.id)" class="fas fa-trash fa-2x m-1" style="color: #EB3E37;" ></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش وظیفه'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن وظیفه جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="title" placeholder="عنوان وظیفه فارسی" class="form-control" name="title">
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" v-model="role" placeholder="عنوان وظیفه" class="form-control" name="title">
                            </div>
                            
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saverole" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>








        <!-- Role Modal -->
        <div class="modal fade" id="Permissionmodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">تعیین دسترسی
                            {{title}}
                        </h5>
                    </div>

                    <div class="modal-body row">
                        <div class="col-12 col-lg-6">
                            <div class="list-group ">
                                <ul class="pl-0 pr-4">
                                    <li class="list-group-item list-group-item-action pointer row" v-for="item in permissionlistright" :key="item.id" @click="changepermissiontick(item.id)">
                                        <div class="col-1 px-0 float-right">
                                            <i class="fas fa-check fa-lg" style="color: #22d83d;" v-if="accessflag[item.id-1]"></i>
                                        </div>
                                        <div class="col-10 px-2 mr-4">
                                            {{item.title}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="list-group ">
                                <ul class="pl-0 pr-4">
                                    <li class="list-group-item list-group-item-action pointer row" v-for="item in permissionlistleft" :key="item.id" @click="changepermissiontick(item.id)">
                                        <div class="col-1 px-0 float-right">
                                            <i class="fas fa-check fa-lg" style="color: #22d83d;" v-if="accessflag[item.id-1]"></i>
                                        </div>
                                        <div class="col-10 px-2 mr-4">
                                            {{item.title}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savepermission" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>




    </div>


</template>

<script>

    export default {
        name: "BrandComponent",
        data() {
            return {
                rolelist: [],
                error: [],
                editflag: false,
                roleid: null,
                role: null,
                title: null,
                permissionlistright: [],
                permissionlistleft: [],

                accessflag: {
                    0 : false,
                    1 : false,
                    2 : false,
                    3 : false,
                    4 : false,
                    5 : false,
                    6 : false,
                    7 : false,
                    8 : false,
                    9 : false,
                },
            }
        },
        methods: {

            reloadPage() {
                let that = this;

                this.permissionlistright= [];
                this.permissionlistleft= [];
                axios.post('/dashboard/roles')
                    .then(function (response) {
                        that.rolelist = response.data[0];
                        var i=0;
                        var x = response.data[1].length;
                        for (i; i<(x/2) ;i++){
                            that.permissionlistright.push(response.data[1][i]);
                        }
                        for (i; i<x;i++){
                            that.permissionlistleft.push(response.data[1][i]);
                        }

                    });
            },

            editRole(id, title, role){
                this.error = [];
                this.editflag = true;
                this.roleid = id;
                this.title = title;
                this.role = role;
            },

            permissionchange(id, title, permissions){

                this.accessflag  = {0 : false, 1 : false, 2 : false, 3 : false, 4 : false, 5 : false, 6 : false, 7 : false, 8 : false, 9 : false};

                for (var i=0; i<permissions.length; i++){
                    this.accessflag[permissions[i]['id']-1] = true;
                }

                this.roleid = id;
                this.title = title;
                $('#Permissionmodal').modal('show');
            },

            changepermissiontick(id){
                this.accessflag[id - 1] == false ? this.accessflag[id - 1] = true : this.accessflag[id - 1] = false;
            },

            addRole(){
                this.error = [];
                this.editflag = false;
                this.roleid = null;
                this.title = null;
                this.role = null;
            },

            saverole(){
                let that = this;
                let data = {
                    editflag: this.editflag,
                    roleid: this.roleid,
                    roletitle: this.title,
                    role: this.role,
                };
                axios.post('/dashboard/saverole', data)
                    .then(function (response) {
                        $('#Modal').modal('hide');
                        that.reloadPage();
                    });
            },

            savepermission(){
                let that = this;
                let data = {
                    roleid: this.roleid,
                    accessflag: this.accessflag,
                };
                axios.post('/dashboard/savepermission', data)
                    .then(function (response) {
                        $('#Permissionmodal').modal('hide');
                        that.reloadPage();
                    });
            },

            deleteRole(id){
                let that = this;
                let data = {
                    roleid: id,
                };
                axios.post('/dashboard/deleterole', data)
                    .then(function (response) {
                        that.reloadPage();
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