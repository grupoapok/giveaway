import {mapActions, mapState} from 'vuex';

export default namespace => ({
    data() {
        return {
            orderBy: {
                field: null,
                order: 'asc'
            },
            filters: {},
            filtersFields: []
        }
    },
    computed: {
        ...mapState(namespace, ['list', 'loading', 'currentPage', 'totalPages', 'perPage', 'pageSize']),
    },
    methods: {
        ...mapActions(namespace, ['getItemList', 'changePage', 'deleteItem', 'resetList']),
        refresh() {
            this.resetList();
            this.loadPage(this.currentPage);
        },
        processFilters() {
            return this.filters;
        },
        loadPage(page) {
            if (!this.list[page]) {
                let orderBy = '';
                if (this.orderBy.field) {
                    orderBy = `${this.orderBy.field}|${this.orderBy.order}`
                }
                this.getItemList({page, size: this.pageSize, orderBy, ...this.processFilters()});
            } else {
                this.changePage(page);
            }
        },
        changePageSize(size) {
            this.$store.dispatch(`${namespace}/changePageSize`, size, {root: true})
                .then(() => this.resetList())
                .then(() => {
                    this.$nextTick(() => {
                        this.loadPage(this.currentPage);
                    });
                });
        },
        toggleOrder(field) {
            let newOrder = 'asc';
            if (this.orderBy.field === field) {
                if (this.orderBy.order === 'asc') {
                    newOrder = 'desc'
                }
            }
            this.orderBy = {
                field,
                order: newOrder
            }
        },
        filtersUpdated() {
            this.resetList();
            this.loadPage(1)
        }
    },
    watch: {
        orderBy() {
            this.resetList().then(() => this.loadPage(this.currentPage))
        }
    },
    mounted() {
        this.loadPage(this.currentPage);
    },
});
