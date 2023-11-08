<?php 
session_start();
require_once("../database/db-conf.php");
$jp = new Jasper();
if (isset($_SESSION['user'])) {
  $user = $jp->get_row("../database/db/users", ["uid" => $_SESSION['user']['uid']]);
  if(count($user) < 1){
    redirect("/admin/login");
  }
}else{
  redirect("/admin/login");
}
$articles = $jp->get("../database/db/articles");
?>
<html>
  <head>
    <title>Admin Controls</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='../designs/style.css'>
  </head>
  <style>
      /* Style for the container */
      .article-container {
          display: flex;
          flex-wrap: wrap;
      }

      /* Style for each article item */
      .article-item {
          width: 200px;
          margin: 10px;
          text-align: center;
          overflow: hidden; /* To hide any image overflow */
      }

      /* Style for the thumbnail image container */
      .imdis {
          border-style: solid;
          height: 130px; /* Specify the height */
          width: 195px; /* Specify the width */
          display: flex;
          align-items: center;
          overflow: hidden;
          justify-content: center;
          border-width: 2px;
          border-color: #ccc;
          border-radius: 5px;
      }
  .alx{
        font-family: lucida sans;
        font-size: 16px;
        margin: 10px;
      }
      .url{
        padding: 0px;
        margin: 0px;
        border: none;
        background: none;
        cursor: pointer;
      }
    .delete{
      border: none;
      padding: 10;
      border-radius: 5px;
      background: #ff5f5f;
      color: white;
    }
      /* Style for the thumbnail image */
      .imdis img {
          max-width: 100%; /* Make the image fit the width of the container */
          height: auto; /* Maintain aspect ratio */
      }
  </style>
  <body>
    <div class='topbar'>
        <a class='igcc' href='/'>
    <img src='../designs/mblog.png'>
        </a>
        <div class='nvg'>
        <!-- Create a container for the editor -->
          <a href='/' class='alx'>Home</a>          
          <a href='/admin/write' class='alx'>Write</a>

        </div>
      </div>
    <mainbody>
<?php
echo '<div class="article-container">'; // Start a container div

foreach ($articles as $arts) {
    $aid = $arts['block']['article']['articleId'];
    $tubn = $arts['block']['thumbnailImage'];
    $titl = $arts['block']['title'];


    echo '<div class="art-item">';
    echo "<div style='display: flex;vertical-align: top;'><div class='imdis' ><img src='data:image/png;base64,$tubn' alt='$titl'></div><h2 style='margin-left: 10px;padding:0px;margin-top:  0px;'>$titl</h2></div><br>";
  echo "<form method='post'><button name='del' class='delete' value='$aid'>Delete Article</button></form>";
    echo "<p><a href='/read?id=$aid'>Read More</a></p>";
    echo '</div>';
}

echo '</div>'; // Close the container div

if(isset($_POST['del'])){
  $jp->remove_row("../database/db/articles", array(
    "block"=>array(
      "article"=>array(
        "articleId" => $_POST['del']
      )
    )
  ));
  reload();
}
?>
    </mainbody>
  </body>

      
</html>