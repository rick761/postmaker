<template>      
    <v-row>
        <v-col>            
            <v-data-iterator 
                :items="orders" 
                :items-per-page.sync="itemsPerPage" 
                :page="page" 
                :search="search" 
                :sort-by="sortBy.toLowerCase()" 
                :sort-desc="sortDesc" 
                hide-default-footer
            >
                        
                        <!--TOOLBAR-->                            
                        <template v-slot:header>
                            <card>
                                <v-toolbar flat >
                                <v-text-field v-model="search" clearable flat dense solo-inverted hide-details label="Zoek"></v-text-field>                            
                                <template v-if="$vuetify.breakpoint.mdAndUp">
                                    <v-spacer></v-spacer>
                                    <v-select v-model="sortBy" flat dense solo-inverted hide-details :items="keys" label="Sorteer"></v-select>
                                        <v-spacer></v-spacer>
                                        <v-btn-toggle v-model="sortDesc" mandatory >
                                            <v-btn icon small depressed color="blue" :value="false" >
                                                <v-icon>mdi-arrow-up</v-icon>
                                            </v-btn>
                                            <v-btn icon small depressed color="blue" :value="true" >
                                                <v-icon>mdi-arrow-down</v-icon>
                                            </v-btn>
                                        </v-btn-toggle>
                                    </template>
                                </v-toolbar>
                            </card>
                        </template>                      
                        <!--/TOOLBAR-->
                    
                    <!---- items -->
                    <template v-slot:default="props">
                        
                        <v-row class="mb-5">
                            
                            <v-col v-for="(item, key) in props.items" :key="key" cols="12"  md="6" lg="4" >

                                <card height="100%" >   
                             
                                    <!--title-->
                                    <v-card-title class="text-truncate subheading font-weight-bold" :class="{ 'blue--text': sortBy === 'title' }" >
                                         <v-icon class="accent--text">mdi-{{item.type}}</v-icon> &nbsp;
                                         {{item.title}}
                                         
                                    </v-card-title>

                                 
                                    <v-img 
                                        v-if="GetAnImageUrl(item.order_files)"
                                        :src="`/storage/${item.user.id}/order_files/${item.id}/${GetAnImageUrl(item.order_files)}`"
                                    ></v-img>        

                                   <v-divider  v-if="!GetAnImageUrl(item.order_files)"></v-divider>                                                                    

                                    <v-list dense style="background:transparent">

                                        <div style="padding: 0 16px;" v-if="item.order_tags && item.order_tags.length">
                                            
                                            <v-chip @click="search=item.text" class="mr-1 mb-1" v-for="(item,key) in item.order_tags" :key="key">
                                                #{{item.text}}
                                            </v-chip>                                           

                                        </div>

                                        <v-divider v-if="item.order_tags && item.order_tags.length"></v-divider>

                                        <v-list-item v-if="item.deliver">

                                            <v-list-item-icon :class="{
                                                'error--text': dateDiffInDays(item.deliver) <= 10, 
                                                'warning--text': dateDiffInDays(item.deliver) > 10 && dateDiffInDays(item.deliver) <= 20, 
                                                'primary--text': dateDiffInDays(item.deliver) > 20 && dateDiffInDays(item.deliver) <= 30,
                                                '': dateDiffInDays(item.deliver) > 30 
                                            } ">

                                                <v-icon :class="{
                                                    'error--text': dateDiffInDays(item.deliver) <= 10, 
                                                    'warning--text': dateDiffInDays(item.deliver) > 10 && dateDiffInDays(item.deliver) <= 20, 
                                                    'primary--text': dateDiffInDays(item.deliver) > 20 && dateDiffInDays(item.deliver) <= 30,
                                                    '': dateDiffInDays(item.deliver) > 30 
                                                    } ">mdi-calendar</v-icon>  
                                                    {{dateDiffInDays(item.deliver)}}
                                                    &nbsp; 
                                            </v-list-item-icon>            

                                            <v-list-item-content class="text-right"   >
                                                <span class="float-right" :class="{ 'blue--text': sortBy === 'deliver' }">{{item.deliver}}</span>
                                            </v-list-item-content>  

                                        </v-list-item> 

                                        <!-- <v-list-item :to="'/account/'+item.user.id"> -->
                                        <v-list-item @click="search = item.user.display_name"  >

                                             <v-list-item-avatar v-if="item.user.avatar" >
                                                <v-img  :src="'./storage/'+item.user.id+'/avatar/'+item.user.avatar" ></v-img>                                                
                                            </v-list-item-avatar>

                                            <v-list-item-icon v-else>
                                                <v-icon >mdi-account</v-icon>
                                            </v-list-item-icon>

                                            <v-list-item-content class="text-right">
                                                <span class="float-right" :class="{ 'blue--text': sortBy === 'user.display_name' }" >{{item.user.display_name}}</span>
                                            </v-list-item-content>                                              
                                        </v-list-item>

                                    </v-list>
                                    <v-spacer></v-spacer>
                                    <v-card-actions >
                                        <v-spacer></v-spacer>
                                        <v-btn text :to="'/order/open/'+item.id"  color="accent accent-4" >                                            
                                            open
                                        </v-btn>
                                    </v-card-actions>

                                </card>

                            </v-col>

                        </v-row>

                    </template>
                    <!--FOOTER-->

                    <template v-slot:footer>
                        <card>
                        <v-card-text>
                            <v-row class="mt-2" align="center" justify="center">          
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-btn dark text color="primary" class="ml-2" v-bind="attrs" v-on="on" >
                                        {{ itemsPerPage }}
                                        <v-icon>mdi-chevron-down</v-icon>
                                    </v-btn>
                                    </template>
                                    <v-list>
                                    <v-list-item v-for="(number, index) in itemsPerPageArray" :key="index" @click="updateItemsPerPage(number)" >
                                        <v-list-item-title>{{ number }}</v-list-item-title>
                                    </v-list-item>
                                    </v-list>
                                </v-menu>
                                <v-spacer></v-spacer>
                                <span class="mr-4 grey--text" >
                                    Pagina {{ page }} of {{ numberOfPages }}
                                </span>
                                <v-btn icon small fab dark color="blue darken-3" class="mr-1" @click="formerPage" >
                                    <v-icon>mdi-chevron-left</v-icon>
                                </v-btn>
                                <v-btn icon small fab dark color="blue darken-3" class="ml-1 mr-5" @click="nextPage" >
                                    <v-icon>mdi-chevron-right</v-icon>
                                </v-btn>
                            </v-row>
                        </v-card-text>
                        </card>   
                    </template>
                <!--/FOOTER-->
                </v-data-iterator>                    
            </v-col>
        </v-row>
      
</template>

<script>

import {mapState} from 'vuex'

export default {
    data(){return{
        itemsPerPageArray: [12, 48, 96, 192],            
        search: '',
        filter: {},
        sortDesc: false,
        page: 1,
        itemsPerPage: 12,
        sortBy: '',
        keys: [
            {text:'Naam', value:'title'},                   
            {text:'Deadline',value:'deliver'},
            {text:'Gebruiker',value:'user.display_name'},            
        ],        
    }},
    computed: {

        ...mapState({
            orders : state => state.orders.open
        }),        

        numberOfPages () {            
            return Math.ceil(this.orders.length / this.itemsPerPage)
        },

        filteredKeys () {
            return this.keys.filter(key => key !== `Name`)
        },    

    },
    methods: {
       
        nextPage () {
            if (this.page + 1 <= this.numberOfPages) this.page += 1
        },

        formerPage () {
            if (this.page - 1 >= 1) this.page -= 1
        },

        updateItemsPerPage (number) {
            this.itemsPerPage = number
        },

        dateDiffInDays(b) {            
            const _MS_PER_DAY = 1000 * 60 * 60 * 24;
            const utc1 = new Date();//Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
            const utc2 = new Date(b);          
            return Math.floor((utc2 - utc1) / _MS_PER_DAY);
        },

        GetAnImageUrl(list){            
            if(list.length){                          
                var newList = list.filter(function(file){
                    if(!file.url) return;
                    var allowedExtension = ['jpg','png']    
                    var ext = file.url.split('.')[file.url.split('.').length-1].toLowerCase();
                    for(var i in allowedExtension){
                        if(allowedExtension[i] == ext){
                            return file;
                        }
                    }
                });
                if(newList.length){
                    return newList[0].url;
                }
            }            
        },
    },
    created(){
        this.$store.dispatch('orders/getAvailable');
    }
}
</script>