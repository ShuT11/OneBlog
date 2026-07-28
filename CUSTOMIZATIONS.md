# ShuT11 OneBlog 定制说明

本仓库基于 OneBlog `3.7.2` 的 `lite` 分支维护，用于 `ShuT11` 博客的后续个性化开发。当前定制不包含 Typecho 数据库、站点密码、邮件授权码、对象存储密钥或服务器配置。

## 当前定制

### 系统原生 Emoji

- 评论选择器使用标准 Unicode Emoji，由访客操作系统显示对应的 Apple、Google 或 Microsoft 样式。
- 提供 `34` 个常用表情、`10` 个特殊符号和 `17` 个颜文字。
- 新评论直接保存 Unicode，不加载 `static/img/emoji/*.svg`。
- 当前站点没有旧评论，因此不兼容 `[emoji:101]` 等旧短代码。
- 表情面板会根据视口空间自动选择展开方向，并支持键盘操作、纯文本粘贴和隐藏提交字段同步。
- 原 `static/js/emoji.js` 与 SVG 文件暂时保留但不再引用，便于快速回退。

相关文件：

- `header.php`
- `footer.php`
- `static/css/native-emoji-v1.css`
- `static/js/emoji-native-v1.js`

### Album 安全适配

`photos.php` 对相册原图地址、缩略图地址、标题和说明进行 HTML 属性转义，避免插件数据进入页面属性时形成不安全输出。

### MemosImage 安全适配

`static/js/main.js` 会在本地上传和 COS 签名请求中附带 Typecho CSRF Token，与服务器端仅允许管理员 POST 请求的加固逻辑配合使用。

## 维护要求

- 合并上游 OneBlog 更新前，先比较 `header.php`、`footer.php`、`comments.php`、`photos.php` 和 `static/js/main.js`。
- 不要直接覆盖本仓库中的原生 Emoji、Album 或 MemosImage 改动。
- 发布前至少执行 PHP 语法检查、JavaScript 语法检查，以及桌面和手机尺寸的评论选择器验收。
- 评论验收应检查光标插入、纯文本粘贴、隐藏字段同步、表单提交和 CommentNotifier 邮件内容；发送测试邮件前需要单独确认。
- 插件代码与主题代码分开维护，任何密码、Token、密钥、数据库导出和上传内容都不得提交到本仓库。
