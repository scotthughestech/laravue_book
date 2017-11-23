<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>
                    Purchases
                </span>

                <a class="action-link">
                    Create New Purchase
                </a>
            </div>
        </div>
        <div class="panel-body">
            <p class="m-b-none" v-if="purchases.length === 0">
                You have not created any purchases.
            </p>
            <table class="table table-borderless m-b-none" v-if="purchases.length > 0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in purchases">
                        <td style="vertical-align: middle;">
                            {{ purchase.date }}
                        </td>
                        <td style="vertical-align: middle;">
                            ${{ purchase.price }}
                        </td>
                        <td style="vertical-align: middle;">
                            {{ purchase.description }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                purchases: []
            }
        },
        mounted() {
            this.getPurchases();
        },
        methods: {
            getPurchases() {
                axios.get('/purchases')
                    .then(response => {
                        this.purchases = response.data;
                    });
            }
        }
    }
</script>
