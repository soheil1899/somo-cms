<template>

    <div>
        <h4 class="admin-title py-3 px-4"> لیست تگ ها </h4>

        <input type="button" @click="addtag" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن تگ جدید">
        <input type="button" @click="reloadPage" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-dark btn-sm my-2 mr-1">داشبورد</a>

        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col" width="10%">#</th>
                <th scope="col" width="60%">تگ</th>
                <th scope="col" class="p-0" width="30%">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in this.taglist" :key="item.id">
                <th class="py-2" scope="row">{{item.id}}</th>
                <td class="py-2">{{item.tag}}</td>
                <td class="py-1 icons">
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1" style="color: #00B2C9;" @click="editTag(item.id, item.tag)"  data-toggle="modal" data-target="#Modal"></i>
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
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش تگ'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن تگ جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>

                        <form>
                            <div class="form-group mb-1">
                                <input type="text" v-model="tag" class="form-control" name="title" placeholder="نام تگ">
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savetag" class="btn btn-primary btn-sm px-4">ذخیره</button>
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
                taglist: [],
                error: [],
                editflag: false,
                tagid: null,
                tag: null,
            }
        },
        methods: {

            reloadPage() {
                let that = this;
                axios.post('/dashboard/gettags')
                    .then(function (response) {
                        that.taglist = response.data;
                    });
            },

            editTag(id, tag){
                this.error = [];
                this.editflag = true;
                this.tagid = id;
                this.tag = tag;
            },

            addtag(){
                this.error = [];
                this.editflag = false;
                this.tagid = null;
                this.tag = null;
            },

            savetag(){
                let that = this;
                let data = {
                    editflag: this.editflag,
                    tagid: this.tagid,
                    tag: this.tag,
                };
                axios.post('/dashboard/savetag', data)
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
