<template>
     <v-row>
         <v-col>
             <v-card  flat>
                <v-card-title>Opleveringen</v-card-title>
                <v-card-text  class="list">
                    <v-list>
                      <v-list-item v-for="(item,key) in deliverys.list" :key="key"> 
                          <v-list-item-icon>                            
                             <v-icon>mdi-file</v-icon>
                          </v-list-item-icon>
                          <v-list-item-content>                            
                            <v-list-item-title><a :href="public_path+'/'+item.file.url">{{item.title}}</a></v-list-item-title>
                          </v-list-item-content>
                      </v-list-item>    
                       <v-list-item v-if="!deliverys.list.length" > 
                           <p class="text-center" style="width:100%">Er zijn geen opleveringen</p>
                           
                       </v-list-item>                 
                    </v-list>
                </v-card-text>

                <v-form ref="form" v-if="authUser.id == order.postmaker.id">
                    <v-card-actions >
                        <v-row>
                            <v-col cols="12">
                                <v-file-input v-model="files" outlined multiple show-size counter label="File input"></v-file-input>
                            </v-col>
                            <v-col v-if="files.length">
                                <v-btn @click.prevent="uploadFiles" class="success">Opleveren</v-btn>
                                <v-btn @click.prevent="deleteFiles" class="ml-2 inverse">annuleren</v-btn>
                            </v-col>
                        </v-row>                        
                    </v-card-actions>

                    <v-card-text v-if="files.length">

                        <ul class=" list-group list-group-flush ">                    
                            <li class="list-group-item" v-for="(item,key) in files" :key="key">
                                <span class="mdi mdi-file-outline"></span> "{{item.name}}"
                            </li>
                        </ul>
                        
                    </v-card-text>
                </v-form>

             </v-card>
         </v-col>

        <!-- <div v-if="order.postmaker.id == authUser.id">           

            <hr class="mt-4 mb-4">

            <form ref="form" >

                <p>Lever bestanden op</p>                
            
                <div class="custom-file">
                    <input ref="files" v-on:change="handleFileUploads"  multiple type="file" class="custom-file-input" id="validatedCustomFile" required>
                    <label class="custom-file-label text-left" for="validatedCustomFile">Choose file...</label>
                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                </div>

                <p v-if="loader.loader9">
                    <span  class="text-primary spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>  Aan het uploaden...
                </p>

                <p v-if="files"> Weet u zeker dat u dit wilt uploaden? <small>U kunt ze niet meer verwijderen</small></p>
                <ul class=" list-group list-group-flush ">                    
                    <li class="list-group-item" v-for="(item,key) in files" :key="key">
                        <span class="mdi mdi-file-outline"></span> "{{item.name}}"
                    </li>
                </ul>
                
              
                <button v-if="files" class="mt-3 btn btn-success" @click.prevent="uploadFiles">Uploaden</button>
                <button v-if="files" class="mt-3 ml-1 btn btn-danger" @click.prevent="deleteFiles">annuleren</button>
            </form>

            
            <hr class="mt-4 mb-4">

            <p>Opgeleverde bestanden:</p>
            <ul class="mt-2 mb-2 list-group list-group-flush">
                <li v-for="(item,key) in deliverys.list" :key="key" class="list-group-item">
                    <a v-if="item.file" :href="public_path+'/'+item.file.url">
                        {{item.title}}
                    </a>                    
                </li>  
                <li v-if="!deliverys.list.length" class="list-group-item">
                    <i>*Er is nog niks opgeleverd</i>
                </li>              
            </ul>

        </div>

        

        <div v-if="hasPostmaker">
            <hr>
            <p>Opgeleverde bestanden</p>           

            <ul class="mt-2 mb-2 list-group list-group-flush">
                <li v-for="(item,key) in deliverys.list" :key="key" class="list-group-item">
                <a v-if="item.file" :href="public_path+'/'+item.file.url">
                        {{item.title}}
                    </a>           
                </li>   
                <li v-if="!deliverys.list.length" class="list-group-item">
                    <i>*Er is nog niks opgeleverd</i>
                </li>                    
            </ul>
        </div> -->


     </v-row>
</template>

<script>
import {mapState} from 'vuex';

export default {
     data: () => ({
        files:[],
        public_path : localStorage.getItem('server-public-path'),

      items: [
        {
          id: 1,
          name: 'Documenten',
          children: [
            { id: 2, name: 'Calendar : app' },           
          ],
        },        
      ],

    }),
    methods:{

        hasPostmaker:function(){
            return this.order.postmaker.id != null;
        },

        uploadFiles(){            
            let formData = new FormData();
            for( var i = 0; i < this.files.length; i++ ){
                let file = this.files[i];
                formData.append('files[' + i + ']', file);                
            }
            this.files = "";
            this.$store.dispatch('order_page/order/deliverys/upload', formData );
            this.files = [];
        },

        deleteFiles(){
            this.files = [];
        }

    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order,
            authUser : state => state.auth.user,
            loader : state => state.loader,
            deliverys : state => state.order_page.order.deliverys
        }),
    }
}
</script>

<style scoped>
    .list{        
        max-height:500px;
        overflow-y: scroll;
        overflow-x:auto;
    }
    
</style>