<template>
    <div class="row" id="dashboard">
        <div class="col-12 col-lg-8 mb-4 mb-lg-0">
            <div class="row mt-3 mr-0 mr-sm-3">
                <div class="col-3 box-item py-3 ml-4 mr-3 mr-sm-5"
                     style="background: linear-gradient(#02B0CB, #04C4DB); color: #fff;" v-if="useraccess == 1">
                    <a :href="'/dashboard/user'">
                        <i class="fas fa-users fa-3x mb-2"></i>
                        کاربران
                    </a>
                </div>
                <div class="col-3 box-item ml-4 mr-3 mr-sm-5"
                     style="cursor: default; background: none" v-else>

                </div>
                <div class="col-3 box-item ml-4"
                     style="cursor: default; background: none">

                </div>

                <div class="col-3 box-item py-3 ml-4"
                     style="background: linear-gradient(#02B0CB, #04C4DB); color: #fff;" v-if="writeraccess == 1">
                    <a :href="'/dashboard/article'">
                        <i class="far fa-keyboard fa-3x mb-2"></i>
                        مطالب
                    </a>
                </div>


            </div>

            <div class="row mt-4 mr-0 mr-sm-3" v-if="storeaccess == 1">

                <div class="col-3 box-item py-3 ml-4 mr-3 mr-sm-5"
                     style="background: linear-gradient(#911BAF, #AD40BF); color: #fff;">
                    <a :href="'/dashboard/attribute'">
                        <i class="fab fa-steam-symbol fa-3x mb-2"></i>
                        ویژگی ها
                    </a>
                </div>

                <div class="col-3 box-item py-3 ml-4"
                     style="background: linear-gradient(#459F47, #60BF63); color: #fff;">
                    <a :href="'/dashboard/color'">
                        <i class="fas fa-palette fa-3x mb-2"></i>
                        رنگ ها
                    </a>
                </div>

                <div class="col-3 box-item py-3" style="background: linear-gradient(#911BAF, #AD40BF); color: #fff;">
                    <a :href="'/dashboard/category'">
                        <i class="fas fa-sitemap fa-3x mb-2"></i>
                        دسته بندی
                    </a>
                </div>

            </div>

            <div class="row mt-4 mr-0 mr-sm-3" v-if="storeaccess == 1">

                <div class="col-3 box-item py-3 ml-4 mr-3 mr-sm-5"
                     style="background: linear-gradient(#02B0CB, #04C4DB); color: #fff;">
                    <a :href="'/dashboard/guarantee'">
                        <i class="fas fa-shield-alt fa-3x mb-2"></i>
                        گارانتی ها
                    </a>
                </div>

                <div class="col-3 box-item py-3 ml-4"
                     style="background: linear-gradient(#459F47, #60BF63); color: #fff;">
                    <a :href="'/dashboard/slider'">
                        <i class="fas fa-camera fa-3x mb-2"></i>
                        اسلایدر
                    </a>
                </div>

                <div class="col-3 box-item py-3" style="background: linear-gradient(#02B0CB, #04C4DB); color: #fff;">
                    <a :href="'/dashboard/comment'">
                        <i class="far fa-envelope fa-3x mb-2"></i>
                        کامنت ها
                    </a>
                </div>

            </div>

            <div class="row mt-4 mr-0 mr-sm-3" v-if="storeaccess == 1">

                <div class="col-3 box-item ml-4 mr-3 py-3 mr-sm-5" style="background: linear-gradient(#911BAF, #AD40BF); color: #fff;">
                    <a :href="'/dashboard/brand'">
                        <i class="fab fa-apple fa-3x mb-2"></i>
                        برندها
                    </a>
                </div>
                <div class="col-3 box-item ml-4"
                     style="cursor: default; background: none">

                </div>
                <div class="col-3 box-item py-3" style="background: linear-gradient(#911BAF, #AD40BF); color: #fff;">
                    <a :href="'/dashboard/product'">
                        <i class="fas fa-box-open fa-3x mb-2"></i>
                        محصولات
                    </a>
                </div>

            </div>


        </div>


        <div class="col-12 col-lg-4 mt-5 mt-lg-0">
            <div class="col-12 mb-2 mylist" style="border-color: #00B2C9">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل کاربران
                        <span class="badge badge-primary badge-pill">112</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل مطالب
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل دسته بندی ها
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل ویژگی ها
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل رنگ ها
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل برند ها
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل محصولات
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل کامنت ها
                        <span class="badge badge-primary badge-pill">14</span>
                    </li>
                </ul>
            </div>
            <div class="col-12 mt-5 mylist" style="border-color: #5BB760">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل فروش امروز
                        <span class="badge badge-success badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل فروش هفته
                        <span class="badge badge-success badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل فروش ماه
                        <span class="badge badge-success badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل فروش سال
                        <span class="badge badge-success badge-pill">14</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        تعداد کل فروش
                        <span class="badge badge-success badge-pill">14</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "DashboardComponent",

        props:['useraccess', 'storeaccess', 'writeraccess'],

        data(){
            return {
                userflag: false,
                storeflag: false,
                writeflag: false,
            }
        },

        methods: {

        },

        mounted() {
        }
    }
</script>

<style scoped>
    #dashboard .box-item {
        text-align: center;
        height: fit-content;
        border-radius: 0;
        cursor: pointer;
    }

    #dashboard .box-item a {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: #fff;
    }

    #dashboard .box-item:hover {
        box-shadow: 0 0 25px #999;
    }

    #dashboard .box-item i {
        display: block;
    }

</style>