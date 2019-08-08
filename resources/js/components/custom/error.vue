<template>
    <div  v-if="error.length!=0" >
        <div class="alert alert-danger">
            <div v-for="item in error" >
                <div v-for="i in item " >
                    {{ i }}
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        name: "error",
        props: ['error'],
    }
</script>

<style scoped>

</style>