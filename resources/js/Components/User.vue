<script setup>
import SecondaryButton from "../Jetstream/SecondaryButton";

defineProps({
    user: Object,
});
</script>

<template>
    <div class="mb-2 bg-white overflow-hidden">
        <div class="flex items-start">
            <button v-if="user.profile_photo_url" class="flex-none mr-4 text-sm border-2 border-transparent rounded-full">
                <img class="h-12 w-12 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
            </button>
            <div class="flex-1">
                <h3 class="text-md">{{ user.name }}</h3>
                <p class="text-sm text-gray-500">{{ user.followers_count }} Followers</p>
                <p class="text-sm">{{ followerIDs.indexOf($page.props.user.id) }}</p>
            </div>
            <div v-if="user.id !== $page.props.user.id" class="flex-none">
                <secondary-button v-if="followerIDs.indexOf($page.props.user.id) >= 0" @click="unfollow(user.id)">
                    Unfollow
                </secondary-button>
                <secondary-button v-else @click="follow(user.id)" class="bg-blue-500 text-white hover:text-gray-300">
                    Follow
                </secondary-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            followerIDs: [],
        };
    },
    methods: {
        getFollowerIDs() {
            this.followerIDs = [];
            this.user.followers.forEach((follower) => {
                this.followerIDs.push(follower.id);
            });
        },
        follow() {
            axios.post('/api/followers/store', {user_id: this.user.id}).then((response) => {
                this.$emit('refresh-popular-users');
                setTimeout(this.getFollowerIDs, 500);
            });
        },
        unfollow() {
            axios.delete('/api/followers/' + this.user.id + '/' + this.$page.props.user.id).then((response) => {
                this.$emit('refresh-popular-users');
                setTimeout(this.getFollowerIDs, 500);
            });
        }
    },
    beforeMount() {
        this.getFollowerIDs();
    }
}
</script>
