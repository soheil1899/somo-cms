<template>
    <div>
        <div class="modal fade" id="videomodal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ویدیو مطلب
                            {{articletitle}}
                        </h5>
                    </div>

                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header row m-0 p-1 pt-2">
                                <div class="col-8">
                                    ویدئو مطلب
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div id="myId" class="dropzone">
                                </div>

                                <div class="row mt-3">
                                    <div v-for="(item, index) in movies" :key="item.id" class="col-4 position-relative">
                                        <i title="حذف" @click="deletevideo(item.id, item.name)"
                                           class="fas fa-times-circle fa-lg position-absolute deletevideo"></i>
                                        <video width="100%" controls>
                                            <source :src="videosrc(item.name)">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer py-2">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import dropzone from 'dropzone';
    import Swal from 'sweetalert2';

    export default {
        name: "ArticleVideo",
        props:['articleid' , 'articletitle'],
        data(){
            return{
                error: [],
                movies: [],
            }
        },
        components:{
            'dropzone': dropzone,
            'Swal': Swal,
        },
        methods:{
            deletevideo(id, name){
                let that = this;
                let data = {
                    articleid : this.articleid,
                    videoid : id,
                    videoname : name,
                };
                axios.post('/dashboard/deletevideo', data)
                    .then(function (response) {
                        that.getmovie();
                    });
            },
            videosrc(name){
                return '/media/article/'+ this.articleid + '/video/'+ name;
            },
            getmovie(){
                let that = this;
                let data = {
                    articleid : this.articleid,
                };
                axios.post('/dashboard/getvideos', data)
                    .then(function (response) {
                        that.movies = response.data;
                    });
            }
        },
        mounted() {
            this.getmovie();

            $('#videomodal').modal('show');

            let that = this;

            var token = $('meta[name=csrf-token]').attr("content");
            var myDropzone = new dropzone("div#myId", {
                url: "/dashboard/upload/"+ that.articleid + "/article",
                chunking: true,
                method: "POST",
                maxFilesize: 400000000,
                chunkSize: 1000000,
                parallelChunkUploads: false,
                headers: {'X-CSRF-TOKEN':token},
                acceptedFiles:'.mp4',
            });
            myDropzone.on('sending', function(file, xhr, formData){

            });

            myDropzone.on("complete", function (file) {
                Swal.fire({
                    text: 'ویدیو با موفقیت آپلود شد',
                    type: 'success',
                    showConfirmButton: false,
                    timer: 1300
                });
                that.getmovie();

            });
        }
    }
</script>

<style scoped>

    .deletevideo{
        top: 10px;
        right: 25px;
        background-color: #fff;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
    }
</style>
