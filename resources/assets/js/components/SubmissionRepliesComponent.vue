<template>
    <div class="card card-default mb-3 mt-3">
        <div class="card-header">
            Sent by {{current.user.name}} on {{ current.created_at}} from {{current.city}}
            <weather-component :city="current.city"></weather-component>
        </div>
        <div class="card-body pr-2">
            <div class="card-text">
                {{ current.text }}
            </div>
            <a href="#" class="btn btn-secondary" @click.prevent="showReplyForm()">Reply</a>


            <!--REPLY FORM-->
            <div class="card text-white bg-secondary mb-3 mt-3" v-if="showReplyBox">
                <div class="card-header">Reply Form</div>
                <div class="card-body pr-2">
                    <div class="card-text">
                        <form action="" method="POST" @submit.prevent="onSubmitReply">

                            <div class="form-group">
                                <label for="replytext">Text</label>
                                <input v-model="replytext" type="text" class="form-control" id="replytext" placeholder="Text" required>
                            </div>

                            <div class="form-group">
                                <label for="repycity">City</label>
                                <input v-model="repycity" type="text" class="form-control" id="repycity" placeholder="City" required>
                            </div>

                            <input type="submit" class="btn btn-primary" value="Done" @click.prevent="onReply(current)">
                        </form>
                    </div>
                </div>
            </div>


            <replies-component
                    v-for="reply in current.all_replies"
                    :current="reply"
                    :key="current.id"
                    :user="user">
            </replies-component>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['current', 'user'],

        mounted() {
            console.log('Loaded a reply' + this.index);
            console.log(this.current);
        },

        data() {
            return {
                showReplyBox: false,
                replytext: '',
                repycity: ''
            }
        },

        methods: {
            showReplyForm() {
                console.log('showing reply form');
                if (this.showReplyBox) {
                    this.showReplyBox = false;
                } else {
                    this.showReplyBox = true;
                }
            },

            onReply(item) {
                console.log('replying to item ', item.id);
                console.log(item);
                axios.post('/api/submission/reply/' + item.id, {
                    text: this.replytext,
                    user_id: item.user_id,
                    city: item.city
                }).then(
                    (result) => {
                        this.response = result.data.message;
                        //todo: fix this, when 2nd level stops working. Event maybe
                        this.$parent.getAllSubmissions();
                    })
            },
        },


        name: 'more-replies',


    }

</script>
