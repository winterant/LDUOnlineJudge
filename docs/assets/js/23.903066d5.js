(window.webpackJsonp=window.webpackJsonp||[]).push([[23],{312:function(t,a,e){t.exports=e.p+"assets/img/git-repo.9c57d540.jpg"},313:function(t,a,e){t.exports=e.p+"assets/img/coding.f06b3a48.png"},332:function(t,a,e){"use strict";e.r(a);var s=e(14),r=Object(s.a)({},(function(){var t=this,a=t._self._c;return a("ContentSlotsDistributor",{attrs:{"slot-key":t.$parent.slotKey}},[a("h1",{attrs:{id:"开发手册"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#开发手册"}},[t._v("#")]),t._v(" 开发手册")]),t._v(" "),a("blockquote",[a("p",[t._v("开发应尽最大可能地遵循"),a("a",{attrs:{href:"https://github.com/winterant/restful-api-specification",target:"_blank",rel:"noopener noreferrer"}},[t._v("前后端接口规范 - RESTful版"),a("OutboundLink")],1),t._v("。")])]),t._v(" "),a("h2",{attrs:{id:"生产环境"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#生产环境"}},[t._v("#")]),t._v(" 生产环境")]),t._v(" "),a("p",[t._v("生产环境采用"),a("code",[t._v("docker-compose")]),t._v("编排方式部署，包含4个镜像，分别是")]),t._v(" "),a("ul",[a("li",[a("code",[t._v("winterant/lduoj")]),t._v("; 基于Ubuntu22.04镜像构建"),a("a",{attrs:{href:"https://github.com/winterant/OnlineJudge",target:"_blank",rel:"noopener noreferrer"}},[t._v("Web端"),a("OutboundLink")],1),t._v("；")]),t._v(" "),a("li",[a("code",[t._v("winterant/go-judge")]),t._v("; 基于"),a("a",{attrs:{href:"https://github.com/criyle/go-judge",target:"_blank",rel:"noopener noreferrer"}},[t._v("go-judge"),a("OutboundLink")],1),t._v("构建判题端；")]),t._v(" "),a("li",[a("code",[t._v("mysql:8.0")]),t._v("; 官方镜像；")]),t._v(" "),a("li",[a("code",[t._v("redis:7.0")]),t._v("; 官方镜像；")])]),t._v(" "),a("p",[t._v("部署方式请参考"),a("RouterLink",{attrs:{to:"/deploy/deploy.html"}},[t._v("安装")]),t._v("。")],1),t._v(" "),a("h2",{attrs:{id:"本地开发"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#本地开发"}},[t._v("#")]),t._v(" 本地开发")]),t._v(" "),a("blockquote",[a("p",[t._v("开发前，你需要对"),a("a",{attrs:{href:"https://learnku.com/docs/laravel/10.x",target:"_blank",rel:"noopener noreferrer"}},[t._v("Laravel框架"),a("OutboundLink")],1),t._v("有一些基本的了解。"),a("br"),t._v("\n本地开发最简单的方法是按照生产环境的部署方式部署到本地电脑，并将源码映射到宿主机，在本地打开源码目录进行开发即可。")])]),t._v(" "),a("h3",{attrs:{id:"一-个人电脑需要安装的软件"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#一-个人电脑需要安装的软件"}},[t._v("#")]),t._v(" 一. 个人电脑需要安装的软件")]),t._v(" "),a("h4",{attrs:{id:"_1-代码编辑器或ide-任选一个"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_1-代码编辑器或ide-任选一个"}},[t._v("#")]),t._v(" 1. 代码编辑器或IDE（任选一个）")]),t._v(" "),a("ul",[a("li",[a("a",{attrs:{href:"https://code.visualstudio.com",target:"_blank",rel:"noopener noreferrer"}},[t._v("vscode"),a("OutboundLink")],1),t._v("（推荐）；"),a("br"),t._v("\nvscode是一个编辑器，你需要安装一些必备的插件才能进行开发：\n"),a("ul",[a("li",[t._v("Chinese (Simplified)(简体中文)（可选；汉化vscode主界面）")]),t._v(" "),a("li",[t._v("PHP Intelephense（必需；php语法提示工具）")]),t._v(" "),a("li",[t._v("Laravel Blade Snippets（必需；前端模板提示工具）")]),t._v(" "),a("li",[t._v("Laravel Blade formatter（必需；前端模板格式化工具）")]),t._v(" "),a("li",[t._v("Git History（可选；可视化查看文件修改历史）")])])]),t._v(" "),a("li",[a("a",{attrs:{href:"https://www.jetbrains.com/phpstorm/",target:"_blank",rel:"noopener noreferrer"}},[t._v("PhpStorm"),a("OutboundLink")],1),t._v("；")])]),t._v(" "),a("h4",{attrs:{id:"_2-docker"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_2-docker"}},[t._v("#")]),t._v(" 2. docker")]),t._v(" "),a("p",[t._v("安装docker请参考"),a("RouterLink",{attrs:{to:"/deploy/deploy.html"}},[t._v("安装-准备工作")]),t._v("。")],1),t._v(" "),a("h4",{attrs:{id:"_3-git"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_3-git"}},[t._v("#")]),t._v(" 3. git")]),t._v(" "),a("p",[t._v("如需向远程仓库贡献代码，请安装"),a("a",{attrs:{href:"https://git-scm.com/",target:"_blank",rel:"noopener noreferrer"}},[t._v("git"),a("OutboundLink")],1),t._v("。附"),a("a",{attrs:{href:"https://blog.csdn.net/winter2121/article/details/124227331",target:"_blank",rel:"noopener noreferrer"}},[t._v("git基础操作笔记"),a("OutboundLink")],1),t._v("。")]),t._v(" "),a("p",[t._v("注意：现在github口令验证变严格了，从本地向远程仓库推送代码，只能通过ssh方式，所以你需要参考"),a("a",{attrs:{href:"https://blog.csdn.net/winter2121/article/details/124227331",target:"_blank",rel:"noopener noreferrer"}},[t._v("git基础操作笔记"),a("OutboundLink")],1),t._v("配置好github access ssh key。")]),t._v(" "),a("h3",{attrs:{id:"二-将项目部署到本地"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#二-将项目部署到本地"}},[t._v("#")]),t._v(" 二. 将项目部署到本地")]),t._v(" "),a("h4",{attrs:{id:"_1-获取最新部署脚本-全部版本详见releases"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_1-获取最新部署脚本-全部版本详见releases"}},[t._v("#")]),t._v(" 1. 获取最新部署脚本（全部版本详见"),a("a",{attrs:{href:"https://github.com/winterant/OnlineJudge/releases",target:"_blank",rel:"noopener noreferrer"}},[t._v("releases"),a("OutboundLink")],1),t._v("）；")]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 1. 创建项目文件夹并进入")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("mkdir")]),t._v(" OnlineJudge\n"),a("span",{pre:!0,attrs:{class:"token builtin class-name"}},[t._v("cd")]),t._v(" OnlineJudge\n"),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 2. 下载部署脚本和配置文件, 注意-O是大写字母O.")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("curl")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-O")]),t._v(" https://gitee.com/winant/OnlineJudge/raw/master/install/docker-compose.yml\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("curl")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-O")]),t._v(" https://gitee.com/winant/OnlineJudge/raw/master/install/lduoj.conf\n")])])]),a("p",[t._v("下文所有开发操作都将发生在文件夹"),a("code",[t._v("OnlineJudge")]),t._v("内，所以建议你把它放在一个你熟悉的位置（Windows用户不要放在C盘）。")]),t._v(" "),a("h4",{attrs:{id:"_2-修改必要的配置"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_2-修改必要的配置"}},[t._v("#")]),t._v(" 2. 修改必要的配置")]),t._v(" "),a("p",[a("code",[t._v("docker-compose.yml")]),t._v("：")]),t._v(" "),a("div",{staticClass:"language-yml extra-class"},[a("pre",{pre:!0,attrs:{class:"language-yml"}},[a("code",[a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 其它代码...")]),t._v("\n\n"),a("span",{pre:!0,attrs:{class:"token key atrule"}},[t._v("services")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(":")]),t._v("\n  "),a("span",{pre:!0,attrs:{class:"token key atrule"}},[t._v("web")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(":")]),t._v("\n    "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 其它代码...")]),t._v("\n    "),a("span",{pre:!0,attrs:{class:"token key atrule"}},[t._v("volumes")]),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(":")]),t._v("\n      "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# - ./data/web/storage:/app/storage  # **必须注释掉**")]),t._v("\n      "),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v("-")]),t._v(" ./data/web"),a("span",{pre:!0,attrs:{class:"token punctuation"}},[t._v(":")]),t._v("/app  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# **必须启用**，将源码将挂载到宿主机`./data/web/`")]),t._v("\n\n"),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 其它代码...")]),t._v("\n")])])]),a("p",[a("code",[t._v("lduoj.conf")]),t._v("：")]),t._v(" "),a("div",{staticClass:"language-shell extra-class"},[a("pre",{pre:!0,attrs:{class:"language-shell"}},[a("code",[a("span",{pre:!0,attrs:{class:"token assign-left variable"}},[t._v("APP_DEBUG")]),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=")]),t._v("true    "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# **强烈建议**，启用laravel框架的debug模式")]),t._v("\n")])])]),a("h4",{attrs:{id:"_3-启动容器-在宿主机文件夹onlinejudge-下执行。稍等几分钟-docker会自动下载好镜像并启动容器。"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_3-启动容器-在宿主机文件夹onlinejudge-下执行。稍等几分钟-docker会自动下载好镜像并启动容器。"}},[t._v("#")]),t._v(" 3. 启动容器；在宿主机文件夹"),a("code",[t._v("OnlineJudge/")]),t._v("下执行。稍等几分钟，docker会自动下载好镜像并启动容器。")]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("sudo")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("docker")]),t._v(" compose up "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-d")]),t._v("\n")])])]),a("p",[t._v("打开浏览器访问"),a("a",{attrs:{href:"http://localhost:8080",target:"_blank",rel:"noopener noreferrer"}},[t._v("http://localhost:8080"),a("OutboundLink")],1),t._v("，如果成功显示首页，则表示本地开发环境部署成功。")]),t._v(" "),a("h3",{attrs:{id:"三-网页端开发与维护"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#三-网页端开发与维护"}},[t._v("#")]),t._v(" 三. 网页端开发与维护")]),t._v(" "),a("h4",{attrs:{id:"_1-使用vscode打开文件夹onlinejudge-data-web-即可看到web端源码。"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_1-使用vscode打开文件夹onlinejudge-data-web-即可看到web端源码。"}},[t._v("#")]),t._v(" 1. 使用vscode打开文件夹"),a("code",[t._v("OnlineJudge/data/web/")]),t._v("，即可看到Web端源码。")]),t._v(" "),a("h4",{attrs:{id:"_2-配置git仓库"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_2-配置git仓库"}},[t._v("#")]),t._v(" 2. 配置git仓库；")]),t._v(" "),a("p",[t._v("配置两个远程仓库：")]),t._v(" "),a("ul",[a("li",[a("code",[t._v("origin")]),t._v("，原始远程仓库，人人拥有pull权限，但只有"),a("a",{attrs:{href:"https://github.com/winterant",target:"_blank",rel:"noopener noreferrer"}},[t._v("winterant"),a("OutboundLink")],1),t._v("拥有"),a("code",[t._v("push")]),t._v("权限；")]),t._v(" "),a("li",[a("code",[t._v("forked")]),t._v("，你从"),a("a",{attrs:{href:"https://github.com/winterant/OnlineJudge",target:"_blank",rel:"noopener noreferrer"}},[t._v("github原始仓库"),a("OutboundLink")],1),t._v("网页上fork出来的远程仓库。")])]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" init  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 初始化仓库，将创建默认分支main")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" remote "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),t._v(" origin git@github.com:winterant/OnlineJudge.git  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 添加原始远程仓库，用于pull获取最新代码")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" remote "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),t._v(" forked git@github.com:"),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v("<")]),t._v("GithubUser"),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v(">")]),t._v("/OnlineJudge.git  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 添加个人远程仓库，用于push改动的代码")]),t._v("\n")])])]),a("p",[t._v("解释：\n"),a("code",[t._v("origin")]),t._v("、"),a("code",[t._v("forked")]),t._v("仅仅是在本地的别名，你可以随便起名字，远程仓库不会得知它们。\n在实际使用时，")]),t._v(" "),a("ul",[a("li",[t._v("你完全可以从"),a("code",[t._v("forked")]),t._v("源"),a("code",[t._v("pull")]),t._v("和"),a("code",[t._v("push")]),t._v("自己的远程仓库，而不配置"),a("code",[t._v("origin")]),t._v("；")]),t._v(" "),a("li",[t._v("如果你拥有原始仓库的"),a("code",[t._v("push")]),t._v("权限，则无需"),a("code",[t._v("forked")]),t._v("仓库，只配置一个"),a("code",[t._v("origin")]),t._v("就可以了；")])]),t._v(" "),a("div",{attrs:{align:"center"}},[a("img",{attrs:{src:e(312),width:"500"}})]),t._v(" "),a("h4",{attrs:{id:"_3-从github获取最新代码"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_3-从github获取最新代码"}},[t._v("#")]),t._v(" 3. 从github获取最新代码；")]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" fetch "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("--all")]),t._v("  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 拉取远程代码，但不合并到本地仓库")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" reset "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("--hard")]),t._v(" origin/master "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 将origin/master分支远程代码覆盖本地、暂存区、工作区当前本地分支(main)")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" branch --set-upstream-to"),a("span",{pre:!0,attrs:{class:"token operator"}},[t._v("=")]),t._v("origin/master main  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 设置origin/master作为本地分支main的获取源")]),t._v("\n")])])]),a("h4",{attrs:{id:"_4-开始愉快地开发吧"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_4-开始愉快地开发吧"}},[t._v("#")]),t._v(" 4. 开始愉快地开发吧！")]),t._v(" "),a("div",{attrs:{align:"center"}},[a("img",{attrs:{src:e(313),width:"300"}})]),t._v(" "),a("ul",[a("li",[t._v("（可选）默认情况下，laravel框架的开发依赖包没有被安装在"),a("code",[t._v("winterant/lduoj")]),t._v("镜像内。\n大多数情况下，不使用它们也不会影响开发。你可以在"),a("code",[t._v("composer.json")]),t._v("的"),a("code",[t._v("require-dev")]),t._v("部分看到这些仅用于开发的依赖包。\n如果你是资深开发者或对此项目有长期开发计划，那么非常建议你手动安装这些依赖：")])]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("docker")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token builtin class-name"}},[t._v("exec")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-it")]),t._v(" ludoj-web "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("composer")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("install")]),t._v(" --ignore-platform-reqs "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("--dev")]),t._v("\n")])])]),a("ul",[a("li",[t._v("（可选）开发过程中，若配置（如"),a("code",[t._v("routes/web.php")]),t._v(","),a("code",[t._v("config/*.php")]),t._v("等）修改后不生效，可手动取消缓存：")])]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("docker")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token builtin class-name"}},[t._v("exec")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-it")]),t._v(" lduoj-web php artisan opimize:clear  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 清空容器内配置的缓存")]),t._v("\n")])])]),a("h4",{attrs:{id:"_5-开发完某个功能后-你需要提交-commit-你的代码-注意这仅仅是提交到本地仓库-不代表提交到远程仓库"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_5-开发完某个功能后-你需要提交-commit-你的代码-注意这仅仅是提交到本地仓库-不代表提交到远程仓库"}},[t._v("#")]),t._v(" 5. 开发完某个功能后，你需要提交(commit)你的代码（注意这仅仅是提交到本地仓库，不代表提交到远程仓库）；")]),t._v(" "),a("p",[t._v("你可以使用vscode自带的代码管理器来提交，也可以使用以下命令进行提交：")]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("add")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token builtin class-name"}},[t._v(".")]),t._v("  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# .代表当前项目目录全部添加到暂存区等候提交，你也可以替换成你希望提交的那部分文件")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" commit "),a("span",{pre:!0,attrs:{class:"token parameter variable"}},[t._v("-m")]),t._v(" "),a("span",{pre:!0,attrs:{class:"token string"}},[t._v('"committing information."')]),t._v("\n")])])]),a("h4",{attrs:{id:"_6-向远程仓库推送代码-将本地的改动推送到你的远程仓库"}},[a("a",{staticClass:"header-anchor",attrs:{href:"#_6-向远程仓库推送代码-将本地的改动推送到你的远程仓库"}},[t._v("#")]),t._v(" 6. 向远程仓库推送代码；将本地的改动推送到你的远程仓库：")]),t._v(" "),a("div",{staticClass:"language-bash extra-class"},[a("pre",{pre:!0,attrs:{class:"language-bash"}},[a("code",[a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" pull  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 先将远程代码合并到本地，若有冲突则解决冲突之后再push")]),t._v("\n"),a("span",{pre:!0,attrs:{class:"token function"}},[t._v("git")]),t._v(" push --set-upstream forked main:master  "),a("span",{pre:!0,attrs:{class:"token comment"}},[t._v("# 本地main分支推送到forked远程仓库master分支")]),t._v("\n")])])]),a("p",[t._v("然后在你的远程仓库中，向原始仓库发起Pull Request，并联系"),a("a",{attrs:{href:"https://github.com/winterant",target:"_blank",rel:"noopener noreferrer"}},[t._v("winterant"),a("OutboundLink")],1),t._v("审阅、合并代码。")])])}),[],!1,null,null,null);a.default=r.exports}}]);