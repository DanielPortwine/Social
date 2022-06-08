<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';
import PopularUsers from '@/Components/PopularUsers.vue';
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
                    <div v-if="post && post.deleted_at" class="py-4 sm:px-6 lg:px-8 sm:mb-4 bg-red-500 overflow-hidden shadow-xl sm:rounded-lg">
                        <i class="fa-solid fa-circle-info"></i> This post is deleted
                    </div>
                    <Post v-if="post" v-on:delete-post="deletePost" v-on:restore-post="restorePost" :post=post :deletable="true" :key="post.id" />
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
            post: null,
            comments: [],
            commentsPage: 1,
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
        refreshPost() {
            axios.get('/api/posts/' + this.post_id).then((response) => {
                this.post = response.data;
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
        },
        deletePost(id) {
            axios.delete('/api/posts/' + id).then((response) => {
                this.refreshPost();
            })
        },
        restorePost(id) {
            axios.post('/api/posts/' + id).then((response) => {
                this.refreshPost();
            })
        }
    },
    beforeMount() {
        this.getPost();
        window.onscroll = () => {
            this.getNextComments();
        };
    },
    mounted() {
        document.getElementById('refresh-comments-button').onclick = () => {
            this.getPost();
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
