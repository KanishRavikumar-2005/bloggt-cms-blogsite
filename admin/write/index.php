<?php 
session_start();
require_once("../../database/db-conf.php");
$jp = new Jasper();
if (isset($_SESSION['user'])) {
  $user = $jp->get_row("../../database/db/users", ["uid" => $_SESSION['user']['uid']]);
  if(count($user) < 1){
    redirect("/admin/login");
  }
}else{
  redirect("/admin/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Writer</title>
    <!-- Include Quill.js stylesheets and scripts -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Roboto' href='stylesheeet'>
  <link rel='stylesheet' href='../../designs/style.css'>

</head>
  <style>
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value]::before {
  content: attr(data-value) !important;
}

    .ql-snow .ql-picker.ql-font .ql-picker-label[data-value]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value]::before {
  content: attr(data-value) !important;
}
    .ql-snow .ql-picker.ql-font {
  width: 150px !important;
  white-space: nowrap;
}

    .ql-snow .ql-picker.ql-expanded .ql-picker-options{
      max-height: 400px;
    overflow-y: scroll;
    }
    .ql-container{
      height: 89%!important;
    }
    .ql-toolbar.ql-snow{
      text-align: left!important;
    }
     .box{
      width: 800px;
      height: 400px;
       clear: both;
       margin-bottom: 10px;
    }
    *{
      box-sizing: border-box;
    }
    @media screen and (max-width: 605px){
      .ql-editor{
        width: 95%;
      }
    }

    .texr{
      border-style: solid;
      border-width: 1px;
      border-radius: 4px;
      padding:5px;
      width: 800px;
      border-color: #CCCCCC;
      text-align: left;
      clear: both;

    }
    @media screen and (max-width: 805px){
      .box{
        width: 100%;
      }
      .texr{
        width: 90%;
      }
    }
    .typein{
      padding-left: 10px;
      width:98%;
      height: 35px;
      border:none;
      border-style: solid;
      border-width:1px;
      border-radius: 4px;
      margin-bottom: 5px;
      border-color: #CCCCCC;
      outline: none;
    }
    .bxn{
      border:none;
      border-style: solid;
      border-width:0px;
      height: 35px;
      border-radius: 4px;
      background-color: #0062ff;
      color: white;
      padding: 10px;
      cursor: pointer;
    }

    .image-container {
            text-align: center;
        }
        .image-container img {
            max-width: 200px;
            max-height: 200px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
    .btn{
      border-style:solid;
      border-width: 2px;
      padding:10px;
      border-radius:4px;
      display: block;
      width: fit-content;
      background-color: #0062ff;
      color: white;
      padding: 10px;
      cursor: pointer;
      margin-bottom: 10px;

    }
    #image, .btn{
      display: none;
    }
    .ql-toolbar.ql-snow {
    /* border: 1px solid #ccc; */
    box-sizing: border-box;
    font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
    padding: 8px;
    border: 2px solid rgba(83, 69, 52, 0.39);
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    color: #534534;
}
.ql-container.ql-snow {
    border: 2px solid rgba(83, 69, 52, 0.39);
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
}
  </style>
  <?php 
function generateUniqueID($STRT = "IMG") {
    // Define characters for each segment of the ID
    $chars1 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $chars2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $numericChars = '0123456789';
    $chars3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    // Generate each segment of the ID
    $segment1 = $STRT.'-' . substr(str_shuffle($chars1), 0, 7);
    $segment2 = substr(str_shuffle($chars2), 0, 4);
    $segment3 = substr(str_shuffle($numericChars), 0, 5);
    $segment4 = substr(str_shuffle($chars3), 0, 6);

    // Combine the segments to create the unique ID
    $uniqueID = $segment1 . '-' . $segment2 . '-' . $segment3 . '-' . $segment4;

    return $uniqueID;
}
?>
<body>
  <div class='topbar'>
      <a class='igcc' href='/'>
  <img src='../designs/mblog.png'>
      </a>
      <div class='nvg'>
      <!-- Create a container for the editor -->
        <a href='/' class='alx'>Home</a>          
        <a href='/admin' class='alx'>Admin</a>

      </div>
    </div>
  <mainbody>
    <!-- Create a container for the editor -->

  <center>

    <br>
    <form method='post' enctype="multipart/form-data">

    <div class='texr'>
      <div class="image-container" style='text-align: left'>
            <img src="avatar.png" id="preview-image" alt="Avatar" role="button" onclick='clykr()'/>
        </div>
        <input type="file" name="image" id="image" style="display: none;">
        <label for="image" class="btn">Select an image</label>
      <input type='text' class='typein' placeholder='Title' value='Untitled' name='tytl'>
      <br>
      <div class='box'>
    <div id="editor-container" style="width: 96.5%; height: 100%;">
        <div id="editor"></div>
    </div>
    </div>
    <textarea id='crrtxt' class='typein' style='height: 100px;resize:vertical;display: none;' placeholder='View (Read Only)' name='hcond' readonly></textarea>
      <br>
      <button class='bxn' name='sub'>Upload Article</button>

    </div>
    </form>
      <?php 
if(isset($_POST['sub'])){
  $code = $_POST['hcond'];
  $tytl = $_POST['tytl'];
  $JSXY = array(
    "uniqId" => generateUniqueID(),
    "sno" => "",
    "block" => array(
      "thumbnailImage" => "",
      "title" => "$tytl",
      "article" => array(
        "text" => base64_encode($code),
        "articleId" => generateUniqueID("ART")
      ),
      "uploadDate" => "",
      "uploadTime" => ""
    )
  );
  if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $uploadedFile = $_FILES["image"]["tmp_name"];
        $originalFileName = $_FILES["image"]["name"];

        list($width, $height) = getimagesize($uploadedFile);

        $isAvatar = false;

        if ($width <= 100 && $height <= 100) {
            $isAvatar = true;
        }

        if ($isAvatar) {
            echo "The uploaded file is an avatar. Original file name: " . $originalFileName;
        } else {
            $imageData = file_get_contents($uploadedFile);
            $base64Image = base64_encode($imageData);
            $currentDateTime = new DateTime();
            $uploadDate = $currentDateTime->format('d-m-Y'); 
            $uploadTime = $currentDateTime->format('h:i:s A');
            $JSXY['block']['thumbnailImage'] = $base64Image;
            $JSXY['block']['uploadDate'] = $uploadDate;
            $JSXY['block']['uploadTime'] = $uploadTime;
            $already = $jp->get("../../database/db/articles");
            if($already != ""){
              $convrt = $already;
              $thisVal = count($convrt) + 1;
              $JSXY['sno'] = "$thisVal";
              $jp->add_row("../../database/db/articles", $JSXY);
            }else{
              $JSXY['sno'] = "1";
              $fullJson = array($JSXY);
              $jp->add_row("../../database/db/articles", $fullJson);
            }

        }
    } else {
        echo "Error uploading the file.";
    }
  //file_put_contents("store-file.ttx", $code);
}

?>
      </div>
    </center>
    <!-- Include Quill.js script -->
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://newsing.thous.repl.co/mods/image-resize.js"></script>
    <script src="https://newsing.thous.repl.co/mods/video-resize.js"></script>

    <script>
        const fontFamilyArr = ["Arial","Arial Black","Arial Narrow","Calibri","Calibri Light","Century Gothic","Comic Sans MS","Courier New","Franklin Gothic Medium","Garamond",
"Georgia","Impact","Lucida Console","Palatino Linotype","Roboto Condensed","Sans-Serif","Tahoma","Times New Roman","Trebuchet MS","Verdana",
"Agency FB","Arial Rounded MT Bold","Book Antiqua","Candara","Century","Copperplate Gothic Bold","Courier","Elephant","Futura","Geneva",
"Georgia Ref","Gill Sans","Helvetica","Helvetica Neue","High Tower Text","Lucida Sans","Monospace","MS Reference Sans Serif","MS Reference Serif","MS Sans Serif",
"MS Serif","Myanmar Text","Nirmala UI","Palatino","Segoe Print","Segoe Script","Segoe UI","Segoe UI Emoji","Segoe UI Historic","Segoe UI Symbol",
"Serif","Stencil","Symbol","Tahoma","Times","Tw Cen MT","Verdana","Webdings","Wingdings"
];
let fonts = Quill.import("attributors/style/font");
fonts.whitelist = fontFamilyArr;
Quill.register(fonts, true);

      const fontSizeArr = ['10px', '11px', '12px', '14px', '18px', '24px', '30px', '36px', '48px', '60px', '72px', '84px', '96px', '100px'];
var Size = Quill.import('attributors/style/size');
Size.whitelist = fontSizeArr;
Quill.register(Size, true);

        // Initialize Quill editor
        var container = document.getElementById('editor');
        var options = {
            modules: {
                imageResize: {
                    displaySize: true
                },
                videoResize: {
                    displaySize: true
                },
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'script': 'sub' }, { 'script': 'super' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': fontSizeArr }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                     // Add the font family dropdown with custom fonts
                    ['link', 'image', 'video'],
                    ['clean'],
                    [{ 'font': fontFamilyArr }]
                ]

            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
        };
        var editor = new Quill(container, options);
    </script>


  <script> 
    function deltaToHtml(delta) {
            var tempContainer = document.createElement('div');
            var tempEditor = new Quill(tempContainer);
            tempEditor.setContents(delta);
            return tempEditor.root.innerHTML;
        }
    editor.on('text-change', function() {
            // Get the editor's content as a Delta object
            var delta = editor.getContents();

            // Convert the Delta object to HTML
            var html = deltaToHtml(delta);
            document.getElementById('crrtxt').value = html
        });</script>
  </mainbody>
</body>
</html>
   <script>
     function clykr(){
       document.getElementById('image').click()
     }
        document.getElementById('image').addEventListener('change', function () {
            const fileInput = this;
            const previewImage = document.getElementById('preview-image');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Reset to default avatar image if no file selected
                previewImage.src = 'avatar.png';
            }
        });
    </script>