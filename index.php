<?php
include_once 'Engine/E.php';
$cfs = new Confession();
$vote = new Vote();

$confession = $cfs->getAllConfessions();

//Get User Ip Address
$user = Misc::getUserIpAddr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confessionally</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="vendor/font-awesome/fontawesome-all.min.js"></script>
    <script>
      var user = '<?php echo $user; ?>';
    </script>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Confessionally</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <h1 class="my-4">Confessionally
        <small>Fess up your deepest and darkest secrets, maybe?</small>
      </h1>

     
      <div class="central-meta">
              <div class="new-postbox">
                <div class="newpst-input">
                
                  	<div class="form-group">
                    <input type="text" id="cfs_title" class="form-control" placeholder="Confession Title">
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" name="message" id="cfs_content" rows="5"></textarea>
                  </div>
                  
                    <ul>
                        <li>
                            <button class="btn btn-info" type="button" id="cfs_btn">Confess</button>
                            <div id="err"></div>
                        </li>
                    </ul>


                </div>
              </div>
            </div>

        <?php 
          if (!empty($confession)):
             foreach ($confession as $fess):
        ?>

      <!-- Blog Post -->
      <div class="card mb-4" id="confession_<?= $fess['id']; ?>">
        <div class="card-body">
          <h2 class="card-title"><?= $fess['title'];?></h2>
          <p class="card-text"><?= $fess['message'];?></p>
          <a href="#" class="btn btn-sm btn-primary">Read More &rarr;</a>
        </div>
        <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
        <div class="pull-right">
          <?= date('F j, Y, g:i ', strtotime( $fess['date_posted'])); ?>
        
        </div>
              <div class="pull-left">
              <span>12</span><button> <i class="far fa-comments"></i></button>

                <?php 
                //Check if the user or ip address already voted
                if ($vote->isUserUpvoted($user, $fess['id'])): 
                ?>
          <span><?= $fess['upvote']?></span><button class="upvoted" data-id="<?= $fess['id']; ?>"> <i class="fas fa-hand-point-up fa-fw"></i></button>
                <?php else: ?>
                  <span><?= $fess['upvote']?></span><button class="upvote" data-id="<?= $fess['id']; ?>"> <i class="far fa-hand-point-up fa-fw"></i></button>
                <?php endif; ?>

                <?php 
                //Check if the user or ip address already voted
                if ($vote->isUserDownvoted($user, $fess['id'])): 
                ?>

          <span><?= $fess['downvote']?></span><button class="downvoted" data-id="<?= $fess['id']; ?>"> <i class="fas fa-hand-point-down fa-fw"></i></button>
          <?php else: ?>
          <span><?= $fess['downvote']?></span><button class="downvote" data-id="<?= $fess['id']; ?>"> <i class="far fa-hand-point-down fa-fw"></i></button>
          <?php endif; ?>
          <div id="vote<?= $fess['id']; ?>"></div>
              </div>
        </div>
      </div>

      <?php
     
             endforeach;
        endif;
      ?>


      <!-- Pagination -->
      <!-- <ul class="pagination justify-content-center mb-4">
        <li class="page-item">
          <a class="page-link" href="#">&larr; Older</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link" href="#">Newer &rarr;</a>
        </li>
      </ul> -->

    </div>

    <!-- Sidebar Widgets Column -->
    <div class="col-md-4">

      <!-- Search Widget -->
      <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-append">
              <button class="btn btn-secondary" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>

      <!-- Categories Widget -->
      <div class="card my-4">
        <h5 class="card-header">Categories</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <ul class="list-unstyled mb-0">
                <li>
                  <a href="#">Web Design</a>
                </li>
                <li>
                  <a href="#">HTML</a>
                </li>
                <li>
                  <a href="#">Freebies</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-6">
              <ul class="list-unstyled mb-0">
                <li>
                  <a href="#">JavaScript</a>
                </li>
                <li>
                  <a href="#">CSS</a>
                </li>
                <li>
                  <a href="#">Tutorials</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Side Widget -->
      <div class="card my-4">
        <h5 class="card-header">Side Widget</h5>
        <div class="card-body">
          You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
        </div>
      </div>

    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
  </div>
  <!-- /.container -->
</footer>


  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/scripts.js"></script>
 
</body>
</html>