<?php 
$artx = $_GET['id'];
require_once("../database/db-conf.php");
$jp = new Jasper();
$artKK = $jp->get_row('../database/db/articles', array(
  "block"=>array(
    "article"=>array(
      "articleId" => "$artx"
    )
  )
));
$news = $artKK[0];
$title = $news['block']['title'];
//$img = $news['block']['thumbnailImage'];
$artkl = base64_decode($news['block']['article']['text']);

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Jost'>
    <title>Read Article</title>
    <!-- Include Quill.js stylesheets and scripts -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link rel='stylesheet' href='designs/style.css'>

</head>
  <style>
    .ql-toolbar {
    display: none !important;
}
    .ql-toolbar.ql-snow + .ql-container.ql-snow{
      border-width: 0px;
    } 
    .ql-editor{
      width: 600px;
    }
    .ql-editor p{
      font-size: 18px;
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
    @media screen and (max-width: 605px){
      .ql-editor{
        width: 95%;
      }
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
  <button onclick='history.back()' class='url alx'>Back</button>
    </div>
  </div>
  <mainbody>
  <center>
    <h1><?php echo $title;?></h1>
    <img style='max-width: 300px;' class='ergo' src='data:image/png;base64,<?php echo $news['block']['thumbnailImage'];?>' alt='<?php echo $title;?>'>
    <div id="editor-container">
      <?php echo $artkl; ?>
    </div>
</center>
  <script>
// Date and Time


// You can add more variables to capture additional details as needed.


  </script>
    <!-- Include Quill.js script -->
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
      var say = " New";
        // Initialize Quill without a toolbar (view-only mode)
        var container = document.getElementById('editor-container');
        var options = {
            readOnly: true, // Set to true to make it read-only
            theme: 'snow',
          toolbar: null,
        };
        var quill = new Quill(container, options);

        // Insert content into the editor (optional)

    </script>
    </mainbody>
</body>
</html>
