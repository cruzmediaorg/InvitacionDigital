<template>
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-50">
          <th class="border-b p-2 text-left w-10">
            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" />
          </th>
          <th class="border-b p-2 text-left">Guest</th>
          <th class="border-b p-2 text-left">Tags</th>
          <th v-for="question in rsvpQuestions" :key="question.question" 
              class="border-b p-2 text-left">
            {{ question.question }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="guest in guests" :key="guest.id" class="hover:bg-gray-50">
          <td class="border-b p-2">
            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" />
          </td>
          <td class="border-b p-2">{{ guest.name }}</td>
          <td class="border-b p-2"><!-- Tags component --></td>
          <td v-for="question in rsvpQuestions" :key="question.question" 
              class="border-b p-2">
            {{ getGuestResponse(guest, question) }}
          </td>
        </tr>
      </tbody>
    </table>
  </template>
  
  <script setup>
  defineProps({
    guests: Array,
    rsvpQuestions: Array,
  });
  
  function getGuestResponse(guest, question) {
    // Implement logic to get guest response for each question
    return '-'; // Placeholder
  }
  </script>