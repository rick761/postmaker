<template >
    <div>
        <input 
            :value="value" 
            @input="$emit(
                'input',
                 $event.target.value
            )" 
        />
    </div>    
</template>

<script>
    export default {
        prop: ['value'],   
    }

</script>

<style scoped>

</style>