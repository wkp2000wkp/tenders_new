<?php
class ShowLang
{

    private static $language = array(
        'no_data_submit' => '无数据提交',
        'no_permissions' => '无操作权限',
    
        'login_success' => '登录成功', 
        'login_time_out' => '登录超时', 
        'login_password_error' => '用户名密码错误！',
    
    
        'zhaobiao_insert_success' => ' 招标项目信息添加成功！',
        'zhaobiao_insert_faile' => '招标项目信息添加失败，请重试！',
        'zhaobiao_update_success' => '招标项目信息更新成功！',
        'zhaobiao_update_faile' => '招标项目信息更新失败，请重试！',
        'zhaobiao_delete_success' => '招标项目信息删除成功！',
        'zhaobiao_delete_faile' => '招标项目信息删除失败，请重试！',
        'zhaobiao_copy_success' => '招标项目信息复制成功！',
        'zhaobiao_copy_faile' => '招标项目信息复制失败，请重试！',
        'zhaobiao_import_success' => '招标项目信息转换成功！',
        'zhaobiao_import_faile' => '招标项目信息转换失败，请重试！',
    
        'toubiao_no_exist' => '投标项目不存在！',
        'toubiao_update_success' => '投标项目信息更新成功！',
        'toubiao_update_faile' => '投标项目信息更新失败，请重试！',
        'toubiao_delete_success' => '投标项目信息删除成功！',
        'toubiao_delete_faile' => '投标项目信息删除失败，请重试！',
    
        'kaibiao_insert_success' => '开标记录导入完成！',
    
        'delete_option_success' => '删除成功！',
        'delete_option_faile' => '删除失败，请重试！',
        'update_option_success' => '更新成功！',
        'update_option_faile' => '更新失败，请重试！',
        'insert_option_success' => '添加成功！',
        'insert_option_faile' => '添加失败，请重试！',
        'delete_result_option_success' => '删除成功！',
        'delete_result_option_faile' => '删除失败，请重试！',
        'delete_record_option_success' => '删除成功！',
        'delete_record_option_faile' => '删除失败，请重试！',
        'copy_result_option_success' => '复制成功！',
        'copy_result_option_faile' => '复制失败，请重试！',
    );

    public static function getLanguage ($word) {
        return isset( self::$language[$word] ) ? self::$language[$word] : $word;
    }
}
