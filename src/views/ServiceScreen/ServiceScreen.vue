<script>
import { mapGetters } from 'vuex'

export default {
    async created(){
        this.$store.dispatch('toggleFullLoader', true)
        await this.$store.dispatch('getServiceQueues', { department_id: this.$route.query.department_id })
        this.$store.dispatch('toggleFullLoader', false)
    },
    computed: {
        ...mapGetters({
            'serviceQueues': 'serviceQueues'
        })
    }
}
</script>

<template>
    <ContentContainer title="Service Screen" class-names="relative pt-0 pr-0 pb-0 pl-0">
        <div class="fez123-border-bottom p-4 w-full" v-for="(server, index) in serviceQueues" :key="index">
            <h2>
                {{ server.name }}
            </h2>
            <h3 class="mt-2">
                Serving: 
                <span class="text-red">
                    {{ server.queues.length ? server.queues[0].priority_number : 'N/A' }}
                </span>
            </h3>
        </div>
    </ContentContainer>
</template>
