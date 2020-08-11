<template>
    <div > 
        <div class="container">
            <div class="row" v-if="error" >
                <div class=" col-12 card">
                    <p >{{error}}</p>
                </div>
            </div>
        </div>  
       

        <slot/>
    </div>    

</template>
<script>
export default {
     data: () => ({ error: null }),
    errorCaptured (err, vm, info) {
        this.error = `${err.stack}\n\nfound in ${info} of component`
        return false
    },
    render (h) {
        if (this.error) {
        return h('pre', { style: { color: 'red' }}, this.error)
        }
        // ignoring edge cases for the sake of demonstration
        return this.$slots.default[0]
    }
}
</script>