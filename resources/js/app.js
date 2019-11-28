
require('./bootstrap');

window.Vue = require('vue');
window.axios=require('axios');

import tinymce from 'vue-tinymce-editor';
Vue.component('tinymce', tinymce);


Vue.component('dashboard-component', require('./components/admin/DashboardComponent.vue').default);
Vue.component('myinfo-component', require('./components/admin/users/MyinfoComponent.vue').default);
Vue.component('user-component', require('./components/admin/users/UserComponent.vue').default);
Vue.component('userinfo-component', require('./components/admin/users/UserInfoComponent.vue').default);
Vue.component('role-component', require('./components/admin/users/RoleComponent.vue').default);




Vue.component('articlegroup-component', require('./components/admin/article/ArticleGroupComponent.vue').default);
Vue.component('article-component', require('./components/admin/article/ArticleComponent.vue').default);
Vue.component('article-contents-component', require('./components/admin/article/ArticleContentComponent.vue').default);
Vue.component('article-content-new-component', require('./components/admin/article/ArticleContentNewComponent.vue').default);
Vue.component('article-video', require('./components/admin/article/video/ArticleVideo.vue').default);




Vue.component('category-component', require('./components/admin/store/CategoryComponent.vue').default);
Vue.component('myattribute-component', require('./components/admin/store/AttributeComponent.vue').default);
Vue.component('color-component', require('./components/admin/store/ColorComponent.vue').default);
Vue.component('guarantee-component', require('./components/admin/store/GuaranteeComponent.vue').default);
Vue.component('brand-component', require('./components/admin/store/BrandComponent.vue').default);
Vue.component('tag-component', require('./components/admin/setting/TagComponent.vue').default);
Vue.component('product-component', require('./components/admin/product/ProductComponent.vue').default);
Vue.component('add-product-component', require('./components/admin/product/AddProductComponent.vue').default);
Vue.component('product-comment-component', require('./components/admin/product/ProductCommentComponent.vue').default);
Vue.component('comment-component', require('./components/admin/product/CommentComponent.vue').default);
Vue.component('slider-component', require('./components/admin/setting/SliderComponent.vue').default);

Vue.component('setting-component', require('./components/admin/setting/SettingComponent.vue').default);

Vue.component('customer-component', require('./components/admin/setting/CustomerComponent.vue').default);
Vue.component('post-component', require('./components/admin/setting/PostComponent.vue').default);
Vue.component('menugroup-component', require('./components/admin/setting/MenugroupComponent.vue').default);
Vue.component('menu-component', require('./components/admin/setting/MenuComponent.vue').default);














Vue.component('error', require('./components/custom/error.vue').default);






const app = new Vue({
    el: '#app',
});





/* npms

npm install verte --save


*/
