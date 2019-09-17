<template>
    <ul>
        <li v-for="(logo, i) in logos">
            <a :href="links[i]" target="_blank">
                <i :class="logo"></i>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "SocialLinksComponent",
        data() {
            return {
                logos: [
                    'icon-twitter-logo',
                    'icon-facebook-logo',
                    'icon-instagram-logo',
                    'icon-linkedin-logo'
                ],
                links: [
                    'https://twitter.com/grupoapok',
                    'https://facebook.com/grupoapok',
                    'https://instagram.com/grupoapok',
                    'https://linkedin.com/company/grupoapok'
                ]
            }
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
            }
        }
    }

    [class^="icon-"], [class*=" icon-"] {
        font-size: 25px;
    }
</style>