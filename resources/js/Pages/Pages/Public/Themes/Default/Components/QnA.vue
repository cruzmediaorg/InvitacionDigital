<template>
    <div class="qna-container">
        <h2 class="title">{{ block.fields[0].value }}</h2>
        <div v-for="(item, index) in qnaItems" :key="index" class="qna-item">
            <details>
                <summary>{{ item.question }}</summary>
                <p>{{ item.answer }}</p>
            </details>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['block']);

const qnaItems = computed(() => {
    return JSON.parse(props.block.fields[1].value);
});
</script>

<style scoped>

</style>