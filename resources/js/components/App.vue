<script setup>
import vueFilepond, {setOptions} from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import {onMounted, ref} from "vue";

const pond = ref();
const FilePond = vueFilepond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
const axios = require("axios");
const images = ref([]);
let serverMessage = {};

setOptions({
    server: {
        process: {
            url: './upload',
            onerror: (response) => {
                serverMessage.value = JSON.parse(response)
            },
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
            }
        }
    },
    labelFileProcessingError: () => {
        return serverMessage.value.error;
    }
});

function filepondInitialized() {
    console.log('Ready');
}

function handleProcessedFile(error, file) {
    if (error) {
        console.error(error);
        return;
    }

    // add the file to front of images array
    images.value.unshift(file.serverId);
}

onMounted(async () => {
    await axios.get('/images')
        .then(response => {
            images.value = response.data;
        })
        .catch(error => {
                console.log(error.log)
            }
        );
});


</script>
<template>
    <div>
        <div class="mt-4">
            <FilePond
                name="image"
                ref="pond"
                label-idle="Click to choose image, or drag here..."
                @init="filepondInitialized"
                accepted-file-types="image/jpg, image/png, image/jpeg"
                @processfile="handleProcessedFile"
                max-file-size="1MB"
            />
        </div>

        <div class="mt-8 mb-24">
            <h3 class="text-2xl font-medium text-center">Image Gallery</h3>
            <div class="grid grid-cols-3 gap-2 justify-evenly mt-4">
                <div v-for="(image, index) in images" :key="index">
                    <img :src="'/storage/images/' + image" alt="">
                </div>
            </div>
        </div>
    </div>

</template>

