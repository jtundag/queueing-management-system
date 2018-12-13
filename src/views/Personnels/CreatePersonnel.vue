<template>
    <ContentContainer title="Create Peronnel" class-names="relative pb-0">
        <Form action="#">
            <div class="text-lg mb-5 mt-4">
                Account Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="first_name" class="block text-sm mb-2">
                        Username
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="first_name" id="first_name" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="First Name">
                </div>
                <div class="flex-grow px-2">
                    <label for="password" class="block text-sm mb-2">
                        Password 
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="password" name="password" id="password" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Middle Name (Optional)">
                </div>
            </div>
            <div class="text-lg mb-5 mt-4">
                Employee Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="student_id" class="pl-1 block text-sm mb-2">
                        Personnel ID
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="student_id" id="student_id" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Personnel ID">
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
            <div class="w-full fez123-border-top px-10 py-4 text-right bg-white mt-8">
                <button type="reset" class="mr-3 px-4 py-2 text-center leading-normal rounded-sm hover:bg-grey-lighter no-outline">
                    Reset
                </button>
                <button class="fez123-button-primary px-4 py-2 text-center leading-normal rounded-sm no-outline">
                    Create
                </button>
            </div>
        </Form>
    </ContentContainer>
</template>

<script>
export default {
}
</script>

