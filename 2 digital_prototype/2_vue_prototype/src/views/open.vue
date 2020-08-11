<template>
  <v-container fluid>
    <v-data-iterator
      :items="items"
      :items-per-page.sync="itemsPerPage"
      :page="page"
      :search="search"
      :sort-by="sortBy.toLowerCase()"
      :sort-desc="sortDesc"
      hide-default-footer
    >

    <!--TOOLBAR-->    
      <template v-slot:header>
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
            label="Zoek"
          ></v-text-field>
          
          <template v-if="$vuetify.breakpoint.mdAndUp">
            <v-spacer></v-spacer>
            <v-select
              v-model="sortBy"
              flat dense
              solo-inverted
              hide-details
              :items="keys"              
              label="Sorteer"
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
      </template>
<!--/TOOLBAR-->


<!--ITEMS-->
      <template v-slot:default="props">
        <v-row>
          <v-col
            v-for="item in props.items"
            :key="item.name"
            cols="12"
            sm="6"
            md="4"
            lg="3"
          >
            <v-card flat tile style="height:100%;">
                <!--if img is set-->
                <v-img v-if="item.images[0]"
                    class="white--text align-end"
                    height="200px"
                    src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                >
                    <v-card-title :class="{ 'blue--text': sortBy === 'title' }" > {{ item.title }}</v-card-title>       
                </v-img>

                <!--no img-->
                <v-card-title                  
                v-if="!item.images[0]" 
                class="subheading font-weight-bold"
                :class="{ 'blue--text': sortBy === 'title' }"
                >
                    {{ item.title }}
                </v-card-title>
                <v-card-subtitle 
                >
                    van <span :class="{ 'blue--text': sortBy === 'user.first_name' }" >{{item.user.first_name}}</span>
                     <span :class="{ 'blue--text': sortBy === 'user.last_name' }" > {{item.user.last_name}}</span>
                </v-card-subtitle>

              <v-divider></v-divider>

              <v-list dense>
                  
                <v-list-item class="mb-6" v-if="item.description" >
                    <v-list-item-content style="max-height:100px"><i>{{item.description}}</i></v-list-item-content>                    
                </v-list-item>

                <v-list-item v-if="item.payment" >
                    <v-list-item-content :class="{ 'blue--text': sortBy === 'payment' }">Opbrengst</v-list-item-content>
                    <v-list-item-content class="align-end" :class="{ 'blue--text': sortBy === 'payment' }">{{ item.payment }}</v-list-item-content>
                </v-list-item>

                <v-list-item v-if="item.created_at" >
                    <v-list-item-content :class="{ 'blue--text': sortBy === 'created_at' }">Sinds</v-list-item-content>
                    <v-list-item-content class="align-end" :class="{ 'blue--text': sortBy === 'created_at' }">{{ formatDate(item.created_at) }}</v-list-item-content>
                </v-list-item>

                <v-list-item  v-if="item.deliver">
                    <v-list-item-content :class="{ 'blue--text': sortBy === 'deliver' }">Tot</v-list-item-content>
                    <v-list-item-content class="align-end" :class="{ 'blue--text': sortBy === 'deliver' }">{{ formatDate(item.deliver) }}</v-list-item-content>
                </v-list-item>                  
              </v-list>

              

              <v-card-actions >
                  <v-btn  :to="'/order/'+item.id"
                      text
                      color="success accent-4"
                  >
                      Bekijk
                  </v-btn>
              </v-card-actions>


            </v-card>
          </v-col>
        </v-row>
      </template>

<!--/ITEMS-->

<!--FOOTER-->
      <template v-slot:footer>
        <v-card tile flat class="mb-5">
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

<!--/FOOTER-->

<script>
import { mapState } from 'vuex'
  export default {
    data () {
      return {
        itemsPerPageArray: [4, 8, 12, 16],
        search: '',
        filter: {},
        sortDesc: false,
        page: 1,
        itemsPerPage: 16,
        sortBy: '',
        keys: [
          {text:'Titel', value: 'title' },         
          {text:'Voornaam', value: 'user.first_name' },
          {text:'Achternaam', value: 'user.last_name' },
          {text:'Oplevering', value: 'deliver' },
          {text:'Aangemaakt', value: 'created_at' },         
        ],        
      }
    },
    computed: {
      ...mapState({
            items : state => state.orders.orders_open,
      }),
      numberOfPages () {
        return Math.ceil(this.items.length / this.itemsPerPage)
      },
      filteredKeys () {
        return this.keys.filter(key => key !== `title` && key !== `user`)
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
        this.$store.dispatch('orders/openOrders');  
    }
  }
</script>