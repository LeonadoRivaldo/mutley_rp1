<?php
$file = './public/files/default/logo-pequeno.png';
$mtime = filemtime($file);
?>

<section id="topo">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand{padding:0}" href="/">
                <img src="<?php  echo '../public/files/default/logo-pequeno.png?v='.$mtime; ?>" alt="Mutley" height="50px">
            </a>                
            <form class="nav navbar-form navbar-right busca-site" submit="busca.php">
                <div class="form-group"> 
                    <div class="input-group">
                        <input id="campoBusca" type="text" class="form-control" placeholder="Procurar no Mutley...">
                        <span id="pesquisar" class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </form>
            <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="collapse navbar-collapse" id="myNavbar">
             
                <p class="navbar-text navbar-left">Bem Vindo(a) <?php echo $_SESSION['nome']; ?></p>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./sobre.php">Sobre o Mutley</a></li>
                    <li>
                        <a id="criarPublicacao" href="#">
                            <i class="fa fa-plus"></i> Nova publicação
                        </a>
                    </li>
                    <li>
                        <a id="editarUsuario" href="#" data-logado="true">
                            <i class="fa fa-user"></i> Editar Perfil
                        </a>
                    </li>
                    <li>
                        <a id="logout" href="#">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            <?php } else { ?>
                <div class="collapse navbar-collapse" id="myNavbar">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="./sobre.php">Sobre o Mutley</a></li>
                    <li>
                        <a id="criarUsuario" href="#">
                            <i class="fa fa-user-plus"></i> Criar Conta
                        </a>
                    </li>
                    <li><a id="login" href="#"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</a></li>
                </ul>
            </div>
            <?php } ?>
        </div>
    </nav>
</section>