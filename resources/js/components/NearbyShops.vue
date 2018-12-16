<template>
    <div>
        <template v-if="geolocationErrorMsg">
            <p class="alert alert-danger">
                Geolocation is necessary to find nearby shops. Using fake location now!

                <small>
                    {{ geolocationErrorMsg }}
                </small>
            </p>
        </template>

        <div class="shops row">
            <div v-for="shop in shops" class="col shop">
                <shop
                        :shop="shop"
                        v-on:shop-liked="fetchShops(currentPage)"
                        v-on:shop-disliked="fetchShops(currentPage)"
                ></shop>
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
    import Geolocation from 'geolocation'

    Vue.component('paginate', Paginate);

    export default {
        data() {
            return {
                shops: [],
                pageCount: 0,
                currentPage: 1,
                currentLocation: null,
                geolocationErrorMsg: null
            }
        },
        mounted() {
            // TODO; Check browser support before starting.
            // TODO; because of some security issues, the spec only allows HTTPS, localhost, ...
            Geolocation.getCurrentPosition((error, location) => {
                if (error) {
                    this.geolocationErrorMsg = this.getGeolocationError(error);
                    alert("We need your current location to find nearby shops! You get all shops instead. Using fake location now!");
                    this.currentLocation = JSON.parse('{"coords": {"latitude":50.941863,"longitude":6.958374, "accuracy":20.0}}');
                } else {
                    this.currentLocation = location;
                }

                this.fetchShops();
            });
        },
        methods: {
            fetchShops(page = 1) {
                axios.get(route('api.shops.index'),
                    {
                        params: {
                            page: page,
                            lat: _.has(this.currentLocation, 'coords.latitude') ? this.currentLocation.coords.latitude : null,
                            lng: _.has(this.currentLocation, 'coords.longitude') ? this.currentLocation.coords.longitude : null
                        }
                    }
                ).then((response) => {
                    this.shops = response.data.data;
                    this.pageCount = response.data.meta.pagination.total_pages;
                    this.currentPage = response.data.meta.pagination.current_page;
                }).catch((error) => {
                    alert("An error occurred while fetching shops, plz reload the page and try again!")
                });
            },
            getGeolocationError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        return "User denied the request for Geolocation.";
                    case error.POSITION_UNAVAILABLE:
                        return "Location information is unavailable.";
                    case error.TIMEOUT:
                        return "The request to get user location timed out.";
                    case error.UNKNOWN_ERROR:
                        return "An unknown error occurred.";
                }
            }
        }
    }
</script>

<style scoped>
    .shops > .shop {
        margin-bottom: 10px;
    }
</style>
