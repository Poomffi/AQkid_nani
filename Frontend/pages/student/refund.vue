<template>
    <div class="my-24">
        <div
            class="mt-8 flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white shadow-2xl p-3 border broder-gray-400">
            <div class="mt-2 w-full ">
                <h4 class="px-2 text-xl font-bold text-navy-700 ">
                    Refund Information
                </h4>
            </div>
            <div class="text-2xl font-semibold flex w-full px-6 flex-col items-start justify-center rounded-2xl bg-white bg-clip-border mb-4 py-4 shadow-lg">
                <span class="mr-4">Title</span> 
                <input 
                                        class="w-full px-2 py-2 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-300 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                        type="text" name="title" placeholder="Title" />
                                        
            </div>
            
            <div class="flex justify-center gap-5">
                        <input @change="handleImageChange" accept="image/png, image/gif, image/jpeg" ref="profileImageInput"
                            id="profile_image" name="profile_image"
                            class='inline-flex items-center shadow-md my-2 px-2 py-2 bg-gray-900 text-gray-50 border border-transparent
                    rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                    focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150' type="file">
                        <button @click="removeImagePreview"
                            class='inline-flex items-center shadow-md my-2 px-2 py-2 bg-gray-900 text-gray-50 border border-transparent
                    rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                    focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>
                            remove image
                        </button>
            </div>  
            <div class="flex justify-center items-center">
                        <div
                            class="w-full object-cover relative order-first md:order-last h-1/3 md:h-auto flex justify-center items-center border border-dashed border-gray-400 col-span-2 m-2 rounded-lg bg-no-repeat bg-center bg-origin-padding bg-cover">
                            <span v-if="imagefix" class="text-gray-400 opacity-75">
                                <svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="0.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </span>
                            <h3 v-if="imagefix" class="w-full">Preview Image</h3>

                            <img ref="imagePreview" class="object-scale-down h-1/2 w-3/5 text-gray-400 rounded-lg"
                                :src="imagePreviewSrc" alt="">
                        </div>
            </div>          
            <div class="grid grid-cols-2 gap-4 px-2 w-full ">
                <NuxtLink to="/student">
                <div class="flex flex-col items-start justify-center duration-200 text-white rounded-2xl bg-red-500  bg-clip-border px-3 py-4 shadow-lg hover:bg-white hover:text-black">
                        <p class="text-sm">Cancel</p>
                        <p class="text-base font-medium text-navy-700 ">
                        </p>
                    </div>
                </NuxtLink>

                <NuxtLink to="/student">
                <div class="flex flex-col justify-center rounded-2xl duration-200 text-white bg-green-500 bg-clip-border px-3 py-4 shadow-lg hover:bg-white hover:text-black">
                        <p class="text-sm ">Send</p>
                        <p class="text-base font-medium text-navy-700 ">
                        </p>
                    </div>
                </NuxtLink>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
// image preview
const profileImageInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<HTMLImageElement | null>(null);
const imagePreviewSrc = ref<string>(''); // Store the image source
const imagefix = ref(true);
const profile_image_path = ref<File | null>(null)

const handleImageChange = () => {
    if (profileImageInput.value && profileImageInput.value.files && profileImageInput.value.files[0]) {
        const selectedFile = profileImageInput.value.files[0];
        const reader = new FileReader();

        reader.onload = (event: ProgressEvent<FileReader>) => {
            if (imagePreview.value) {
                imagePreview.value.src = event.target?.result as string;
                imagePreviewSrc.value = event.target?.result as string; // Set the image source
                imagefix.value = false;
                profile_image_path.value = selectedFile;
            }
        };

        reader.readAsDataURL(selectedFile);
    } else {
        // Handle the case when no file is selected or the selection is canceled
        if (imagePreview.value) {
            imagePreview.value.src = '';
            imagePreviewSrc.value = ''; // Clear the image source
            imagefix.value = true;
            profile_image_path.value = null;
        }
    }
};

const removeImagePreview = () => {
    if (imagePreview.value) {
        imagePreview.value.src = '';
        imagePreviewSrc.value = ''; // Clear the image source
        imagefix.value = true;
        profile_image_path.value = null;
    }

    if (profileImageInput.value) {
        profileImageInput.value.value = ''; // Clear the input value
    }
};

</script>