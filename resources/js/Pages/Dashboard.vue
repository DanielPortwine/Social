<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';
import PopularUsers from '@/Components/PopularUsers.vue';
import SecondaryButton from "../Jetstream/SecondaryButton";
</script>

<template>
    <AppLayout title="Home">
        <div class="max-w-7xl py-2 sm:py-6 mx-auto">
            <div class="grid grid-cols-6 md:mx-4">
                <div class="col-span-6 md:col-span-4 md:mr-4">
                    <div class="py-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <textarea id="post-textarea"
                                  class="w-full form-textarea border-0 focus:ring-0 focus:border-b border-gray-400 resize-none overflow-hidden"
                                  placeholder="Share your thoughts..."
                                  maxlength="255"
                                  rows="1"></textarea>
                        <secondary-button id="create-post-button" class="mx-2">Post</secondary-button>
                    </div>
                    <div class="p-2 overflow-hidden">
                        <secondary-button id="refresh-posts-button" class="bg-blue-500 text-white hover:text-gray-300">Refresh</secondary-button>
                    </div>
                    <div id="posts-container">
                        <Post v-for="post in posts" :post=post :key="post.id" />
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
        createPost() {
            let textarea = document.getElementById('post-textarea'),
                content = textarea.value;

            if (content.length > 0) {
                axios.post('/api/posts/store', {
                    content: content,
                }).then((response) => {
                    this.posts.unshift(response.data);
                    textarea.value = "";
                    textarea.rows = "1";
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
        document.getElementById('post-textarea').onfocus = () => {
            document.getElementById('post-textarea').rows = "5";
        };
        document.getElementById('post-textarea').onblur = () => {
            if (document.getElementById('post-textarea').value.length === 0) {
                document.getElementById('post-textarea').rows = "1";
            }
        };
        document.getElementById('create-post-button').onclick = () => {
            this.createPost();
        }
    }
}
</script>
