<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';
import User from '@/Components/User.vue';
import SecondaryButton from "../Jetstream/SecondaryButton";
defineProps({
    post_id: Number,
});
</script>

<template>
    <AppLayout title="Post">
        <div class="max-w-7xl py-2 sm:py-6 mx-auto">
            <div class="grid grid-cols-6 md:mx-4">
                <div class="col-span-6 md:col-span-4 md:mr-4">
                    <Post v-if="post" :post=post :key="post.id" />
                    <div class="p-2">
                        <secondary-button id="refresh-comments-button" class="bg-blue-500 text-white hover:text-gray-300">Refresh</secondary-button>
                    </div>
                    <div class="py-4 sm:px-6 lg:px-8 sm:mb-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <textarea id="comment-textarea"
                                  class="w-full form-textarea border-0 focus:ring-0 focus:border-b border-gray-400 resize-none overflow-hidden"
                                  placeholder="Leave a comment..."
                                  maxlength="255"
                                  rows="1"></textarea>
                        <secondary-button id="create-comment-button" class="mx-2">Post</secondary-button>
                    </div>
                    <div id="comments-container">
                        <Post v-if="comments" v-for="comment in comments" :post=comment :key="comment.id" />
                    </div>
                </div>
                <div class="hidden md:block md:col-span-2">
                    <div class="py-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <h1 class="text-2xl mb-2">Popular Users</h1>
                        <User v-for="user in popularUsers" :user=user />
                        <a id="popular-users-more" class="cursor-pointer text-blue-500">Show more</a>
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
            post: null,
            comments: [],
            commentsPage: 1,
            popularUsers: [],
            popularUsersPage: 1,
        };
    },
    methods: {
        getPost() {
            axios.get('/api/posts/' + this.post_id).then((response) => {
                this.post = response.data;
                this.comments = response.data.comments;
                setTimeout(this.getNextComments, 1);
            });
        },
        getNextComments() {
            let shouldScroll = document.documentElement.scrollTop + window.innerHeight + 500 >= document.documentElement.offsetHeight &&
                                this.comments.length < this.post.comments_count;

            if (shouldScroll) {
                axios.get('/api/posts/' + this.post_id + '?page=' + ++this.commentsPage).then((response) => {
                    response.data.comments.forEach((comment) => {
                        this.comments.push(comment);
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
        },
        createComment() {
            let textarea = document.getElementById('comment-textarea'),
                content = textarea.value;

            if (content.length > 0) {
                axios.post('/api/posts/store', {
                    content: content,
                    parent_id: this.post_id,
                }).then((response) => {
                    this.comments.unshift(response.data);
                    textarea.value = "";
                    textarea.rows = "1";
                });
            }
        }
    },
    beforeMount() {
        this.getPost();
        window.onscroll = () => {
            this.getNextComments();
        };
        this.getPopularUsers();
    },
    mounted() {
        document.getElementById('refresh-comments-button').onclick = () => {
            this.getPost();
        };
        document.getElementById('popular-users-more').onclick = () => {
            this.getNextPopularUsers();
        };
        document.getElementById('comment-textarea').onfocus = () => {
            document.getElementById('comment-textarea').rows = "5";
        };
        document.getElementById('comment-textarea').onblur = () => {
            if (document.getElementById('comment-textarea').value.length === 0) {
                document.getElementById('comment-textarea').rows = "1";
            }
        };
        document.getElementById('create-comment-button').onclick = () => {
            this.createComment();
        }
    }
}
</script>
