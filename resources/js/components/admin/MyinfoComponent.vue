<template>

    <div>
        <h4 class="admin-title py-3 px-4"> اطلاعات شما </h4>

        <div class="row col-8 mx-auto my-5">
            <error :error="error"></error>

            <div class="row col-12 mb-2">
                <div class="col-3">
                    نام و نام خانوادگی :
                </div>
                <div class="col-9">
                    <input type="text" class="form-control" v-model="name">
                </div>
            </div>
            <div class="row col-12 mb-2">
                <div class="col-3">
                    ایمیل :
                </div>
                <div class="col-9">
                    <input type="email" class="form-control" v-model="email">
                </div>
            </div>
            <div class="row col-12 mb-2">
                <div class="col-3">
                    رمز عبور فعلی :
                </div>
                <div class="col-9">
                    <input type="password" class="form-control" v-model="oldpass">
                </div>
            </div>
            <div class="row col-12 mb-2">
                <div class="col-3">
                    رمز عبور جدید :
                </div>
                <div class="col-9">
                    <input type="password" class="form-control" v-model="newpass">
                </div>
            </div>
            <div class="row col-12 mb-2">
                <div class="col-3">
                    تکرار رمز عبور جدید:
                </div>
                <div class="col-9">
                    <input type="password" class="form-control" v-model="repass">
                </div>
            </div>
            <div class="row col-8 mt-5 mx-auto">
                <input type="button" @click="saveuserinfo" class="btn btn-primary col-12" value="ذخیره">
            </div>
        </div>


    </div>


</template>

<script>
    import Swal from 'sweetalert2';

    export default {
        name: "UserinfoComponent",
        data() {
            return {
                error: [],
                name: null,
                email: null,
                oldpass: null,
                newpass: null,
                repass: null,
            }
        },
        comments:{
            Swal,
        },
        methods: {

            reloadPage() {
                let that = this;
                axios.post('/dashboard/getmyinfo')
                    .then(function (response) {
                        that.name = response.data['name'];
                        that.email = response.data['email'];
                    });
            },

            saveuserinfo() {
                let that = this;
                let data = {
                    name: this.name,
                    email: this.email,
                    oldpass: this.oldpass,
                    newpass: this.newpass,
                    repass: this.repass,

                };
                axios.post('/dashboard/savemyinfo', data)
                    .then(function (response) {

                        if (response.data == true){
                            // alert('fuck');
                            Swal.fire({
                                text: 'اطلاعات شما با موفقیت تغییر یافت!',
                                type: 'success',
                                confirmButtonText: 'بستن'
                            });
                        }else{
                            Swal.fire({
                                text: 'اطلاعات وارد شده صحیح نمی باشد!',
                                type: 'warning',
                                confirmButtonText: 'بستن'
                            });
                        }
                        that.reloadPage();
                    }).catch((error) => {
                    that.error = error.response.data.errors;
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
