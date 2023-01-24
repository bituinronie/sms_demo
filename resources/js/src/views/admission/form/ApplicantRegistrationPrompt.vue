<template>
    <v-container>
        <v-row style="height: 200px"></v-row>
        <v-row>
            <v-col md="12">
                <div class="check"></div>
            </v-col>
        </v-row>
        <v-row class="mt-16">
            <!-- <v-col cols="12" md="4" >
                <div class="check"></div>
            </v-col> -->
            <v-col cols="12" md="6" offset-md="3" class="text-center">
                <span class="text-h5 text-sm-h5 text-md-h4 font-weight-bold custom-font">Congratulations!</span><br>
                <div class="mt-2">You are a step closer from being an SPCF student!<br></div>
                <div class="mt-10">
                    We've sent your account credentials in your 
                    <span class="font-weight-bold">email</span>
                    <br class="hidden-sm-and-down">
                    that you can use to check your current
                    <br class="hidden-sm-and-down"> 
                    <span class="font-weight-bold">enrollment status</span>
                    in
                    <span class="font-weight-bold">SPCF Student Portal</span>
                </div>
                <div class="mt-16">
                    <v-btn color="primary" :to="{name: 'Student Login'}">Login to Student Portal</v-btn>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
  computed: {
  }
}
</script>

<style scoped>
    /* Here... */
    .check {
        position: absolute;
        left: calc(50%);
        /* top: calc(50% + 20px); */
        border: solid 25px var(--v-accent-base);
        width: 175px;
        height: 100px;
        margin: -50px 0 0 -100px;
        border-top: none;
        border-right: none;
        transform: rotate(-45deg);
        transform-origin: top left;
    }

    .check {
        animation: start 1s ease both;
        /* Override default play state paused of codepen iframe */
        animation-play-state: running!important;
    }

    @keyframes start {
        0% {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        20% {
            opacity: 1;
            width: 0;
            height: 100px;
        }
        100% {
            width: 175px;
        }
    }
</style>