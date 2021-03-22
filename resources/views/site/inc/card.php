<div class="card-item">
    <div class="img-wrap">
        <img src="<?php echo $img; ?>" alt="">
    </div>
    <div class="card-info">
        <h3 class="card-title"><?php echo $title; ?></h3>
        <div class="card-middle">
            <div class="store"><?php echo $store; ?></div>
            <div class="card-group">
                
                <div class="card-count-item"><div class="icon"><?php include "img/view-icon.svg"; ?></div><div class="count"><?php echo $view; ?></div></div>
            </div>
        </div>
        <div class="card-bottom">
            <div class="price"><?php echo $price; ?></div>
            <div class="card-group">
                <div class="till">Till <?php echo $till; ?></div>
                <div class="card-count-item"><div class="icon"><?php include "img/user-icon.svg"; ?></div><div class="count"><?php echo $share; ?></div></div>
                <div class="card-count-item"><div class="icon"><?php include "img/heart-icon.svg"; ?></div><div class="count"><?php echo $like; ?></div></div>
            </div>
        </div>
    </div>
</div>