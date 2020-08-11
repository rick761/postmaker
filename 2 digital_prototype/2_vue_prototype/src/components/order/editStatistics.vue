<template>
    <v-row>
        <v-col cols="12">
            <v-card flat>
                <v-card-title>Gegevens</v-card-title>
                <v-card-subtitle>
                     <v-col cols="12">
                        <v-text-field
                            number
                            v-model.lazy="payment"
                            label="Opbrengst"
                            placeholder="€"
                            outlined
                        ></v-text-field>
                        
                     <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="deliver"
                            label="Opleverdatum"
                            prepend-icon="mdi-calendar"
                            readonly
                            outlined
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>

                        </template>
                        <v-date-picker v-model="deliver" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                        <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                        </v-date-picker>
                    </v-menu>

                    </v-col>
                </v-card-subtitle>            
            </v-card>
        </v-col>

    </v-row>
    <!-- <collapse title='Gegevens'  > -->

        <!--Uit profiel weergeven miss voor later... -->   
        <!-- <p>uit profiel weergeven</p>       
        <div>         
            <input v-bind:checked="isChecked('phone')"  v-on:input="update($event.target)" style="width:auto;" :id="'toonuitprofiel1'" type="checkbox" />
            <label class="ml-1" style="width:auto;" :for="'toonuitprofiel1'">Tel nr </label>
        </div>
        <div>
            <input v-bind:checked="isChecked('email')"  v-on:input="update($event.target)" name="" style="width:auto;" :id="'toonuitprofiel2'" type="checkbox" />
            <label class="ml-1" style="width:auto;" :for="'toonuitprofiel2'">E-mail adres </label>
        </div>   -->

            <!-- <p>Vergoeding</p>                     
            <input class="form-control" v-model.lazy="payment" type="text" placeholder="€">
            <p>Inleverdatum</p> 
            <input class="form-control" v-model.lazy="deliver" type="date" placeholder="vult een datum in.">  

             
            <div class="text-right">                
                <p class="text-success" v-if="!loader.loader5">Slaat automatisch op.</p>
                <p class="text-primary" v-if="loader.loader5">
                   <span class=" text-primary spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Aan het opslaan...
                </p>                
            </div>
            
    </collapse> -->
</template>

<script>
import {mapState} from 'vuex'


export default {
    props:[],
    data(){return{
        date: null,
        menu: false,
    }},
    
    methods: {
      save (date) {
        this.$refs.menu.save(date)
      },
    },
    computed:{
        ...mapState({  
            order : state => state.order_page.order,
            loader : state => state.loader
        }),

        payment: {
            get () {return this.$store.state.order_page.order.payment},
            set (value) {
                this.$store.dispatch('order_page/order/set', {payment : value})
                this.$store.dispatch('order_page/order/save', {payment : value})
            }
        },
        deliver: {
            get () {return this.$store.state.order_page.order.deliver},
            set (value) {
                this.$store.dispatch('order_page/order/set', {deliver : value})
                this.$store.dispatch('order_page/order/save', {deliver : value})
            }
        },
        computedDateFormatted () {
        return this.formatDate(this.date)
      },
        
 

    },    
    components:{        
                
    },
    
}

</script>

<style scoped>

</style>