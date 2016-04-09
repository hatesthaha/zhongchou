<?php
/**
 * @author: wuwenhan <329576084@qq.com>
 * @copyright 万虎网络
 * @link http://www.wanhunet.com
 */

namespace wanhunet\helpers;

use wanhunet\wanhunet;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Util
 * @package wanhunet\helpers
 * @author: wuwenhan <329576084@qq.com>
 * @copyright wanhunet
 * @link http://www.wanhunet.com
 */
class Utils
{
    //对新审核的产品进行排序，$zhouqi排序周期
    public static function sortZhongchou($zhouqi){
        $Q = ceil($zhouqi/3);
        return $Q;
    }
    //传入月份，获取当前季度01~12
    public static function getQuarterByMonth($date){
        $Q = ceil($date/3);
        return $Q;
    }

    /**
     * 导出数据为excel表格
     * @param array $data 一个二维数组,结构如同从数据库查出来的数组
     * @param array $title excel的第一行标题,一个数组,如果为空则没有标题
     * @param string $filename 下载的文件名
     * @examlpe
     * $stu = M ('User');
     * $arr = $stu -> select();
     * exportexcel($arr,array('id','账户','密码','昵称'),'文件名!');
     */
    public static function exportExcel($data = array(), $title = array(), $filename = 'report')
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

    public static function createcode($length = 8)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        // 在 $chars 中随机取 $length 个数组元素键名
        $keys = array_rand($chars, $length);

        $password = '';
        for($i = 0; $i < $length; $i++)
        {
            // 将 $length 个数组元素连接成字符串
            $password .= $chars[$keys[$i]];
        }

        return $password;
    }

    public static function munw($b,$e,$c=1,$da=16){
        $n=0;
        $t=array();
        $btime=strtotime($b[2]." ".Utils::getM($b[1])." ".$b[0]);
        $etime=strtotime($e[2]." ".Utils::getM($e[1])." ".$e[0]);
        for($i=$btime;$i<$etime;$i=$i+86400){
            if($n>=$da) {
                break;
            }
                if(date("N",$i)==$c){
                    $n++;
                    $t[]=date("Y-m-d",$i);
                }


        }

        return $t;
    }
    public static function munnum($b,$e,$c=1){
        $n=0;
        $t=array();
        $btime=strtotime($b[2]." ".Utils::getM($b[1])." ".$b[0]);
        $etime=strtotime($e[2]." ".Utils::getM($e[1])." ".$e[0]);
        for($i=$btime;$i<$etime;$i=$i+86400){
            if(date("N",$i)==$c){
                $n++;
                $t[]=date("Y-m-d",$i);
            }
        }

        return $n;
    }
    public static function getM($m)
    {
        switch ($m) {
            case 1:
                return "January";
                break;
            case 2:
                return "February";
                break;
            case 3:
                return "March";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "May";
                break;
            case 6:
                return "June";
                break;
            case 7:
                return "July";
                break;
            case 8:
                return "August";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "October";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "December";
                break;
        }
    }

}