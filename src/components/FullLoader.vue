<template>
    <div class="fixed w-full h-full pin full-loader">
        <bar-loader class="spinner absolute" color="#FFB31E" :width="200" :height="5" sizeUnit="px"></bar-loader>
    </div>
</template>

<script>
import { BarLoader } from '@saeris/vue-spinners'
export default {
    components: {
        BarLoader
    }
}
</script>
