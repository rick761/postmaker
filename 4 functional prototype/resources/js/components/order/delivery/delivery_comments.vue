<template>
    <card >    
        <v-card-text id="chat" style="max-height:350px; overflow-y:auto" >
            <p v-if="!comments.length">Er zijn geen berichten</p>        
            <p 
                v-for="(comment,key) in comments" 
                :key="key" 
                :class="{'text-right': comment.user_id == auth.id}"
            >
                <span v-if="comment.user_id == auth.id">Ik: </span>          
                {{comment.text}}
            </p>     
        </v-card-text>
        <v-card-actions>          
            <v-text-field  
                class="ml-2"       
                label="Message"
                required
                v-model="text"
            ></v-text-field>                
            <v-btn @click="send" dark class="ml-2 primary">
                <v-icon>mdi-send</v-icon>
            </v-btn>           
        </v-card-actions>
    </card>
</template>

<script>
import {mapState} from 'vuex'
export default {

    data(){return{
        text: ''
    }},
    computed:{
        ...mapState({
            comments : state => state.order.delivery.comments.list,
            order : state => state.order,
            auth: state => state.auth.user
        })
    },
    methods:{
        send(){
            if(this.text != "")
                this.$store.dispatch('order/delivery/comments/comment', this.text);
                var container = document.getElementById("chat");
                container.scrollTop = container.scrollHeight;
            this.text = "";
        }
    },
    created(){
         this.$store.dispatch('order/delivery/comments/get');
    },
    updated(){
       var container = document.getElementById("chat");
       container.scrollTop = container.scrollHeight;
    }
}
</script>