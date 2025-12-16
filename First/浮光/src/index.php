<?php
error_reporting(0); 

$html_output = '';
$show_result = false;

$preset_urls = [
    'http://124.221.168.69/pics/avt.jpg',
    'http://124.221.168.69/pics/avtor.png',
    'http://124.221.168.69/pics/cul.jpg',
    'http://124.221.168.69/pics/green.png',
    'http://124.221.168.69/pics/liang.png',
    'http://124.221.168.69/pics/tutu.jpeg',
];

function check($key){
    $blacklist = [
        'file', 'phar', 'zip', 'data', 'glob', 'expect', 'ftp',
        'passwd', 'shadow', 'etc',
        'base64',  'string',  'rot13', 
        'eval', 'system', 'exec', 'shell_exec', 'popen', 'passthru', 'echo'
    ];

    foreach ($blacklist as $keyword){
        if (stripos($key, $keyword) !== false){
            return false;
        }
    }
    return true;
}

$imageUrl = '';

if (isset($_POST['file']) && $_POST['file'] !== '') {
    $imageUrl = $_POST['file'];
} else {
    if (!empty($preset_urls)) {
        $imageUrl = $preset_urls[array_rand($preset_urls)];
    }
}

if (!empty($imageUrl)) {
    $show_result = true; 
    
    if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        if (check($imageUrl)) {
            $imageContent = @file_get_contents($imageUrl);
            
            if ($imageContent !== false && !empty($imageContent)) {
                
                if (stripos($imageContent, 'sdpcsec{') !== false) {
                    $html_output = '<span style="color:#ef4444; font-weight: bold;">Waf!!!</span>';
                } 
                else {
                    $imageInfo = @getimagesizefromstring($imageContent);
                    
                    if ($imageInfo) {
                        $html_output = '<div class="avatar-frame"><img src="' . htmlspecialchars($imageUrl) . '" class="avatar-img"></div>';
                    } else {
                        $error = '无法识别的图片格式,内容为: ';
                        $html_output = '<div style="white-space: pre-wrap; word-break: break-all; color:#f59e0b; font-weight: bold;">' . $error . $imageContent . '</div>';
                    }
                }

            } else {
                $error = '图片内容获取失败,请检查url:' . htmlspecialchars($imageUrl);
                $html_output = '<span style="color:#f59e0b; font-weight: bold;">' . $error . '</span>';
            }
        } else {
            $html_output = '<span style="color:#ef4444; font-weight: bold;">Waf!!!</span>';
        }
    } else {
        $html_output = '<span style="color:#ef4444; font-weight: bold;">无效的url格式</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>浮光</title>
    <style>
        :root {
            --bg-color: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --accent: #38bdf8;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Helvetica Neue', 'Arial', sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .container {
            width: 100%;
            max-width: 900px;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 4rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            font-weight: 200;
            letter-spacing: 0.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
            letter-spacing: 0.2rem;
            margin-bottom: 3rem;
            text-transform: uppercase;
        }

        .control-area {
            margin: 2rem auto;
            text-align: center;
        }

        button.random-btn {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.1), rgba(56, 189, 248, 0));
            border: 1px solid var(--glass-border);
            color: var(--accent);
            padding: 1rem 3rem;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            letter-spacing: 0.1rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            box-shadow: 0 0 15px rgba(56, 189, 248, 0.1);
            outline: none;
        }

        button.random-btn:hover {
            background: rgba(56, 189, 248, 0.15);
            border-color: var(--accent);
            box-shadow: 0 0 25px rgba(56, 189, 248, 0.3);
            transform: scale(1.05);
        }

        .result-area {
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        
        .result-area.visible {
            animation: fadeIn 0.5s ease;
        }

        .avatar-frame {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            padding: 5px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0));
            border: 1px solid var(--glass-border);
            box-shadow: 0 0 30px rgba(56, 189, 248, 0.2);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .result-area div { text-align: left; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--accent);
            filter: blur(150px);
            opacity: 0.15;
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="glow" style="top: -50px; left: -50px;"></div>
    <div class="glow" style="bottom: -50px; right: -50px; background: #c084fc;"></div>

    <div class="container">
        <div class="glass-panel">
            <h1>浮光</h1>
            <p class="subtitle">头像查看器</p>

            <div class="result-area <?php echo $show_result ? 'visible' : ''; ?>">
                <?php echo $html_output; ?>
            </div>

            <div class="control-area">
                <form id="viewForm" method="POST" action="">
                    <button type="button" class="random-btn" onclick="loadRandomImage()">
                        随机头像
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadRandomImage() {
            document.getElementById('viewForm').submit();
        }
    </script>
</body>
</html>