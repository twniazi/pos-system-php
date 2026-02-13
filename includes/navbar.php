 <nav class=" navbar navbar-expand-lg  bg-white shadow">
           <div class="container">
            <a class="navbar-brand">
                POS SYSTEM IN php Mysql
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=""> 
                 <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Home</a>
                    </li>
                    <?php if(isset($_SESSION['loggedIn'])):?>
                        <li class="nav-item">
                        <a href="#" class="nav-link"><?=$_SESSION['loggedInUser']['name']?></a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </li>
                    <?php else:?>
                     <li class="nav-item">
                        <a href="login.php" class="nav-link active">Login</a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
           
           </div>
            
              
</nav>