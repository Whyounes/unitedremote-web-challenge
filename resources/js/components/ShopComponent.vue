<template>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title text-center">{{ shop.name }}</h5>
            <img class="card-img-top" :src="shop.image" :alt="shop.name">

            <hr/>

            <template v-if="isPreferredListing == true">
                <a href="#" @click.prevent="removeShop" class="btn btn-danger card-link">Remove</a>
            </template>
            <template v-else>
                <a
                        href="#"
                        class="btn btn-info card-link"
                        @click.prevent="likeShop"
                        v-if="!isLiked(shop)"
                >
                    Like
                </a>
                <a
                        href="#"
                        class="btn btn-danger card-link"
                        @click.prevent="dislikeShop"
                        v-if="!isDisliked(shop)"
                >
                    Dislike
                </a>
            </template>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            shop: {
                validator(value) {
                    return _.isObject(value) && _.has(value, 'name') && _.has(value, 'image') && _.has(value, 'id');
                }
            },
            isPreferredListing: {
                type: Boolean,
                default: false
            }
        },
        mounted() {
        },
        methods: {
            isLiked(shop) {
                return shop.hasOwnProperty('is_liked') && shop.is_liked === true;
            },
            isDisliked(shop) {
                return shop.hasOwnProperty('is_disliked') && shop.is_disliked === true;
            },
            removeShop() {
                axios.delete(route('api.shops.like.delete', {shop: this.shop.id}))
                    .then((response) => {
                        alert(`Successfully removed ${this.shop.name} to your preferred shops.`);
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            alert("Plz login to add the shop to your preferred shops list.");
                            return;
                        }

                        if (error.response.status === 400) {
                            alert(error.response.data.message);
                            return;
                        }

                        alert(`An error occurred while adding ${this.shop.name} to your preferred shops.`);
                    })
            },
            likeShop() {
                // Quick exist for 401
                if (!window.hasOwnProperty('user_authenticated') || window.user_authenticated !== true) {
                    alert("Plz login to add the shop to your preferred shops list.");
                    return;
                }

                axios.post(route('api.shops.like', {shop: this.shop.id}))
                    .then((response) => {
                        this.$emit('shop-liked', {shop: this.shop});

                        alert(`Successfully added ${this.shop.name} to your preferred shops.`);
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            alert("Plz login to add the shop to your preferred shops list.");
                            return;
                        }

                        if (error.response.status === 400) {
                            alert(error.response.data.message);
                            return;
                        }

                        alert(`An error occurred while adding ${this.shop.name} to your preferred shops.`);
                    })
            },
            dislikeShop() {
                // Quick exist for 401
                if (!window.hasOwnProperty('user_authenticated') || window.user_authenticated !== true) {
                    alert("Plz login to dislike a shop.");
                    return;
                }

                axios.post(route('api.shops.dislike', {shop: this.shop.id}))
                    .then((response) => {
                        this.$emit('shop-disliked', {shop: this.shop});

                        alert(`You won't see ${this.shop.name} again :)`);
                        // TODO; remove from listing or reload the page.
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            alert("Plz login to dislike a shop");
                            return;
                        }

                        if (error.response.status === 400) {
                            alert(error.response.data.message);
                            return;
                        }

                        alert(`An error occurred while disliking ${this.shop.name}.`);
                    })
            },
        }
    }
</script>
