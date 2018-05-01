<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Submissions</div>

                    <div class="card-body pr-2">
                        <div class="card-title">
                            Submit your message
                        </div>
                        <div class="card-text">
                            <form action="/api/submission" method="POST" @submit.prevent="onSubmit">
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <input v-model="text" type="text" class="form-control" id="text" placeholder="Text"
                                           required>

                                </div>

                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input v-model="city" type="text" class="form-control" id="city" placeholder="City"
                                           required>
                                </div>

                                <p v-if="response">this is the result: {{ response }}</p>

                                <input type="submit" class="btn btn-primary" value="Done">
                            </form>
                        </div>

                    </div>
                </div>

                <h2>Previous submissions</h2>

                <template v-for="(item, index) in submissions">
                    <div class="card card-default mb-2">
                        <div class="card-header">

                            Sent by {{item.user.name}} on {{ item.created_at}} from {{item.city}}
                            <weather-component :city="item.city"></weather-component>
                        </div>
                        <div class="card-body pr-2">
                            <div class="card-text">
                                {{item.text}}
                            </div>
                            <a href="#" class="btn btn-secondary" @click.prevent="showReplyForm(index)">Reply</a>

                            <!--REPLY FORM-->
                            <div class="card text-white bg-secondary mb-3 mt-3" v-if="showReplyBox[index]">
                                <div class="card-header">Reply Form</div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <form action="" method="POST" @submit.prevent="onSubmitReply">

                                            <div class="form-group">
                                                <label for="text">Text</label>
                                                <input v-model="replytext" type="text" class="form-control" id="replytext" placeholder="Text" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="replycity">City</label>
                                                <input v-model="replycity" type="text" class="form-control" id="replycity" placeholder="City" required>
                                            </div>

                                            <input type="submit" class="btn btn-primary" value="Done" @click.prevent="onReply(item,index)">
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <replies-component v-for="reply in item.all_replies" :current="reply" :key="item.id"></replies-component>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'gkey'],

        mounted() {
            console.log('Submissions Component mounted.');
            this.getAllSubmissions();
        },

        data() {
            return {
                text: '',
                response: '',
                submissions: [],
                showReplyBox: [],
                replytext:'',
                replycity:'',
                city:'',
                coords:[],
                weather:[]
            }
        },

        methods: {

            onSubmit() {
                console.log('time to submit the form');
                axios.post('/api/submission', {
                    text: this.text,
                    user_id: this.user.id,
                    city: this.city
                }).then(
                    (result) => {
                        this.response = result.data.message;
                        this.getAllSubmissions();
                    })
            },

            getAllSubmissions() {
                console.log('getting all the submissions');
                axios.get('/api/submissions').then(result => this.submissions = result.data)
            },

            showReplyForm(index){
                if (this.showReplyBox[index]) {
                    Vue.set(this.showReplyBox, index, 0);
                } else {
                    Vue.set(this.showReplyBox, index, 1);
                }
            },

            onReply(item, index){
                console.log('replying to item ' + item.id);
                axios.post('/api/submission/reply/' + item.id, {
                    text: this.replytext,
                    user_id: item.user.id,
                    city: this.replycity
                }).then(
                    (result) => {
                        this.response = result.data.message;
                        this.getAllSubmissions();
                    })
            },

        },
    }

</script>
