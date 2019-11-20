<template>
    <div class="row">
        <div class="col-12 mt-5">
            <h4 class="text-secondary extra-bold" v-html="lang.title"></h4>
            <p class="text-primary font-weight-bold" v-html="lang.subtitle"></p>
            <ul>
                <li v-for="t in lang.items">
                    <span v-html="t.title"></span>
                    <p class="ml-4" v-html="t.content" v-if="t.content"></p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import LangMixin from '../mixin/lang';

    export default {
        name: "Page2Extra",
        mixins: [LangMixin('step2extra')],
    }
</script>

<style scoped lang="scss">
    @import '../../sass/colors';

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;

        li {
            color: $azul_oscuro2;
            font-size: 1.25rem;

            &::before {
                display: inline-block;
                content: '✔️';
                margin-right: .5rem;
            }
        }
    }
</style>
