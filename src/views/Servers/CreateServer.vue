<template>
    <ContentContainer title="Create Server" class-names="relative pb-0">
        <form action="#">
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="student_id" class="pl-1 block text-sm mb-2">
                        Server Name
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="student_id" id="student_id" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Enter Server Name">
                </div>
                <div class="flex-grow px-2">
                    <label for="department" class="pl-1 block text-sm mb-2">
                        Department
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="department" id="department" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Department">
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="arrival_rate" class="pl-1 block text-sm mb-2">
                        Arrival Rate
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="arrival_rate" id="arrival_rate" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Enter Arrival Rate">
                </div>
                <div class="flex-grow px-2">
                    <label for="service_rate" class="pl-1 block text-sm mb-2">
                        Service Rate
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="service_rate" id="service_rate" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Enter Service Rate">
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label class="pl-1 block text-sm mb-2">
                        Server Personnels
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <SelectList :list="departmentPersonnels" 
                        max-height="450px"
                        filter-with="name">
                        <div slot-scope="props">
                            <div class="font-bold">
                                {{ props.item.name }}
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
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8">
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    Create
                </button>
            </div>
        </form>
    </ContentContainer>
</template>

<script>
import SelectList from '@/components/Base/SelectList.vue'
export default {
    components: {
        SelectList
    },
    data(){
        return {
            departmentPersonnels: [
                {
                    id: 1,
                    name: "Test Personnel",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                },
                {
                    id: 2,
                    name: "Test Personnel 2",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                },
                {
                    id: 3,
                    name: "Test Personnel 3",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                },
                {
                    id: 4,
                    name: "Test Personnel 4",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                },
                {
                    id: 5,
                    name: "Test Personnel 5",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                },
                {
                    id: 6,
                    name: "Test Personnel 6",
                    position: "Developer",
                    department: {
                        id: 1,
                        name: "Web"
                    }
                }
            ]
        }
    }
}
</script>
