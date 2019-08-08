<ul class="sidebar-nav mb-5">
    <li class="sidebar-brand">
        <a href="#"> پنل مدیریت <strong style="color: #7ad785">SO</strong><strong style="color: #96c1ff">MO</strong>
        </a>
    </li>


    <li class="sidebar-dropdown">
        <a href="{{route('admin')}}">
            <i class="fa fa-tachometer-alt ml-1"></i>
            <span>داشبورد</span>
        </a>
    </li>


    @if(Gate::check('edit_user') || Gate::check('add_user') || Gate::check('delete_user'))
        <li class="sidebar-dropdown">
            <a href="#">
                <i class="fas fa-user-shield ml-1"></i>
                <span>کاربران و دسترسی ها</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{route('user.list')}}">لیست کاربران</a>
                    </li>
                    @can('permission_access')
                        <li>
                            <a href="{{route('role.list')}}">مدیریت دسترسی</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
    @endif




    @if(Gate::check('edit_article') || Gate::check('add_article') || Gate::check('delete_article'))
        <li class="sidebar-dropdown">
            <a href="#">
                <i class="far fa-keyboard ml-2"></i>
                <span>مدیریت مطالب</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{route('article.group.list')}}">لیست گروه مطالب</a>
                    </li>
                    <li>
                        <a href="{{route('articles',['id' => '1'])}}">لیست مطالب</a>
                    </li>
                    <li>
                        <a href="{{route('new.content')}}">افزودن مطلب</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif




    @if(Gate::check('edit_product') || Gate::check('add_product') || Gate::check('delete_product'))
        <li class="sidebar-dropdown">
            <a href="#">
                <i class="fas fa-store-alt ml-1"></i>
                <span>مدیریت فروشگاه</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{route('category.list')}}">مدیریت دسته</a>
                    </li>

                    <li>
                        <a href="{{route('attribute.list')}}">مدیریت ویژگی</a>
                    </li>
                    <li>
                        <a href="{{route('color.list')}}">مدیریت رنگ</a>
                    </li>
                    <li>
                        <a href="{{route('brand.list')}}">مدیریت برند</a>
                    </li>
                    <li>
                        <a href="{{route('guarantee.list')}}">مدیریت گارانتی</a>
                    </li>
                </ul>
            </div>
        </li>



        <li class="sidebar-dropdown">
            <a href="#">
                <i class="fas fa-box-open ml-1"></i>
                <span>مدیریت محصولات</span>
            </a>
            <div class="sidebar-submenu">
                <ul>
                    <li>
                        <a href="{{route('product.list')}}">لیست محصولات</a>
                    </li>
                    <li>
                        <a href="{{route('add.product')}}">افزودن محصول جدید</a>
                    </li>
                    <li>
                        <a href="{{route('comment.list')}}">کامنت ها</a>
                    </li>
                </ul>
            </div>
        </li>
    @endif




    <li class="sidebar-dropdown">
        <a href="#">
            <i class="fas fa-cogs ml-1"></i>
            <span>مدیریت سایت</span>
        </a>
        <div class="sidebar-submenu">
            <ul>
                <li>
                    <a href="{{route('setting')}}">تنظیمات سایت</a>
                </li>
                <li>
                    <a href="{{route('customer.list')}}">مدیریت مشتریان</a>
                </li>
                <li>
                    <a href="{{route('posts')}}">مدیریت پیام ها</a>
                </li>
                <li>
                    <a href="{{route('slider')}}">مدیریت اسلایدر</a>
                </li>
                <li>
                    <a href="{{route('tag.list')}}">مدیریت تگ</a>
                </li>
            </ul>
        </div>
    </li>

</ul>


<script>
    // $('.sidebar-nav li').click(function () {
    //     if (this.getAttribute("data-id") != null){
    //
    //     }
    // });
</script>
