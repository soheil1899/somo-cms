<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست رنگ ها </h4>

        <input type="button" @click="addcolor" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن رنگ جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-sm btn-dark my-2 mr-1">داشبورد</a>

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="20%">نام رنگ</th>
                <th scope="col" width="20%">کد رنگ</th>
                <th scope="col" width="20%">رنگ</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.colorlist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.name}}</td>
                <td class="py-2" style="direction: ltr">{{item.hexcode}}</td>
                <td class="py-2">
                    <span class="color-circle" :style="{'background-color': item.hexcode}"></span>
                </td>
                <td class="py-1 icons">
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1"  @click="editcolor(item.id, item.name, item.hexcode)"  data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1" @click="deletecolor(item.id)" ></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش رنگ'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن رنگ جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="colorname" placeholder="نام رنگ" class="form-control" name="username">
                            </div>
                            <div class="form-group mb-1 position-relative">
                                <label class="col-form-label">کد رنگ:</label>
                                <label class="mr-3 colorlabel"><strong>{{colorhex}}</strong></label>
                                <div class="position-absolute my-color">
                                    <verte menuPosition="right" :enableAlpha="false" model="hex" v-model="colorhex" ></verte>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button @click="savecolor" type="button" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>




    </div>


</template>

<script>

    import Verte from 'verte';
    import 'verte/dist/verte.css';

    export default {
        name: "ColorComponent",
        data() {
            return {
                editflag: false,
                colorlist: [],
                colorname: null,
                colorhex: '#00ff00',
                error: [],
                colorid: null,
            }
        },
        components: { Verte },
        methods: {
            reloadPage(){
                let that = this;
                axios.post('/dashboard/getcolors')
                    .then(function (response) {
                        that.colorlist = response.data;
                    });
            },

            addcolor(){
                this.error = [];
                this.editflag = false;
                this.colorname = null;
                this.colorid = null;
            },

            editcolor(id, name, hex){
                this.error = [];
                this.editflag = true;
                this.colorid = id;
                this.colorname = name;
                this.colorhex = hex;
            },

            savecolor(){
                let that = this;
                let data = {
                    id: this.colorid,
                    colorname: this.colorname,
                    hexcode: this.colorhex,
                    editflag: this.editflag,
                };
                axios.post('/dashboard/savecolor', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
                });
            },

            deletecolor(id){
                let that = this;
                let data = {
                    id: id,
                };
                axios.post('/dashboard/deletecolor', data)
                    .then(function (response) {
                        that.reloadPage();
                    })
            },

        },

        mounted() {
            this.reloadPage();
        }


    }
</script>

<style scoped>

</style>
