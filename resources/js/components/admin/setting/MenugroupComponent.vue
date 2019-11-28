<template>

    <div>
        <h4 class="admin-title py-3 px-4"> مدیریت منو </h4>

        <input type="button" class="btn btn-success btn-sm my-2 mr-1" data-toggle="modal"
               data-target="#Modal" value="افزودن منو جدید">
        <input type="button" class="btn btn-dark btn-sm my-2 mr-1" value="بازخوانی">
        <a :href="'../dashboard'" class="back-btn btn btn-dark btn-sm my-2 mr-1">داشبورد</a>


        <table class="table table-hover table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان گروه منو</th>
                <th scope="col">توضیحات</th>
                <th scope="col" class="p-0">
                    <i class="fas fa-cogs fa-2x mb-2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in menugroups" :key="item.id">
                <th class="py-2" scope="row">{{index +1}}</th>
                <td class="py-2">{{item.title}}</td>
                <td class="py-2">{{item.description}}</td>
                <td class="py-1 icons">
                    <a :href="'/menus/'+ item.id">
                        <i title="زیرمنو" class="fas fa-sitemap fa-lg mx-1 mt-2"></i>
                    </a>
                    <i title="ویرایش" class="far fa-edit fa-lg mt-2 mx-1"
                       data-toggle="modal" data-target="#Modal"></i>
                    <i title="حذف" class="fas fa-times-circle fa-lg mt-2 mx-1"></i>
                </td>
            </tr>
            </tbody>
        </table>


        <!--         Add & Edit Modal-->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" v-if="editflag == true" v-text="'ویرایش گروه منو'"></h5>
                        <h5 class="modal-title" v-else v-text="'افزودن گروه منو جدید'"></h5>
                    </div>

                    <div class="modal-body">
                        <error :error="error"></error>


                        <div class="form-group mb-1">
                            <input type="text" v-model="menugroup" class="form-control" placeholder="نام گروه منو">
                        </div>
                        <div class="form-group mb-1">
                            <textarea v-model="description" class="form-control" placeholder="توضیحات"></textarea>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm px-4">ذخیره</button>
                        <button type="button" class="btn btn-secondary btn-sm px-4" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>


</template>

<script>


    export default {
        name: "MenugroupComponent",
        data() {
            return {
                menugroups: [],
                error: [],
                editflag: false,
                menuid: null,
                menugroup: null,
                description: null,
            }
        },
        methods: {

            reloadPage() {
                let that = this;

                axios.post('/dashboard/getmenugroups')
                    .then(function (response) {
                        that.menugroups = response.data;
                    });
            },


        },

        mounted() {
            this.reloadPage();
        }


    }


</script>

<style scoped>


</style>
