<template>

    <div>
        <h4 class="admin-title py-3 px-4"> اطلاعات مربوط به شما </h4>

        <error :error="error"></error>


        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card mt-2">
                    <div class="card-header row m-0 px-3">
                        <strong>
                            اطلاعات شخصی کاربر
                        </strong>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                نام
                            </div>
                            <div class="col-8 col-lg-8">
                                <input v-model="userinfo['firstname']" type="text"
                                       class="form-control mt-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                نام خانوادگی
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['lastname']" type="text" class="form-control mt-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                کدملی
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['mellicode']" type="number"
                                       class="form-control mt-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                تاریخ تولد
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['birthday']" type="text" class="form-control mt-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                تلفن
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['telephone']" type="number"
                                       class="form-control mt-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                موبایل
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['mobile']" type="number" class="form-control mt-2">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <div class="col-8 col-sm-9 col-lg-8 offset-3 offset-lg-4">
                                <input type="checkbox" v-model="userinfo['newsflag'] "
                                       class="form-check-input publish-checkbox mr-2">
                                <label class="form-check-label pr-2 mt-1 mr-4">اشتراک در خبرنامه</label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card mt-2">
                    <div class="card-header row m-0 px-3">
                        <strong>
                            اطلاعات آدرس کاربر
                        </strong>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                استان
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <select class="form-control" name="state" @change="changestate()"
                                        v-model="userinfo['state']">
                                    <option value="0">لطفا استان را انتخاب نمایید</option>
                                    <option v-for="state in states">{{state.name}}</option>

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                شهر
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <select class="form-control" v-model="userinfo['city']">
                                    <option value="0" v-if="userinfo['state'] == 0">لطفا استان را انتخاب نمایید</option>
                                    <option value="1" v-else>لطفا شهر را انتخاب نمایید</option>
                                    <option v-for="city in cities">{{city.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                آدرس
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                            <textarea v-model="userinfo['address']" class="form-control mt-2"
                                                      rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                کدپستی
                            </div>
                            <div class="col-8 col-sm-9 col-lg-8">
                                <input v-model="userinfo['postcode']" type="number"
                                       class="form-control mt-2">
                            </div>
                        </div>
                    </div>

                </div>

                <input type="button" @click="saveuserinfo" class="btn btn-primary float-left mt-5"
                       value="ذخیره اطلاعات">

            </div>
        </div>


    </div>


</template>

<script>

    export default {
        name: "MyinfoComponent",
        data() {
            return {
                error: [],
                user: [],
                states: [],
                cities: [],
                userinfo: {
                    'firstname': null,
                    'lastname': null,
                    'mellicode': null,
                    'birthday': null,
                    'telephone': null,
                    'mobile': null,
                    'newsflag': false,
                    'state': 0,
                    'city': 0,
                    'address': null,
                    'postcode': null,
                },
            }
        },
        props: ['userid'],

        methods: {

            changestate() {
                    var state = this.userinfo['state'];
                    for (var i = 0; i < this.states.length; i++) {
                        if (state == this.states[i]['name']) {
                            this.cities = this.states[i]['Cities'];
                        }
                    }
                    this.userinfo['city'] = 1;
                    if (this.userinfo['state'] == 0) {
                        this.userinfo['city'] = 0;
                        this.cities = [];
                    }
            },

            saveuserinfo() {
                let that = this;
                let data = {
                    userid: this.userid,
                    userinfo: this.userinfo,
                };

                axios.post('/dashboard/saveuserinfo', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },



            reloadPage() {
                let that = this;
                let data = {
                    userid: this.userid,
                };

                axios.post('/dashboard/getmyinfo', data)
                    .then(function (response) {

                        that.user = response.data[0];

                        if(response.data[1] != null) {
                            that.userinfo = response.data[1];
                        }
                        if (that.userinfo['state'] != 0){
                            for (var j=0; j<response.data[2].length; j++){
                                if(that.userinfo['state'] == response.data[2][j]['name']){
                                    that.cities = response.data[2][j]['Cities'];
                                }
                            }
                        }

                        that.states = response.data[2];
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