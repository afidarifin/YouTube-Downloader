<?php
/**
 * @Package YouTube Download by Afid Arifin
 * @Version v1.0
 * @Email   afidbara@gmail.com
 */
ini_set('display_errors', 0);
ob_start();
date_default_timezone_set('Asia/Jakarta');

if(file_exists('core/class.youtube.php')) {
  require_once 'core/class.youtube.php';
} else {
  if(file_exists('../core/class.youtube.php')) {
    require_once '../core/class.youtube.php';
  } else {
    require_once '../../core/class.youtube.php';
  }
}
?>
<!DOCTYPE html>
<html>
  <head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Title -->
    <title>YouTube Downloader by Afid Arifin - Afid Arifin</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- jQuery 3 -->
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <style>
      body { background: #f7f7f7; }
    </style>
  </head>
  <body class="hold-transition">
    <?php
      if(isset($_POST['submit'])) {
        $url    = strip_tags($_POST['url']);
        $errors = [];

        if(empty($url)) {
          $errors[] = '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
              &times;
            </button>
            <i class="icon fa fa-warning"></i>
            <b>Oops!</b>
            Silahkan masukkan url YouTube Anda!
          </div>';
        } else {
          $youtube = new YouTube();
          $url = $youtube->url($url);
          if($url) {
            $result = $youtube->details($url);
            if($result) {
              $data = $result['videos']['info'];
              $formats = $result['videos']['formats'];
              $adapativeFormats = $result['videos']['adapativeFormats'];

              $json = json_decode($data['player_response']);

              $title = $json->videoDetails->title;
              
              $dataHTML = '<div class="row">
                <div class="col-md-6" style="transform: translate(345px, -100px);">
                  <center>
                    <img class="img-responsive" src="'.$json->videoDetails->thumbnail->thumbnails{0}->url.'" style="margin-bottm: 12px;">
                  </center>
                  <div class="box" style="margin-top: 12px;">
                    <div class="box-header with-border">
                      <h3 class="box-title">
                        '.$title.'
                      </h3>
                    </div>
                    <div class="box-body">
                      <table class="table table-responsive table-striped">
                        <tr>
                          <th>
                            Jenis
                          </th>
                          <th>
                            Kualitas
                          </th>
                          <th>
                            Download
                          </th>
                        </tr>';
                        foreach($adapativeFormats as $video) {
                          $dataHTML .= '<tr>
                            <td>'.$video['type'].'</td>
                            <td>'.$video['quality'].'</td>
                            <td><a href="'.$video['link'].'" target="_blank" class="btn btn-success btn-xs">Download</a></td>
                          </tr>';
                        }
                      $dataHTML .= '</table>
                    </div>
                  </div>
                </div>
              </div>';
            }
          }
        }
      }
    ?>
    <div class="row">
      <div class="col-md-12">
        <section class="content">
          <div class="error-page">
            <center>
              <h3>
                <i class="icon fa fa-warning text-yellow"></i>
                Selamat Datang!
              </h3>
              <p>
                Selamat menikmati layanan yang kami sediakan.
              </p>
              <?php
                foreach($errors as $error) {
                  echo $error;
                }
              ?>
              <form method="POST" class="search-form">
                <div class="input-group">
                  <input type="text" name="url" class="form-control" value="https://www.youtube.com/watch?v=aqjEQHmfymQ" placeholder="https://www.youtube.com/watch?v=aqjEQHmfymQ" style="border-top-left-radius: 2px;border-bottom-left-radius: 2px;border-top-right-radius: 0px;border-bottom-right-radius: 0px;border: none;">
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-success">
                      <i class="fa fa-download"></i>
                    </button>
                  </div>
                </div>
              </form>
            </center>
          </div>
        </section>
      </div>
    </div>
    <?php echo $dataHTML; ?>
  </body>

  <!-- jQuery UI 1.11.4 -->
  <script src="assets/bower_components/jquery-ui/jquery-ui.min.js"></script>

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>

  <!-- Bootstrap 3.3.7 -->
  <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Slimscroll -->
  <script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

  <!-- FastClick -->
  <script src="assets/bower_components/fastclick/lib/fastclick.js"></script>

  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
</html>