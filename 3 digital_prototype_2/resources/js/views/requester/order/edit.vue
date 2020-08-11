<template>
    
        <v-row>
         
            <v-col cols="6">
            
            <v-card outlined class="mb-5">
                <v-card-subtitle>Gegevens</v-card-subtitle>
                <v-card-text>
                    <v-text-field  
                        class="mb-3"   
                        :rules="nameRules"
                        label="Naam"
                        required
                    ></v-text-field>
                    
                    <v-textarea solo
                        name="input-7-1"
                        label="Omschrijving"
                        value=""
                        hint="Vul hier de omschrijving in."
                    ></v-textarea>

                    
                    
                    <v-slider
                        v-model="slider"
                        class="align-center"
                        :max="slider+100"
                        min="0"
                        :thumb-size="24"
                        thumb-label
                        hide-details
                    >
                        <template v-slot:prepend>
                            <v-text-field
                                required
                                v-model="slider"
                                label="Bedrag"
                                class="mt-0 pt-0"                                
                                type="number"
                                style="width: 60px"
                            ></v-text-field>
                        </template>
                    </v-slider>               

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
                            v-model="date"
                            label="Deadline"
                            append-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker v-model="date" @input="menu2 = false"></v-date-picker>
                    </v-menu>

                </v-card-text>           
            </v-card>


            <v-card outlined>
                <v-card-subtitle>Aanvulling</v-card-subtitle>
                 <v-card-text>    
                <v-layout  v-for="(i,index) in extraDescription"  :key="index">
                    <v-flex style="width:100%" p>
                        <v-text-field  v-model="extraDescription[index]" counter="100"  :placeholder="'extra veld '+(index+1)" />
                    </v-flex>
                    <v-flex class="pt-3 text-right">
                        <v-btn  @click="extraDescription.splice(index,1)" text class="error"> <v-icon>mdi-minus</v-icon></v-btn>
                    </v-flex>                        
                </v-layout>
                <v-btn class="success mb-6"  @click="extraDescription.push('')"> <v-icon>mdi-plus</v-icon></v-btn>      
            </v-card-text>
            </v-card>
            
            
            
            </v-col>
            <v-col cols=6>

                <v-card outlined class="mb-5">
                    <v-card-subtitle>Acties</v-card-subtitle>      
                    <v-card-text>
                        Aangemaakt op {{ `${new Date().getDate()}-${new Date().getMonth()}-${new Date().getUTCFullYear()}` }}
                    </v-card-text>  
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary">                            
                            <v-icon >mdi-content-save</v-icon> 
                            &nbsp; Opslaan
                        </v-btn>                        
                        <v-btn class="success"><v-icon>mdi-file-send-outline</v-icon> &nbsp; Publiceer </v-btn>
                    </v-card-actions>
                </v-card>

                <v-card outlined class="mb-5">
                    <v-card-subtitle>Type & tags</v-card-subtitle>
                    <v-card-text>
                        
                         <v-select
                            v-model="icon"
                            :items="iconList"
                            item-text="display"
                            item-value="value"
                            :rules="[v => !!v || 'Item is required']"
                            label="Type"
                            :append-icon="'mdi-'+icon"
                            required
                        ></v-select>

                        <v-text-field v-model="tagValue" label="Tag toevoegen" @blur="newTag" v-on:keyup.enter="newTag" >

                        </v-text-field>

                        <div>
                            <v-chip class="mr-3 mb-3" :key="key" v-for="(item,key) in tagList" close @click:close="delTag(key)" >#{{item}}</v-chip>
                        </div>

                    </v-card-text>
                </v-card>

                <v-card outlined class="mb-5">
                    <v-card-subtitle>Moodboard</v-card-subtitle>
                    <v-card-text>
                        <v-file-input v-model="files" show-size multiple label="Afbeeldingen"></v-file-input>                        
                        <p v-for="(file, key) in files" :key="key">
                            {{file.name}}
                        </p>                        
                    </v-card-text>
                </v-card>

                
            </v-col>
        </v-row>
    
</template>


<script>
export default {
    data: () => ({
        nameRules: [
            v => !!v || 'Name is required',
            v => (v && v.length <= 10) || 'Name must be less than 10 characters',
        ],
        extraDescription:[ ''           
        ],
        slider:100,
        date: new Date().toISOString().substr(0, 10),
        menu: false,        
        menu2: false,  
        files: [],
        icon:'',  
        iconList:[
            { value:'camera', display: 'Camera' },
            { value:'image', display: 'Afbeelding' },
            { value:'draw', display: 'Ontwerpen' },
            { value:'film', display: 'Film' },            
        ],
        tagList:[],
        tagValue:''
    }),
    methods:{
        newTag(){
            if(this.tagValue == '') return;           
            if(this.tagList.length > 4) return;
            this.tagList.push(this.tagValue);
            this.tagList = this.tagList.filter((v, i, a) => a.indexOf(v) === i); 
            this.tagValue = ''
        },
        delTag(tag){
            this.tagList.splice(tag,1);
        }
    }
}
</script>