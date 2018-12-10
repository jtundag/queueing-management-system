<template>
    <div class="relative">
        <Input :label="label" 
                :name="name"
                :placeholder="placeholder"
                :validation-rules="validationRules"
                v-model="model"/>
    </div>
</template>

<script>
import { Input } from '.'

export default {
    components: {
        Input
    }
}
</script>
