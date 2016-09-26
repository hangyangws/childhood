<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8" />
    <title>搜索童友-童年</title>
    <?php
        require_once "../public/meta.html";
    ?>
    <!-- this -->
    <link rel="stylesheet" href="../view/css/search.css" />
</head>

<body id="body">
    <?php
        include("../public/header.php");
        include("../admin/ch.class.php");
        $db = new DB();
        $title = '搜索结果';
        $sql = 'SELECT id, name, gender, motto, loving, progress, head FROM ch_user WHERE ';
        // $_POST['c'] 用来搜索用户字符串；$_GET['type'] 匹配用户种类字段
        if (isset($_POST['c']) && preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9 ]+$/u', $_POST['c'])) {
            $arr = preg_split('/[\s]+/', trim($_POST['c']));
            $l = count($arr);
            $sql .= 'name LIKE ';
            while (--$l >= 0) {
                if ($l !== 0) {
                    $sql .= "'%$arr[$l]%' OR name LIKE ";
                } else {
                    $sql .= "'%$arr[$l]%' ORDER BY progress+0 DESC";
                }
            }
        } else if (isset($_GET['type'])) {
            // 获取当前用户的基本信息
            $data = $db->getObjListBySql('SELECT gender, motto, loving, birthday, primary_school, middle_school, high_school, university, hometown, profession FROM ch_user WHERE id = ' . $_COOKIE['ch_user_id'])[0];
            switch($_GET['type']) {
                case 'loving':
                    $sql .= 'gender = ';
                    if ($data->gender === '1') {
                        $sql .= '0';
                    } else if ($data->gender === '0') {
                        $sql .= '1';
                    } else {
                        $sql .= 'null';
                    }
                    $title = '下面的伙伴你可以去认识一下哦';
                    break;
                case 'birthday':
                    if (!$data->birthday) {
                        $data->birthday = 'null';
                    }
                    $sql .= "birthday = $data->birthday";
                    $title = '你们的生日相同哦';
                    break;
                case 'primary_school':
                    $sql .= "primary_school LIKE '%$data->primary_school%'";
                    $title = '你们可能在同一所小学读书';
                    break;
                case 'middle_school':
                    $sql .= "middle_school LIKE '%$data->middle_school%'";
                    $title = '你们可能在同一所中学读书';
                    break;
                case 'high_school':
                    $sql .= "high_school LIKE '%$data->high_school%'";
                    $title = '你们可能在同一所高学读书';
                    break;
                case 'university':
                    $sql .= "university LIKE '%$data->university%'";
                    $title = '你们可能在同一所大学读书';
                    break;
                case 'hometown':
                    $sql .= "hometown LIKE '%$data->hometown%'";
                    $title = '你们可能是老乡哦';
                    break;
                case 'motto':
                    $sql .= "motto LIKE '%$data->motto%'";
                    $title = '你们有相同的座右铭';
                    break;
                case 'profession':
                    $sql .= "profession LIKE '%$data->profession%'";
                    $title = '你们的职业差不多';
                    break;
                default:
                    header('location:../square/square.php');
                    exit;
            }
            $sql .= ' AND id <> ' . $_COOKIE['ch_user_id'] . ' ORDER BY progress+0 DESC';
        } else {
            header('location:../square/square.php');
            exit;
        }
        $user = $db->getObjListBySql($sql);
    ?>
    <div id="main">
        <div class="s-wrap w1100 bc c">
            <?php
                if (count($user)) {
                    echo "<h3 class='lh400 f20 tc fcf'>$title</h3>";
                    // 遍历数组
                    foreach ($user as $u) {
                        echo '<div class="s-each bcf w700 bc c p10 radius4 mb20">'.
                                '<a href="../user/visit.php?u='. $u->id .'" class="s-head fl db radius50 ofh mr20 ts4">';
                                if($u->head == 1) {
                                    echo '<img class="fl" src="../user/user_img/' .
                                        $u->id .
                                        '/head_img/head.jpeg?t=' .
                                        time() .
                                        '" alt="头像" class="fl" />';
                                } else {
                                    echo '<img class="fl" src="../view/img/user.png" alt="头像" class="fl" />';
                                };
                                echo '</a>'.
                                '<ul class="fl lh200">'.
                                    '<li>' .
                                        '<a href="../user/visit.php?u='. $u->id .'" class="fcm f20 mr10" >'.
                                            $u->name .
                                        '</a>' .
                                    '</li>';
                        switch ($u->gender) {
                            case '1':
                                echo '<li>性别: <i class="s-gender dlb mr10 pr boy" title="男"></i>';
                                break;
                            case '0':
                                echo '<li>性别: <i class="s-gender dlb mr10 pr girl" title="女"></i>';
                                break;
                            default :
                                echo '<li>性别: 未设置&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                        switch ($u->loving) {
                            case '1':
                                echo '恋爱状况: 单身狗</li>';
                                break;
                            case '0':
                                echo '恋爱状况: 热恋中</li>';
                                break;
                            default :
                                echo '恋爱状况: 未设置</li>';
                        }
                        if ($u->motto) {
                            echo '<li>个性签名: '. $u->motto .'</li>';
                        } else {
                            echo '<li>个性签名: 未设置</li>';
                        }
                        echo '<li>资料完善度: '. (round(($u->progress)/13, 3))*100 . "%" .'</li>' .
                            '</ul>' .
                        '</div>';
                    }
                } else {
                    echo '<h3 class="lh400 f20 tc fcf">没有搜索到任何用户</h3>';
                }
            ?>
        </div>
    </div>
    <?php
        include("../public/footer.html");
        require_once "../public/footer-js.html";
    ?>
</body>

</html>
