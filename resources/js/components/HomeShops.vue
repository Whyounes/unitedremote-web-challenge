<template>
    <div>
        <div class="shops row">
            <div v-for="shop in shops" class="col shop">
                <shop :shop="shop"></shop>
            </div>
        </div>

        <hr>

        <paginate
                :page-count="pageCount"
                :click-handler="fetchShops"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :next-class="'page-item'"
                :prev-class="'page-item'"
                :page-link-class="'page-link'"
                :next-link-class="'page-link'"
                :prev-link-class="'page-link'"
        >
        </paginate>
    </div>
</template>

<script>
    import Paginate from 'vuejs-paginate'

    Vue.component('paginate', Paginate);

    export default {
        data() {
            return {
                shops: [],
                pageCount: 0,
                currentPage: 1
            }
        },
        mounted() {
            this.fetchShops();
        },
        methods: {
            fetchShops(page = 1) {
                axios.get(route('api.shops.index', {page: page}))
                    .then((response) => {
                        this.shops = response.data.data;
                        this.pageCount = response.data.meta.pagination.total_pages;
                        this.currentPage = response.data.meta.pagination.current_page;
                    })
                    .catch((error) => {
                        alert("An error occurred while fetching shops, plz reload the pae and try again!")
                    });
            }
        }
    }
</script>

<style scoped>
    .shops > .shop {
        margin-bottom: 10px;
    }
</style>
