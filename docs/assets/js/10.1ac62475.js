(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{285:function(s,t,a){"use strict";a.r(t);var e=a(14),n=Object(e.a)({},(function(){var s=this,t=s._self._c;return t("ContentSlotsDistributor",{attrs:{"slot-key":s.$parent.slotKey}},[t("h1",{attrs:{id:"配置代理"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#配置代理"}},[s._v("#")]),s._v(" 配置代理")]),s._v(" "),t("p",[s._v("网页端默认暴露80端口，并通过配置文件"),t("code",[s._v("docker-compose.yml")]),s._v("映射到宿主机8080端口。\n你可以在宿主机配置网络代理，以实现域名访问，以及https证书配置。")]),s._v(" "),t("h2",{attrs:{id:"📡-nginx"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#📡-nginx"}},[s._v("#")]),s._v(" 📡 nginx")]),s._v(" "),t("h3",{attrs:{id:"安装nginx"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#安装nginx"}},[s._v("#")]),s._v(" 安装nginx")]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("apt")]),s._v(" update\n"),t("span",{pre:!0,attrs:{class:"token function"}},[s._v("apt")]),s._v(" "),t("span",{pre:!0,attrs:{class:"token function"}},[s._v("install")]),s._v(" "),t("span",{pre:!0,attrs:{class:"token parameter variable"}},[s._v("-y")]),s._v(" nginx\n")])])]),t("p",[t("code",[s._v("nginx")]),s._v("默认自带80端口配置文件，为避免冲突，在生产环境中可以删除它")]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("rm")]),s._v(" /etc/nginx/sites-enabled/default\n")])])]),t("h3",{attrs:{id:"以http方式配置域名"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#以http方式配置域名"}},[s._v("#")]),s._v(" 以http方式配置域名")]),s._v(" "),t("ol",[t("li",[s._v("创建并编辑配置文件")])]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("vim")]),s._v(" /etc/nginx/conf.d/lduoj-http.conf\n")])])]),t("ol",{attrs:{start:"2"}},[t("li",[s._v("输入内容")])]),s._v(" "),t("div",{staticClass:"language- extra-class"},[t("pre",{pre:!0,attrs:{class:"language-text"}},[t("code",[s._v("server {\n    listen 80;\n    server_name www.lduoj.com;  # 请替换为你的域名\n\n    client_max_body_size 64m;   # 请求体大小上限\n\n    location / {\n        proxy_pass http://127.0.0.1:8080/;  # 代理web端口\n        proxy_redirect off;\n        proxy_set_header Host $host;  # 若监听非80端口,请改为$host:$server_port\n        proxy_set_header X-Real-IP $remote_addr;\n        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;\n    }\n}\n")])])]),t("ol",{attrs:{start:"3"}},[t("li",[s._v("按"),t("code",[s._v("ESC")]),s._v("键，输入"),t("code",[s._v(":wq")]),s._v("并会车，即可保存配置文件。")]),s._v(" "),t("li",[s._v("重启nginx使配置生效")])]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("sudo")]),s._v(" systemctl restart nginx\n")])])]),t("h3",{attrs:{id:"以https方式配置证书和域名"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#以https方式配置证书和域名"}},[s._v("#")]),s._v(" 以https方式配置证书和域名")]),s._v(" "),t("ol",[t("li",[s._v("创建并编辑配置文件")])]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("vim")]),s._v(" /etc/nginx/conf.d/lduoj-https.conf\n")])])]),t("ol",{attrs:{start:"2"}},[t("li",[s._v("输入内容")])]),s._v(" "),t("div",{staticClass:"language- extra-class"},[t("pre",{pre:!0,attrs:{class:"language-text"}},[t("code",[s._v("server{\n    listen 80;\n    server_name lduoj.com;\n    rewrite ^(.*)$  https://$host$1 permanent;  # 强制http转https\n}\n\nserver {\n    listen 443 ssl http2;\n    server_name www.lduoj.com;  # 请替换为你的域名\n\n    client_max_body_size 64m;   # 请求体大小上限\n\n    # ssl的一些配置\n    ssl_certificate conf.d/fullchain.crt;   # 请务必替换成你的ssl证书路径,相对于/etc/nginx/\n    ssl_certificate_key conf.d/private.pem; # 同上\n    ssl_protocols TLSv1.1 TLSv1.2;\n    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:HIGH:!aNULL:!MD5:!RC4:!DHE;\n    ssl_prefer_server_ciphers on;\n    ssl_session_cache shared:SSL:10m;\n    ssl_session_timeout 10m;\n\n    location / {\n        proxy_pass http://127.0.0.1:8080/;\n        proxy_redirect off;\n        proxy_set_header Host $host;\n        proxy_set_header X-Real-IP $remote_addr;\n        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;\n        proxy_set_header X-Forwarded-Proto $scheme;\n    }\n}\n")])])]),t("ol",{attrs:{start:"3"}},[t("li",[s._v("按"),t("code",[s._v("ESC")]),s._v("键，输入"),t("code",[s._v(":wq")]),s._v("并会车，即可保存配置文件。")]),s._v(" "),t("li",[s._v("重启nginx使配置生效")])]),s._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[t("span",{pre:!0,attrs:{class:"token function"}},[s._v("sudo")]),s._v(" systemctl restart nginx\n")])])])])}),[],!1,null,null,null);t.default=n.exports}}]);