<template>
    <v-row>
        <v-col>
            <v-card flat>
                <v-card-title>Afbeeldingen</v-card-title>
                
                <v-card-actions>
                    <v-file-input chips show-size counter multiple v-model="files"  />
                    <v-btn @click="uploadImages" class="mx-2" dark  color="primary">
                        <v-icon dark>mdi-upload</v-icon>
                        Upload
                    </v-btn>
                </v-card-actions>
                <v-card-text>                    
                    <v-row>
                        <v-col v-for="(item,key) in images.list" :key="key" class="d-flex child-flex" cols="4"                        >
                        <v-card flat tile class="d-flex">
                            <v-img :src="public_path+'/'+item.url" aspect-ratio="1" class="grey lighten-2" >
                                <v-btn @click="remove(item.id)" class="m-2" fab dark small color="primary">
                                    <v-icon dark>mdi-minus</v-icon>
                                </v-btn>
                            </v-img>
                        </v-card>
                        </v-col>
                    </v-row>

                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
     <!-- <collapse title="Afbeeldingen" >

            

            <form ref="form">

               
                <input class="form-control mb-2" placeholder="(optioneel) Bestandsnaam" v-model="fileName" name="Filename" /> 
                
                <label>File upload</label>

                <div class="custom-file text-left">                
                    <input ref="files" v-on:change="handleFileUploads" multiple type="file" class="custom-file-input" id="inputGroupFile03">
                    <label class="custom-file-label" for="inputGroupFile03">voeg een afbeelding toe</label>                                            
                </div>

                
                    <div class="m-3" v-if="files">                                               
                        <ul class=" list-group list-group-flush ">
                            <li class="list-group-item" v-for="(item,key) in files" :key="key">
                               <span class="mdi mdi-file-outline"></span> "{{item.name}}"
                            </li>
                        </ul>
                        <button class="mt-3 btn btn-success" @click.prevent="uploadImages">Uploaden naar de server</button>
                        <hr>
                    </div>
                

                <div class="text-right">               
                    <p class="text-success" v-if="!loader.loader3">Slaat automatisch op.</p>
                    <p class="text-primary" v-if="loader.loader3">
                    <span class=" text-primary spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Aan het laden...
                    </p>                
                </div>

            </form>

            <transition-group class="row" name="collapse">                  
                <div class="col-6"  v-for="(item,index) in images.list" :key="index">

                    <div class="img" width="100%" :style="
                        `background-image:url('`+public_path+'/'+item.url+`')`                    
                    ">                     
                        <a @click="remove(item.id)" href="javascript:void(0)" class="float-right btn btn-sm btn-danger ">x</a>
                    </div>              

                    <hr class="mt-2 mb-2">    

                </div> 
            </transition-group>

        </collapse> -->
</template>

<script>
import {mapState} from 'vuex'

export default {

    data(){return{
        files:[],
        public_path : localStorage.getItem('server-public-path')
    }},

    components:{        
                
    },

    methods:{
        remove(id){
            this.$store.dispatch('order_page/order/images/delete', id );
        },

        uploadImages(){            
            let formData = new FormData();
            for( var i = 0; i < this.files.length; i++ ){
                let file = this.files[i];
                formData.append('files[' + i + ']', file);
            }
            this.files = [];
            this.$store.dispatch('order_page/order/images/upload', formData );
        },
        
        handleFileUploads(){            
            this.files = this.$refs.files.files; 
        }
    },
    computed:{
        ...mapState({  
            images : state => state.order_page.order.images,
            loader : state=> state.loader
        })
    } 
}

</script>

<style scoped>
.img{
    height:200px;
    background-size:cover;
    background-repeat: no-repeat;
    padding: 15px 30px;
}

</style>