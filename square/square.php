<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <title>广场-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/square.css" />
    <link rel="stylesheet" href="../view/css/user.css" />
</head>

<body id="body">
    <?php
        include '../public/header.php';
        // 获取热么用户信息
        include("../admin/ch.class.php");
        $db = new DB();
        $users = $db->getObjListBySql("SELECT `id`, `name`, `progress`, `gender`, `loving`, `motto`, `head` FROM `ch_user` ORDER BY progress+0 ASC LIMIT 10");
        // 获取热门说说信息
        $says = $db->getObjListBySql("SELECT S.id, S.to_who, S.create_date, S.aggre_num, S.com_num, S.content, S.img, U.name FROM  ch_says S, ch_user U WHERE S.to_who = U.id ORDER BY S.aggre_num ASC, S.com_num ASC, S.create_date ASC ");
    ?>
    <main id="main">
        <!-- 奔跑吧小伙伴 -->
        <div class="find-wrap h400 pt20 ofh">
            <div class="find w1100 bc c">
                <div id="fStart" class="f-start f-animate w100 h100 tc radius50 cp fcf ml100 mr100 fl ts10 ofh animated">
                    <ul>
                        <li>奔跑吧</li>
                        <li>小伙伴</li>
                    </ul>
                </div>
                <div class="f-con w400 h400 ml100 fl ts4">
                    <div class="f-c-i h90 w30"></div>
                </div>
                <ul id="fMain" class="none w200 f-main fl ml100 tc fcf animated">
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=loving">你想找个女朋友</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=birthday">生日一样的你们</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=primary_school">你们是小学玩伴</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=middle_school">你们是初中同窗</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=high_school">你们是高中旧识</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=university">你们是大学校友</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=hometown">来自同一个故乡</a></li>
                    <li class="blur1 cp mb10 ts4"><a target="_blank" href="../search/search.php?type=motto">有一样的座右铭</a></li>
                    <li class="blur1 cp ts4"><a target="_blank" href="../search/search.php?type=profession">你们的职位相同</a></li>
                </ul>
            </div>
        </div>
        <div class="c w1100 bc">
            <!-- 热门说说 -->
            <div id="says" class="main-wrap fl w800">
                <span class="db fcf tc mt20 mb20">加载中…</span>
            </div>
            <!-- 热点用户 -->
            <div class="u-wrap fr mt10 w300">
                <h3 class="tc fcf f16 lh300">热门用户</h3>
                <div id="hotuserWrap">
                    <span class="db fcf tc mb20">加载中…</span>
                </div>
            </div>
        </div>
    </main>
    <!-- 热门用户模板 -->
    <template id="tpUser" class="none">
        <div class="u-each pt10 pb10 mb20 c">
            <ul class="fl w200 f0">
                <li class="">
                    <span class="dlb f14 w70 tr mr5 ml5">用户名</span>
                    <a class="u-value f14 fcm" href="../user/visit.php?u={{id}}">{{name}}</a>
                </li>
                <li class="">
                    <span class="dlb f14 w70 tr mr5 ml5">资料完善度</span>
                    <span class="fcm f14">{{progress}}</span>
                </li>
                <li class="">
                    <span class="dlb vm f14 w70 tr mr5 ml5">性别</span>
                    {{gender}}
                </li>
                <li>
                    <span class="dlb f14 w70 tr mr5 ml5">恋爱状况</span>
                    <span class="f14">{{loving}}</span>
                </li>
                <li class="">
                    <span class="dlb f14 w70 tr mr5 ml5">个性签名</span>
                    <span class="u-value f14">{{motto}}</span>
                </li>
            </ul>
            <a class="u-head fl w80 h80 radius50 ofh ml10 ts4" href="../user/visit.php?u=2">
                <img class="fl w1 h1" data-head="head" src="{{head}}" alt="用户头像" />
            </a>
        </div>
    </template>
    <!-- 热门说说模板 -->
    <template id="tpSay" class="none">
        <div class="say-item m10 ofh">
            <div class="p10">
                <a class="fcm" href="../user/visit.php?u={{to_who}}">{{name}}</a><span class=" dlb pl5 pr5 f12">发表于</span><time class="say-time pr">{{create_date}}</time>
            </div>
            <p class="say-con t2 f16 fc3 p10 lh150">{{content}}</p>
            <img class="say-img db ml40 zout ts4" src="../user/user_img/{{img}}" />
            <ul class="say-join h30 mt20 p10 c">
                <li class="comment cp fl mr20" data-id="{{id}}" title="查看评论/回复">
                    <span class="com-icon w30 h30 fl mr5"></span>
                    <span class="com-num fl lh250">{{com_num}}</span>
                </li>
                <li class="like cp fl" data-ing="true" data-id="{{id}}" title="点赞">
                    <span class="like-icon w30 h30 fl mr5"></span>
                    <span class="like-num fl lh250">{{aggre_num}}</span>
                </li>
            </ul>
            <div class="comment-con none">
                <div class="p10">
                    <input class="db bc w700 p10 mb10 radius4 animated" type="text" maxlength="200" placeholder="元芳 你怎么看？" />
                    <div class="com-conf bc">
                        <button class="com-sub mr10 p5 radius4 fcm bcf" data-in="true" data-id="{{id}}">确定</button>
                        <button class="com-close p5 radius4 fcm bcf">取消</button>
                    </div>
                </div>
                <ul class="com-show p10 fcf">
                    <li class="tc">加载中…</li>
                </ul>
            </div>
        </div>
    </template>
    <?php
        include '../public/footer.html';
    ?>
    <!-- mask -->
    <div id="loadMask"></div>
    <?php
        require_once "../public/footer-js.html";
    ?>
    <!-- this -->
    <script>
        var isHome = true,
            G = {
                hotUser: <?php echo json_encode($users); ?>,
                hotSays: <?php echo json_encode($says); ?>
            };
    </script>
    <script src="../view/js/square.js"></script>
    <script src="../view/js/user.js"></script>
</body>

</html>
