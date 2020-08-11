<template>
    <div>        

        <div v-if="loader" class="loader">        
            <!-- <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div> -->
        </div> 

        <div v-if="loader" id="skeleton">
            <div id="skeleton-header" style="padding-top:43px;" class="text-center mb-5 align-middle ">
                <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-secondary" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-success" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-danger" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-warning" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-info" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-light" role="status">
                <span class="sr-only">Loading...</span>
                </div>
                <div class="spinner-grow text-dark" role="status">
                <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="row wrapper">
                <div class="col-6" >                    
                    <div class="content">
                        <div class="block-title rounded" style="width:70%"> &nbsp;</div>

                         <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:65%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                        <div class="block rounded" style="width:65%"> &nbsp;</div>
                        <div class="block rounded" style="width:25%"> &nbsp;</div>
                        <div class="block rounded" style="width:67%"> &nbsp;</div>
                    </div>

                     <div class="content rounded">
                        <div class="block-title rounded" style="width:70%"> &nbsp;</div>
                        <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:25%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                        <div class="block rounded" style="width:25%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:25%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                    </div>

                </div>

                <div class="col-6"  >

                    <div class="content rounded">
                        <div class="block-title rounded" style="width:70%"> &nbsp;</div>
                        <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:65%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                    </div>

                     <div class="content rounded">
                        <div class="block-title rounded" style="width:70%"> &nbsp;</div>
                        <div class="block rounded" style="width:20%"> &nbsp;</div>
                        <div class="block rounded" style="width:88%"> &nbsp;</div>
                        <div class="block rounded" style="width:65%"> &nbsp;</div>
                        <div class="block rounded" style="width:35%"> &nbsp;</div>
                        <div class="block rounded" style="width:87%"> &nbsp;</div>
                    </div>
                    
                    
                </div>

            </div>

            
            

        </div>

    </div>
</template>

<script>
import {mapState} from 'vuex'

export default {
    computed:{
        ...mapState({
            loader : state => state.loader.skeleton
        })    
    }
}
</script>

<style scoped>

    #skeleton{
        background:#f5f5f5!important;
        position: absolute;
        height: 100vw;
        width: 100vw;
        z-index: 98;
        box-shadow: 0 999px 999px #f5f5f5!important;
    }

    #skeleton-header{
        height:113px;
        background: rgba(0,0,0,.12);
    }

    .block-title{
        background: rgba(0,0,0,.12);
        height:30px;
        margin:0 0 25px;
    }

    .block{
        background: rgba(0,0,0,.12);
        height:12px;
        margin:0 0 5px;
    }

    .content{
        background:#fff;
        padding:30px 15px;
        box-shadow: 0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12)!important;
        margin: 0 0 25px;
    }

    .rounded{
        border-radius: 6px;
    }

    .rounded-max{
        border-radius: 100%;
    }

    .loader{
        position: absolute;
        /* top:20vh; */
        /* left:50%;    */
        /* margin-left: -40px;      */
        z-index:99;       
    }

    .loader .spinner-border{
        height: 80vh;
        width: 10px;
    }

    .loaderBG{
            position: absolute;
            height: 100vw;
            width: 100vw;
            /* top: 50%;
            left: 50%; */
            background-color: rgba(0,0,0,.12);;
            /* margin-left: -156px;
            margin-top: -148px; */
            
            z-index: 10;
            box-shadow: 0px 0px 999999px 99999px #e8edf3;;
            /* border-radius: 100%; */

    }
    
</style>