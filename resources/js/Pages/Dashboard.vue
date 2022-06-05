<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';
import User from '@/Components/User.vue';
import SecondaryButton from "../Jetstream/SecondaryButton";
</script>

<template>
    <AppLayout title="Home">
        <div class="max-w-7xl py-2 sm:py-6 mx-auto">
            <div class="grid grid-cols-6 md:mx-4">
                <div class="col-span-6 md:col-span-4 md:mr-4">
                    <div class="py-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <textarea class="w-full form-textarea border-0 focus:ring-0 focus:border-b border-gray-400 resize-none h-auto"
                                  placeholder="Share your thoughts..."
                                  rows="1">
                        </textarea>
                        <secondary-button>Post</secondary-button>
                    </div>
                    <div class="p-2 overflow-hidden">
                        <secondary-button id="refresh-posts-button" class="bg-blue-500 text-white hover:text-gray-300">Refresh</secondary-button>
                    </div>
                    <div id="posts-container">
                        <Post v-for="post in posts" :post=post />
                    </div>
                </div>
                <div class="hidden md:block md:col-span-2">
                    <div class="py-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h1 class="text-2xl mb-2">Popular Users</h1>
                        <User v-for="user in popularUsers" :user=user />
                        <a id="popular-users-more" class="">Show more</a>
                    </div>
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
            postsPage: 1,
            popularUsers: [],
            popularUsersPage: 1,
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
                axios.get('/api/posts?page=' + ++this.postsPage).then((response) => {
                    response.data.forEach((post) => {
                        this.posts.push(post);
                    })
                });
            }
        },
        getPopularUsers() {
            axios.get('/api/popular/users').then((response) => {
                this.popularUsers = response.data;
            });
        },
        getNextPopularUsers() {
            axios.get('/api/popular/users?page=' + ++this.popularUsersPage).then((response) => {
                response.data.forEach((user) => {
                    this.popularUsers.push(user);
                })
            });

            if (this.popularUsersPage >= 5) {
                document.getElementById('popular-users-more').remove();
            }
        }
    },
    beforeMount() {
        this.getInitialPosts();
        window.onscroll = () => {
            this.getNextPosts();
        };
        this.getPopularUsers();
    },
    mounted() {
        document.getElementById('refresh-posts-button').onclick = () => {
            this.getInitialPosts();
        };
        document.getElementById('popular-users-more').onclick = () => {
            this.getNextPopularUsers();
        };
    }
}
</script>
