<script setup>
defineProps({
    user: Object,
});
</script>

<template>
    <div class="mb-2 bg-white overflow-hidden">
        <h3 class="text-lg">{{ user.name }}</h3>
        <p class="text-sm">{{ user.followers_count }} Followers</p>
    </div>
</template>

<script>
// follow/unfollow button
</script>
