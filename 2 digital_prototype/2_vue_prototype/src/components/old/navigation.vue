<template>
    <div>
        <nav  class="wrapper">
            <div style="margin-top:5px;" class="float-right ">
                <h5 style="display:inline; margin-right:20px" class="">{{currentroute}}</h5>
            </div>

            <router-link to="/">
                <h1 style="margin-left:20px;" class="">Postmaker</h1>
            </router-link>

                <ul>                     
                    <li style="margin-right:20px" class="ml-3 nav-item right">
                        <a href="javascript:void(0)" class="" @click='logout'>
                             Log uit 
                        </a>
                    </li> 

                    <li class=" ml-3 nav-item right">
                        <router-link tag="a" class="  " to="/account">
                            {{authUser.first_name}}
                        </router-link>
                    </li>
                     

                    <li class=" ml-3 nav-item right">
                        <router-link class=" right " to="/archief">
                            Archief
                        </router-link>
                    </li>

                    <li class=" ml-3  nav-item right">
                        <router-link as class=" right " to="/financien">
                            Financien 
                        </router-link>
                    </li>  

                    <li class=" ml-3 nav-item right active">
                        <a id="notification_link" @click="notificationBox = !notificationBox" class="  " href="javascript:void(0)">
                            <span v-if="unread_notifications" class="badge badge-danger">{{ unread_notifications}}</span> Notificaties 
                        </a>
                        <notifications v-model="notificationBox"/>
                    </li>
                    
                     <li v-if="errors.list.length"  class="ml-3 nav-item right active">
                        <a @click="openErrorBox"  class="" href="javascript:void(0)" >    
                            Foutmeldingen
                            <span class="badge badge-danger">{{errors.list.length}}</span>
                        </a>       
                        <error-messages v-model="errorBox"/>                  
                    </li>
                </ul> 
        </nav>   
        
        
    </div>    
</template>

<script>
import {mapState, mapGetters} from 'vuex'
import errorMessages from './errorMessages'
import notifications from './notifications'

export default {
    props:['currentroute'],
    
    computed:{
        ...mapState({
                authUser : state => state.auth.user,
                errors : state => state.errors,
                notifications : state => state.notifications                
            }            
        ),
        ...mapGetters({
            unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
        })

    },
    data(){return{
        errorBox:0,
        notificationBox:0
    }},
    methods:{

        logout(){
            console.log('loguit');
            this.$store.dispatch('auth/logout')
        },

        openErrorBox(){
            console.log('123')
            this.errorBox= !this.errorBox;
        }

    },
    components:{
        errorMessages,
        notifications
    }     
}
</script>

<style scoped>

#navbarNav {
    right: 0;
    z-index: 999;
    position: absolute;
     width: 100%;      
}

.container{
    padding-top:20px;
    padding-bottom:0;    
}

ul {    
    margin:0;
    padding:0;
    position: relative;
    height:35px;
    list-style-type: none;
}

ul li {   
    display: inline-block;
    width: auto;
    list-style-type: none;
    margin: 0 0 0 0px;
    font-size: 12px;
}

.navbar-collapse ul li{
    text-align: right;
    vertical-align: center;
}

</style>