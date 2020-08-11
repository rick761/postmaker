<template>
    <div>
        <v-card outlined class="mb-1">   
            <v-card-title>Archief</v-card-title>
        </v-card>                    
        <v-expansion-panels >
            <v-expansion-panel
                v-for="(item,i) in 1"
                :key="i"
            >
            <v-expansion-panel-header>                                
                Project x
                <v-icon color="success" v-if="project_show">
                    mdi-eye
                </v-icon>
                <v-icon color="error" v-if="!project_show">
                    mdi-eye-off
                </v-icon>
                <v-spacer></v-spacer>                                
            </v-expansion-panel-header>
                <v-expansion-panel-content>                            
                    <v-card-text>
                        <v-item-group
                            v-model="selected"
                            multiple
                        >                                        
                            <v-row>
                            <v-col
                            v-for="n in 3"
                            :key="n"
                            cols="12"
                            md="4"
                            >
                            <v-item v-slot:default="{ active, toggle }">
                                <v-img
                                    :color="active ? 'primary' : ''"
                                    class="d-flex align-center"
                                    :src="`https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg`"
                                    dark
                                    height="200"
                                    @click="toggle"
                                >                                                
                                    <v-scroll-y-transition>
                                        <div
                                        v-if="active"
                                        class="display-3 flex-grow-1 text-center"
                                        >
                                            <v-icon x-large>mdi-check</v-icon>
                                        </div>
                                    </v-scroll-y-transition>
                                </v-img>
                            </v-item>
                            </v-col>
                        </v-row>
                        </v-item-group>
                    </v-card-text>
                        
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn @click ="project_show=0"
                            text
                            color="secondary"
                        >
                            verberg
                        </v-btn>
                        <v-btn @click ="project_show=1"
                            text
                            color="primary"
                        >
                            Toon
                        </v-btn>
                    </v-card-actions>

                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>


<script>
    export default {
        data(){ return{
            selected:[]      ,
            project_show:false,      
            
        }},
    }
</script>