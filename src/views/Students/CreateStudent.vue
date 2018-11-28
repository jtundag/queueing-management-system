<template>
    <ContentContainer title="Create Student" class-names="relative pb-0">
        <form action="#">
            <div class="text-xl mb-5 mt-4">
                Student Information
            </div>
            <div class="flex mb-2">
                <div class="flex-grow px-2">
                    <label for="student_id" class="block text-sm mb-2">
                        Student ID
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="student_id" id="student_id" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Student ID">
                </div>
                <div class="flex-grow px-2">
                    <label for="course" class="block text-sm mb-2">
                        Course
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="course" id="course" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="What is your course?">
                </div>
                <div class="flex-grow px-2">
                    <label for="department" class="block text-sm mb-2">
                        Department
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <input type="text" name="department" id="department" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="What is your department?">
                </div>
            </div>
            <div class="text-xl mb-5 mt-4">
                Personal Information
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
            <div class="flex mb-2">
                <div class="px-2">
                    <label for="gender" class="block text-sm mb-2">
                        Gender
                        <span class="text-red">
                            *
                        </span>
                    </label>
                    <div>
                        <label for="gender_male" class="text-sm">
                            <input type="radio" name="gender_male" id="gender_male"> <span class="ml-1">Male</span>
                        </label>
                    </div>
                    <div>
                        <label for="gender_fmale" class="text-sm">
                            <input type="radio" name="gender_fmale" id="gender_fmale"> <span class="ml-1">Female</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-xl mb-5 mt-4">
                Contact Information
            </div>
            <div class="flex mb-2">
                <div class="px-2">
                    <label for="mobile_no" class="block text-sm mb-2">
                        Mobile No.
                    </label>
                    <input type="text" name="mobile_no" id="mobile_no" class="block fez123-border rounded-sm leading-normal p-3 text-sm no-outline focus:border-grey w-full" placeholder="Mobile Number">
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
