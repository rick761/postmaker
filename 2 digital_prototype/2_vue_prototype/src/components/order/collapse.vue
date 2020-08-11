<template>    
    <!-- collapse -->
    <article class="col-12 ">
        <div class="card-box">
        <a class="toggleIcon"
            @click="toggleWatch" 
            
            role="button"
            aria-expanded="false" 
            aria-controls="main_right_1"
            >
            <span class="mdi mdi-menu-down " :class="{ 'mdi-rotate-270' : !toggled }"></span>
        </a>
        <h5 class="text-capitalize mb-2" style="display:inline-block;">{{title}}</h5>

        <transition name="collapse" mode="out-in">
            <div v-if="toggled" class=" col-12" :id="'collapse_'+_uid" >                
                <slot />               
            </div>            
        </transition>

        <hr class="indent-1 mt-3">
        </div>
    </article>
    
</template>

<script>
export default {
    props:{title:{default:'No title?'}} ,  
    data(){return{
        toggled:true
    }},  
    methods:{        
        toggleWatch(){
            this.toggled = !this.toggled;
        }
    }  
}
</script>

<style scoped>

</style>