<template>
    <div>
        <h5 class="text-secondary font-weight-bold" v-html="lang.follow_us"></h5>
        <ul>
            <li v-for="(link, i) in links">
                <a :href="links[i].url" target="_blank" @click="() => registerEvent(link)">
                    <font-awesome-icon :icon="['fab', link.name]" class="logo"></font-awesome-icon>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    import LangMixin from '../mixin/lang';

    export default {
        name: "SocialLinksComponent",
        mixins: [LangMixin('social')],
        data() {
            return {
                links: []
            }
        },
        methods: {
            registerEvent(data) {
                fbq('trackCustom', 'SocialLinkClick', data);
            }
        },
        mounted() {
            this.$axios.get('/social_info')
                .then(({data}) => {
                    this.links = data;
                });
        }
    }
</script>

<style scoped lang="scss">
    @import "../../sass/colors";

    div {
        @media(max-width: 576px) {
            width: 100%;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: inline-flex;
            flex-direction: row;

            @media(max-width: 576px) {
                width: 100%;
                justify-content: space-between;
                li {
                    margin: 0 !important;
                }
            }

            li {
                margin-right: 40px;

                &:last-child {
                    margin-right: 0;
                }

                a {
                    color: $azul_oscuro;
                    text-decoration: none;
                    transition: all .25s ease-in-out;

                    &:hover {
                        color: $naranja;
                    }

                    .logo {
                        font-size: 2rem;
                    }
                }
            }
        }
    }
</style>
