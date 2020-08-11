<template>
  <v-container fluid>
      
    <v-data-iterator
      :items="(authUser.type == 'Contentaanvrager')? orders_contentaanvrager : orders_postmaker "
      :items-per-page.sync="itemsPerPage"
      :page="page"
      :search="search"
      :sort-by="sortBy.toLowerCase()"
      :sort-desc="sortDesc"
      hide-default-footer
    >

    <!--TOOLBAR-->


      <template v-slot:header>
        <v-card flat tile class="mb-5">
        <v-card-text>
        
        <v-toolbar flat          
          class="mb-1"
        >
          <v-text-field
            v-model="search"
            clearable
            flat dense
            solo-inverted
            hide-details            
            label="Zoeken"
          ></v-text-field>

          <template v-if="$vuetify.breakpoint.mdAndUp">
            <v-spacer></v-spacer>
            <v-select
              v-model="sortBy"
              dense
              flat
              solo-inverted
              hide-details
              :items="keys"              
              label="Sorteren"
            ></v-select>

            <v-spacer></v-spacer>

            <v-btn-toggle
              v-model="sortDesc"
              mandatory
            >
              <v-btn
                small
                dense                
                icon
                :value="false" color="blue"
              >
                <v-icon>mdi-arrow-up</v-icon>
              </v-btn>
              <v-btn
                small
                dense                
                icon
                :value="true" color="blue"
              >
                <v-icon>mdi-arrow-down</v-icon>
              </v-btn>
            </v-btn-toggle>
          </template>
        </v-toolbar>
        </v-card-text>
        </v-card>
      </template>

<!--/TABLE-->
<template v-slot:default="props">
    <v-card tile flat class="mb-5">
      <v-card-text>
        <v-simple-table>
            <thead>
                <tr>
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'title' }" >Titel</th>  
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'created_at' }">Sinds</th> 
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'deliver' }">Tot</th>                  
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'state' }">Status</th>                    
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'postmaker_state' }">Postmaker status</th>  
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'user.first_name' }">Aanvrager</th>                
                    <th class="text-left" :class="{ 'blue--text': sortBy === 'postmaker.first_name' }">Postmaker</th>  
                    <th></th>
                </tr>
            </thead>       
            <tbody >          
                <tr v-for="(item, key) in props.items" :key="key" >   
                    <td>{{ item.title }}</td>   
                    <td>{{ formatDate(item.created_at) }}</td>                             
                    <td>{{ formatDate(item.deliver) }}</td>    
                    <td>
                        <span class="warning--text" v-if="item.state == 'create'">
                            Nieuw
                        </span>
                        <span class="primary--text" v-if="item.state == 'open'">
                            Open
                        </span>
                        <span v-if="item.state == 'in_progress'">
                            Wachten
                        </span>
                        <span class="success--text" v-if="item.state == 'accepted'">
                            geaccepteerd
                        </span>
                        <span class="warning--text"  v-if="item.state == 'declined'">
                            geweigerd
                        </span>
                        <span class="error--text" v-if="item.state == 'stop'">
                            Stoppen
                        </span>
                        <span color="success--text" v-if="item.state == 'payed'">
                            Betaald
                        </span>                    
                    </td>
                    <td>
                        <span  v-if="item.postmaker_state == 'in_progress'">
                            Bezig
                        </span>
                        <span class="success--text" v-if="item.postmaker_state == 'delivered'">
                            Opgeleverd
                        </span>
                        <span class="error--text" v-if="item.postmaker_state == 'stop'">
                            Stoppen
                        </span>
                        <span class="success--text" v-if="item.postmaker_state == 'payed'">
                            Betaling geverifieerd 
                        </span>                    
                    </td>   
                    <td>
                        {{ item.user.first_name }}
                    </td>                 
                    <td v-if="item.postmaker">
                        {{ item.postmaker.first_name }}
                    </td>
                    <td v-else></td>     
                    <td>
                        <v-btn :to="'/order/'+item.id" dark class="yellow darken-3" icon>
                            <v-icon>mdi-eye</v-icon>
                        </v-btn>
                    </td>
                </tr>                  
            </tbody>         
        </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<!--FOOTER-->
    <template v-slot:footer>
    <v-card tile flat class="mb-5 mt-5">
      <v-card-text>
        <v-row class="mt-2" align="center" justify="center">
          
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                dark
                text
                color="primary"
                class="ml-2"
                v-bind="attrs"
                v-on="on"
              >
                {{ itemsPerPage }}
                <v-icon>mdi-chevron-down</v-icon>
              </v-btn>
            </template>
            <v-list>
              <v-list-item
                v-for="(number, index) in itemsPerPageArray"
                :key="index"
                @click="updateItemsPerPage(number)"
              >
                <v-list-item-title>{{ number }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>

          <v-spacer></v-spacer>

          <span
            class="mr-4
            grey--text"
          >
            Page {{ page }} of {{ numberOfPages }}
          </span>
          <v-btn icon
            fab small
            dark
            color="blue darken-3"
            class="mr-1"
            @click="formerPage"
          >
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
          <v-btn icon small
            fab
            dark
            color="blue darken-3"
            class="ml-1"
            @click="nextPage"
          >
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>
      </template>
      
    </v-data-iterator>


  </v-container>
</template>

<script>
import {mapState} from 'vuex';
  export default {   

    data () {
      return {
        itemsPerPageArray: [4,8,12,16,20,24,26,30],
        search: '',
        filter: {},
        sortDesc: false,
        page: 1,
        itemsPerPage: 30,
        sortBy: 'name',
        keys: [
          {text:'Titel', value: 'title' },
          {text:'Opbrengst', value: 'payment' },
          {text:'Aanvrager', value: 'user.first_name' },    
          {text:'Postmaker', value: 'postmaker.first_name' },        
          {text:'Oplevering', value: 'deliver' },
          {text:'Aangemaakt', value: 'created_at' },     
          {text:'Status', value: 'state' },           
          {text:'Postmaker status', value: 'postmaker_state' },           
        ],        
      }
    },
    computed: {
        ...mapState({
            orders_contentaanvrager : state=> state.orders.orders_contentaanvrager,
            orders_postmaker : state=> state.orders.orders_postmaker,
            authUser: state => state.auth.user,
        }),
      numberOfPages () {
        var items= (this.authUser.type == 'Contentaanvrager')? this.orders_contentaanvrager : this.orders_postmaker 
        return Math.ceil(items.length / this.itemsPerPage)
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
      formatDate(string){
            const _date = new Date(string);
            var unix = Date.parse(string);                  
            var inPast = (Date.now() > unix)
            var inFuture= (Date.now() < unix)
            
            if(inFuture){
                var overXDays = Math.ceil((unix - Date.now()) / (1000 * 3600 * 24));                
                return _date.getDate()+'-'+_date.getMonth()+'-'+_date.getUTCFullYear()+' ('+overXDays+' dagen)';
            }

            if(inPast){                
                return _date.getDate()+'-'+_date.getMonth()+'-'+_date.getUTCFullYear();                              
            }    
      },
      newOrder(){
        this.$store.dispatch('orders/create');
      }   
    },
    created(){
      this.$store.dispatch('orders/myOrders');
    }      
  }
</script>