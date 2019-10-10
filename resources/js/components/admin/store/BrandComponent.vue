<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست برندها </h4>

        <input type="button" @click="addbrand" class="btn btn-success btn-sm mr-1 my-2" data-toggle="modal"
               data-target="#Modal" value="افزودن برند جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="25%">عنوان برند</th>
                <th scope="col" width="35%">توضیحات</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.brandlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2">{{item.description}}</td>
                <td class="py-1 icons">
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1" @click="editBrand(item.id, item.name, item.description)"  data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1"></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش برند'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن برند جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="brand" placeholder="عنوان برند" class="form-control" name="title">
                            </div>
                            <div class="form-group mb-1">
                                <textarea name="description" placeholder="توضیحات..." v-model="description" class="form-control" cols="30" rows="3"></textarea>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savebrand" class="btn btn-primary btn-sm px-4">ذخیره</button>
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
                brandlist: [],
                error: [],
                editflag: false,
                brandid: null,
                brand: null,
                description: null,
            }
        },
        methods: {

            reloadPage() {
                let that = this;
                axios.post('/dashboard/getbrands')
                    .then(function (response) {
                        that.brandlist = response.data;
                    });
            },

            editBrand(id, name, description){
                this.error = [];
                this.editflag = true;
                this.brandid = id;
                this.brand = name;
                this.description = description;
            },

            addbrand(){
                this.error = [];
                this.editflag = false;
                this.brandid = null;
                this.brand = null;
                this.description = null;
            },

            savebrand(){
                let that = this;
                let data = {
                    editflag: this.editflag,
                    brandid: this.brandid,
                    brand: this.brand,
                    description: this.description,
                };
                axios.post('/dashboard/savebrand', data)
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
