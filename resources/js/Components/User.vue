<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import SecondaryButton from "../Jetstream/SecondaryButton";

defineProps({
    user: Object,
    page: Boolean,
});
</script>

<template>
    <Link :href="route('user_view', user.id)">
        <div class="mb-2 bg-white overflow-hidden" :class="{ 'p-6' : page === true }">
            <div class="flex items-center">
                <button v-if="user.profile_photo_url" class="flex-none mr-4 text-sm border-2 border-transparent rounded-full">
                    <img class="h-12 w-12 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                </button>
                <div class="flex-1">
                    <h3  :class="(page === true) ? 'text-3xl' : 'text-md'">{{ user.name }}</h3>
                    <div v-if=page class="flex">
                        <p class="text-sm text-gray-500 mr-2">{{ user.posts_count }} Posts</p>
                        <p class="text-sm text-gray-500 mr-2">{{ user.followers_count }} Followers</p>
                        <p class="text-sm text-gray-500 mr-2">{{ user.following_count }} Following</p>
                    </div>
                    <p v-else class="text-sm text-gray-500 mr-2">{{ user.followers_count }} Followers</p>
                </div>
                <div v-if="user.id !== $page.props.user.id" class="flex-none">
                    <secondary-button v-if="user.followers.map(function(value) {return value.id;}).indexOf($page.props.user.id) >= 0" @click="unfollow(user.id)" v-on:click.prevent>
                        Unfollow
                    </secondary-button>
                    <secondary-button v-else @click="follow(user.id)" v-on:click.prevent class="bg-blue-500 text-white hover:text-gray-300">
                        Follow
                    </secondary-button>
                </div>
            </div>
        </div>
    </Link>
</template>

<script>
export default {
    methods: {
        follow() {
            axios.post('/api/followers/store', {user_id: this.user.id}).then((response) => {
                if (this.page) {
                    this.$emit('refresh-user');
                }
                this.$emit('refresh-popular-users');
            });
        },
        unfollow() {
            axios.delete('/api/followers/' + this.user.id + '/' + this.$page.props.user.id).then((response) => {
                if (this.page) {
                    this.$emit('refresh-user');
                }
                this.$emit('refresh-popular-users');
            });
        }
    }
}
</script>
