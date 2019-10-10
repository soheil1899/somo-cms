<template>
    <div>
        <h4 class="admin-title py-3 px-4 mb-4">
            لیست تمامی کامنتها
        </h4>


        <!-- Comment Modal -->

        <div class="card mb-5" v-for="item in commentlist" :key="item.id">
            <div class="card-header row m-0 px-3">
                <div class="col-6 p-0">
                    <strong>
                        {{item.user['name']}}
                    </strong>
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

                <div class="col-6 p-0 icons" style="text-align: left">
                    <i title="پاسخ" @click="answer(item.id, item.title, item.product_id)" class="fas fa-reply fa-lg mr-2"
                       style="color: #00c111;"></i>
                    <i title="حذف" @click="deletecomment(item.id, item.parent_id)" class="fas fa-times-circle fa-lg mr-2" style="color: #EB3E37;"></i>
                    <i title="ویرایش" @click="edit(item.id, item.title, item.comment, item.product_id)" class="far fa-edit fa-lg mr-2"
                       style="color: #00B2C9;"></i>
                    <i title="انتشار" v-if="item.publish" @click="changepublish(item.id, item.publish, item.answer_flag)" class="far fa-check-circle fa-lg mr-2"
                       style="color: #5BB760;"></i>
                    <i title="عدم انتشار" v-else @click="changepublish(item.id, item.publish, item.answer_flag)" class="fas fa-ban fa-lg mr-2" style="color: #EB3E37;"></i>

                </div>


            </div>
            <div class="card-body">
                <strong>
                    {{item.title}}
                </strong>
                <p class="mt-2 mb-0" v-html="item.comment"></p>

            </div>

            <div v-if="item.answer_flag == true" class="mt-1 pr-5">
                <div v-for="childitem in commentchilds" style="border-right: 4px solid #ffed91" :key="childitem.id">
                    <div class="card mb-2 ml-1 mr-2" v-if="childitem.parent_id == item.id">
                        <div class="card-header row m-0 px-3">
                            <div class="col-6 p-0">
                                <strong>
                                    {{childitem.user['name']}}
                                </strong>
                                &nbsp;&nbsp;(
                                {{childitem.date}}
                                -
                                {{childitem.time}}
                                )
                            </div>

                            <div class="col-6 p-0 icons" style="text-align: left">
                                <i title="حذف" @click="deletecomment(childitem.id, childitem.parent_id)" class="fas fa-trash fa-lg mr-2" style="color: #EB3E37;"></i>
                                <i title="ویرایش" @click="edit(childitem.id, childitem.title, childitem.comment, childitem.product_id)"
                                   class="far fa-edit fa-lg mr-2" style="color: #00B2C9;"></i>
                                <i title="انتشار" v-if="childitem.publish && item.publish" @click="changepublish(childitem.id, childitem.publish, childitem.answer_flag)" class="far fa-check-circle fa-lg mr-2"
                                   style="color: #5BB760;"></i>
                                <i title="عدم انتشار" v-if="item.publish && childitem.publish == false" @click="changepublish(childitem.id, childitem.publish, childitem.answer_flag)" class="fas fa-ban fa-lg mr-2" style="color: #EB3E37;"></i>

                            </div>


                        </div>
                        <div class="card-body">
                            <strong>
                                {{childitem.title}}
                            </strong>
                            <p class="mt-2 mb-0" v-html="childitem.comment"></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- add & edit Modal -->
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{modaltitle}}
                        </h5>
                    </div>

                    <div class="modal-body" style="direction: ltr">
                        <input type="text" placeholder="عنوان پیام..." v-model="title" class="form-control mb-3" style="direction: rtl">

                        <editor v-model="text" ref="editor"
                                api-key="qc1sdre33bdx4lkj24aw4ffoeyx1rvbohr9ow2hzhjgfu2mi"
                                :init="{plugins: 'wordcount','directionality': 'rtl','height':250}"></editor>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="savecomment" class="btn btn-primary">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import moment from 'jalali-moment';
    import Editor from '@tinymce/tinymce-vue';

    export default {
        name: "CommentComponent",

        components: {
            'editor': Editor
        },
        data() {
            return {

                error: [],
                commentlist: [],
                commentchilds: [],
                text: '',
                modaltitle: null,
                title: null,
                commentid: null,
                answeredit: null,
                productid: null,
            }
        },


        methods: {

            changepublish(id, publish, answerflag){
                let that = this;
                let data = {
                    commentid: id,
                    publish: publish,
                    answerflag: answerflag,
                };
                axios.post('/dashboard/changepublish', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },


            deletecomment(id, parentid){
                let that = this;
                let data = {
                    commentid: id,
                    parentid: parentid,
                };
                axios.post('/dashboard/deletecomment', data)
                    .then(function (response) {
                        that.reloadPage();
                    });
            },

            answer(id, title, proid) {
                this.productid = proid;
                this.text = '';
                this.title = null;
                this.commentid = id;
                this.answeredit = 'answer';
                $('#Modal').modal('show');
                this.modaltitle = 'پاسخ به نظر '+ title;
            },

            edit(id, title, comment, proid) {
                this.productid = proid;
                this.text = comment;
                this.title = title;
                this.commentid = id;
                this.answeredit = 'edit';
                $('#Modal').modal('show');
                this.modaltitle = 'ویرایش نظر';
            },



            savecomment(){

                let that = this;
                let data = {
                    commentid: this.commentid,
                    answeredit: this.answeredit,
                    title: this.title,
                    text: this.text,
                    productid: this.productid,
                };
                axios.post('/dashboard/savecomment', data)
                    .then(function (response) {
                        $('#Modal').modal('toggle');
                        that.reloadPage();
                    });
            },




            reloadPage() {
                let that = this;
                let data = {
                    productid: this.productid,
                };
                axios.post('/dashboard/getcomments', data)
                    .then(function (response) {

                        that.commentlist = response.data[0];
                        for (var i = 0; i < that.commentlist.length; i++) {
                            that.commentlist[i]['time'] = (that.commentlist[i]['created_at']).slice(11, 16);
                            that.commentlist[i]['date'] = moment((that.commentlist[i]['created_at']).slice(0, 10), 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD');

                        }

                        that.commentchilds = response.data[1];
                        for (var i = 0; i < that.commentchilds.length; i++) {
                            that.commentchilds[i]['time'] = (that.commentchilds[i]['created_at']).slice(11, 16);
                            that.commentchilds[i]['date'] = moment((that.commentchilds[i]['created_at']).slice(0, 10), 'YYYY/MM/DD').locale('fa').format('YYYY/MM/DD');

                        }

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