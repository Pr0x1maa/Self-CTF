<?php

$code_to_display = '<?php
$Pr0 = $_GET[\'Pr0\'];

if(strlen($Pr0) > 5){
    die("太太太太太长了!");
}else{
    @system($Pr0);
}
?>';


ob_start();

if (isset($_GET['Pr0'])) {
    $Pr0 = $_GET['Pr0'];
    
    echo "命令长度: " . strlen($Pr0) . "\n\n";

    if(strlen($Pr0) > 5){
        echo "太太太太太长了!";
    } else {
        @system($Pr0);
    }
} else {
    echo "没有提交任何东西哦";
}

$challenge_output = ob_get_clean();


ob_start();
highlight_string($code_to_display);
$highlighted_code = ob_get_clean();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>五言</title>
    <style>

        @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@700&family=Playfair+Display:ital@1&family=Noto+Sans+SC:wght@300&display=swap');

        body {
            background-color: #D7D6D5;
            font-family: 'Noto Sans SC', sans-serif;
            font-weight: 300;
            color: #333;
            margin: 0;
            padding: 40px 20px;
            display: grid;
            place-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }

        .content {
            padding: 40px 50px 50px 50px;
        }

        .header h1 {
            font-family: 'Cormorant Garamond', 'Playfair Display', serif;
            color: #415527;
            font-size: 3.2em;
            margin: 0 0 25px 0;
            text-align: center;
        }

        h2.section-title {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: #BE9546;
            font-size: 1.6em;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .code-wrapper {
            background-color: #415527;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(65, 85, 39, 0.2);
        }

        .code-wrapper code {
            font-family: "SFMono-Regular", "Consolas", "Courier New", monospace;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .code-wrapper span[style="color: #0000BB"] {
            color: #f0f0f0 !important;
        }
        .code-wrapper span[style="color: #007700"] {
            color: #BE9546 !important;
        }
        .code-wrapper span[style="color: #DD0000"] {
            color: #D7D6D5 !important;
        }
        .code-wrapper span[style="color: #FF8000"] {
            color: #a1b08e !important;
        }
        .code-wrapper span[style="color: #000000"] {
             color: #ffffff !important;
        }


        pre.output-wrapper {
            background: #fdfdfd;
            border-left: 5px solid #BE9546;
            padding: 20px;
            margin-top: 20px;
            font-family: "Consolas", "Courier New", monospace;
            font-size: 1.1em;
            color: #555;
            white-space: pre-wrap;
            word-wrap: break-word;
            border-radius: 0 8px 8px 0;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Length-Restricted RCE</h1>
            </div>
            
            <h2 class="section-title">Source</h2>
            <div class="code-wrapper">
                <?php
                echo $highlighted_code;
                ?>
            </div>
            
            <h2 class="section-title">Output</h2>
            <pre class="output-wrapper"><?php
                echo htmlspecialchars($challenge_output); 
            ?></pre>

        </div>
    </div>

</body>
</html>