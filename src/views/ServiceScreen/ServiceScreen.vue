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
            'serviceQueues': 'serviceQueues',
            'pastServiceQueues': 'pastServiceQueues'
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
        <div class="flex h-full">
            <div class="flex-grow">
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
            </div>
            <div class="flex">
                <div class="flex w-12 h-full bg-white pt-4 fez123-border-left side-navbar w-64 text-sm flex-col">
                    <div class="bold fez123-border-bottom pb-4 px-3">
                        <strong>
                            Past Queues
                        </strong>
                    </div>
                    <div class="pt-4 px-3" v-for="(queue, index) in pastServiceQueues" :key="index">
                        <span class="align-middle">
                            {{ queue.priority_number }}
                        </span>
                        <small class="float-right align-middle mr-4 text-grey-light">
                            <strong class="font-uppercase">
                                {{ queue.status }}
                            </strong>
                        </small>
                    </div>
                </div>
            </div>
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
