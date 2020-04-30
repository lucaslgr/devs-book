<?= $render('header', ['loggedUser' => $loggedUser]); ?>
<section class="container main">
    <?= $render('sidebar',['activeMenu' => 'profile']) ?>

    <section class="feed">
        <div class="row">
            <div class="box flex-1 border-top-flat">
                <div class="box-body">
                    <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?=$user->getCover();?>');"></div>
                    <div class="profile-info m-20 row">
                        <div class="profile-info-avatar">
                            <img src="<?=$base;?>/media/avatars/avatar.jpg" />
                        </div>
                        <div class="profile-info-name">
                            <div class="profile-info-name-text"><?=$user->getName();?></div>
                            <div class="profile-info-location"><?=$user->getCity();?></div>
                        </div>
                        <div class="profile-info-data row">
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($user->followers)?></div>
                                <div class="profile-info-item-s">Seguidores</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($user->followings)?></div>
                                <div class="profile-info-item-s">Seguindo</div>
                            </div>
                            <div class="profile-info-item m-width-20">
                                <div class="profile-info-item-n"><?=count($user->photos)?></div>
                                <div class="profile-info-item-s">Fotos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="column side pr-5">

                <div class="box">
                    <div class="box-body">

                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/calendar.png" />
                            <?=date('d-m-Y',strtotime($user->getBirthDate()));?> (<?=$user->agrYears;?> anos)
                        </div>

                        <?php if(!empty($user->getCity())):?>
                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/pin.png" />
                            <?=$user->getCity();?>, Brasil
                        </div>
                        <?php endif;?>

                        <?php if(!empty($user->getWork())):?>
                        <div class="user-info-mini">
                            <img src="<?=$base;?>/assets/images/work.png" />
                            <?=$user->getWork();?>
                        </div>
                        <?php endif;?>

                    </div>
                </div>

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Seguindo
                            <span>(<?=count($user->followers)?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?=$base;?>/">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body friend-list">

                        <!-- <div class="friend-icon">
                            <a href="<?=$base;?>/">
                                <div class="friend-icon-avatar">
                                    <img src="<?=$base;?>/media/avatars/avatar.jpg" />
                                </div>
                                <div class="friend-icon-name">
                                    Bonieky
                                </div>
                            </a>
                        </div> -->

                        <?php for($i=0; $i<9; $i++):?>
                            <?php if(isset($user->followings[$i])):?>
                                <div class="friend-icon">
                                    <a href="<?=$base;?>/profile/<?=$user->followings[$i]->getId();?>">
                                        <div class="friend-icon-avatar">
                                            <img src="<?=$base;?>/media/avatars/<?=$user->followings[$i]->getAvatar();?>" />
                                        </div>
                                        <div class="friend-icon-name">
                                            <?=$user->followings[$i]->getName();?>
                                        </div>
                                    </a>
                                </div>
                            <?php endif;?>
                        <?php endfor;?>
                    </div>
                </div>

            </div>
            <div class="column pl-5">

                <div class="box">
                    <div class="box-header m-10">
                        <div class="box-header-text">
                            Fotos
                            <span>(<?=count($user->photos)?>)</span>
                        </div>
                        <div class="box-header-buttons">
                            <a href="<?=$base;?>/">ver todos</a>
                        </div>
                    </div>
                    <div class="box-body row m-20">

                        <?php for($i=0; $i<4; $i++):?>
                            <?php if(isset($user->photos[$i])):?>
                                <div class="user-photo-item">
                                    <a href="<?=$base;?>/#modal-<?=$user->photos[$i]->id;?>" rel="modal:open">
                                        <img src="<?=$base;?>/media/uploads/<?=$user->photos[$i]->body;?>" />
                                    </a>
                                    <div id="modal-<?=$user->photos[$i]->id;?>" style="display:none">
                                        <img src="<?=$base;?>/media/uploads/<?=$user->photos[$i]->body;?>" />
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php endfor;?>
                        
                    </div>
                </div>

                <?php if($user->getId() == $loggedUser->getId()):?>
                    <?=$render('feed-editor', ['user' => $loggedUser]);?>
                <?php endif;?>
                
                <?php foreach($feed['posts'] as $feedItem):?>
                    <?=$render('feed-item', [
                        'feedItem'=> $feedItem,
                        'loggedUser'=>$loggedUser
                    ]);?>
                <?php endforeach;?>
                <div class="pagination">
                    <?php for($i=0;$i<intval($feed['totalPages']);$i++):?>
                        <a class="<?=($i==intval($feed['currentPage']))?('active'):('');?>" href="<?=$base;?>/profile/<?=$user->getId();?>?p=<?=$i;?>"><?=($i+1)?></a>
                    <?php endfor;?>
                </div>
            </div>

        </div>

    </section>

</section>
<?= $render('footer') ?>