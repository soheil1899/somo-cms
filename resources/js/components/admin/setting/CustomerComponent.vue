<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست مشتریان ها </h4>

        <input type="button" @click="addcustomer" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن مشتری جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-dark btn-sm my-2 mr-1">داشبورد</a>

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="30%">نام فارسی</th>
                <th scope="col" width="30%">نام انگلیسی</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.customerlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.company_name}}</td>
                <td class="py-2">{{item.company_name_en}}</td>
                <td class="py-1 icons">
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1" @click="editcustomer(item.id, item.company_name, item.company_name_en, item.logo, item.address, item.description)"  data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" @click="deletecustomer(item.id)" class="fas fa-times-circle fa-lg mt-2 mx-1" ></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش مشتری'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن مشتری جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="company_name" class="form-control"  placeholder="نام مشتری">
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" v-model="company_name_en" class="form-control"  placeholder="نام انگلیسی مشتری">
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" v-model="address" class="form-control"  placeholder="آدرس">
                            </div>
                            <div class="form-group mb-1">
                                <textarea class="form-control" rows="3" v-model="description" placeholder="توضیحات"></textarea>
                            </div>


                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savecustomer" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
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
                customerlist: [],
                error: [],
                editflag: false,
                company_name: null,
                company_name_en: null,
                description: null,
                address: null,
                customerid: null,
            }
        },
        methods: {

            deletecustomer(id){
                let that = this;
                let data = {
                    id: id,
                };
                axios.post('/dashboard/deletecustomer', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            reloadPage() {
                let that = this;
                axios.post('/dashboard/getcustomer')
                    .then(function (response) {
                        that.customerlist = response.data;
                    });
            },

            addcustomer(){
                this.editflag = false;
                this.customerid = null;
                this.company_name = null;
                this.company_name_en = null;
                this.address = null;
                this.description = null;
            },
            editcustomer(id, company_name, company_name_en, logo, address, description){
                this.editflag = true;
                this.customerid = id;
                this.company_name = company_name;
                this.company_name_en = company_name_en;
                this.address = address;
                this.description = description;
            },

            savecustomer(){
                let that = this;
                let data = {
                    editflag: this.editflag,
                    company_name: this.company_name,
                    company_name_en: this.company_name_en,
                    description: this.description,
                    address: this.address,
                    customerid: this.customerid,
                };
                axios.post('/dashboard/savecustomer', data)
                    .then(function (response) {
                        $('#Modal').modal('hide');
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
