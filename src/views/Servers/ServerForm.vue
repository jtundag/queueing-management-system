<template>
    <ContentContainer title="Create Server" class-names="relative pb-32 mb-24">
        <Form @submit="save" ref="createForm">
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <Input label="Server Name" 
                        name="server_name" 
                        placeholder="Enter Server Name"
                        :validation-rules="`required`"
                        v-model="formData.name"/>
                </div>
                <div class="flex-grow px-2">
                    <InputSuggestions label="Department" 
                        name="department" 
                        placeholder="Enter Department"
                        :text="formData.department.name"
                        v-model="formData.department"
                        :validation-rules="`required`"
                        api-url="/config/departments"
                        @selected="selectDepartment">
                        <div slot-scope="props">
                            {{ props.suggestion.name }}
                        </div>
                    </InputSuggestions>
                </div>
            </div>
            <div class="flex mb-2" v-if="formData.department.name">
                <div class="flex-grow px-2">
                    <label class="pl-1 block text-sm mb-2">
                        Server Personnels
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <SelectList :list="availablePersonnels" 
                        max-height="450px"
                        filter-with="name"
                        placeholder="Search personnels..."
                        v-model="formData.personnels"
                        primary-key="id">
                        <div slot-scope="props">
                            <div class="font-bold">
                                {{ props.item.first_name }}
                                {{ props.item.last_name }}
                            </div>
                            <div class="text-xs block">
                                {{ props.item.department.name }}
                            </div>
                            <div class="text-xs block">
                                {{ props.item.position }}
                            </div>
                        </div>
                    </SelectList>
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label class="pl-1 block text-sm mb-2">
                        Services
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <SelectList :list="availableServices" 
                        max-height="450px"
                        filter-with="name"
                        placeholder="Search services..."
                        v-model="formData.services"
                        primary-key="id">
                        <div slot-scope="props">
                            <div class="font-bold">
                                {{ props.item.name }}
                            </div>
                            <div class="duration" v-if="formData.services[_indexOf(props.item)]">
                                <span class="text-xs">
                                    Duration in minute(s)
                                </span>
                                <input type="number" 
                                    class="fez123-border no-outline text-xs w-16 p-2 text-center"
                                    v-model="formData.services[_indexOf(props.item)].pivot.duration"
                                    @click.stop>
                            </div>
                        </div>
                    </SelectList>
                </div>
            </div>
            <div class="flex mb-2">
                <mapbox accessToken="pk.eyJ1IjoiY3JvdzE3OTYiLCJhIjoiY2pqcXN1ZjFwMnl1cDNxbWRtZXI4Z2M1cSJ9.X4boJENMbxxk0oFuIw4T4A"
                :map-options="mapOptions"
                @map-click="setLocation"
                @map-init="mapInit"/>
            </div>
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8 fixed pin-b pin-l">
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    {{ $route.params.id ? 'Save' : 'Create' }}
                </button>
            </div>
        </Form>
    </ContentContainer>
</template>

<script>
import SelectList from '@/components/Base/SelectList.vue'
import Mapbox from 'mapbox-gl-vue';

export default {
    components: {
        SelectList,
        Mapbox
    },
    created(){
        this.$store.dispatch('toggleFullLoader', true)
        this.$store.dispatch('getServices')
            .then((response) => {
                this.$store.dispatch('toggleFullLoader', false)
                window._.map(response.data.result, (service) => service.pivot = { duration: 0 })
                this.availableServices = response.data.result
                if(this.$route.params.id){
                    this.$store.dispatch('toggleFullLoader', true)
                    this.$store.dispatch('findServer', this.$route.params.id)
                        .then(({ data }) => {
                            this.$store.dispatch('toggleFullLoader', false)

                            if(!data.status){
                                return false
                            }

                            let server = data.server
                            this.formData = {
                                name: server.name,
                                department: server.department,
                                department_id: server.department.id,
                                personnels: server.personnels,
                                services: server.services,
                                marker_location: server.department.marker_location ? JSON.parse(server.department.marker_location) : null
                            }
                            if(this.map){
                                this._setMarker(this.map, this.formData.marker_location)
                            }
                        })
                }
            })
            
    },
    data(){
        return {
            availablePersonnels: [],
            availableServices: [],
            formData: {
                name: null,
                department: {name: null},
                department_id: null,
                personnels: [],
                services: [],
                marker_location: null
            },
            mapOptions: {
                style: 'mapbox://styles/crow1796/cjregm9nv1yon2tptb42o6ibn',
                center: [124.656700, 8.485778], 
                zoom: 17.5, 
                maxBounds: [
                    124.653,8.484,
                    124.660,8.487
                ]
            },
            marker: {},
            map: null
        }
    },
    methods: {
        _indexOf(item){
            return window._.findIndex(this.formData.services, { id: item.id })
        },
        selectDepartment(department){
            this.$store.dispatch('toggleFullLoader', true)
            this.formData.department_id = department.id
            this.formData.marker_location = department.marker_location
            if(department.marker_location) this._setMarker(this.map, JSON.parse(department.marker_location))
            this.$store.dispatch('getUsers', { params: { role: 'personnel', department_id: department.id } })
                .then((response) => {
                    this.$store.dispatch('toggleFullLoader', false)
                    this.availablePersonnels = response.data.result
                })
        },
        save(){
            this.$store.dispatch('toggleFullLoader', true)
            this.$refs.createForm.validate()
                .then((result) => {
                    if(!result) return false
                    if(this.$route.params.id){
                        if(!this.formData.password) delete this.formData.password
                        this.$store.dispatch('updateServer', {
                            ...this.formData,
                            id: this.$route.params.id
                        })
                        .then(() => {
                            this.$store.dispatch('toggleFullLoader', false)
                            this.$router.replace('/servers')
                        })
                        return true
                    }
                    
                    this.$store.dispatch('createServer', this.formData)
                        .then(() => {
                            this.$store.dispatch('toggleFullLoader', false)
                            this.$router.replace('/servers')
                        })
                })
        },
        setLocation(map, t){
            this.formData.marker_location = JSON.stringify(t.lngLat)
            this._setMarker(map, t.lngLat)
        },
        mapInit(map){
            this.map = map
            var el = document.createElement('div');
            el.className = 'marker';

            this.marker = new mapboxgl.Marker(el)
            
            map.setMinZoom(17.5)
            map.setMaxZoom(17.5)

            if(this.formData.marker_location) this._setMarker(map, this.formData.marker_location)
        },
        _setMarker(map, loc){
            this.marker
                .setLngLat(loc)
                .addTo(map)
        }
    }
}
</script>
