<template>
    <font-awesome-icon fixed-width :icon="['fab', brand]"></font-awesome-icon>
</template>

<script>
    export default {
        name: "BrandIcon",
        props: {
            brand: {
                type: String,
                default: null
            }
        },
        computed: {
            logo() {
                if (this.brand) {
                    const capitalized = this.brand[0].toUpperCase() + this.brand.substring(1);
                    return `fa${capitalized}`;
                }
                return '';
            }
        }
    }
</script>

<style scoped>

</style>
