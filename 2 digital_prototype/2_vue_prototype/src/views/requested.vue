<template>
  <v-container fluid>
      
    <v-data-iterator
      :items="orders_requested"
      :items-per-page.sync="itemsPerPage"
      :page="page"
      :search="search"
      :sort-by="sortBy.toLowerCase()"
      :sort-desc="sortDesc"
      hide-default-footer
    >

    <!--TOOLBAR-->
      <template v-slot:header>
      <v-card tile flat class="mb-5">
      <v-card-text>
        <v-toolbar
           flat           
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
              flat dense
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
              <v-btn icon
                small
                depressed
                color="blue"
                :value="false"
              >
                <v-icon>mdi-arrow-up</v-icon>
              </v-btn>
              <v-btn icon
                small
                depressed
                color="blue"
                :value="true"
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
                <th class="text-left" :class="{ 'blue--text': sortBy === 'deliver' }">Deadline</th>                                 
                <th class="text-left" :class="{ 'blue--text': sortBy === 'user.first_name' }">
                  
                  <div v-if="authUser.type == 'Contentaanvrager'">
                        Aantal aanvragen
                  </div>
                  <div v-else> 
                        Motivatie
                  </div>
                </th> 
                <th></th>  
            </tr>
        </thead>
        <tbody>
            <tr to="/" v-for="(item, key) in props.items" :key="key" >                 
                <td>{{ item.title }}</td>                   
                <td>{{ formatDate(item.deliver) }}</td>      
                <td>                    
                    <div v-if="authUser.type == 'Contentaanvrager'">
                        {{item.requests.length}}
                    </div>

                    <div v-if="authUser.type == 'Postmaker'">
                        {{item.requests[0].text}}
                    </div>

                </td> 
                <td>
                    <v-btn :to="'/order/'+item.id" dark class="primary" icon>
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
          <v-btn icon small
            fab
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
            orders_requested: state=> state.orders.orders_requested,            
            authUser: state => state.auth.user,
        }),
      numberOfPages () {
        var items= this.orders_requested 
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
        }   
    },
    created(){
        this.$store.dispatch('orders/requestedOrders');  
    }
  }
</script>