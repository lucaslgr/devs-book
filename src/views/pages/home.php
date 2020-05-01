<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'home']) ?>
    <section class="feed mt-10">
        <div class="row">
            <div class="column pr-5">
                <?=$render('feed-editor', ['user' => $loggedUser]);?>

                <?php foreach($feed['posts'] as $feedItem):?>
                    <?=$render('feed-item', [
                        'feedItem'=> $feedItem,
                        'loggedUser'=>$loggedUser
                    ]);?>
                <?php endforeach;?>
                <div class="pagination">
                    <?php for($i=0;$i<intval($feed['totalPages']);$i++):?>
                        <a class="<?=($i==intval($feed['currentPage']))?('active'):('');?>" href="<?=$base;?>/?p=<?=$i;?>"><?=($i+1)?></a>
                    <?php endfor;?>
                </div>
            </div>
            <div class="column side pl-5">
                <?=$render('right-side');?>
            </div>
        </div>

    </section>
</section>
<?=$render('footer')?>