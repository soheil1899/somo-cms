<template>
    <div class="row" id="dashboard">
        <div class="col-12 mb-4 mb-lg-0">
            <div class="row mt-3 mt-md-0">
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="useraccess == 1">
                    <div>
                        <a class="py-4" :href="'/dashboard/user'">
                            <i class="fas fa-users fa-3x mb-2 d-block"></i>
                            کاربران
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="useraccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/role'">
                            <i class="fas fa-user-shield fa-3x mb-2 d-block"></i>
                            دسترسی
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="writeraccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/article'">
                            <i class="fas fa-layer-group fa-3x mb-2 d-block"></i>
                            گروه مطالب
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="writeraccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/articles/1'">
                            <i class="far fa-keyboard fa-3x mb-2 d-block"></i>
                                لیست مطالب
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="writeraccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/newcontent'">
                            <i class="far fa-file-alt fa-3x mb-2 d-block"></i>
                            مطلب جدید
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/attribute'">
                            <i class="fab fa-steam-symbol fa-3x mb-2 d-block"></i>
                            ویژگی ها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/color'">
                            <i class="fas fa-palette fa-3x mb-2 d-block"></i>
                            رنگ ها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/brand'">
                            <i class="fab fa-apple fa-3x mb-2 d-block"></i>
                            برندها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/category'">
                            <i class="fas fa-sitemap fa-3x mb-2 d-block"></i>
                            دسته بندی
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/guarantee'">
                            <i class="fas fa-shield-alt fa-3x mb-2 d-block"></i>
                            گارانتی ها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div>
                        <a class="py-4" :href="'/dashboard/product'">
                            <i class="fas fa-box-open fa-3x mb-2 d-block"></i>
                            محصولات
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div>
                        <a class="py-4" :href="'/dashboard/addproduct'">
                            <i class="fas fa-cart-plus fa-3x mb-2 d-block"></i>
                                افزودن محصول
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center" v-if="storeaccess == 1">
                    <div >
                        <a class="py-4" :href="'/dashboard/comment'">
                            <i class="far fa-comments fa-3x mb-2 d-block"></i>
                            کامنت ها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center">
                    <div >
                        <a class="py-4" :href="'/dashboard/setting'">
                            <i class="fas fa-cogs fa-3x mb-2 d-block"></i>
                            تنظیمات
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center">
                    <div >
                        <a class="py-4" :href="'/dashboard/posts'">
                            <i class="far fa-envelope fa-3x mb-2 d-block"></i>
                            پیام ها
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center">
                    <div >
                        <a class="py-4" :href="'/dashboard/slider'">
                            <i class="fas fa-film fa-3x mb-2 d-block"></i>
                            اسلایدر
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center">
                    <div >
                        <a class="py-4" :href="'/dashboard/customer'">
                            <i class="fas fa-store fa-3x mb-2 d-block"></i>
                            مشتریان
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2 box-item py-3 px-4 text-center">
                    <div >
                        <a class="py-4" :href="'/dashboard/tag'">
                            <i class="fas fa-tags fa-3x mb-2 d-block"></i>
                            تگ ها
                        </a>
                    </div>
                </div>



            </div>

        </div>


    </div>
</template>

<script>
    export default {
        name: "DashboardComponent",

        props: ['useraccess', 'storeaccess', 'writeraccess'],

        data() {
            return {
                userflag: false,
                storeflag: false,
                writeflag: false,
            }
        },

        methods: {},

        mounted() {
        }
    }
</script>

<style scoped>

    #dashboard .box-item > div {
        height: 100%;
        border-radius: 5px;
        box-shadow: 0 0 10px 2px #ccc;
        background-color: #fcfcfc;
    }
    #dashboard .box-item > div:hover {
        box-shadow: 0 0 10px 2px #e76e73;
        background-color: #fc787e;
    }
    #dashboard .box-item > div:hover a{
        color: #fff;
    }
    #dashboard .box-item a {
        text-decoration: none;
        display: block;
    }

</style>
