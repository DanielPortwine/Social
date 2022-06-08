<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import User from '@/Components/User.vue';
import Post from '@/Components/Post.vue';
import PopularUsers from '@/Components/PopularUsers.vue';
import SecondaryButton from "../Jetstream/SecondaryButton";
defineProps({
    user_id: Number,
});
</script>

<template>
    <AppLayout title="Post">
        <div class="max-w-7xl py-2 sm:py-6 mx-auto">
            <div class="grid grid-cols-6 md:mx-4">
                <div class="col-span-6 md:col-span-4 md:mr-4">
                    <User v-if="user" v-on:refresh-user="refreshUser" :user=user :page="true" :key="user.id" />
                    <div class="p-2">
                        <secondary-button @click="getUser()" class="bg-blue-500 text-white hover:text-gray-300">Refresh</secondary-button>
                    </div>
                    <div id="posts-container">
                        <Post v-if="posts" v-for="post in posts" :post=post :key="post.id" />
                    </div>
                </div>
                <div class="hidden md:block md:col-span-2">
                    <PopularUsers />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            posts: [],
            postsPage: 1,
        };
    },
    methods: {
        getUser() {
            axios.get('/api/users/' + this.user_id).then((response) => {
                this.user = response.data;
                this.posts = response.data.posts;
                setTimeout(this.getNextPosts, 1);
            });
        },
        refreshUser() {
            axios.get('/api/users/' + this.user_id).then((response) => {
                this.user = response.data;
            });
        },
        getNextPosts() {
            let shouldScroll = document.documentElement.scrollTop + window.innerHeight + 500 >= document.documentElement.offsetHeight &&
                                this.posts.length < this.user.posts_count;

            if (shouldScroll) {
                axios.get('/api/users/' + this.user_id + '?page=' + ++this.postsPage).then((response) => {
                    response.data.posts.forEach((post) => {
                        this.posts.push(post);
                    })
                });
            }
        }
    },
    beforeMount() {
        this.getUser();
        window.onscroll = () => {
            this.getNextPosts();
        };
    }
}
</script>
