<template>
    <div class="relative">
        <Input :label="label" 
                :name="name"
                :placeholder="placeholder"
                :validation-rules="validationRules"
                v-model="model"/>
        <div class="absolute pin-b bg-white shadow-lg">
            sdas
        </div>
    </div>
</template>

<script>
import Fields from '.'

export default {
    components: {
        ...Fields
    }
}
</script>
