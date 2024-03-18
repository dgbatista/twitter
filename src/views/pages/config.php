<?=$render('header', ['loggedUser' => $loggedUser]);?>

<section class="container main">
    <?=$render('sidebar',['activeMenu'=>'config']);?>

    <section class="feed mt-10">
        
        <h1>Configurações</h1><br/>
           
        <div class="flash">
            <?=$flash;?>
        </div><br/>           
            
        <form class="config-form" method="POST" action="<?=$base;?>/config" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$user->id;?>"/>    

            <img id="config-form-avatar" src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" /><br/><br/>

            <label for="avatar">Novo Avatar:</label></br></br>
            <input  type="file" name="avatar" id="avatar"/></br></br></br>

            <img id="config-form-cover" src="<?=$base;?>/media/covers/<?=$user->cover;?>" /><br/><br/>

            <label for="cover">Nova Capa:</label></br></br>
            <input  type="file" name="cover" id="cover"/></br></br>

            <hr/></br></br>

            <label for="name">Nome Completo:</label></br>
            <input  type="text" name="name" id="name" value="<?=$user->name;?>"/></br></br></br>

            <label for="birthdate">Data de nascimento:</label></br>
            <input  type="text" name="birthdate" id="birthdate" value="<?=date('d/m/Y', strtotime($user->birthdate));?>"/></br></br></br>

            <label for="email">E-mail:</label></br>
            <input  type="email" name="email" id="email" value="<?=$user->email;?>"/></br></br></br>

            <label for="cidade">Cidade:</label></br>
            <input  type="text" name="city" id="city" value="<?=$user->city;?>"/></br></br></br>

            <label for="work">Trabalho:</label></br>
            <input  type="text" name="work" id="work" value="<?=$user->work;?>"/></br></br></br>

            <label for="password">Nova Senha:</label></br>
            <input  type="password" name="password" id="password"/></br></br></br>

            <label for="password-confirm">Confirmar Nova Senha:</label></br>
            <input  type="password" name="password_confirm" id="password_confirm"/></br></br></br>

            <input class="button" type="submit" value="Salvar" />
 
        </form>
        
    </section>

</section>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(document.querySelector('#birthdate'),
    {
        mask: '00/00/0000'
    });
</script>
<?=$render('footer');?>