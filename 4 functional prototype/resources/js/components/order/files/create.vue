<template>
     <card toggle>
        <!--MOODBOARD-->

            <v-card-subtitle>
                
                Bestanden en afbeeldingen  
                
                <explain>  Deze documenten worden openbaar gesteld als instructie of voorbeeld voor alle postmakers. </explain>

            </v-card-subtitle> 

            <v-card-text>
                <v-file-input @click:clear="removeAllTmp" v-model="_tmp_files" show-size multiple label="Afbeeldingen en/of bestanden toevoegen"></v-file-input>                        
                
                    
                <v-chip 
                    @click:close="delTmpFile(key)" 
                    close 
                    class="mb-1 mr-1"
                    v-for="(item,key) in _tmp_files" 
                    :key="key+item"
                >
                    <v-icon>mdi-file-plus</v-icon> &nbsp; {{item.name}}
                </v-chip> 

                <v-chip 
                    @click:close="delFile(item.id)" 
                    close 
                    class="mb-1 mr-1"
                    v-for="(item,key) in files" 
                    :key="key+item"
                >
                    <v-icon>mdi-file</v-icon> &nbsp; {{item.url}}
                </v-chip> 
                                       
            </v-card-text>
        <!---->
    </card>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data(){return{
        // files:[]
    }},
    computed:{
        ...mapState({
            files: state => state.order.files.list
        }),

        _tmp_files:{
            get(){
                return this.$store.state.order.files.tmp_files;
            },                
            set (value) {                                                                        
                this.$store.commit('order/files/ADD_TMP_FILES',value); 
            }
        },        
    },
    methods:{
        delFile(id){
            this.$store.dispatch('order/files/deleteFile',id);
        },
        delTmpFile(i){            
            this.$store.commit('order/files/DEL_TMP_FILES',i);             
        },
        removeAllTmp(){
             this.$store.commit('order/files/DEL_ALL_TMP_FILES');      
        }

    }
    
}
</script>