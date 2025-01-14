<div class="container">
    <!-- Tab Prodcut Section -->
    <div class="mb-6">
        <!-- Nav Classic -->
        <div class="position-relative bg-white text-center z-index-2">
            <ul class="nav nav-classic nav-tab justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active js-animation-link" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab"
                        aria-controls="pills-one-example1" aria-selected="true" data-target="#pills-one-example1" data-link-group="groups"
                        data-animation-in="slideInUp">
                        <div class="d-md-flex justify-content-md-center align-items-md-center">
                            Productos
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Nav Classic -->
        <!-- Tab Content -->
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab"
                data-target-group="groups">
                <ul class="row list-unstyled products-group no-gutters">
                    <?php foreach ($productsList as $product): ?>
                        <li class="col-6 col-md-4 col-lg-3 col-xl product-item">
                            <div class="product-item__outer h-100">
                                <div class="product-item__inner px-xl-4 p-3">
                                    <div class="product-item__body pb-xl-2">
                                        <div class="mb-2"><a href="#" class="font-size-12 text-gray-5"><?= $product['description'] ?></a></div>
                                        <h5 class="mb-1 product-item__title"><a href="#" class="text-blue font-weight-bold"><?= $product['name'] ?></a>
                                        </h5>
                                        <div class="mb-2">
                                            <a href="#" class="d-block text-center"><img class="img-fluid" src="<?= $product['image'] ?>"
                                                    alt="Image Description"></a>
                                        </div>
                                        <div class="flex-center-between mb-1">
                                            <div class="prodcut-price d-flex align-items-center position-relative">
                                                <div class="text-gray-100">s/ <?= number_format($product['price'], 2) ?></div>
                                            </div>
                                            <div class="d-none d-xl-block prodcut-add-cart">
                                                <a href="javascript:;" class="btn-add-cart btn-primary transition-3d-hover"
                                                    onclick="addToCart(<?= $product['id'] ?>)"><i class="ec ec-add-to-cart"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
        <!-- End Tab Content -->
    </div>
    <!-- End Tab Prodcut Section -->
</div>