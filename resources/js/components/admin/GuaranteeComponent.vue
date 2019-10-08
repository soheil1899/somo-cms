<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست گارانتی ها </h4>

        <input type="button" @click="addguarantee" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن گارانتی جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-dark btn-sm my-2 mr-1">داشبورد</a>

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col" width="25%">نام شرکت</th>
                <th scope="col" width="15%">مدت گارانتی</th>
                <th scope="col" width="30%">توضیحات</th>
                <th scope="col" class="p-0" width="25%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.guaranteelist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.companyname}}</td>
                <td class="py-2">{{item.time}} ماه</td>
                <td class="py-2">{{item.description}}</td>
                <td class="py-1 icons">
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1" style="color: #00B2C9;" @click="editguarantee(item.id, item.companyname, item.description, item.time)"   data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1" style="color: #EB3E37;" ></i>

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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش گارانتی'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن گارانتی جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="companyname" placeholder="نام شرکت" class="form-control" name="username">
                            </div>
                            <div class="form-group mb-1">
                                <label class="col-form-label">مدت گارانتی:</label>
                                <div class="input-group" style="direction: ltr">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="btnGroupAddon">ماه</div>
                                    </div>
                                    <input type="number" v-model="time" class="form-control" name="username">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="description" v-model="description" placeholder="توضیحات..." class="form-control" cols="30" rows="3"></textarea>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="saveguarantee" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>




    </div>


</template>

<script>


    export default {
        name: "ColorComponent",
        data() {
            return {
                editflag: false,
                guaranteelist: [],
                companyname: null,
                time: null,
                error: [],
                guaranteeid: null,
                description: null,
            }
        },
        methods: {
            reloadPage(){
                let that = this;
                axios.post('/dashboard/getguarantees')
                    .then(function (response) {
                        that.guaranteelist = response.data;
                    });
            },

            addguarantee(){
                this.error = [];
                this.editflag = false;
                this.companyname = null;
                this.guaranteeid = null;
                this.description = null;
                this.time = null;
            },

            editguarantee(id, companyname, description, time){
                this.error = [];
                this.editflag = true;
                this.companyname = companyname;
                this.guaranteeid = id;
                this.description = description;
                this.time = time;
            },

            saveguarantee(){
                let that = this;
                let data = {
                    id: this.guaranteeid,
                    companyname: this.companyname,
                    description: this.description,
                    time: this.time,
                    editflag: this.editflag,
                };
                axios.post('/dashboard/saveguarantee', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },


        },

        mounted() {
            this.reloadPage();
        }


    }
</script>

<style scoped>
.my-color{
    top: 6px;
    left: 310px;
}
.color-circle{
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #999;
    display: block;
}

</style>
