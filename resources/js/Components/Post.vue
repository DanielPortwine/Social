<script setup>
defineProps({
    post: Object,
});
</script>

<template>
    <div class="p-4 sm:px-6 lg:px-8 sm:mb-4 bg-white overflow-hidden sm:shadow-xl sm:rounded-lg border-b sm:border-none">
        <h1 class="text-2xl">{{ post.user.name }}</h1>
        <p>{{ post.content }}</p>
        <p class="text-sm">{{ moment(post.created_at).fromNow() }}</p>
    </div>
</template>

<script>
let moment = require('moment');
</script>
