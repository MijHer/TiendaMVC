<?php headerAdmin($data); ?>
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_title'] ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url();?>/dashboard">Dashboard</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">Dashboard</div>
                <?php
                    //$requestApi = CurlConnectionGet(URLPAYPAL."/v2/checkout/orders/3R855766JM8845306", "application/json", getTokenPaypal());
                    //dep($requestApi);

                    //$requestPost = CurlConnectionPost(URLPAYPAL."/v2/payments/captures/51P58980FU366112V/refund", "application/json", getTokenPaypal());
                    //dep($requestPost);
                 ?>
            </div>
        </div>
    </div>
</main>
<?php footerAdmin($data); ?>