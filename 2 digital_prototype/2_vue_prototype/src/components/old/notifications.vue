<template>   
     <transition name="collapse"> 
            <div v-if="value"  id="notification" class="card-box card" > 

                <div class="">    
                    <a href="javascript:void(0)" @click="emit" class="close float-right">
                        <b>
                            <span class="text-danger mdi mdi-close"></span>
                        </b>
                    </a>   
                </div>
            
            
                <ul class="list-group list-group-flush">                     
                    <li @click="openUrl(item)" @mouseover="read(item)" v-for="(item,key) in notifications.list" :key="key" :class="{active: !item.read, hasUrl: item.url}" class="list-group-item">
                            <div> {{item.message}} </div> 
                            <div class="right"> {{formatDate(item.created_at)}}</div>                                        
                    </li>     
                    <li class="list-group-item" v-if="!notifications.list.length" >
                            Er zijn geen notificaties
                    </li>                                   
                </ul>
            
                <div class="card-body">            
                    <a href="#" @click="emit" class="card-link text-primary">Sluit</a>
                </div>

            </div>  

        </transition>   
</template>

<script>
import {mapState} from 'vuex';
export default {
    props:['value'],                
    methods:{
        emit(){            
            this.$emit('input', false);
        },
        clear(){
            console.log('clear');
        },
        read(item){
            if(!item.read){
                this.$store.dispatch('notifications/read',item);
            }
        },
        openUrl(item){
            if(item.url){
                console.log(this.$router.go(item.url));
                
            }
        },
        formatDate(string){
            const _date = new Date(string);            
            return `${_date.getDate()}-${_date.getMonth()}-${_date.getUTCFullYear()} ${_date.getUTCHours()}:${_date.getMinutes()}`;    
        }
    },    
    computed:{    
        ...mapState({
            notifications : state => state.notifications
        })
    },  
}
</script>

<style scoped>
    ul{
        max-height:40vh;
        overflow: auto;
    }
    li{
        margin-bottom:2px;
        
    }

    #notification{
        position: absolute;
        z-index: 9999;    
        min-width:20vw
    }

    .close{
        text-align: right;
        height: 65px;
        width: 65px;
        padding-right: 10px;
        line-height: 60px;
        margin-right:20px
        /* padding-bottom: 10px;         */
    }

    .card-box, .card{
        margin:0;
        padding:0;        
    }

    .hasUrl{
        cursor: pointer;
        color:#007bff;
    }

    .active{
        color:white;
    }
    
</style>