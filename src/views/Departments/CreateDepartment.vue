<template>
    <ContentContainer title="Create Department" class-names="relative pb-0">
        <form action="#">
            <div class="text-xl mb-5 mt-4">
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="student_id" class="block text-sm mb-2">
                        Name
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="student_id" id="student_id" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey" placeholder="Student ID">
                </div>
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="student_id" class="block text-sm mb-2">
                        Location
                        <span class="text-red">
                            *
                        </span>
                    </label>
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
