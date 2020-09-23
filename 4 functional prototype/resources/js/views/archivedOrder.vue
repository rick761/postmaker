<template>    
    <v-row>
        <v-col cols=12 md=8>     
            <project-progress />         
            <order-info-component />                             
            <order-extra-description-component />
            <order-delivery-component />
            <order-chatbox-component />   
        </v-col>  

        <v-col cols=12 md=4>     
            <order-actions-component />    
            <order-aside-component />
            <order-files-moodboard-component />                 
        </v-col> 

    <order-delivery-open-component />    
    
    </v-row>    

</template>

<script>
import { mapState } from 'vuex';
  export default {
    computed:{

        ...mapState({
            order: state => state.order.data,
            requests: state => state.order.requests.list,
            auth: state => state.auth.user,
            tags : state => state.order.tags.list
        }),

        isOwner(){
            if(this.auth && this.order.user)
                return this.auth.id == this.order.user.id;
        },

        isPostmaker(){
            if(this.auth.type == 'postmaker' ){
                return 1;
            }
        }

    },
    data () {
        return {
            editModal:false,
            files:[{name:'docks.jpg'},{name:'docks.jpg'},{name:'docks.jpg'}],            
            load:false,            
            motivation:''
        }    
    },

    methods:{
        upload(){            
            this.load = true;
            setTimeout( () => {
                this.load = false;                
            }, 1000)
        },
        
    },
    created(){         
        this.$store.dispatch('order/get',this.$route.params.orderId);          
    }
  }
</script>
