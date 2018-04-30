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
                                    <label for="text">Text</label>
                                    <input v-model="text" type="text" class="form-control" id="text" placeholder="Text" required>
                                </div>

                                <input type="submit" class="btn btn-primary" value="Done">
                            </form>
                        </div>

                        <p v-if="response">this is the result {{ response }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Submissions Component mounted.');
        },

        data () {
           return {
               text:'',
               response: ''
           }
        },

        methods: {

            onSubmit(){
                console.log('time to submit the form');
                axios.post('/api/submission', {text:this.text}).then(result => this.response = result.data.data)
            }
        }
    }

</script>
