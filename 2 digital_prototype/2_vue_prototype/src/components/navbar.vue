<template>
    <v-col>
    <!-- <v-app-bar  flat light app>   
        <v-app-bar-nav-icon @click.stop="emit()" >
        </v-app-bar-nav-icon>    -->
        <!-- <v-toolbar-title thin>Postmaker</v-toolbar-title>         -->
        <!-- <v-spacer></v-spacer>   -->
        <!--NOTIFICATIONS-->
        <v-menu  light open-on-hover top offset-y>
            
            <template v-slot:activator="{ on, attrs }">
                <v-btn icon v-bind="attrs" v-on="on" >                     
                    <v-badge
                        :content="unread_notifications"
                        :value="unread_notifications"
                        color="orange"
                        overlap
                    >                
                        <v-icon v-if="notifications.list.length < 5">mdi-comment-outline</v-icon>
                        <v-icon v-else >mdi-comment-multiple-outline</v-icon>                
                    </v-badge>
                </v-btn>                
            </template>
            
            <v-list min-height="300"  v-if="notifications.list.length" >       
                <v-list-item style="background:white;" :class="{primary : !item.read, hasUrl: item.url}" @click="openUrl(item)" @mouseover="read(item)" light  v-for="(item,key) in notifications.list" :key="key">
                    <v-list-item-content>
                        <v-list-item-title >{{item.message}}</v-list-item-title>
                        <v-list-item-subtitle>{{formatDate(item.created_at)}}</v-list-item-subtitle>
                        
                    </v-list-item-content>
                </v-list-item>
            </v-list>           
        </v-menu>

        

        <v-btn @click="logout" icon>
          <v-icon>mdi-logout</v-icon>
        </v-btn>    

        <!-- <template v-slot:extension>
            <v-tabs align-with-title  v-model="tab" >
                        
            <v-tab to="/home" >
                <v-badge
                    color="error"
                    :content="ORDERS_PERSONAL_COUNT"
                > 
                 Mijn
                </v-badge>
            </v-tab>
            <v-tab v-if="ORDERS_REQUESTED_COUNT != 0"  to="/home/requested">
                <v-badge
                    color="error"
                    :content="ORDERS_REQUESTED_COUNT"
                >
                Aanvragen
                </v-badge>
            </v-tab>
            <v-tab to="/home/open">
                <v-badge
                    color="error"
                    :content="ORDERS_OPEN_COUNT"
                >
                Open posts
                </v-badge>
            </v-tab>
            </v-tabs>
      </template> -->
    
<!-- </v-app-bar>     -->
</v-col>
</template>

<script>
import {mapGetters,mapState} from 'vuex'
export default {
    data(){return {
        tab:0,
        show:false
    }},
    computed:{
       
        ...mapState({
            errors : state => state.errors,
            notifications : state => state.notifications 
        }),
         ...mapGetters({
            ORDERS_OPEN_COUNT: 'orders/ORDERS_OPEN_COUNT',
            ORDERS_PERSONAL_COUNT: 'orders/ORDERS_PERSONAL_COUNT',
            ORDERS_REQUESTED_COUNT: 'orders/ORDERS_REQUESTED_COUNT',
            unread_notifications: 'notifications/UNREAD_NOTIFICATIONS',
        }),        
    },
    props: ['value'], 
    methods:{
        emit(){
            this.$emit('input', !this.value);
        },
        logout(){
            this.$store.dispatch('auth/logout');
            this.$router.push('/'); 
        },
        formatDate(string){
            const _date = new Date(string);            
            return `${_date.getDate()}-${_date.getMonth()}-${_date.getUTCFullYear()} ${_date.getUTCHours()}:${_date.getMinutes()}`;    
        },
        openUrl(item){
            if(item.url){                         
                this.$router.push('/'+item.url, () => {});               
                this.$store.dispatch('order_page/load', this.$route.params.id )
            }
        },
        read(item){
            if(!item.read){
                this.$store.dispatch('notifications/read',item);
            }
        },
    }  
}
</script>