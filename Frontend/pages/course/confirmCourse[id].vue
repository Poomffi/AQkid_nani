<script setup lang="ts">
definePageMeta({ layout: "student" })


// fullcalendar


import FullCalendar from '@fullcalendar/vue3'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid'
import dayGridPlugin from '@fullcalendar/daygrid'


const calendarOptions = ref({
    plugins: [interactionPlugin, timeGridPlugin, dayGridPlugin],
    initialView: 'timeGridWeek',
    nowIndicator: true,
    editable: false,
    //   dateClick: handleDateClick,
    // eventClick: handleEventClick,
    //   eventMouseEnter: handleEventhover,
    //   eventMouseLeave: handleEventLeave,
    contentHeight: 'auto',
    events: ref([]),
    scrollTime: '10:00:00', // Set the scrollTime to 10:00 AM (optional)
    slotMinTime: '10:00:00', // Set the minimum time to 10:00 AM (optional)
    slotMaxTime: '18:00:00', // 
    slotLabelFormat: {
        hour: 'numeric',
        minute: '2-digit',
        omitZeroMinute: false,
    },
    allDaySlot: false,
    initialDate: ref(),
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay',
    },


})

const eventData = ref([])


calendarOptions.value.events = eventData;


// timestore
import { useTimeStore } from "~/stores/useTimeStore";
const route = useRoute();

const course = ref({});

// route.params.id


const { data: eventCourse, error: loginError } = await useApiFetch("api/student/showCourse/" + route.params.id, {});

if (eventCourse.value) {

    course.value = eventCourse.value;

    let first = 1;

    for (const event in eventCourse.value.timeslots) {

        if (first === 1) {

            calendarOptions.value.initialDate = eventCourse.value.timeslots[event].datetime

            first = 0;
        }

        let temp = {
            title: eventCourse.value.timeslots[event].title,
            start: eventCourse.value.timeslots[event].datetime,
            uid: eventCourse.value.timeslots[event].id,
            datestore: eventCourse.value.timeslots[event].datetime,
            type: eventCourse.value.timeslots[event].type,
            color: "green",

        }

        eventData.value.push(temp);


    }

} else {
    if (loginError.value) {
        
    }
}

const timer = useTimeStore();

const confirmError = ref('');
async function paymentConfirm() {

    if (timer.setTime()) {

        await navigateTo(`/course/paymentDetails${route.params.id}`);

    } else {

        confirmError.value = "You are currently unable to enroll in this course. Please log out and log in again to reset the enrollment process.";

    }

}


</script>

<template>
    <div class='app bg-white p-12 transform ease-in-out mt-24 mb-4 mx-12 shadow-2xl border rounded-2xl'>
        <FullCalendar :options='calendarOptions' />
    </div>

    <div class="bg-gradient-to-b justify-center items-center mb-8">
        <div
            class="mt-8 relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white shadow-2xl p-3 border broder-gray-400">
            <div class="mt-2 mb-8 w-full ">
                <h4 class="px-2 text-xl font-bold text-navy-700 ">
                    Course Information
                </h4>
                <p class="mt-2 px-2 text-base text-gray-600">
                    {{ course.description }}
                </p>
            </div>
            <div class="grid grid-cols-3 gap-4 px-2 w-full ">
                <div
                    class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg ">
                    <p class="text-sm text-gray-600">Quota</p>
                    <p class="text-base font-medium text-navy-700 ">
                        {{ course.quota }} classes
                    </p>
                </div>

                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg">
                    <p class="text-sm text-gray-600">Capacity</p>
                    <p class="text-base font-medium text-navy-700">
                        {{ course.enroll_count }} / {{ course.capacity }} people
                    </p>
                </div>

                <div
                    class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg ">
                    <p class="text-sm text-gray-600">Age-restricted</p>
                    <p class="text-base font-medium text-navy-700 ">
                        {{ course.min_age }} to {{ course.max_age }} years old
                    </p>
                </div>

                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg ">
                    <p class="text-sm text-gray-600">Class duration</p>
                    <p class="text-base font-medium text-navy-700">
                        {{ course.duration }} Minutes
                    </p>
                </div>

                <div
                    class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg ">
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="text-base font-medium text-navy-700 ">
                        {{ course.status }}
                    </p>
                </div>

                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-lg ">
                    <p class="text-sm text-gray-600">Course price</p>
                    <p class="text-base font-medium text-navy-700 ">
                        {{ course.price }}
                    </p>
                </div>

            </div>
            <p class="text-red-500 mt-8">
                {{ confirmError }}
            </p>
            <button v-if="course.enroll_count < course.capacity" v-on:click="paymentConfirm"
                class="bg-orange-500 text-white px-6 py-2 text-2xl relative mt-6 rounded-md hover:bg-orange-700 duration-150">
                Confirm
            </button>


        </div>


    </div>
</template>
