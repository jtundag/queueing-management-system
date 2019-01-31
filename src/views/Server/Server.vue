<template>
    <ContentContainer title="Server" class-names="relative pb-0 pt-0 pl-0 pr-0 flex">
        <div class="flex w-12 h-full bg-white pt-4 fez123-border-right side-navbar w-64 text-sm flex-col">
            <div class="bold fez123-border-bottom pb-4 px-3">
                <strong>
                    Queueing
                </strong>
            </div>
            <div class="pt-4 px-3" v-for="(queue, index) in queues" :key="index">
                <span class="align-middle">
                    {{ queue.priority_number }}
                </span>
                <small class="float-right align-middle mr-4 text-grey-light" v-if="index == 0">
                    <strong>
                        Next &raquo;
                    </strong>
                </small>
            </div>
        </div>
        <div class="flex-grow subcontent px-5 py-3 relative">
            <div>
                Currently Serving:
            </div>
            <div class="text-center">
                <div class="num-box p-16 inline-block rounded-lg m-auto mt-24">
                    <strong class="num text-5xl">
                        {{ currentlyServing ? currentlyServing.priority_number : 'N/A' }}
                    </strong>
                </div>
            </div>

            <div class="queue-actions flex absolute pin-b pin-l w-full fez123-border-top">
                <button type="button" class="text-4xl flex-grow text-grey hover:text-grey-dark py-4" 
                    v-if="currentlyServing"
                    @click="skipNext">
                    <strong>
                        SKIP
                    </strong>
                    <span class="text-5xl">
                        &raquo;
                    </span>
                </button>

                <button type="button" class="text-4xl flex-grow text-grey hover:text-grey-dark py-4 fez123-border-left" @click="serveNext">
                    <strong>
                        NEXT
                    </strong>
                    <span class="text-5xl">
                        &rarr;
                    </span>
                </button>
            </div>
        </div>

        <VodalExt ref="serverIdModal" 
            title="Server ID"
            :width="500"
            :height="210"
            :closable="false">
            <template slot="body">
                <Input label="Server ID" 
                        name="serverId" 
                        placeholder="Enter Server ID"
                        :required="true"
                        v-model="manualServerId"/>
            </template>
            <template slot="footer">
                <Button type="primary" 
                    text="Save"
                    @click="setServerId"/>
            </template>
        </VodalExt>

    </ContentContainer>
</template>

<script>
import VodalExt from '@/components/Base/Vodal/VodalExt.vue'
import { mapGetters } from 'vuex'

export default {
    components: {
        VodalExt
    },
    mounted(){
        if(!this.serverId){
            this.$refs.serverIdModal.show()
            return
        }
        this._loadQueues()
    },
    data(){
        return {
            manualServerId: null
        }
    },
    computed: {
        ...mapGetters({
            'queues': 'queues',
            'currentlyServing': 'currentlyServing',
            'serverId': 'serverId'
        })
    },
    methods: {
        async serveNext(){
            this.$store.dispatch('toggleFullLoader', true)
            await this.$store.dispatch('serveNext')
            this._loadQueues()
        },
        async skipNext(){
            this.$store.dispatch('toggleFullLoader', true)
            await this.$store.dispatch('serveNext', { action: 'skip' })
            this._loadQueues()
        },
        async _loadQueues(){
            this.$store.dispatch('toggleFullLoader', true)
            await this.$store.dispatch('getQueues')
            this.$store.dispatch('toggleFullLoader', false)
        },
        setServerId(){
            if(!this.manualServerId) return false
            this.$store.commit('SERVER_ID', this.manualServerId)
            this.$refs.serverIdModal.hide()
            this._loadQueues()
        }
    }
}
</script>
