<script setup>
import { Link } from '@inertiajs/inertia-vue3';
defineProps({
    post: Object,
});
</script>

<template>
    <Link :href="route('post_view', post.id)">
        <div class="p-4 sm:mb-4 bg-white overflow-hidden sm:shadow-xl sm:rounded-lg border-b sm:border-none cursor-pointer">
            <div class="flex items-start">
                <button v-if="post.user.profile_photo_url" class="flex-none mr-4 text-sm border-2 border-transparent rounded-full">
                    <img class="h-12 w-12 rounded-full object-cover" :src="post.user.profile_photo_url" :alt="post.user.name">
                </button>
                <div class="flex-1">
                    <h1 class="text-2xl">{{ post.user.name }}</h1>
                    <p class="text-sm text-gray-500">{{ moment(post.created_at).fromNow() }}</p>
                    <p class="whitespace-pre-wrap py-2">{{ post.content }}</p>
                    <div v-if="post.comments_count" class="text-sm text-gray-500 flex">
                        <p>{{ post.comments_count }} comments</p>
                    </div>
                </div>
            </div>
        </div>
    </Link>
</template>

<script>
let moment = require('moment');
</script>
