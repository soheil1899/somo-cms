<template>

    <div>
        <h4 class="admin-title py-3 px-4">
            ریزاطلاعات
            {{user['name']}}

            <a :href="'/dashboard/user'" class="back-btn btn btn-secondary float-left"
               style="margin-top: -5px">برگشت</a>

        </h4>
        <error :error="error"></error>


        <div class="accordion" id="accordionExample">

            <div class="card">
                <div class="card-header py-1" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" style="text-decoration: none" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong>
                                پروفایل کاربر
                            </strong>
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body row">
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
                                            <select class="form-control" name="state" @change="changestate('1')" v-model="userinfo['state']">
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
            </div>
            <div class="card" v-if="user.act == 'seller'">
                <div class="card-header py-1" id="headingFive">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse"
                                data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <strong>
                                اطلاعات مربوط به فروشگاه
                            </strong>
                        </button>
                    </h2>
                </div>

                <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        نام فروشگاه
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['name']" type="text" class="form-control mt-2">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        تلفن
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['telephone']" type="number" class="form-control mt-2">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        فکس
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['fax']" type="number" class="form-control mt-2">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        کد اقتصادی
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['economic_num']" type="number" class="form-control mt-2">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        شناسه ملی
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['national_identity_num']" type="number" class="form-control mt-2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        استان
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <select class="form-control" name="state" @change="changestate('2')" v-model="storeinfo['state']">
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
                                        <select class="form-control" v-model="storeinfo['city']">
                                            <option value="0" v-if="storeinfo['state'] == 0">لطفا استان را انتخاب نمایید</option>
                                            <option value="1" v-else>لطفا شهر را انتخاب نمایید</option>
                                            <option v-for="city in cities2">{{city.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        آدرس
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <textarea v-model="storeinfo['address']" class="form-control mt-2"
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-lg-4 pl-0" style="line-height: 45px">
                                        کدپستی
                                    </div>
                                    <div class="col-8 col-sm-9 col-lg-8">
                                        <input v-model="storeinfo['postcode']" type="number" class="form-control mt-2">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <input type="button" @click="savestoreinfo" class="btn btn-primary float-left m-4"
                           value="ذخیره اطلاعات">
                </div>
            </div>

            <div class="card" v-if="user.act == 'user'">
                <div class="card-header py-1" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                            <strong>
                                کامنت های کاربر
                            </strong>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="card mb-5" v-for="item in commentlist" :key="item.id">
                            <div class="card-header row m-0 px-3">
                                <div class="col-6 p-0">
                                    &nbsp;&nbsp;(
                                    {{item.date}}
                                    -
                                    {{item.time}}
                                    )
                                    (
                                    <strong style="color: #2f468d;">
                                        محصول:
                                        {{item.product['faname']}}
                                    </strong>
                                    )
                                </div>

                                <!--                                <div class="col-6 p-0 icons" style="text-align: left">-->
                                <!--                                    <i title="پاسخ" @click="answer(item.id, item.title, item.product_id)" class="fas fa-reply fa-lg mr-2"-->
                                <!--                                       style="color: #00c111;"></i>-->
                                <!--                                    <i title="حذف" @click="deletecomment(item.id, item.parent_id)" class="fas fa-trash fa-lg mr-2" style="color: #EB3E37;"></i>-->
                                <!--                                    <i title="ویرایش" @click="edit(item.id, item.title, item.comment, item.product_id)" class="far fa-edit fa-lg mr-2"-->
                                <!--                                       style="color: #00B2C9;"></i>-->
                                <!--                                    <i title="انتشار" v-if="item.publish" @click="changepublish(item.id, item.publish, item.answer_flag)" class="far fa-check-circle fa-lg mr-2"-->
                                <!--                                       style="color: #5BB760;"></i>-->
                                <!--                                    <i title="عدم انتشار" v-else @click="changepublish(item.id, item.publish, item.answer_flag)" class="fas fa-ban fa-lg mr-2" style="color: #EB3E37;"></i>-->

                                <!--                                </div>-->


                            </div>
                            <div class="card-body">
                                <strong>
                                    {{item.title}}
                                </strong>
                                <p class="mt-2 mb-0" v-html="item.comment"></p>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card" v-if="user.act == 'user'">
                <div class="card-header py-1" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                            <strong>
                                سفارشات کاربر
                            </strong>
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">


                    </div>
                </div>
            </div>
            <div class="card" v-if="user.act == 'user'">
                <div class="card-header py-1" id="headingFour">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" style="text-decoration: none" type="button"
                                data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                aria-controls="collapseFour">
                            <strong>
                                خریدهای کاربر
                            </strong>
                        </button>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                    <div class="card-body">


                    </div>
                </div>
            </div>
        </div>


    </div>


</template>


<script>

    import moment from 'jalali-moment';

    export default {
        name: "UserInfoComponent",


        data() {
            return {
                error: [],
                user: [],
                states: [],
                cities: [],
                cities2: [],
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
                storeinfo:{
                    'name': null,
                    'telephone': null,
                    'fax': null,
                    'economic_num': null,
                    'national_identity_num': null,
                    'state': 0,
                    'city': 0,
                    'address': null,
                    'postcode': null,
                },
                commentlist: [],


            }
        },

        props: ['userid'],


        methods: {
            changestate(flag) {
                if (flag == 1){
                    var state = this.userinfo['state'];
                    for (var i=0; i<this.states.length; i++){
                        if(state == this.states[i]['name']){
                            this.cities = this.states[i]['Cities'];
                        }
                    }
                    this.userinfo['city'] = 1;
                    if (this.userinfo['state'] == 0){
                        this.userinfo['city'] = 0;
                        this.cities = [];
                    }
                } else{
                    var state1 = this.storeinfo['state'];
                    for (var j=0; j<this.states.length; j++){
                        if(state1 == this.states[j]['name']){
                            this.cities2 = this.states[j]['Cities'];
                        }
                    }
                    this.storeinfo['city'] = 1;
                    if (this.storeinfo['state'] == 0){
                        this.storeinfo['city'] = 0;
                        this.cities2 = [];
                    }
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
                        that.loadPage();
                    });
            },

            savestoreinfo() {
                let that = this;
                let data = {
                    userid: this.userid,
                    storeinfo: this.storeinfo,
                };

                axios.post('/dashboard/savestoreinfo', data)
                    .then(function (response) {
                        that.loadPage();
                    });
            },

            loadPage() {
                let that = this;
                let data = {
                    userid: this.userid,
                };

                axios.post('/dashboard/getuserinfo', data)
                    .then(function (response) {

                        that.user = response.data[0];

                        if (response.data[1] != null) {
                            that.userinfo = response.data[1];
                            if (that.userinfo['state'] != 0) {
                                for (var j = 0; j < response.data[4].length; j++) {
                                    if (that.userinfo['state'] == response.data[4][j]['name']) {
                                        that.cities = response.data[4][j]['Cities'];
                                    }
                                }
                            }
                        }

                        that.commentlist = response.data[2];
                        for (var i = 0; i < that.commentlist.length; i++) {
                            that.commentlist[i]['time'] = (that.commentlist[i]['created_at']).slice(11, 16);
                            that.commentlist[i]['date'] = moment((that.commentlist[i]['created_at']).slice(0, 10), 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD');

                        }

                        if (response.data[3] != null){
                            that.storeinfo = response.data[3];
                            if (that.storeinfo['state'] != 0){
                                for (var j=0; j<response.data[4].length; j++){
                                    if(that.storeinfo['state'] == response.data[4][j]['name']){
                                        that.cities2 = response.data[4][j]['Cities'];
                                    }
                                }
                            }
                        }


                        that.states = response.data[4];
                    });
            },

        },

        mounted() {
            this.loadPage();
        }


    }
</script>

<style scoped>

</style>