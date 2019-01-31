<script>
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'
import { mapGetters } from 'vuex'

export default {
    components: {
        VodalExt
    },
    mounted(){
        if(!this.$route.query.department_id){
            this.$refs.departmentIdModal.show()
            return
        }
        this._loadQueues()
    },
    computed: {
        ...mapGetters({
            'serviceQueues': 'serviceQueues'
        })
    },
    data(){
        return {
            manualDepartmentId: null
        }
    },
    methods: {
        async _loadQueues(){
            this.$store.dispatch('toggleFullLoader', true)
            await this.$store.dispatch('getServiceQueues', { department_id: this.$route.query.department_id })
            this.$store.dispatch('toggleFullLoader', false)
        },
        setDepartmentId(){
            if(!this.manualDepartmentId) return false
            this.$router.replace(`/service-screen/?department_id=${this.manualDepartmentId}`)
            this.$refs.departmentIdModal.hide()
            this._loadQueues()
        }
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

        <VodalExt ref="departmentIdModal" 
            title="Department ID"
            :width="500"
            :height="210"
            :closable="false">
            <template slot="body">
                <Input label="Department ID" 
                        name="departmentId" 
                        placeholder="Enter Department ID"
                        :required="true"
                        v-model="manualDepartmentId"/>
            </template>
            <template slot="footer">
                <Button type="primary" 
                    text="Save"
                    @click="setDepartmentId"/>
            </template>
        </VodalExt>
    </ContentContainer>
</template>
