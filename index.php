<?php 
require_once("database/db-conf.php");
$jp = new Jasper();
$articles = $jp->get("database/db/articles");
$tp = "";
 if(isset($_GET['q'])){
   $tp = $_GET['q'];
 }

?>
<html>
  <head>
    <title>Blogg't</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Jost'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='designs/style.css'>
  </head>

  <body>
    <div class='topbar'>
        <a class='igcc' href='/'>
    <img src='../designs/mblog.png'>
        </a>
        <div class='nvg'>
        <!-- Create a container for the editor -->
          <form method='get' style='display: inline;'>
          <input type='search' class='searchinp' name='q' placeholder="Search" value="<?php echo $tp;?>">
          </form>
          <a href='/admin' class='alx'>Admin</a>

        </div>
      </div>
      <mainbody>
        <div class='disp'>
          <div class='downer'>
            <?php

            echo '<div class="article-cont-box">'; // Start a container div

            foreach ($articles as $arts) {
              if(isset($_GET['q'])){
                if($_GET['q'] != ""){
                  if(strpos(strtolower($arts['block']['title']), strtolower($_GET['q'])) !== false){
                  $aid = $arts['block']['article']['articleId'];
                      $tubn = $arts['block']['thumbnailImage'];
                      $titl = $arts['block']['title'];


                      echo '<div class="art-item">';
                      echo "<div class='imis'><img src='data:image/png;base64,$tubn' alt='$titl'></div>";
                      echo "<h2>$titl</h2>";
                      echo "<p><a href='/read?id=$aid'>Read More</a></p>";
                      echo '</div>';
                  

                  echo '</div>';
                }
                }else{
                  $aid = $arts['block']['article']['articleId'];
                      $tubn = $arts['block']['thumbnailImage'];
                      $titl = $arts['block']['title'];


                      echo '<div class="art-item">';
                      echo "<div class='imis'><img src='data:image/png;base64,$tubn' alt='$titl'></div>";
                      echo "<h2>$titl</h2>";
                      echo "<p><a href='/read?id=$aid'>Read More</a></p>";
                      echo '</div>';
                  

                  echo '</div>';
                }
              }else{
                $aid = $arts['block']['article']['articleId'];
                    $tubn = $arts['block']['thumbnailImage'];
                    $titl = $arts['block']['title'];


                    echo '<div class="art-item">';
                    echo "<div class='imis'><img src='data:image/png;base64,$tubn' alt='$titl'></div>";
                    echo "<h2>$titl</h2>";
                    echo "<p><a href='/read?id=$aid'>Read More</a></p>";
                    echo '</div>';
                

                echo '</div>';
              }
            }
                 // Close the container div
            ?>
          </div>
        </div>
      </mainbody>
  
  </body>
</html>