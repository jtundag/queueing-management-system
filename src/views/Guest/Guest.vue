<template>
    <ContentContainer title="Guest" class-names="relative pb-0">
        <div class="text-lg mb-5 mt-4">
            Guest Information
        </div>
        <div class="flex mb-2">
            <div class="flex-grow px-2">
                <label for="first_name" class="block text-sm mb-2">
                    First Name
                    <span class="text-red">
                        *
                    </span>
                </label>
                <input type="text" name="first_name" id="first_name" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="First Name">
            </div>
            <div class="flex-grow px-2">
                <label for="middle_name" class="block text-sm mb-2">
                    Middle Name (Optional)
                </label>
                <input type="text" name="middle_name" id="middle_name" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Middle Name (Optional)">
            </div>
            <div class="flex-grow px-2">
                <label for="last_name" class="block text-sm mb-2">
                    Last Name <span class="text-red">*</span>
                </label>
                <input type="text" name="last_name" id="last_name" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Last Name">
            </div>
        </div>
        <div class="text-lg mb-5 mt-4">
            Contact Information
        </div>
        <div class="flex mb-2">
            <div class="px-2">
                <label for="mobile_no" class="block text-sm mb-2">
                    Mobile No.
                </label>
                <input type="text" name="mobile_no" id="mobile_no" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Mobile Number">
            </div>
            <div class="px-2">
                <label for="phone_no" class="block text-sm mb-2">
                    Phone No.
                </label>
                <input type="text" name="phone_no" id="phone_no" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Phone Number">
            </div>
        </div>
        <div class="text-lg mb-5 mt-4 font-bold fez123-border-top pt-4">
            <span class="ribbon-title">
                <span class="text">GET PRIORITY NUMBER</span>
            </span>
        </div>
        <div class="flex mb-2">
            <div class="flex-grow px-2">
                <label for="department" class="block text-sm mb-2">
                    Department
                </label>
                <input type="text" name="department" id="department" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Enter Department">
            </div>
        </div>
        <SelectList :list="stages" 
            max-height="450px"
            :full-width="false">
            <div slot-scope="props">
                <div class="font-bold">
                    {{ props.item.name }}
                </div>
            </div>
        </SelectList>
        <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8">
            <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                Reset
            </button>
            <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                Create
            </button>
        </div>
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
            stages: [
                {
                    id: 1,
                    name: 'Stage 1'
                },
                {
                    id: 2,
                    name: 'Stage 2'
                },
                {
                    id: 3,
                    name: 'Stage 3'
                }
            ]
        }
    }
}
</script>

