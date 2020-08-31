<template>
    <card >    
        <v-card-text v-if="messages.length == 0">Er zijn geen berichten </v-card-text>         
        <v-list id="chatbox" v-else style="max-height:500px; overflow-y:auto">
             <v-list-item v-for="(message,key) in messages" :key="key">
                 
                <v-list-item-avatar 
                    v-if=" message.user_id != auth.id " 
                    size="48" 
                    color="grey" 
                >  
                    <img v-if="isRequester && postmakerAvatarUrl"                       
                        :src="postmakerAvatarUrl"
                        :alt="'Error'"
                    >
                    <img v-else-if="!isRequester && requesterAvatarUrl"                       
                        :src="requesterAvatarUrl"
                        :alt="'Error'"
                    >
                    <v-icon v-else >mdi-account</v-icon>
                </v-list-item-avatar> 
               
                <v-list-item-content>
                    <v-list-item-title :class="{'text-right': message.user_id == auth.id }" >{{message.text}}</v-list-item-title>
                    <v-list-item-title 
                        v-if="message.url"
                        :class="{'text-right': message.user_id == auth.id }" 
                    >
                        <a href="#">{{message.url}}</a>
                    </v-list-item-title>
                </v-list-item-content> 

                <v-list-item-avatar 
                    v-if=" message.user_id == auth.id " 
                    size="48" 
                    color="grey" 
                >  
                    <img  v-if="myAvatarUrl"                       
                        :src="myAvatarUrl"
                        :alt="'Error'"
                    >
                    <v-icon v-else >mdi-account</v-icon>
                </v-list-item-avatar> 


            </v-list-item>                 
        </v-list> 

        <v-card-actions>                
                  
            <v-text-field  class="ml-2"       
                label="Message"
                required
                v-model="textField"
            ></v-text-field>    

            <span v-if="selectedFile">       
                <v-chip @click:close="selectedFile=null" close>{{selectedFile.name}}</v-chip>
            </span>

            <v-btn icon dark class="ml-2 primary"
                @click="send"
                @keydown.enter="send"
            >
                <v-icon                 
                >mdi-send</v-icon>
            </v-btn>            
            <div>
                <v-btn
                    dark               
                    class="text-none primary ml-2"                    
                    depressed   
                    @click="fileUpload"   
                    icon       
                >
                    <v-icon>
                    mdi-file
                    </v-icon>                
                </v-btn>            
                <input
                    ref="uploader"
                    class="d-none"
                    type="file"
                    accept="image/*"                    
                    @change="onFileChanged"
                >
            </div>
            
        </v-card-actions>
    </card>
</template>

<script>
import {mapState} from 'vuex'
export default {
    computed:{
        ...mapState({
            messages : state => state.order.messages.list,
            order: state => state.order.data,
            auth: state => state.auth.user,
        }),
        postmakerAvatarUrl(){
            if(this.order.postmaker.avatar)
                return './storage/'+this.order.postmaker.id+'/avatar/'+this.order.postmaker.avatar;
        },
        requesterAvatarUrl(){
            if(this.order.user.avatar)
                return './storage/'+this.order.user.id+'/avatar/'+this.order.user.avatar;
        },
        myAvatarUrl(){
            if(this.auth.avatar)
                 return './storage/'+this.auth.id+'/avatar/'+this.auth.avatar;
        },
        isRequester(){
            return this.auth.type == 'requester';
        }
    },
    data(){return{
        selectedFile: null,
        isSelecting: false,
        textField:'',        
    }},
    methods:{
        
        fileUpload() {
            this.isSelecting = true
            window.addEventListener('focus', () => {
                this.isSelecting = false
            }, { once: true })

            this.$refs.uploader.click()
        },

        onFileChanged(e) {
         this.selectedFile = e.target.files[0]
        },

        send(){
            if(this.textField != '' || this.selectedFile != null ){
                this.$store.dispatch('order/messages/send', 
                { msg:this.textField, file: this.selectedFile } );
            }
            this.textField = '';
            this.selectedFile = null;
        }

    },
    updated(){
       var container = document.getElementById("chatbox");
       container.scrollTop = container.scrollHeight;
    }
}
</script>
