<template><div>
    <v-menu
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="290px"
    >

        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="dateFormatted"
                label="Project moet klaar zijn op"
                append-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"                                
            ></v-text-field>
        </template>

        <v-date-picker v-model="deliver" @input="menu2 = false"></v-date-picker>

    </v-menu>
    Date:{{date}}<br>
    dateFormatted:{{dateFormatted}}<br>
    deliver: {{deliver}}
    </div>
</template>

<script>
  import {mapState} from 'vuex';

  export default {
    data: vm => ({
      date: new Date().toISOString().substr(0, 10),
      dateFormatted: vm.formatDate(new Date().toISOString().substr(0, 10)),
      menu1: false,
      menu2: false,
    }),

    computed: {
      ...mapState({
          order: state => state.order.data
      }),
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
      deliver: {
            get () {  
                if(!this.order.deliver) return ;
                const [day, month, year] = this.order.deliver.split('-');              
                return `${year}-${month}-${day}`                 
            },
            set (value) {               
                this.$store.commit( 'order/SET_DELIVER', value );
            }
        },  
    },

    watch: {
      deliver (val) {
        this.dateFormatted = this.formatDate(this.deliver)
      },
    },

    methods: {
      formatDate (date) {
        if (!date) return null;

        const [day, month, year] = date.split('-')
        return `${day}-${month}-${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },
    },
    
  }
</script>