<template>
    <v-card>
        <v-img class="white--text align-end" height="200px" src="https://cdn.vuetifyjs.com/images/cards/docks.jpg">                                
            <v-card-title>Oplevering</v-card-title>
        </v-img>
        
        <v-card-text>
            <p>
                Beschrijving van de postmaker bij de oplevering                                           
            </p>  
        </v-card-text>
        
        <v-card-actions>
            <slot />
        </v-card-actions>
    </v-card>
</template>