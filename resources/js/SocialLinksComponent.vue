<template>
    <ul>
        <li v-for="(link, i) in links">
            <a :href="links[i].url" target="_blank">
                <font-awesome-icon :icon="['fab', link.name]" class="logo"></font-awesome-icon>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "SocialLinksComponent",
        data() {
            return {
                links: []
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
    @import "../sass/colors";

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
</style>