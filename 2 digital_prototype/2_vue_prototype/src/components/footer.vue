<template>
       <v-footer  dark padless >
      <!---->
          <v-card           
            color="blue-grey darken-3 white--text text-center"
          >
            <!-- <v-card-text>
              <v-btn
                v-for="icon in icons"
                :key="icon"
                class="mx-4 white--text"
                icon
              >
                <v-icon size="24px">{{ icon }}</v-icon>
              </v-btn>
            </v-card-text>

            <v-card-text style="width:100vw" class="white--text pt-0">          
                Hogeschool leiden, Informatica - Afstudeerproject bij SituatieWin B.V.            
            </v-card-text> -->

            <!-- <v-divider></v-divider> -->

            <v-card-text style="width:100vw" class="white--text">
              {{ new Date().getFullYear() }} — <strong>Rick van Megen</strong>
            </v-card-text>

          </v-card>
      <!---->
    </v-footer>
</template>

<script>
export default {
    data: () => ({  
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
    })
}
</script>