<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    post: Object,
});
</script>

<template>
    <Link :href="route('post_view', post.id)">
        <div class="p-4 sm:px-6 lg:px-8 sm:mb-4 bg-white overflow-hidden sm:shadow-xl sm:rounded-lg border-b sm:border-none cursor-pointer">
            <h1 class="text-2xl">{{ post.user.name }}</h1>
            <p class="text-sm">{{ moment(post.created_at).fromNow() }}</p>
            <p class="whitespace-pre-wrap p-2">{{ post.content }}</p>
            <div v-if="post.comments_count" class="border-t">
                <p>{{ post.comments_count }} comments</p>
            </div>
        </div>
    </Link>
</template>

<script>
let moment = require('moment');
</script>
