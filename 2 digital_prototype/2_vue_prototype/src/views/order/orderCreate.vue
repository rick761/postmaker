<template>
    <v-row>

        <v-col cols=12>
            <v-card flat tile>
                <v-card-title>
                    Nieuw project
                </v-card-title>
            </v-card>
        </v-col>
        <v-col cols="6">
        
        <v-card flat tile class="mb-5">
            <v-card-title>Project gegevens</v-card-title>
            <v-card-text>
                <v-text-field  
                    class="mb-3"   
                    :rules="nameRules"
                    label="Project naam"
                    required
                ></v-text-field>
                
                <v-textarea outlined
                    name="input-7-1"
                    label="Omschrijving"
                    value=""
                    hint="Vul hier de omschrijving in."
                ></v-textarea>
                
                <v-slider
                    v-model="slider"
                    class="align-center"
                    max="500"
                    min="0"
                    :thumb-size="24"
                    thumb-label
                    hide-details
                >
                    <template v-slot:prepend>
                        <v-text-field
                            required
                            v-model="slider"
                            label="Betaling"
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
                        label="Datum van oplevering"
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


        <v-card flat tile>
            <v-card-title>Aanvulling</v-card-title>
            <v-card-text>
                <v-row>
                    <v-col :cols="( (12/extraDescription.length) > 4 ) ? 12/extraDescription.length : 4 " v-for="(row, key) in extraDescription" :key="key">
                        <v-card flat tile>
                            <v-card-title >
                                <v-text-field  
                                    dense
                                    v-model="row.title" 
                                    class="mb-3"                           
                                    label="Kop"                            
                                ></v-text-field>
                            </v-card-title>

                            <v-card-text>
                                <v-textarea 
                                    outlined dense
                                    v-model="row.text" 
                                    name="input-7-1"
                                    label="tekst"
                                    value=""                            
                                ></v-textarea>
                                <v-btn icon class="error float-right" @click="extraDescription.splice(key,1)" > <v-icon>mdi-minus</v-icon></v-btn>
                            </v-card-text>                            
                        </v-card>
                    </v-col>
                </v-row>
                <v-btn icon class="success"  @click="extraDescription.push({})"> <v-icon>mdi-plus</v-icon></v-btn>
            </v-card-text>           
        </v-card>
        
        
        
        </v-col>
        <v-col cols=6>
            <v-card flat tile class="mb-5">
                <v-card-title>Afbeeldingen</v-card-title>
                <v-card-text>
                    <v-file-input v-model="files" show-size multiple label="File input"></v-file-input>
                    
                    <p v-for="(file, key) in files" :key="key">
                        {{file.name}}
                    </p>
                    
                </v-card-text>
            </v-card>

            <v-card flat tile class="mb-3">
                <v-card-title>Acties</v-card-title>      
                <v-card-text>
                    Aangemaakt op {{ `${new Date().getDate()}-${new Date().getMonth()}-${new Date().getUTCFullYear()}` }}
                </v-card-text>  
                <v-card-actions>
                    <v-btn to="/home" class="primary"> Publiceer </v-btn>
                </v-card-actions>
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
        extraDescription:[            
        ],
        slider:100,
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        modal: false,
        menu2: false,  
        files: []      
    })
}
</script>