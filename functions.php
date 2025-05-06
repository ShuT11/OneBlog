<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Theme：OneBlog
 * Author: ©彼岸临窗 oneblogx.com
 *
 * 注释含命名规范，开源不易，如需引用请注明来源:彼岸临窗 https://oneblogx.com。
 * 本主题已取得软件著作权（登记号：2025SR0334142）和外观设计专利（专利号：第7121519号），请严格遵循GPL-2.0协议使用本主题。
 * 
 **/

//主题版本号自动获取
function parseThemeVersion() {
    $indexFile = __DIR__ . '/index.php'; 
    $content = file_get_contents($indexFile);
    preg_match('/\* @version\s+([0-9.]+)/', $content, $matches);
    return $matches[1] ?? '1.0.0'; 
}

//主题设置自定义
function themeConfig($form) {?>
    <link rel="stylesheet" href="<?php echo Helper::options()->themeUrl('assets/css/theme.css'); ?>" type="text/css" />
    <script src="<?php echo Helper::options()->themeUrl('assets/js/theme.js'); ?>" type="text/javascript"></script>
    <div class="OneBlog"><h3>OneBlog 主题设置</h3></div>
    <div id="tab-container">
        <ul id="tab-nav"></ul>
        <div id="tab-content">
            <div id="tab1" class="tab-pane active">
                <h2>OneBlog V<?php echo parseThemeVersion();?></h2>
                <p>本主题精心打磨多年，且持续优化，现免费开源，致敬互联网社区开源精神，也致敬热爱生活和记录的我们。</p>
                <p>主题安装教程请前往<b></b>主题文档</b>：<a href="https://docs.oneblogx.com" target="_blank">docs.oneblogx.com</a> 获取，</a>主题最新版本请前往Github仓库：<a href="https://github.com/LawyerLu/OneBlog" target="_blank">OneBlog</a> 或 <a href="https://gitcode.com/LawyerLu/OneBlog" target="_blank">国内镜像仓库</a>查看，记得★Star，既是对作者的支持，也方便记住来时的路。</p>
                <p>本主题仅有微信交流群，其他均不是官方群组。如需加群，请通过官方仓库获取最新群二维码。</p>
                <p>如二维码已过期，请通过微信公众号&nbsp;<b>彼岸临窗</b>&nbsp;私信获取或添加作者微信号：&nbsp;<b>oneblogx</b>&nbsp;。</p>
                <p>主题图标库（可直接引用，如 "iconfont icon-home"）：</p>
                <div class="icon-list" id="iconList"></div>
            </div>
        </div>
    </div>
    <?php
    
    //—————————————————————————————————————— 基础设置 ——————————————————————————————————————
    
    //网站logo
    $logo = new Typecho_Widget_Helper_Form_Element_Text('logo', NULL, NULL, _t('LOGO'), _t('请输入深色logo图片的url，填写后会显示在PC首页和移动端顶栏，建议尺寸：300×83'));
    $form->addInput($logo); 
    
    //护眼模式下的logo
    $logoLight = new Typecho_Widget_Helper_Form_Element_Text('logoLight', NULL, NULL, _t('护眼模式下的LOGO'), _t('请输入浅绿色logo图片的url，填写后会显示在护眼模式下的PC端顶栏，建议尺寸：300×83'));
    $form->addInput($logoLight);
    
    //黑色模式下的logo
    $logoWhite = new Typecho_Widget_Helper_Form_Element_Text('logoWhite', NULL, NULL, _t('黑夜模式下的LOGO'), _t('请输入浅白色logo图片的url，填写后会显示在黑夜模式下的移动端顶栏，建议尺寸：300×83'));
    $form->addInput($logoWhite);
    
    //正方形logo
    $logoX = new Typecho_Widget_Helper_Form_Element_Text('logoX', NULL, NULL, _t('正方形LOGO'), _t('填写正方形logo的url地址，填写后会显示在PC端独立页面背景部分，建议图片比例：1:1'));
    $form->addInput($logoX); 
    
    //网站slogan
    $slogan = new Typecho_Widget_Helper_Form_Element_Text('slogan', NULL, NULL, _t('网站slogan'), _t('一句话介绍网站，填写后会显示在独立页面的顶栏和首页的标题中。'));
    $form->addInput($slogan);  
    
    //网站favicon
    $Favicon = new Typecho_Widget_Helper_Form_Element_Text('Favicon', NULL, NULL, _t('Favicon'), _t('请输入网站favicon图片的url。'));
    $form->addInput($Favicon); 
    
    // 添加多行文本框
    $MenuSet = new Typecho_Widget_Helper_Form_Element_Textarea('MenuSet',NULL,NULL,_t('自定义菜单'),_t('每行一个菜单项，菜单项的参数用英文逗号隔开。格式：菜单项名称,链接,图标类名<br>示例：<br>首页,/,iconfont icon-home<br>相册,/photos,iconfont icon-pic')
    );
    $form->addInput($MenuSet);
 
    // 首页杂志效果开关
    $switch = new Typecho_Widget_Helper_Form_Element_Radio('switch', array('on' => '显示','off' => '不显示'),'on', '首页是否显示Banner文章', '选择开启则需要填写下方的文章cid；PC端会在首页顶部显示杂志效果文章，移动端会在首页顶部显示幻灯片自动切换。');
    $form->addInput($switch);
    
    // 首页杂志效果文章
    $Banner = new Typecho_Widget_Helper_Form_Element_Text('Banner', NULL, NULL, _t('首页banner文章cid'), _t('用英文逗号隔开，限3个,填需要显示在banner区域三篇文章的cid。'));
    $form->addInput($Banner);   
    
    // 全站右键菜单
    $Menu = new Typecho_Widget_Helper_Form_Element_Radio('Menu', array('on' => '开启','off' => '不开启'),'off','网站右键菜单', '默认关闭，开启后PC端在博客点击鼠标右键会替换默认的右键菜单，替换为博客的菜单，建议在网站全部调试完毕后再开启');
    $form->addInput($Menu); 
    
    // 文章默认缩略图
    $NoPostIMG = new Typecho_Widget_Helper_Form_Element_Text('NoPostIMG', NULL, NULL, _t('文章默认缩略图'), _t('填写后会在没有设置文章缩略图且未开启随机图库时显示在列表中。'));
    $form->addInput($NoPostIMG); 
    
    //网站标识图
    $Webthumb = new Typecho_Widget_Helper_Form_Element_Text('Webthumb', NULL, NULL, _t('网站标识图'), _t('请填写图片地址，用于SEO优化，建议尺寸：1280×720'));
    $form->addInput($Webthumb); 
    
    //建站年份
    $Webtime = new Typecho_Widget_Helper_Form_Element_Text('Webtime', NULL, NULL, _t('建站年份'), _t('填写后显示在网站底栏，格式：2016，如果是今年刚建站，请勿填写。'));
    $form->addInput($Webtime);
    
    // 统计代码
    $Tongji = new Typecho_Widget_Helper_Form_Element_Textarea('Tongji',NULL,NULL,_t('统计代码'),_t('请输入统计代码，填写后会直接加载至页脚。')
    );
    $form->addInput($Tongji);
    
    //ICP备案号
    $ICP = new Typecho_Widget_Helper_Form_Element_Text('ICP', NULL, NULL, _t('ICP备案号'), _t('如需要显示，请填写网站备案号。'));
    $form->addInput($ICP);   
    
    //公安备案号
    $WA = new Typecho_Widget_Helper_Form_Element_Text('WA', NULL, NULL, _t('公安备案号'), _t('如需要显示，请填写公安备案号，跳转链接请自行在footer.php中修改。'));
    $form->addInput($WA);

    //—————————————————————————————————————— 高级设置 ——————————————————————————————————————
    
    // 添加自定义 DNS 预解析域名字段
    $dnsPrefetch = new Typecho_Widget_Helper_Form_Element_Textarea('dnsPrefetch',NULL,NULL,_t('DNS预解析域名'),_t('请输入需要预解析的域名，每行一个。例如：<br>https://oneblogx.com<br>https://cdn.oneblogx.com')
    );
    $form->addInput($dnsPrefetch);
    
    // 后台表单配置（已实现）
    $imgSmall = new Typecho_Widget_Helper_Form_Element_Text('imgSmall', NULL, NULL, _t('缩略图参数'), _t('填写服务端支持的缩略图参数（如 !small），需搭配 CDN 或云存储图片处理功能使用。留空则显示原图。'));
    $form->addInput($imgSmall);
    
    // 代码块美化
    $BeCode = new Typecho_Widget_Helper_Form_Element_Radio('BeCode', array('on' => '开启','off' => '不开启'),'on','代码块美化', '默认开启，开启后会美化代码区域，技术博客请开启，否则代码块会显示异常，纯生活记录类博客建议关闭。');
    $form->addInput($BeCode); 
    
    // 禁用F12
    $F12 = new Typecho_Widget_Helper_Form_Element_Radio('F12', array('on' => '开启','off' => '不开启'),'off','禁用F12', '默认关闭，开启后未登录用户会禁用浏览器F12调试功能。');
    $form->addInput($F12); 
    
    // 禁用右键
    $RightClick = new Typecho_Widget_Helper_Form_Element_Radio('RightClick', array('on' => '开启','off' => '不开启'),'off','禁用右键', '默认关闭，开启后未登录用户会禁用右键，本功能与主题的右键菜单不冲突。');
    $form->addInput($RightClick); 
    
    // 禁用复制
    $Copy = new Typecho_Widget_Helper_Form_Element_Radio('Copy', array('on' => '开启','off' => '不开启'),'off','禁用复制功能', '默认关闭，开启后未登录用户会禁用复制功能，如果想让友情链接页面允许复制，请将友链slug修改为links。');
    $form->addInput($Copy); 
    
    // 随机高清文艺图片源
    $RandomIMG = new Typecho_Widget_Helper_Form_Element_Radio('RandomIMG', array('oneblog' => '主题图库','off' => '关闭'),'off','随机高清缩略图', '设置后文章列表页在文章没有任何图片且没有单独设置封面时显示随机缩略图，如果想让文章详情页显示封面图，请编辑文章时填写自定义字段[文章封面]。');
    $form->addInput($RandomIMG);  
 
    // Unsplash Api
    $Unsplash_API = new Typecho_Widget_Helper_Form_Element_Text('Unsplash_API', NULL, NULL, _t('Unsplash API'), _t('请填写Unsplash API提供的accessKey，用于随机文艺图片的获取以及Unsplash相册的同步'));
    $form->addInput($Unsplash_API);
    
    // Unsplash照片同步
    $Unsplash = new Typecho_Widget_Helper_Form_Element_Radio('Unsplash', array('on' => '开启','off' => '不开启'),'off','Unsplash照片同步', '默认关闭，开启后PC端在相册页面会出现同步Unsplash照片的功能按钮，点击按钮会自动同步指定用户的照片信息到博客后台，如果开启本功能，需要填写Unsplash API、Unsplash作者用户名、相册mid，否则不会生效');
    $form->addInput($Unsplash); 
    
    //Unsplash用户名
    $Unsplash_User = new Typecho_Widget_Helper_Form_Element_Text('Unsplash_User', NULL, NULL, _t('Unsplash作者用户名'), _t('请填写Unsplash用户名，用于同步该用户发布的摄影作品。'));
    $form->addInput($Unsplash_User);
 
    //相册分类mid
    $Unsplash_Cat = new Typecho_Widget_Helper_Form_Element_Text('Unsplash_Cat', NULL, NULL, _t('相册mid'), _t('请填写相册分类的mid，用于同步摄影作品时自动勾选该分类。'));
    $form->addInput($Unsplash_Cat);
    
    //—————————————————————————————————————— 社交按钮 ——————————————————————————————————————

    $Xiaohongshu = new Typecho_Widget_Helper_Form_Element_Text('Xiaohongshu', NULL, NULL, _t('小红书主页'), _t('请填写小红书主页链接。'));
    $form->addInput($Xiaohongshu);   
    
    $Weixin = new Typecho_Widget_Helper_Form_Element_Text('Weixin', NULL, NULL, _t('微信公众号'), _t('请填写微信公众号或个人微信的二维码远程图片url，格式为:https://。'));
    $form->addInput($Weixin);   
    
    $Email = new Typecho_Widget_Helper_Form_Element_Text('Email', NULL, NULL, _t('邮箱'), _t('请填写站长邮箱。'));
    $form->addInput($Email);
    
    $Github = new Typecho_Widget_Helper_Form_Element_Text('Github', NULL, NULL, _t('Github'), _t('请填写Github地址。'));
    $form->addInput($Github);
 
}
 
//文章自定义字段
function themeFields($layout) { ?>
    <link rel="stylesheet" href="<?php echo Helper::options()->themeUrl('assets/css/theme.css'); ?>" type="text/css" />
    <?php 
 	$thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('封面图片'), _t('此处填写后会对应显示在文章封面图、书籍封面、相册缩略图、页面背景图等区域，建议根据用途选择合适尺寸的图片。'));
 	$thumb->input->setAttribute('class', 'full-width-input');
    $layout->addItem($thumb);  
 
    $origin = new Typecho_Widget_Helper_Form_Element_Text('origin', NULL, NULL, _t('图片来源'), _t('请输入图片的版权所有人名称或网站名（如：Unsplash）'));
    $origin->input->setAttribute('class', 'full-width-input');
    $layout->addItem($origin);  
    
    $author = new Typecho_Widget_Helper_Form_Element_Text('author', NULL, NULL, _t('作者'), _t('不填则默认为原创文章，作者为账号本人。建议根据内容权属填写著作权人，书单填写书籍作者，如果是Unsplash同步过来的照片，会自动获取照片作者，无需填写。'));
    $author->input->setAttribute('class', 'full-width-input');
    $layout->addItem($author);  
    
    /**文章分类为相册时的专用字段**/
 	$photo = new Typecho_Widget_Helper_Form_Element_Text('photo', NULL, NULL, _t('照片原图'), _t('相册专用字段，相册类文章必填，在这里填入照片的原图地址，未填写则直接调用填写的封面图片。'));
 	$photo->input->setAttribute('class', 'full-width-input');
    $layout->addItem($photo);
    
 	$Unsplash_ID = new Typecho_Widget_Helper_Form_Element_Text('Unsplash_ID', NULL, NULL, _t('Unsplash图片ID'), _t('相册专用字段,不要手动填写，自动识别填写，请勿擅自改动，建议隐藏。用于保证图片同步的一致性。'));
    $layout->addItem($Unsplash_ID);

    /**文章分类为书单时的专用字段**/
    
 	$bookYear = new Typecho_Widget_Helper_Form_Element_Text('bookYear', NULL, NULL, _t('出版日期'), _t('书单专用字段，填你所读版本的出版日期，格式：2000年6月'));
    $layout->addItem($bookYear);   
    
    $bookCat = new Typecho_Widget_Helper_Form_Element_Select('bookCat', array(
        '随笔' => '随笔',
        '散文'=> '散文',
        '记事' =>'记事',
        '诗集' => '诗集',
        '其他' => '其他'
        ),'散文', _t('书籍分类'), _t('书单专用字段，书籍的分类'));
    $layout->addItem($bookCat);  //  可根据自身需要灵活添加更多分类
    
 }

//自定义菜单
function parseCustomMenu() {
    $menuItems = Typecho_Widget::widget('Widget_Options')->MenuSet;
    $hasIcon = '';
    $noIcon = '';
    if (!empty($menuItems)) {
        $lines = explode("\n", $menuItems);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            @list($name, $url, $icon, $target) = array_pad(array_map('trim', explode(',', $line)), 4, '');
            if (empty($name) || empty($url)) continue;
            $targetAttr = ($target === '_blank') ? ' target="_blank" rel="noopener"' : '';
            $hasIcon .= sprintf(
                '<li><a href="%s"%s><i class="%s"></i>%s</a></li>',//移动端菜单格式
                htmlspecialchars($url),
                $targetAttr,
                htmlspecialchars($icon ?? ''),
                htmlspecialchars($name)
            );
            $noIcon .= sprintf(
                '<a href="%s"%s>%s</a>',//PC端底部菜单格式
                htmlspecialchars($url),
                $targetAttr,
                htmlspecialchars($name)
            );
        }
    }
    return [
        'hasIcon' => $hasIcon ? $hasIcon : '',
        'noIcon'  => $noIcon ? $noIcon : ''
    ];
}

//PC端右键菜单数据格式化
function getNZMenuData() {
    static $cachedData = null; // 添加静态缓存
    if ($cachedData !== null) return $cachedData;
    $menuItems = Typecho_Widget::widget('Widget_Options')->MenuSet;
    $data = [];
    if (!empty($menuItems)) {
        foreach (explode("\n", $menuItems) as $line) {
            $line = trim($line);
            if ($line === '') continue;
            $parts = array_map('trim', explode(',', $line, 4)); 
            if (count($parts) < 3) continue;
            $name = $parts[0] ?? '';
            $url = $parts[1] ?? '';
            $icon = $parts[2] ?? '';
            $target = ($parts[3] ?? '') === '_blank' ? '_blank' : '';
            if ($name === '' || $url === '') continue;
            $data[] = [
                'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'), 
                'url'  => htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
                'icon' => htmlspecialchars($icon, ENT_QUOTES, 'UTF-8'),
                'target' => $target
            ];
        }
    }
    return $cachedData = $data; 
}


//首页置顶banner文章 极致优化 只查询1次
function get_banner_data($options) {
    if ($options->switch != 'on') return [];
    // 高效处理CID：过滤非数字、取前3个、防注入
    $cids = array_filter(
        array_slice(explode(',', $options->Banner ?? ''), 0, 3),
        function($v) { return ctype_digit((string)$v) && $v > 0; }
    );
    if (empty($cids)) return [];
    $db = Typecho_Db::get();
    return $db->fetchAll($db->select()
        ->from('table.contents')
        ->where('cid IN ?', $cids)
        ->where('type = ?', 'post')
        ->order('FIELD(cid, '.implode(',', $cids).')'));
}

//无插件阅读数，cookie保证阅读量真实性
function get_post_view($archive){
    $cid = $archive->cid;
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if(empty($views)){
            $views = array();
        }else{
            $views = explode(',', $views);
        }
        if(!in_array($cid,$views)){
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
        array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    $newViews = $row['views'];
    $newViews = formatNum($newViews);
    echo $newViews;
}

//格式化阅读数：≥1000 单位转化为k；≥10000 单位转化为W；最多显示10W+
function formatNum($num) {
	if ($num >= 100000) {
		$num = '10w+';
	} elseif ($num >= 10000) {
        $num = round($num / 10000 * 100) / 100 ;
        $num = round($num,1).' w';//四舍五入保留一位小数
    } elseif($num >= 1000) {
        $num = round($num / 1000 * 100) / 100 ;
        $num = round($num,1). ' k';//四舍五入保留一位小数
    } else {
        $num = $num;
    }
    return $num;
}

//文章发表时间格式化
function time_ago($date) {
    $timestamp = strtotime($date->format('Y-m-d H:i:s'));
    $current_time = time();
    $time_diff = $current_time - $timestamp;
    if ($time_diff < 60) {
        return $time_diff . "秒前";
    } elseif ($time_diff < 3600) {
        return floor($time_diff / 60) . "分钟前";
    } elseif ($time_diff < 86400) {
        return floor($time_diff / 3600) . "小时前";
    } elseif ($time_diff < 2592000) { // 30天以内
        return floor($time_diff / 86400) . "天前";
    } elseif ($time_diff < 31536000) { // 1年内
        return floor($time_diff / 2592000) . "个月前";
    } elseif ($time_diff < 94608000) { // 3年内
        return floor($time_diff / 31536000) . "年前";
    } else {
        return $date->format('Y/m/d'); // 超过3年显示具体日期
    }
}

//页面加载时间统计
function timer_start(){
    global $timestart;
    $mtime = explode( ' ', microtime() );
    $timestart = $mtime[1] + $mtime[0];
    return true;
}
timer_start();

//页面加载时间格式化为秒
function timer_stop($display = 0, $precision = 3){
    global $timestart, $timeend;
    $mtime = explode( ' ', microtime() );
    $timeend = $mtime[1] + $mtime[0];
    $timetotal = number_format( $timeend - $timestart, $precision );
    $r = $timetotal < 1 ? $timetotal  . " s" : $timetotal . " s";
    if($display){echo $r;}
    return $r;
}

//相册\书单页面展示更多图片以及评论点赞
function themeInit($archive) {
    if ($archive->is('category', 'photos') || $archive->is('category', 'books')) {
        $archive->parameter->pageSize = 24; // 初始显示书籍/照片数量
    }
    //评论点赞
    if ($archive->request->is("commentLike=dz")) {
        commentLikes($archive);
    }
    
}


//微语数据加载
function MemosList($comments, $user) { ?>
    <li class="animated fadeIn">
        <div id="<?php echo $comments->theId(); ?>">
            <div class="user">
                <?php $email = $comments->mail; $imgUrl = getGravatar($email); echo '<img class="avatar" src="' . $imgUrl . '">'; ?>
                <div class="user-info">
                    <span class="name"><?php echo $comments->author(); ?></span>
                    <span class="date lite-black"><?php echo $comments->date('Y-m-d H:i'); ?></span>
                </div>
            </div>
            <?php echo $comments->content(); ?>
            <!-- 评论点赞次数 -->
            <?php $commentLikes = commentLikesNum($comments->coid); 
                $commentLikesNum = $commentLikes['likes'];
                $commentLikesRecording = $commentLikes['recording'];?>
            <div class="commentLike">
                <a class="commentLikeOpt" id="commentLikeOpt-<?php echo $comments->coid; ?>" href="javascript:;" data-coid="<?php echo $comments->coid; ?>" data-recording="<?php echo $commentLikesRecording; ?>">
                        <i id="commentLikeI-<?php echo $comments->coid; ?>" class="<?php echo $commentLikesRecording ? 'iconfont icon-liked red' : 'iconfont icon-like red'; ?>"></i>
                        <span class="lite-black" id="commentLikeSpan-<?php echo $comments->coid; ?>"><?php echo $commentLikesNum; ?></span>
                    </a>
                </div>
        </div>
    </li>
<?php } 

//判断是否为手机端
function isMobile() {
    // 检查常见的移动设备HTTP头
    $mobileHeaders = [
        'HTTP_X_WAP_PROFILE',
        'HTTP_PROFILE'
    ];
    foreach ($mobileHeaders as $header) {
        if (isset($_SERVER[$header])) {
            return true;
        }
    }

    // 检查HTTP_VIA头中是否包含 "wap"
    if (isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
        return true;
    }

    // 检查User-Agent中是否包含常见的移动设备关键字
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $mobileUserAgents = [
            'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh',
            'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
            'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android',
            'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini',
            'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        ];
        if (preg_match("/(" . implode('|', $mobileUserAgents) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }

    // 检查HTTP_ACCEPT头中是否包含支持WAP的MIME类型
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||
                (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }

    return false;
}

//文章字数统计
function art_count ($cid){
    $db=Typecho_Db::get ();
    $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
    echo mb_strlen($rs['text'], 'UTF-8');
}

//评论者等级
function dengji($i){
    $db = Typecho_Db::get();
    $adminAuthorId = 1;
    $author = $db->fetchRow($db->select('authorId')->from('table.comments')->where('mail = ?', $i)->limit(1));
    $authorId = $author['authorId'];
    if ($authorId == $adminAuthorId) {
        echo '<span class="level owner">博主</span>';
        return;
    }
    $mail = $db->fetchRow($db->select(array('COUNT(cid)' => 'rbq'))->from('table.comments')->where('mail = ?', $i)->where('authorId = ?', '0'));
    $rbq = $mail['rbq'];
    if ($rbq < 3) {
        echo '<span class="level">Lv.1</span>';
    } elseif ($rbq < 10) {
        echo '<span class="level">Lv.2</span>';
    } elseif ($rbq < 20) {
        echo '<span class="level">Lv.3</span>';
    } elseif ($rbq < 30) {
        echo '<span class="level">Lv.4</span>';
    } elseif ($rbq < 40) {
        echo '<span class="level">Lv.5</span>';
    } else {
        echo '<span class="level owner">知己</span>';
    }
}

//替换默认的Gravatar头像地址为国内镜像源 QQ邮箱取用qq头像
function getGravatar($email, $s = 96, $d = 'mp', $r = 'g', $img = false, $atts = array()){
    preg_match_all('/((\d)*)@qq.com/', $email, $vai);
    if (empty($vai['1']['0'])) {
        $url = 'https://weavatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
    }else{
        $url = 'https://q2.qlogo.cn/headimg_dl?dst_uin='.$vai['1']['0'].'&spec=100';
    }
    return  $url;
}

//获取文章缩略图
function showThumbnail($widget){
    // 如果文章设置了缩略图，优先返回缩略图
    if ($widget->fields->thumb) {
        return $widget->fields->thumb;
    }
    // 如果文章内容有图片，返回第一张图片作为缩略图
    $content = $widget->content;
    preg_match_all('/<img.*?src=["\'](.*?)["\']/', $content, $matches);
    if (isset($matches[1][0])) {
        return $matches[1][0];
    }
    // 如果设置了随机缩略图
    if (Helper::options()->RandomIMG == 'oneblog'){
        $randomParam = '?t=' . time() . rand(1, 1000);
        return Helper::options()->themeUrl . '/api/RandomPic.php' . $randomParam;
    }
    // 如果设置了默认缩略图
    $defaultthumb = Helper::options()->NoPostIMG;
    if ($defaultthumb){
        return $defaultthumb;
    }
    // 如果没有任何图片，则返回NULL。
    return;
}

//评论点赞 cookie保证点赞数量准确
function commentLikesNum($coid, &$record = NULL){
    $db = Typecho_Db::get();
    $callback = array(
        'likes' => 0,
        'recording' => false
    );
    if (array_key_exists('likes', $data = $db->fetchRow($db->select()->from('table.comments')->where('coid = ?', $coid)))) {
        $callback['likes'] = $data['likes'];
    } else {
        $db->query('ALTER TABLE `' . $db->getPrefix() . 'comments` ADD `likes` INT(10) NOT NULL DEFAULT 0;');
    }
    if (empty($recording = Typecho_Cookie::get('__typecho_comment_likes_record'))) {
        Typecho_Cookie::set('__typecho_comment_likes_record', '[]');
    } else {
        $callback['recording'] = is_array($record = json_decode($recording)) && in_array($coid, $record);
    }
    return $callback;
}

//评论点赞处理
function commentLikes($archive){
    $archive->response->setStatus(200); 
    $_POST['coid'];
    $_POST['behavior'];
    $loginState = Typecho_Widget::widget('Widget_User')->hasLogin();
    $res1 = commentLikesNum($_POST['coid'], $record);
    $num = 0;
    if(!empty($_POST['coid']) && !empty($_POST['behavior'])){
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        $coid = (int)$_POST['coid'];
        if (!array_key_exists('likes', $db->fetchRow($db->select()->from('table.comments')))) {
        $db->query('ALTER TABLE `' . $prefix . 'comments` ADD `likes` INT(30) DEFAULT 0;');
        }
        $row = $db->fetchRow($db->select('likes')->from('table.comments')->where('coid = ?', $coid));
        $updateRows = $db->query($db->update('table.comments')->rows(array('likes' => (int) $row['likes'] + 1))->where('coid = ?', $coid));
        if($updateRows){
            $num = $row['likes'] + 1;
            $state =  "success";
            array_push($record, $coid);
            Typecho_Cookie::set('__typecho_comment_likes_record', json_encode($record));
        }else{
            $num = $row['likes'];
            $state =  "error";
        }
    }else{
        $state = 'Illegal request';
    }  
    $archive->response->throwJson(array(
       "state" => $state,
       "num" => $num
    ));    
}

//表情短代码解析
function parseEmojis($content) {
    //使用绝对地址保证邮件通知中也能解析
    $emojiPath = Helper::options()->siteUrl.'usr/themes/OneBlog/assets/img/emoji/';
    return preg_replace_callback('/\[emoji:([a-zA-Z0-9_]+)\]/', function($matches) use ($emojiPath) {
        $emojiName = $matches[1];
        return '<img class="biaoqing" src="' . $emojiPath . $emojiName . '.svg" alt="' . $emojiName . '">';
    }, $content);
}

//文章内图片标签自动解析为灯箱效果
function AutoLightbox($content) {
    if (empty($content)) {return $content;}
    $pattern = '/<img.*?src=["\'](.*?)["\'].*?>/i';
    if (!preg_match($pattern, $content)) {return $content;}
    $replacement = '<a data-fancybox="gallery" href="$1"><img class="lazy-load" data-src="$1" src="$1" /></a>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}


//附件页面和作者页面重定向到404页面
function redirect_404(){
    $request = Typecho_Request::getInstance();
    $pathInfo = $request->getPathInfo();
    // 使用正则表达式匹配路径
    if (preg_match('/^\/(attachment\/\d+|author\/\w+)/i', $pathInfo)) {
        // 调用 404 页面
        $options = Typecho_Widget::widget('Widget_Options');
        $url = $options->siteUrl . '404';
        header("Location: $url");
        exit;
    }
}
// 在页面加载之前调用
Typecho_Plugin::factory('Widget_Archive')->beforeRender = 'redirect_404';
