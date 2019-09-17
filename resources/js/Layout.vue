<template>
    <div class="row" id="main_row" :class="[grow && 'flex-grow-1']">
        <div class="col-12 col-lg" id="left">
            <slot name="col1"/>
        </div>
        <div class="col-12 col-lg my-5 my-lg-0" id="right">
            <slot name="col2"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Layout",
        props: {
            grow: {
                type: Boolean,
                default: true,
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../sass/colors";

    .layout {
        height: 100%;
        overflow: hidden;
        position: relative;

        @media(max-width: 1200px) {
            overflow: unset;
        }

        #main {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 2% 10%;
            @media(max-width: 992px) {
                padding: 10%;
            }
            justify-content: space-between;
        }
    }

    #big_square {
        z-index: 0;
        width: 64.6vw;
        height: 64.6vw;
        position: absolute;
        transform: rotate(45deg);
        transition: left .75s ease-in-out;
        left: -20%;
        top: -20%;

        &.right {
            right: -20%;
            left: unset;
        }

        @media(max-width: 768px) {
            width: 100vw;
            height: 100vw;
            left: 0;
            top: -70vw;
            &.right {
                right: 0;
            }
        }

        > div {
            width: 100%;
            height: 100%;
            border: 15px solid white;
            -webkit-box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.1);
            background-image: linear-gradient(to bottom right, #93DCEB, white);
        }
    }
</style>