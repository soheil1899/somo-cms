<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست کاربران </h4>

        <input type="button" @click="adduser" class="btn btn-success my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن کاربر جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark my-2 mr-1" value="بازخوانی">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col" width="30%">نام کاربر</th>
                <th scope="col" width="35%">ایمیل</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.userlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.email}}</td>
                <td class="py-1 icons">
                    <a :href="'user/'+item.id">
                        <i title="جزئیات" class="fas fa-info-circle fa-2x m-1" style="color: #b721c9;"></i>
                    </a>
                    <i title="دسترسی" class="fas fa-universal-access fa-2x m-1" style="color: #12c908;" @click="rolechange(item.id, item.name, item.roles)" v-if="accessshow"></i>
                    <i title="ویرایش" class="far fa-edit fa-2x m-1" style="color: #00B2C9;" data-toggle="modal" data-target="#Modal" @click="edituser(item.id, item.name, item.email)"></i>
                    <i title="حذف" class="fas fa-trash fa-2x m-1" style="color: #EB3E37;" @click="deleteuser(item.id)"></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش کاربر'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن کاربر جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>
                        <div v-if="passwordfalsediv" class="alert alert-danger" role="alert">
                            تکرار رمز عبور را صحیح وارد کنید.
                        </div>
                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="username" placeholder="نام کاربر" class="form-control" name="username">
                            </div>
                            <div class="form-group mb-1">
                                <input type="email" v-model="email" placeholder="ایمیل" class="form-control" name="email">

                            </div>
                            <div class="form-group mb-1" v-if="editflag">
                                <input type="checkbox" class="form-check-input publish-checkbox mr-2" @change="passwordchenge" v-model="passwordedit">
                                <label class="form-check-label pr-2 mt-1 mr-4">قصد تغییر رمزعبور را دارید؟</label>
                            </div>
                            <div class="form-group mb-1" v-if="passwordedit">
                                <input type="password" v-model="password" placeholder="رمز عبور" :class="{ 'border-green': passwordflag }"
                                       @keyup="checkpassword" class="form-control" name="password">
                            </div>
                            <div class="form-group mb-1" v-if="passwordedit">
                                <input type="password" :class="{ 'border-green': passwordflag }"
                                       v-model="confirmpassword" @keyup="checkpassword" class="form-control"
                                       name="confirmpassword" placeholder="تکرار رمز عبور">
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button @click="saveuser" type="button" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>




        <!-- Role Modal -->
        <div class="modal fade" id="Rolemodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true" v-if="accessshow">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-text="'تعیین دسترسی '+ username"></h5>
                    </div>

                    <div class="modal-body">
                        <div class="list-group">
                            <ul class="pl-0 pr-4">
                                <li class="list-group-item list-group-item-action pointer row" v-for="item in rolelist" :key="item.id" @click="changeroletick(item.ordered)">
                                    <div class="col-1 px-0 float-right">
                                        <i class="fas fa-check fa-lg" style="color: #22d83d;" v-if="accessflag[item.ordered-1]"></i>
                                    </div>
                                    <div class="col-10 px-0">
                                        {{item.title}}
                                    </div>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saveuseraccess" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>

    export default {
        name: "UserComponent",
        data() {
            return {
                editflag: false,
                userlist: [],
                rolelist: [],
                userrolesids: [],
                username: null,
                email: null,
                password: null,
                confirmpassword: null,
                passwordedit: false,
                error: [],
                userid: null,
                passwordflag: false,
                passwordfalsediv: false,


                accessshow: true,
                accessflag: {0 : false, 1 : false, 2 : false, 3 : false, 4 : false, 5 : false, 6 : false, 7 : false, 8 : false, 9 : false,
                    10 : false, 11 : false, 12 : false, 13 : false, 14 : false, 15 : false, 16 : false, 17 : false, 18 : false, 19 : false},
            }
        },
        methods: {
            saveuseraccess(){
                let that = this;
                let data = {
                    userid: this.userid,
                    accessflag: this.accessflag,
                };
                axios.post('/dashboard/saveuseraccess', data)
                    .then(function (response) {
                        $('#Rolemodal').modal('hide');
                        that.reloadPage();

                });
            },

            changeroletick(id){

                if (this.accessflag[id - 1] == false) {
                    this.accessflag[id - 1] = true;
                } else {
                    if(id != 2){
                        this.accessflag[id - 1] = false
                    }
                }


                if (id == 1) {
                    if (this.accessflag[0] == true) {

                        for (var i=1; i<this.rolelist.length; i++){
                            this.accessflag[i]=false;
                        }

                    } else if (this.accessflag[0] == false) {
                        this.accessflag[1] = true;
                    }
                }

                if (id == 2) {
                    this.accessflag[0] = false;
                    this.accessflag[1] = true;
                    for (var i=2; i<this.rolelist.length; i++){
                        this.accessflag[i] = false;
                    }
                }

                if(id != 1 && id != 2) {
                    var allbefalse = true;
                    for (var i=2; i<this.rolelist.length; i++){
                        if (this.accessflag[i] == true) {
                            this.accessflag[0] = false;
                            this.accessflag[1] = false;
                            allbefalse = false;
                        }
                    }
                    if (allbefalse == true){
                        this.accessflag[1] = true;
                    }
                }
            },

            rolechange(id, username, roles){
                this.userid = id;
                this.username = username;

                for (var i=0; i<this.rolelist.length; i++){
                    this.accessflag[i]=false;
                }

                for (var j=0; j<roles.length; j++){
                    this.accessflag[roles[j]['id']-1] = true;
                }

                $('#Rolemodal').modal('toggle');
            },

            reloadPage() {
                let that = this;
                axios.post('/dashboard/users')
                    .then(function (response) {
                        that.userlist = response.data[0];

                        that.rolelist = response.data[1];
                        // that.accessflag.;
                        if (response.data[2] == 'superadmin'){
                            that.accessshow = true;
                        } else{
                            that.accessshow = false;
                        }
                        // console.log(that.accessflag.length);
                    });
            },

            adduser() {
                this.error = [];
                this.editflag = false;
                this.username = null;
                this.email = null;
                this.password = null;
                this.confirmpassword = null;
                this.userid = null;
                this.passwordflag = false;
                this.passwordfalsediv = false;
                this.passwordedit = true;
            },

            edituser(id, name, email){
                this.error = [];
                this.editflag = true;
                this.userid = id;
                this.username = name;
                this.email = email;
                this.passwordedit = false;
            },


            saveuser() {
                if (this.passwordedit == true){
                    if (this.passwordflag == true) {
                        let that = this;
                        let data = {
                            id: this.userid,
                            username: this.username,
                            email: this.email,
                            passwordedit: this.passwordedit,
                            password: this.password,
                            editflag: this.editflag,
                        };
                        axios.post('/dashboard/saveuser', data)
                            .then(function (response) {
                                $('#Modal').modal('hide');
                                that.reloadPage();
                            }).catch((error) => {
                            that.error = error.response.data.errors;
                        });
                    }
                    else{
                        this.passwordfalsediv = true;
                    }
                } else{
                    let that = this;
                    let data = {
                        id: this.userid,
                        username: this.username,
                        email: this.email,
                        password: this.password,
                        editflag: this.editflag,
                    };
                    axios.post('/dashboard/saveuser', data)
                        .then(function (response) {
                            $('#Modal').modal('hide');
                            that.reloadPage();
                        }).catch((error) => {
                        that.error = error.response.data.errors;
                    });
                }



            },

            deleteuser(id){
                let that = this;
                let data = {
                    id: id,
                };
                axios.post('/dashboard/deleteuser', data)
                    .then(function (response) {
                        that.reloadPage();
                    })
            },

            checkpassword() {
                if (this.password == this.confirmpassword) {
                    this.passwordflag = true;
                } else {
                    this.passwordflag = false;
                }
                this.passwordfalsediv = false;
            },
        }
        ,

        mounted() {
            this.reloadPage();
        }


    }

    // $('#Modal').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget); // Button that triggered the modal
    //     var recipient = button.data('whatever'); // Extract info from data-* attributes
    // })
</script>

<style scoped>


</style>