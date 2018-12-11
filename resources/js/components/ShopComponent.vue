<template>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title text-center">{{ shop.name }}</h5>
            <img class="card-img-top" :src="shop.image" :alt="shop.name">

            <hr/>

            <template>
                <a href="#" @click.prevent="likeShop" class="btn btn-info card-link">Like</a>
                <a href="#" @click.prevent="dislikeShop" class="btn btn-danger card-link">Dislike</a>
            </template>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['shop'],
        mounted() {

        },
        methods: {
            likeShop() {
                // Quick exist for 401
                if (!window.hasOwnProperty('user_authenticated') || window.user_authenticated !== true) {
                    alert("Plz login to add the shop to your preferred shops list.");
                    return;
                }

                axios.post(route('api.shops.like', {shop: this.shop.id}))
                    .then((response) => {
                        alert(`Successfully added ${this.shop.name} to your preferred shops.`);
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            alert("Plz login to add the shop to your preferred shops list.");
                            return;
                        }

                        alert(`An error occurred while adding ${shop.name} to your preferred shops.`);
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
                        alert(`You won't see ${this.shop.name} again :)`);
                    })
                    .catch((error) => {
                        if (error.response.status === 401) {
                            alert("Plz login to dislike a shop");
                            return;
                        }

                        alert(`An error occurred while disliking ${shop.name}.`);
                    })
            },
        }
    }
</script>
