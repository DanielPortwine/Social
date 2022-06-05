<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';
import SecondaryButton from "../Jetstream/SecondaryButton";
</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <secondary-button id="refresh-posts-button" class="bg-blue-500 text-white hover:text-gray-300 m-6">Refresh</secondary-button>
                <div id="posts-container">
                    <Post v-for="post in posts" :post=post />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            page: 1,
        };
    },
    methods: {
        getInitialPosts() {
            axios.get('/api/posts').then((response) => {
                this.posts = response.data;
                setTimeout(this.getNextPosts, 1);
            });
        },
        getNextPosts() {
            let shouldScroll = document.documentElement.scrollTop + window.innerHeight + 500 >= document.documentElement.offsetHeight;

            if (shouldScroll) {
                axios.get('/api/posts?page=' + ++this.page).then((response) => {
                    response.data.forEach((post) => {
                        this.posts.push(post);
                    })
                });
            }
        }
    },
    beforeMount() {
        this.getInitialPosts();
        window.onscroll = () => {
            this.getNextPosts();
        };
    },
    mounted() {
        document.getElementById('refresh-posts-button').onclick = () => {
            this.getInitialPosts();
        };
    }
}
</script>
