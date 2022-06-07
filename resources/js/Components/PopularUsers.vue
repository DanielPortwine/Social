<script setup>
import User from '@/Components/User.vue';
</script>

<template>
    <div class="py-4 sm:px-6 lg:px-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h1 class="text-2xl mb-2">Popular Users</h1>
        <User v-for="user in popularUsers" v-on:refresh-popular-users="refreshPopularUsers" :user=user :key="user.id" ref="user" />
        <a @click="getNextPopularUsers" id="popular-users-more" class="cursor-pointer text-blue-500">Show more</a>
    </div>
</template>

<script>
export default {
    data() {
        return {
            popularUsers: [],
            popularUsersPage: 1,
        };
    },
    methods: {
        getPopularUsers() {
            axios.get('/api/popular/users').then((response) => {
                console.log(response.data);
                this.popularUsers = response.data;
            });
        },
        getNextPopularUsers() {
            axios.get('/api/popular/users?page=' + ++this.popularUsersPage).then((response) => {
                response.data.forEach((user) => {
                    this.popularUsers.push(user);
                });

                if (this.popularUsersPage === 5) {
                    document.getElementById('popular-users-more').remove();
                }
            });
        },
        refreshPopularUsers() {
            axios.get('/api/popular/users?pages=' + this.popularUsersPage).then((response) => {
                this.popularUsers = response.data;
            });
        }
    },
    beforeMount() {
        this.getPopularUsers();
    }
}
</script>
