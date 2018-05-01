<template>
    <div class="weather">

        <span v-if="lat">(lat: {{lat}}, lon:{{lon}})</span>
        <span v-if="temp">{{temp}}C</span>
    </div>
</template>

<script>
    export default {
        props: ['city'],

        mounted() {
            console.log('Weather Component mounted.');
            this.getWeather();
        },

        data() {
            return {
                lat: '',
                lon: '',
                temp: ''
            }
        },

        methods: {

            getWeather() {
                console.log('getting weather for ' + this.city);

                axios.get('/api/weather/' + this.city).then(
                    (result) => {
                        this.temp = result.data.main.temp;
                        this.lat = result.data.coord.lat;
                        this.lon = result.data.coord.lon;
                    }
                );
            }
        },
    }

</script>
