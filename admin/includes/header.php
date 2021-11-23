   <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
       <span class="navbar-toggler-icon"></span>
   </button>


   <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" href="dashboard.php">TABLEAU DE BORD</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              CATEGORIES
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-category.php">Ajouter une catégorie</a>
                  <a class="dropdown-item" href="manage-categories.php">Gérer les catégories</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              AUTEURS
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-author.php">Ajouter un auteur</a>
                  <a class="dropdown-item" href="manage-authors.php">Gérer les auteurs</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              LIVRES
              </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-book.php">Ajouter un livre</a>
                  <a class="dropdown-item" href="manage-books.php">Gérer les livres</a>
              </div>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              SORTIES
              </a>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="add-issue-book.php">Ajouter une sortie</a>
                  <a class="dropdown-item" href="manage-issued-books.php">Gérer les sorties</a>
              </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="reg-readers.php">LECTEURS</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="change-password.php">MODIFIER LE MOT DE PASSE</a>
          </li>
      </ul>
   </div>
   <div class="right-div">
       <a href="logout.php" class="btn btn-danger pull-right">DECONNEXION</a>
   </div>    
</nav>





<?php /* ?>

<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">
                    <!--img src="assets/img/logo.png" /-->
                </a>
            </div>

            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">Déconnexion</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">TABLEAU DE BORD</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Categories <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-category.php">Ajouter une catégorie</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-categories.php">Gérer les catégories</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Auteurs <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-author.php">Ajouter un auteur</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-authors.php">Gérer les auteurs</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Livres <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-book.php">Ajouter un livre</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-books.php">Gérer les livres</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Sorties <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-issue-book.php">Ajouter une sortie</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-issued-books.php">Gérer les sorties</a></li>
                                </ul>
                            </li>
                            <li><a href="reg-readers.php">Lecteurs</a></li>
                            <li><a href="change-password.php">Modifier le mot de passe</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php */ ?>