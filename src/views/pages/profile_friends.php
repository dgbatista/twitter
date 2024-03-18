<?=$render('header', ['loggedUser' => $loggedUser]);?>

<section class="container main">
    <?=$render('sidebar',['activeMenu'=>'friends']);?>

    <section class="feed">

        <?=$render('profile-header', [
            'user' => $user,
            'loggedUser' => $loggedUser,
            'isFollowing' => $isFollowing
        ]);?>
        
        <div class="row">

            <div class="column">
                        
                <div class="box">
                    <div class="box-body">

                        <div class="tabs">
                            <div class="tab-item" data-for="followers">
                                Seguidores
                            </div>
                            <div class="tab-item active" data-for="following">
                                Seguindo
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-body" data-item="followers">
                                <div class="full-friend-list">

                                    <?php for($q=0; $q<14; $q++): ?>
                                        <?php if(isset($user->followers[$q])):?>
                                            <div class="friend-icon">
                                                <a href="<?=$base;?>/perfil/<?=$user->followers[$q]->id;?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base?>/media/avatars/<?=$user->followers[$q]->avatar;?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$user->followers[$q]->name;?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif;?>
                                    <?php endfor;?>  
                                </div>

                            </div>
                            <div class="tab-body" data-item="following">
                                
                                <div class="full-friend-list">
                                    
                                    <?php for($q=0;$q<14;$q++):?>
                                        <?php if(isset($user->following[$q])): ?>
                                            <div class="friend-icon">
                                                <a href="<?=$base;?>/perfil/<?=$user->following[$q]->id;?>">
                                                    <div class="friend-icon-avatar">
                                                        <img src="<?=$base;?>/media/avatars/<?=$user->following[$q]->avatar;?>" />
                                                    </div>
                                                    <div class="friend-icon-name">
                                                        <?=$user->following[$q]->name;?>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>            
        </div>
    </section>

</section>
<?=$render('footer');?>