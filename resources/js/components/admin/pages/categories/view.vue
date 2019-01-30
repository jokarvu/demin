<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="bgc-white bd bdrs-3 p-20 mB-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="c-grey-900 mB-20">Category: {{category.name}}</h4>
                        </div>
                        <div class="col-md-6">
                            <router-link to="/admin/product/create" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Add product</router-link>
                        </div>
                    </div>

                    <table id="product-index" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Instock</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in products" :key="product.id" :id="'product-'+product.id">
                                <th scope="row" class="text-center">{{product.id}}</th>
                                <td>{{product.name}}</td>
                                <td>{{product.description}}</td>
                                <td>{{product.price}}</td>
                                <td>{{product.instock}}</td>
                                <td>{{product.total}}</td>
                                <td class="text-center">
                                    <router-link :to="{name: 'ProductView', params: {slug: product.slug}}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                    <router-link :to="{name: 'ProductUpdate', params: {slug: product.slug}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></router-link>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" :data-target="'#productmodal-'+product.id">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" :id="'productmodal-'+product.id" tabindex="-1" product="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" product="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete product</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure?
                                                </div>
                                                    <div class="modal-footer">
                                                    <button type="button" @click="DeleteProduct(product.id)" class="btn btn-danger" data-dismiss="modal">Yes</button>
                                                    <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        data() {
            return {
                category: {},
                products: [],
                // table: null
            };
        },
        created () {
            var app = this;
            var slug  = app.$route.params.slug;
            axios.get("/api/category/" + slug).then(function(json) {
                app.category = json.data.category;
                app.products = json.data.products;
            }).catch(function(errors) {
                ResponseHelper.error(errors);
            });
        },
        updated() {
            var app = this;
            app.table = $("#product-index").DataTable({
                stateSave: true,
            });
        },
        methods : {
            DeleteProduct (id) {
                var app = this;
                axios.delete('/api/product/' + id).then(response => {
                    toastr.success(response.data.message);
                    app.table.rows('#product-'+id).remove().draw(false);
                }).catch(errors => {
                    ResponseHelper.error(errors);
                });
            },
        }
    };
</script>
