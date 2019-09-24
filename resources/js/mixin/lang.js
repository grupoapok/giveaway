const LangMixin = (step) => ({
    data() {
        return {
            lang: {},
        }
    },
    methods: {
        loadLang() {
            this.$axios.get(`/lang/${step}`)
                .then(({data}) => this.lang = data);
        },
    },
    mounted() {
        this.loadLang();
    }
});

export default LangMixin;
