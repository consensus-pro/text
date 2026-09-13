<?php
// ===== 服务端直接获取 IPv4（恩赐.php 同款逻辑） =====
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
<title>ReaxNet Console</title>
<style>
:root {
    --a: #000000;
    --b: #ffffff;
    --c: #555555;
    --d: #777777;
    --e: rgba(0, 0, 0, 0.07);
    --f: rgba(0, 0, 0, 0.05);
    --g: rgba(0, 0, 0, 0.08);
    --h: rgba(0, 0, 0, 0.10);
    --i: rgba(0, 0, 0, 0.15);
    --j: rgba(0, 0, 0, 0.45);
    --k: rgba(255, 255, 255, 0.50);
    --l: rgba(255, 255, 255, 0.60);
    --m: rgba(255, 255, 255, 0.62);
    --n: rgba(255, 255, 255, 0.80);
    --o: rgba(0, 0, 0, 0);

    --p: 42px;
    --q: 10px;
    --r: 1px;
    --s: 2px;
    --t: 4px;

    --u: 0.25s;
    --v: 0.4s;

    --w: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: var(--w);
    -webkit-tap-highlight-color: var(--o);
}

html { min-height: 100%; }

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: var(--b);
    background-image:
        linear-gradient(to right, var(--e) var(--r), transparent var(--r)),
        linear-gradient(to bottom, var(--e) var(--r), transparent var(--r));
    background-size: var(--p) var(--p);
    background-position: calc(var(--r) * -1) calc(var(--r) * -1);
    background-attachment: fixed;
    color: var(--a);
    overflow-x: hidden;
}

header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 20px;
    background: var(--n);
    border-bottom: var(--r) solid var(--h);
}

.l {
    font-size: 19px;
    font-weight: 600;
    letter-spacing: 1px;
    color: var(--a);
}

.m {
    background: none;
    border: none;
    cursor: pointer;
    width: 22px;
    height: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0;
}

.m span {
    display: block;
    width: 100%;
    height: 1.8px;
    border-radius: var(--s);
    background: var(--a);
    transition: transform var(--u), opacity var(--u);
}

.m.a span:nth-child(1) { transform: translateY(7.1px) rotate(45deg); }
.m.a span:nth-child(2) { opacity: 0; }
.m.a span:nth-child(3) { transform: translateY(-7.1px) rotate(-45deg); }

.n {
    position: absolute;
    top: 100%; left: 0; right: 0;
    background: var(--l);
    border-bottom: var(--r) solid var(--h);
    display: grid;
    grid-template-rows: 0fr;
    overflow: hidden;
    transition: grid-template-rows var(--u) ease;
}

.n.a { grid-template-rows: 1fr; }

.i {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    padding: 0;
    transition: padding var(--u) ease;
}

.n.a .i { padding: 3px 0; }

.n a {
    position: relative;
    display: block;
    padding: 7px 20px;
    color: var(--a);
    text-decoration: none;
    font-size: 14px;
    letter-spacing: 0.3px;
    transition: background var(--u), padding-left var(--u);
}

.n a::after {
    content: '';
    position: absolute;
    bottom: 4px; left: 20px; right: 20px;
    height: 1.5px;
    background: var(--a);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform var(--u) ease;
}

.n a:hover::after,
.n a:focus::after,
.n a:active::after { transform: scaleX(1); }

.n a:hover {
    background: var(--f);
    padding-left: 24px;
}

.c {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 90px 20px 40px;
    position: relative;
    z-index: 1;
}

.c h1 {
    font-size: 2.5rem;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--a);
    margin-bottom: 12px;
}

.c .s {
    font-size: 0.95rem;
    color: var(--c);
    letter-spacing: 1px;
}

.e {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-top: 36px;
    width: 100%;
    max-width: 1080px;
}

.f {
    position: relative;
    width: 320px;
    background: var(--k);
    border: var(--r) solid var(--i);
    border-radius: var(--q);
    padding: 20px 18px 18px;
    cursor: pointer;
    text-align: left;
    transition: border-color var(--u), background var(--u);
    overflow: hidden;
}

.f:hover {
    border-color: var(--j);
    background: var(--m);
}

.g {
    position: absolute;
    top: calc(var(--r) * -1);
    left: calc(var(--r) * -1);
    right: calc(var(--r) * -1);
    height: 3px;
    background: transparent;
    border-radius: var(--q) var(--q) 0 0;
    pointer-events: none;
    z-index: 5;
}

.g::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--a);
    transform: scaleX(0);
    transform-origin: left center;
}

.g.r::before  { animation: lineIn  var(--v) ease forwards; }
.g.x::before { animation: lineOut var(--v) ease forwards; }

@keyframes lineIn {
    from { transform: scaleX(0); transform-origin: left center; }
    to   { transform: scaleX(1); transform-origin: left center; }
}

@keyframes lineOut {
    from { transform: scaleX(1); transform-origin: left center; }
    to   { transform: scaleX(0); transform-origin: left center; }
}

.h {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.j { flex: 1; min-width: 0; }

.j h3 {
    font-size: 15px;
    font-weight: 600;
    color: var(--a);
    margin-bottom: 5px;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.k {
    width: 16px;
    height: 16px;
    object-fit: contain;
    flex-shrink: 0;
}

.j p {
    font-size: 11px;
    line-height: 1.55;
    color: var(--c);
    word-break: break-all;
}

.p {
    flex-shrink: 0;
    display: inline-block;
    padding: 6px 14px;
    font-size: 12px;
    color: var(--a);
    text-decoration: none;
    border: var(--r) solid var(--a);
    border-radius: var(--t);
    background: transparent;
    transition: background var(--u), color var(--u);
    white-space: nowrap;
}

.p:hover {
    background: var(--a);
    color: var(--b);
}

/* ===== 访问信息卡片 ===== */
.f.info {
    width: 100%;
    max-width: 1080px;
    margin-top: 36px;
    cursor: default;
    padding: 18px 20px 16px;
}

.f.info:hover {
    border-color: var(--i);
    background: var(--k);
}

.info-head {
    font-size: 15px;
    font-weight: 600;
    color: var(--a);
    letter-spacing: 0.5px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.info-head::before {
    content: '';
    width: 3px;
    height: 14px;
    border-radius: var(--s);
    background: var(--a);
}

.info-body {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 0 26px;
}

.info-row {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 8px 0;
    border-bottom: var(--r) solid var(--g);
    font-size: 12px;
}

.info-label {
    flex-shrink: 0;
    width: 62px;
    color: var(--c);
    letter-spacing: 0.5px;
}

.info-value {
    flex: 1;
    min-width: 0;
    font-family: "SFMono-Regular", Consolas, "Liberation Mono", monospace;
    font-size: 11.5px;
    line-height: 1.6;
    color: var(--a);
    word-break: break-all;
    transition: color var(--u);
}

.info-value.loading { color: var(--d); }

footer {
    text-align: center;
    padding: 7px 20px;
    font-size: 11px;
    letter-spacing: 0.5px;
    line-height: 1.3;
    color: var(--d);
    border-top: var(--r) solid var(--g);
    background: var(--k);
    position: relative;
    z-index: 1;
}

@media (max-width: 1060px) { .f { width: 290px; } }

@media (max-width: 820px) {
    .c h1 { font-size: 2.4rem; }
    .e { gap: 14px; }
    .f { width: 100%; max-width: 380px; }
    .f.info { max-width: 100%; padding: 16px 14px 14px; }
    .info-body { grid-template-columns: 1fr; gap: 0; }
}
</style>
</head>
<body>

    <header>
        <nav>
            <div class="l">ReaxNet</div>
            <button class="m" aria-label="菜单">
                <span></span><span></span><span></span>
            </button>
        </nav>

        <div class="n">
            <div class="i">
                <a href="/">首页</a>
                <a href="https://ai.reax.cn">纪失AI</a>
                <a href="https://t8000x.cn">T8000X</a>
                <a href="https://fuck.reax.cn">#Fuck</a>
                <a href="https://support.reax.cn">赞助Reax项目</a>
                <a href="javascript:void(0);" onclick="IQ()">联系我们</a>
            </div>
        </div>
    </header>

    <div class="c">
        <h1>ReaxNet</h1>
        <p class="s">REAX.CN·借口盒旗下项目集中网</p>

        <!-- ===== 访问信息卡片 ===== -->
        <div class="f info">
            <div class="g"></div>
            <div class="info-head">访问信息</div>
            <div class="info-body">
                <div class="info-row">
                    <span class="info-label">IPv4</span>
                    <!-- 直接输出 PHP 获取到的 IP，无需前端加载 -->
                    <span class="info-value" id="infoIpv4"><?php echo htmlspecialchars($clientIPv4); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">设备型号</span>
                    <span class="info-value loading" id="infoDevice">检测中...</span>
                </div>
                <div class="info-row">
                    <span class="info-label">指纹</span>
                    <span class="info-value loading" id="infoFingerprint">...</span>
                </div>
                <div class="info-row">
                    <span class="info-label">浏览器</span>
                    <span class="info-value loading" id="infoBrowser">...</span>
                </div>
                <div class="info-row">
                    <span class="info-label">系统</span>
                    <span class="info-value loading" id="infoOs">...</span>
                </div>
            </div>
        </div>

        <div class="e">
            <div class="f">
                <div class="g"></div>
                <div class="h">
                    <div class="j">
                        <h3>
                            <img src="svg/ai.svg" class="k">
                            纪失AI - 快速响应
                        </h3>
                        <p>由借口盒开发的基础语言模型，适合日常对话、数据分析、简单代码编写与调试等。</p>
                    </div>
                    <a class="p" href="https://ai.reax.cn">进入</a>
                </div>
            </div>

            <div class="f">
                <div class="g"></div>
                <div class="h">
                    <div class="j">
                        <h3>
                            <img src="svg/chat.svg" class="k">
                            T8000X - Chat
                        </h3>
                        <p>由借口盒开发的轻量网聊，内置AI调用、图片发送、实时消息、账号设置等，后端由python支持。</p>
                    </div>
                    <a class="p" href="https://t8000x.cn">进入</a>
                </div>
            </div>

            <div class="f">
                <div class="g"></div>
                <div class="h">
                    <div class="j">
                        <h3>
                            <img src="svg/fuck.svg" class="k">
                            ReaxNet - #Fuck1.0.2
                        </h3>
                        <p>由ReaxNet支持的小型项目，仅供测试环境使用，无实质性用处。</p>
                    </div>
                    <a class="p" href="https://fuck.reax.cn">进入</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        © 2026 ReaxNet. All rights reserved.
    </footer>

    <script>
    /* ===== S.js ===== */
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.querySelector('.m');
        const navLinks = document.querySelector('.n');
        const allLines = document.querySelectorAll('.g');

        function playLine(card) {
            const line = card.querySelector('.g');
            line.classList.remove('r', 'x');
            void line.offsetWidth;
            line.classList.add('r');
        }

        function hideLine(line) {
            line.classList.remove('r');
            void line.offsetWidth;
            line.classList.add('x');
        }

        document.addEventListener('pointerdown', function (e) {
            const card = e.target.closest('.f');

            allLines.forEach(function (line) {
                const owner = line.closest('.f');
                if (card && owner === card) return;
                if (line.classList.contains('r')) {
                    hideLine(line);
                }
            });

            if (card) {
                playLine(card);
            }
        });

        document.addEventListener('click', function (e) {
            const isMenuBtn = e.target.closest('.m');
            const isMenuPanel = e.target.closest('.n');
            const card = e.target.closest('.f');

            if (isMenuBtn) {
                navLinks.classList.toggle('a');
                btn.classList.toggle('a');
                return;
            }

            if (!isMenuPanel) {
                navLinks.classList.remove('a');
                btn.classList.remove('a');
            }

            if (card) {
                const enterBtn = e.target.closest('.p');
                if (enterBtn) {
                    e.preventDefault();
                    const url = enterBtn.getAttribute('href');
                    setTimeout(function () {
                        window.location.href = url;
                    }, 450);
                }
            }
        });
    });

    /* ===== Q.js ===== */
    function IQ() {
      const qq = "3645935484",
            link = "v6cQTemr3a",
            ua = navigator.userAgent,
            path = `card/show_pslcard?src_type=internal&version=1&uin=${qq}`;

      location.href = /Windows/i.test(ua)
        ? `mqqapi://${path}`
        : /Android|iPhone|iPod|iPad|Macintosh|MacOS|Mac_OS_X/i.test(ua)
          ? `mqq://${path}`
          : `https://qm.qq.com/q/${link}`;
    }

    /* ===== 访问信息采集（仅前端部分，IPv4 已由 PHP 输出） ===== */
    (function () {
        var uaStr = navigator.userAgent || '';

        function $(id) { return document.getElementById(id); }

        function setVal(id, text, isLoading) {
            var el = $(id);
            if (!el) return;
            el.textContent = text;
            if (!isLoading) el.classList.remove('loading');
        }

        /* ---- 浏览器识别 ---- */
        function parseBrowser(ua) {
            if (/MicroMessenger/i.test(ua)) { var v = ua.match(/MicroMessenger\/([\d.]+)/i); return '微信内置浏览器' + (v ? ' ' + v[1] : ''); }
            if (/QQBrowser/i.test(ua)) { var v = ua.match(/QQBrowser\/([\d.]+)/i); return 'QQ浏览器' + (v ? ' ' + v[1] : ''); }
            if (/UCBrowser/i.test(ua) || /UCWEB/i.test(ua)) { var v = ua.match(/UCBrowser\/([\d.]+)/i); return 'UC浏览器' + (v ? ' ' + v[1] : ''); }
            if (/Quark/i.test(ua)) { var v = ua.match(/Quark\/([\d.]+)/i); return '夸克浏览器' + (v ? ' ' + v[1] : ''); }
            if (/Baidu|baiduboxapp|BIDUBrowser/i.test(ua)) { var v = ua.match(/(?:BIDUBrowser|baiduboxapp)\/([\d.]+)/i); return '百度浏览器' + (v ? ' ' + v[1] : ''); }
            if (/SogouMobileBrowser|SogouMSESDK/i.test(ua)) { var v = ua.match(/SogouMobileBrowser\/([\d.]+)/i); return '搜狗浏览器' + (v ? ' ' + v[1] : ''); }
            if (/360SE|360browser|QihooBrowser/i.test(ua)) return '360浏览器';
            if (/LieBaoFast/i.test(ua)) return '猎豹浏览器';
            if (/Maxthon|MxBrowser/i.test(ua)) return '遨游浏览器';
            if (/OPR\//i.test(ua) || /Opera/i.test(ua)) { var v = ua.match(/(?:OPR|Opera)\/([\d.]+)/i); return 'Opera' + (v ? ' ' + v[1] : ''); }
            if (/EdgA\//i.test(ua) || /EdgiOS\//i.test(ua) || /Edge\//i.test(ua)) { var v = ua.match(/EdgA?\/([\d.]+)/i); return 'Edge' + (v ? ' ' + v[1] : ''); }
            if (/Firefox\//i.test(ua)) { var v = ua.match(/Firefox\/([\d.]+)/i); return 'Firefox' + (v ? ' ' + v[1] : ''); }
            if (/CriOS\//i.test(ua)) { var v = ua.match(/CriOS\/([\d.]+)/i); return 'Chrome iOS' + (v ? ' ' + v[1] : ''); }
            if (/Chrome\//i.test(ua)) { var v = ua.match(/Chrome\/([\d.]+)/i); return 'Chrome' + (v ? ' ' + v[1] : ''); }
            if (/Safari\//i.test(ua)) { var v = ua.match(/Version\/([\d.]+)/i); return 'Safari' + (v ? ' ' + v[1] : ''); }
            if (/Via\//i.test(ua)) { var v = ua.match(/Via\/([\d.]+)/i); return 'Via浏览器' + (v ? ' ' + v[1] : ''); }
            if (/XBrowser/i.test(ua)) return 'X浏览器';
            if (/MiuiBrowser/i.test(ua)) { var v = ua.match(/MiuiBrowser\/([\d.]+)/i); return '小米浏览器' + (v ? ' ' + v[1] : ''); }
            if (/HuaweiBrowser|HUAWEI/i.test(ua)) { var v = ua.match(/HuaweiBrowser\/([\d.]+)/i); return '华为浏览器' + (v ? ' ' + v[1] : ''); }
            if (/VivoBrowser/i.test(ua)) { var v = ua.match(/VivoBrowser\/([\d.]+)/i); return 'vivo浏览器' + (v ? ' ' + v[1] : ''); }
            if (/HeyTapBrowser|OPPOBrowser/i.test(ua)) return 'OPPO浏览器';
            if (/SamsungBrowser/i.test(ua)) { var v = ua.match(/SamsungBrowser\/([\d.]+)/i); return '三星浏览器' + (v ? ' ' + v[1] : ''); }
            return '未知浏览器';
        }

        /* ---- 系统识别 ---- */
        function parseOS(ua) {
            if (/iPhone/i.test(ua)) { var v = ua.match(/iPhone OS\s([\d_]+)/i) || ua.match(/CPU iPhone OS\s([\d_]+)/i); if (v) return 'iOS ' + v[1].replace(/_/g, '.'); return 'iOS'; }
            if (/iPad/i.test(ua)) { var v = ua.match(/CPU OS\s([\d_]+)/i); if (v) return 'iPadOS ' + v[1].replace(/_/g, '.'); return 'iPadOS'; }
            if (/Android/i.test(ua)) { var v = ua.match(/Android\s([\d.]+)/i); return 'Android' + (v ? ' ' + v[1] : ''); }
            if (/HarmonyOS/i.test(ua)) { var v = ua.match(/HarmonyOS[\s/]([\d.]+)/i); return 'HarmonyOS' + (v ? ' ' + v[1] : ''); }
            if (/Windows NT/i.test(ua)) return 'Windows';
            if (/Macintosh|Mac OS X/i.test(ua)) return 'macOS';
            if (/Linux/i.test(ua)) return 'Linux';
            return '未知系统';
        }

        /* ---- 设备型号（恩赐.php 同款：优先取 UA 内 Android 机型标识） ---- */
        function parseDevice(ua) {
            if (/iPhone/i.test(ua)) return 'iPhone';
            if (/iPad/i.test(ua)) return 'iPad';
            var m = ua.match(/Android[^;]*;\s*(?:[a-z]{2}(?:[-_][A-Za-z]{2})?;\s*)?([^;)]+)/i);
            if (m && m[1]) {
                var d = m[1].replace(/\s*Build.*$/i, '').trim();
                if (d && !/^[a-z]{2}(-[A-Za-z]{2})?$/.test(d)) return d;
            }
            if (/Windows NT/i.test(ua)) return 'Windows PC';
            if (/Macintosh|Mac OS X/i.test(ua)) return 'Mac';
            if (/Linux/i.test(ua)) return 'Linux';
            return '未知设备';
        }

        /* ---- Canvas 指纹（恩赐.php 同款） ---- */
        function getFingerprint() {
            var c = document.createElement('canvas');
            var x = c.getContext('2d');
            c.width = 200; c.height = 50;
            x.fillStyle = '#f60'; x.fillRect(0, 0, 200, 50);
            x.fillStyle = '#069'; x.font = '14px Arial';
            x.fillText('fp-' + uaStr, 10, 30);
            var d = c.toDataURL(), h = 0;
            for (var i = 0; i < d.length; i++) { h = ((h << 5) - h) + d.charCodeAt(i); h = h & h; }
            return Math.abs(h).toString(36) + '-' + (navigator.hardwareConcurrency || '?') + 'core';
        }

        /* ---- 立即填充本地可获取项（IPv4 已由 PHP 直接输出，无需在此处理） ---- */
        setVal('infoBrowser', parseBrowser(uaStr));
        setVal('infoOs', parseOS(uaStr));
        setVal('infoDevice', parseDevice(uaStr));
        setVal('infoFingerprint', getFingerprint());
    })();
    </script>
</body>
</html>