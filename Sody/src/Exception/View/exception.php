<!DOCTYPE html>
<html>
  <head>
    <title>Sody Framework Exception</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap core CSS -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.2/css/bootstrap.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
      <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-offset-3 col-lg-6">
          <div class="alert alert-danger">Not again! Well, this shouldn't happend</div>

          <div class="row">
            <div class="col-lg-12">
              <div class="list-group">
                <a href="#" class="list-group-item active">
                  <h4 class="list-group-item-heading">Reason</h4>
                  <p class="list-group-item-text"><?= $this->message ?></p>
                </a>
              </div>
              <div class="list-group">
                <a href="#" class="list-group-item">
                  <h4 class="list-group-item-heading">File</h4>
                  <p class="list-group-item-text"><?= $this->file ?></p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
  </body>
</html>