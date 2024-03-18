<?=$render('header', ['loggedUser' => $loggedUser]);?>

<section class="container main">
    <?=$render('sidebar',['activeMenu'=>'home']);?>
<section class="feed mt-10">
        
    <div class="row">
        <div class="column pr-5">

            <?=$render('feed-editor', ['user' => $loggedUser]); ?>

            <?php foreach($feed['posts'] as $feedItem): ?>

                <?=$render('feed-item', [
                    'data' => $feedItem,
                    'loggedUser' => $loggedUser
                ]);?>

            <?php endforeach; ?>

            <div class="feed-pagination">
                <?php for($p=0;$p<$feed['pageCount'];$p++):?>
                    <a class="<?=($feed['currentPage']==$p)?'active':''?>" href="<?=$base;?>/?page=<?=$p;?>"><?=$p+1;?></a>
                <?php endfor;?>
            </div>

        </div>
        <div class="column side pl-5">
            <?=$render('right-side');?>
        </div>
    </div>

</section>
</section>
<?=$render('footer');?>