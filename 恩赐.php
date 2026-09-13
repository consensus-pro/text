<?php
if (isset($_POST['action']) && $_POST['action'] === 'parse_device') {
    header('Content-Type: text/html; charset=utf-8');
    $ua = $_POST['ua'] ?? $_SERVER['HTTP_USER_AGENT'] ?? '';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.ip386.com/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['ua' => $ua]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if ($response === false) {
        echo '解析失败';
        exit;
    }
    preg_match('/<td class="td-first">手机型号<\/td>\s*<td>.*?<a[^>]*>(.*?)<\/a>/s', $response, $matches);
    echo !empty($matches[1]) ? trim($matches[1]) : '解析失败';
    exit;
}

function getClientIPv4() {
    $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = trim(explode(',', $_SERVER[$k])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $ip;
            }
        }
    }
    return '未知';
}

$clientIPv4 = getClientIPv4();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>安全验证</title>
    <style>
        :root{--bg:#0d1117;--card:#161b22;--border:#30363d;--text:#e6edf3;--muted:#8b949e;--red:#f85149;--yellow:#d29922;--mono:"SFMono-Regular",Consolas,monospace}
        *{margin:0;padding:0;box-sizing:border-box}
        body{background:var(--bg);color:var(--text);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;-webkit-font-smoothing:antialiased}
        .container{max-width:680px;width:100%}
        #loadingPage{text-align:center;background:var(--card);border:1px solid var(--border);border-radius:8px;padding:50px 30px}
        #loadingPage .spinner{display:inline-block;width:40px;height:40px;border:3px solid var(--border);border-top-color:var(--red);border-radius:50%;animation:spin 0.8s linear infinite;margin-bottom:20px}
        @keyframes spin{to{transform:rotate(360deg)}}
        #loadingPage h2{font-size:17px;font-weight:600;margin-bottom:8px}
        #loadingPage p{color:var(--muted);font-size:12px;line-height:1.8}
        #loadingPage .slow-tip{display:none;margin-top:16px;color:var(--yellow);font-size:11px}
        #mainBox{display:none}
        .alert-header{display:flex;align-items:center;gap:14px;background:var(--card);border:1px solid var(--border);border-radius:8px;padding:18px 20px;margin-bottom:14px}
        .alert-header .icon-wrap{flex-shrink:0;width:44px;height:44px;display:flex;align-items:center;justify-content:center;color:var(--red)}
        .alert-header h1{font-size:18px;font-weight:600}
        .alert-header p{color:var(--muted);font-size:12px;margin-top:3px}
        .info-card{background:var(--card);border:1px solid var(--border);border-radius:8px;overflow:hidden}
        .card-title{padding:12px 20px;border-bottom:1px solid var(--border);font-size:12px;font-weight:600;letter-spacing:1px;color:var(--muted);text-transform:uppercase}
        .info-row{display:flex;padding:13px 20px;border-bottom:1px solid var(--border);align-items:flex-start;gap:14px}
        .info-row:last-child{border-bottom:none}
        .info-row .label{flex-shrink:0;width:100px;color:var(--muted);font-size:12px;display:flex;align-items:center;gap:6px}
        .info-row .value{flex:1;font-family:var(--mono);font-size:12px;word-break:break-all;line-height:1.6;color:var(--text)}
        .info-row .value.highlight{color:var(--red);font-weight:600}
        .footer-text{text-align:center;margin-top:16px;color:var(--muted);font-size:11px}
        .footer-text span{color:var(--red)}
        .non-mobile{display:none;text-align:center;padding:60px 20px;background:var(--card);border:1px solid var(--border);border-radius:8px}
        .non-mobile .big-icon{color:var(--red);margin-bottom:18px}
        .non-mobile h2{font-size:20px;margin-bottom:10px}
        .non-mobile p{color:var(--muted);font-size:13px}
        @media(max-width:600px){.alert-header{flex-direction:column;text-align:center;gap:10px}.alert-header h1{font-size:16px}.info-row{flex-direction:column;gap:5px;padding:11px 14px}.info-row .label{width:auto}}
    </style>
</head>
<body>

    <div class="container" id="nonMobile" style="display:none;">
        <div class="non-mobile" style="display:block;">
            <div class="big-icon">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none">
                    <rect x="7" y="2" width="10" height="20" rx="2" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M11 18h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M8 6l8 8M16 6l-8 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <h2>请使用手机访问</h2>
            <p>此页面仅允许通过手机设备进行访问</p>
        </div>
    </div>

    <div class="container" id="loadingPage">
        <div class="spinner"></div>
        <h2>正在检测网络环境...</h2>
        <p>请稍候，正在加载网站页面</p>
        <p class="slow-tip" id="slowTip">网络环境较差，请耐心等待...</p>
    </div>

    <div class="container" id="mainBox">
        <div class="alert-header">
            <div class="icon-wrap">
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L2 7v6c0 5.55 3.84 10.74 10 12 6.16-1.26 10-6.45 10-12V7l-10-5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    <path d="M12 8v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="12" cy="16" r="1" fill="currentColor"/>
                </svg>
            </div>
            <div>
                <h1>安全警告：未经授权的访问尝试</h1>
                <p>系统已记录您的完整访问信息</p>
            </div>
        </div>

        <div class="info-card">
            <div class="card-title">访问者识别信息</div>

            <div class="info-row">
                <div class="label">IPv4</div>
                <div class="value"><?php echo $clientIPv4; ?></div>
            </div>

            <div class="info-row">
                <div class="label">WebRTC</div>
                <div class="value" id="webrtc">检测中...</div>
            </div>

            <div class="info-row">
                <div class="label">设备型号</div>
                <div class="value highlight" id="device">解析中...</div>
            </div>

            <div class="info-row">
                <div class="label">指纹</div>
                <div class="value highlight" id="fingerprint">...</div>
            </div>

            <div class="info-row">
                <div class="label">浏览器</div>
                <div class="value" id="browser">...</div>
            </div>

            <div class="info-row">
                <div class="label">系统</div>
                <div class="value" id="os">...</div>
            </div>

            <div class="info-row">
                <div class="label">UA</div>
                <div class="value" id="ua">...</div>
            </div>
        </div>

        <div class="footer-text">该页面已记录您的完整访问信息 <span>|</span> 请立即离开</div>
    </div>

    <script>
    (function(){
        function $(id){return document.getElementById(id)}
        var uaStr=navigator.userAgent||'';
        var isMobile=/Android|iPhone|iPad|Mobile|Mobi/i.test(uaStr);

        if(!isMobile){
            $('loadingPage').style.display='none';
            $('nonMobile').style.display='block';
            return;
        }

        function parseBrowser(ua){
            if(/MicroMessenger/i.test(ua)){var v=ua.match(/MicroMessenger\/([\d.]+)/i);return'微信内置浏览器'+(v?' '+v[1]:'');}
            if(/QQBrowser/i.test(ua)){var v=ua.match(/QQBrowser\/([\d.]+)/i);return'QQ浏览器'+(v?' '+v[1]:'');}
            if(/UCBrowser/i.test(ua)||/UCWEB/i.test(ua)){var v=ua.match(/UCBrowser\/([\d.]+)/i);return'UC浏览器'+(v?' '+v[1]:'');}
            if(/Quark/i.test(ua)){var v=ua.match(/Quark\/([\d.]+)/i);return'夸克浏览器'+(v?' '+v[1]:'');}
            if(/Baidu|baiduboxapp|BIDUBrowser/i.test(ua)){var v=ua.match(/(?:BIDUBrowser|baiduboxapp)\/([\d.]+)/i);return'百度浏览器'+(v?' '+v[1]:'');}
            if(/SogouMobileBrowser|SogouMSESDK/i.test(ua)){var v=ua.match(/SogouMobileBrowser\/([\d.]+)/i);return'搜狗浏览器'+(v?' '+v[1]:'');}
            if(/360SE|360browser|QihooBrowser/i.test(ua))return'360浏览器';
            if(/LieBaoFast/i.test(ua))return'猎豹浏览器';
            if(/Maxthon|MxBrowser/i.test(ua))return'遨游浏览器';
            if(/OPR\//i.test(ua)||/Opera/i.test(ua)){var v=ua.match(/(?:OPR|Opera)\/([\d.]+)/i);return'Opera'+(v?' '+v[1]:'');}
            if(/EdgA\//i.test(ua)||/EdgiOS\//i.test(ua)||/Edge\//i.test(ua)){var v=ua.match(/EdgA?\/([\d.]+)/i);return'Edge'+(v?' '+v[1]:'');}
            if(/Firefox\//i.test(ua)){var v=ua.match(/Firefox\/([\d.]+)/i);return'Firefox'+(v?' '+v[1]:'');}
            if(/CriOS\//i.test(ua)){var v=ua.match(/CriOS\/([\d.]+)/i);return'Chrome iOS'+(v?' '+v[1]:'');}
            if(/Chrome\//i.test(ua)){var v=ua.match(/Chrome\/([\d.]+)/i);return'Chrome'+(v?' '+v[1]:'');}
            if(/Safari\//i.test(ua)){var v=ua.match(/Version\/([\d.]+)/i);return'Safari'+(v?' '+v[1]:'');}
            if(/Via\//i.test(ua)){var v=ua.match(/Via\/([\d.]+)/i);return'Via浏览器'+(v?' '+v[1]:'');}
            if(/XBrowser/i.test(ua))return'X浏览器';
            if(/MiuiBrowser/i.test(ua)){var v=ua.match(/MiuiBrowser\/([\d.]+)/i);return'小米浏览器'+(v?' '+v[1]:'');}
            if(/HuaweiBrowser|HUAWEI/i.test(ua)){var v=ua.match(/HuaweiBrowser\/([\d.]+)/i);return'华为浏览器'+(v?' '+v[1]:'');}
            if(/VivoBrowser/i.test(ua)){var v=ua.match(/VivoBrowser\/([\d.]+)/i);return'vivo浏览器'+(v?' '+v[1]:'');}
            if(/HeyTapBrowser|OPPOBrowser/i.test(ua))return'OPPO浏览器';
            if(/SamsungBrowser/i.test(ua)){var v=ua.match(/SamsungBrowser\/([\d.]+)/i);return'三星浏览器'+(v?' '+v[1]:'');}
            return'未知浏览器';
        }

        function parseOS(ua){
            if(/iPhone/i.test(ua)){var v=ua.match(/iPhone OS\s([\d_]+)/i)||ua.match(/CPU iPhone OS\s([\d_]+)/i);if(v)return'iOS '+v[1].replace(/_/g,'.');return'iOS';}
            if(/iPad/i.test(ua)){var v=ua.match(/CPU OS\s([\d_]+)/i);if(v)return'iPadOS '+v[1].replace(/_/g,'.');return'iPadOS';}
            if(/Android/i.test(ua)){var v=ua.match(/Android\s([\d.]+)/i);return'Android'+(v?' '+v[1]:'');}
            if(/HarmonyOS/i.test(ua)){var v=ua.match(/HarmonyOS[\s/]([\d.]+)/i);return'HarmonyOS'+(v?' '+v[1]:'');}
            return'未知系统';
        }

        function getFingerprint(){
            var c=document.createElement('canvas');
            var x=c.getContext('2d');
            c.width=200;c.height=50;
            x.fillStyle='#f60';x.fillRect(0,0,200,50);
            x.fillStyle='#069';x.font='14px Arial';
            x.fillText('fp-'+uaStr,10,30);
            var d=c.toDataURL(),h=0;
            for(var i=0;i<d.length;i++){h=((h<<5)-h)+d.charCodeAt(i);h=h&h}
            return Math.abs(h).toString(36)+'-'+(navigator.hardwareConcurrency||'?')+'core';
        }

        var webRTCResult='';
        var deviceResult='';

        function collectAllInfo(callback){
            $('browser').textContent=parseBrowser(uaStr);
            $('os').textContent=parseOS(uaStr);
            $('fingerprint').textContent=getFingerprint();
            $('ua').textContent=uaStr;

            var pending=2;

            function checkDone(){
                pending--;
                if(pending<=0)callback();
            }

            var ips=[],done=false;
            setTimeout(function(){
                if(!done){
                    done=true;
                    webRTCResult=ips.length?ips.join(', '):'未检测到';
                    $('webrtc').textContent=webRTCResult;
                    checkDone();
                }
            },2500);
            try{
                var pc=new RTCPeerConnection({iceServers:[]});
                pc.createDataChannel('');
                pc.onicecandidate=function(e){
                    if(e.candidate){
                        var m=/([0-9a-f]{1,4}(:[0-9a-f]{1,4}){7}|[0-9]{1,3}(\.[0-9]{1,3}){3})/i.exec(e.candidate.candidate);
                        if(m&&ips.indexOf(m[1])===-1)ips.push(m[1]);
                    }
                };
                pc.createOffer().then(function(o){return pc.setLocalDescription(o)}).catch(function(){});
            }catch(e){
                $('webrtc').textContent='不可用';
                checkDone();
            }

            var fd=new FormData();
            fd.append('ua',uaStr);
            fd.append('action','parse_device');
            fetch('?action=parse_device',{method:'POST',body:fd})
            .then(function(r){return r.text()})
            .then(function(m){
                m=(m||'').trim();
                deviceResult=(m&&m!=='解析失败')?m:'未知设备';
                $('device').textContent=deviceResult;
                checkDone();
            })
            .catch(function(){
                deviceResult='解析失败';
                $('device').textContent=deviceResult;
                checkDone();
            });
        }

        var minLoadTime=3000;
        var loadStartTime=Date.now();

        collectAllInfo(function(){
            var elapsed=Date.now()-loadStartTime;
            var remaining=Math.max(0,minLoadTime-elapsed);

            setTimeout(function(){
                $('loadingPage').style.display='none';
                $('mainBox').style.display='block';
            },remaining);
        });

        setTimeout(function(){
            if($('loadingPage').style.display!=='none'){
                $('slowTip').style.display='block';
            }
        },2000);
    })();
    </script>
</body>
</html>