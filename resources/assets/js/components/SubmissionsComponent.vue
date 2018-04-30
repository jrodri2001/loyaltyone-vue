<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Submissions</div>

                    <div class="card-body">
                        <div class="card-title">
                            Create a submission
                        </div>
                        <div class="card-text">
                            <form action="/api/submission" method="POST" @submit.prevent="onSubmit">

                                <div class="form-group">
                                    <label v-model="user">User {{ user.name }}</label>
                                </div>

                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <input v-model="text" type="text" class="form-control" id="text" placeholder="Text"
                                           required>
                                    <p v-if="response">this is the result: {{ response }}</p>
                                </div>

                                <input type="submit" class="btn btn-primary" value="Done">
                            </form>
                        </div>

                    </div>
                </div>

                <h2>Previous submissions</h2>

                <template v-for="item in submissions">
                    <div class="card card-default">
                        <div class="card-header">
                            Sent by {{item.user.name}} on {{ item.created_at | date 'Y-m-d'}}
                        </div>
                        <div class="card-body">
                            {{item.text}}
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        mounted() {
            console.log('Submissions Component mounted.');
            this.getAllSubmissions();
        },

        data() {
            return {
                text: '',
                response: '',
                submissions: []
            }
        },

        methods: {

            onSubmit() {
                console.log('time to submit the form');
                axios.post('/api/submission', {text: this.text, user_id: this.user.id}).then(
                    (result) => {
                        this.response = result.data.message;
                        this.getAllSubmissions();
                    })
            },

            getAllSubmissions() {
                console.log('getting all the submissions');
                axios.get('/api/submissions').then(result => this.submissions = result.data)
            }
        },
    }

</script>
