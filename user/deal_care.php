<?php
if (isset($_POST['from']) && isset($_POST['to'])) {
    if (preg_match('/^[0-9]+$/', $_POST['from']) && preg_match('/^[0-9]+$/', $_POST['to'])) {
        include '../admin/ch.class.php';
        $db = new DB();
        // 获取值 判断是否有关注数据
        $status = $db->getRowByTwo('ch_fans', 'from_care', $_POST['from'], 'to_care', $_POST['to']);
        // 更新值
        if ($status) {
            // 删除关注数据
            $status = $db->delete('ch_fans', 'id', $status);
        } else {
            // 插入关注数据
            $columns = array('from_care', 'to_care');
            $values = array($_POST['from'], $_POST['to']);
            $status = $db->insertData('ch_fans', $columns, $values);
        }
        // 返回值
        echo $status;
    } else {
        echo '0';
    }
} else {
    header('location:../index/');
}