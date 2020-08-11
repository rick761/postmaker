<template>
      
        <v-row>


            <v-col>
                 
                    <v-data-iterator :items="items" :items-per-page.sync="itemsPerPage" :page="page" :search="search" :sort-by="sortBy.toLowerCase()" :sort-desc="sortDesc" hide-default-footer >
                        <!--TOOLBAR-->                            
                        <template v-slot:header>
                            <v-toolbar flat outlined class="mb-4">
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
                        </template>                      
                        <!--/TOOLBAR-->

                    <!---- items -->
                    <template v-slot:default="props">
                        <v-row class="mb-5">
                            <v-col v-for="item in props.items" :key="item.name" cols="12" sm="6" md="4" lg="3" >
                                <v-card outlined style="height:100%;">                                                                    
                                    <v-card-title class="subheading font-weight-bold" :class="{ 'blue--text': sortBy === 'title' }" >
                                         {{item.name}}
                                         <v-spacer />
                                         <v-icon>mdi-{{item.icon}}</v-icon> 
                                    </v-card-title>
                                    <v-img
                                        :src="item.url"
                                    ></v-img>                                    
                                    <v-card-subtitle class="text-truncate"> 
                                        {{item.description}}
                                    </v-card-subtitle>
                                    <v-list dense>
                                        <v-list-item v-if="item.tags.length">
                                            <v-chip @click="search=item" class="mr-1 mb-1" v-for="(item,key) in item.tags" :key="key">
                                                #{{item}}
                                            </v-chip>
                                        </v-list-item>
                                        <v-list-item>
                                            <v-icon>mdi-clock-time-eight-outline</v-icon> &nbsp; {{item.deliver}}
                                        </v-list-item>                                        
                                        <v-list-item to="/account">
                                            <v-icon>mdi-account</v-icon> &nbsp; {{item.user}}
                                        </v-list-item>
                                    
                                    <!-- <v-list-item  v-if="item.deliver">
                                        <v-list-item-content :class="{ 'blue--text': sortBy === 'deliver' }">Tot</v-list-item-content>
                                        <v-list-item-content class="align-end" :class="{ 'blue--text': sortBy === 'deliver' }">{{ formatDate(item.deliver) }}</v-list-item-content>
                                    </v-list-item>                    -->

                                    </v-list>

                                    <v-card-actions >
                                        <v-btn text color="success accent-4" >                                            
                                            Open
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>
                    <!--FOOTER-->

                    <template v-slot:footer>
                        <v-card outlined class="mb-5">
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
                        </v-card>   
                    </template>
                <!--/FOOTER-->
                </v-data-iterator>                    
            </v-col>
        </v-row>
      
</template>

<script>
export default {
    data(){return{
        itemsPerPageArray: [4, 8, 12],
            search: '',
            filter: {},
            sortDesc: false,
            page: 1,
            itemsPerPage: 4,
            sortBy: '',
            keys: [
            'Naam',
            'Omschrijving',            
            'Deadline',
            'Gebruiker',            
        ],
        items: [
            {
                icon: 'camera',
                name: 'Fotoshoot',
                url: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                description: 'blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blahblah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah ',
                deliver: '100 dagen',
                user:'Rick van Megen',
                tags:['1','2','3','4']
            },
            {
                icon: 'camera',
                name: 'Fotoshoot',
                url: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg',
                description: 'blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blahblah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah ',
                deliver: '100 dagen',
                user:'Rick van Megen',
                tags:['5','6','7','8']
            },
        ]
    }},
    computed: {
        numberOfPages () {
            return Math.ceil(this.items.length / this.itemsPerPage)
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
    },
}
</script>