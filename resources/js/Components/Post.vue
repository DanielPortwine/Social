<script setup>
defineProps({
    post: Object,
});
</script>

<template>
    <div class="p-4 border-b border-b-gray-300">
        <h1>{{ post.user.name }}</h1>
        <p>{{ post.content }}</p>
        <p>{{ moment(post.created_at).fromNow() }}</p>
    </div>
</template>

<script>
let moment = require('moment');
</script>
