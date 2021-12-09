<template>
    <div>
        <button class="btn btn-primary" @click="followUser" v-text="followText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],

        data: function() {
            return {
                status: this.follows
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            followUser() {
                axios.post(`/follow/${this.userId}`)
                    .then(response => {
                        this.status = ! this.status;
                        console.log(response.data);
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            window.location = '/login';
                        }
                    });
            }

        },

        computed: {  
            followText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>
