<?=$render('header', ['loggedUser' => $loggedUser]);?>

<section class="container main">
    <?=$render('sidebar',['activeMenu'=>'photos']);?>

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
                        
                        <div class="full-user-photos">

                            <?=(count($user->photos) === 0)?'Este usuário não possui fotos.': ''?>

                            <?php foreach($user->photos as $photo): ?>
                                <div class="user-photo-item">
                                    <a href="#modal-<?=$photo->id?>" rel="modal:open">
                                        <img src="<?=$base;?>/media/uploads/<?=$photo->body;?>" />
                                    </a>
                                    <div id="modal-1" style="display:none">
                                        <img src="media/uploads/1.jpg" />
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>                    
                    </div>
                </div>   
            </div>         
        </div>
    </section>

</section>
<?=$render('footer');?>