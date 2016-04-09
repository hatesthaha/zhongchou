<?php
namespace yii\web;

use Yii;
use yii\base\InlineAction;
use yii\helpers\Url;
use yii\web\Controller;
use frontend\models\Sort;


/**
 * Site controller
 */
class SortController extends Controller
{
    public function init(){
        parent::init();
        $this->Index();
    }
    public function Index()
    {
        //天数为进一取整，当前周期为向下取整

        //栏目对应的周期天数
        $terms = [
            ['term_id'=>2,'zhouqi'=>1],
            ['term_id'=>3,'zhouqi'=>3],
            ['term_id'=>4,'zhouqi'=>5],
            ['term_id'=>5,'zhouqi'=>7],
            ['term_id'=>6,'zhouqi'=>9],
        ];
        $connection = \Yii::$app->db;
        foreach ($terms as $key => $term) {
                //当前周期数
             $now_zhouqi = floor(ceil(time()/86400)/$term['zhouqi']);

            $terms[$key]['now_zhouqi'] = $now_zhouqi;//此类产品当前周期
            $command = $connection->createCommand(sprintf('SELECT `pid`,`updated_at` FROM `sort` WHERE `status`=%u AND `term_id`=%u ',1,$term['term_id']));
            $res1 = $command->queryOne();
            if($res1){
                $terms[$key]['has_pro'] = 1;//该栏目有产品，继续下一步
                //排序的周期数
                $last_update = $res1['updated_at'];
                $terms[$key]['pid'] = $res1['pid'];//当前在线产品id
                if(($last_update && $last_update<$now_zhouqi) ||$last_update==0){
                    $terms[$key]['issort'] = 0;//未排序
                }else{
                     $terms[$key]['issort'] = 1;//已排序
                }
            }else{
                $terms[$key]['has_pro'] = 0;//该栏目无产品
            }

        }

        //下线当前产品，上线下一产品
        foreach ($terms as $key => $term) {
            if($term['has_pro']==1 && $term['issort']==0){
                //当前产品暂停
                $command = $connection->createCommand(sprintf('UPDATE `sort` SET `status`=2,`sorted_at`=0,`updated_at`=%u WHERE `pid`=%u',$term['now_zhouqi'],$term['pid']));
                $command->execute();
                //下一产品上线,
                //首先上线已排序的产品
                $command = $connection->createCommand(sprintf('UPDATE `sort` SET `status`=%u,`sorted_at`=%u ,`updated_at`=%u  WHERE `term_id`=%u AND `sorted_at`>0 ORDER BY `sorted_at` ASC,`sorted_at` ASC LIMIT 1',1,0,$term['now_zhouqi'],$term['term_id']));
                //判断是否上线成功
                $terms[$key]['isshangxian'] = $command->execute();
                //如果没有上线成功
                if($terms[$key]['isshangxian']==0){
                    //检查此栏目下是否有未排序产品
                    $command = $connection->createCommand(sprintf('SELECT `sort`.`pid` FROM `sort` LEFT JOIN `member` ON `sort`.`uid`=`member`.`id`  WHERE `sort`.`term_id`=%u AND `sort`.`sorted_at`=0 ORDER BY `member`.`prestige` DESC LIMIT 0,1',$term['term_id']));
                    $res1 = $command->queryOne();
                    if($res1){
                        $command = $connection->createCommand(sprintf('UPDATE `sort` SET `status`=1,`sorted_at`=0,`updated_at`=%u WHERE `pid`=%u',$term['now_zhouqi'],$res1['pid']));
                        $command->execute();
                    }
                    //上线完成后。对所有产品进行排序，sorted_at=updated_at+1；
                    $command = $connection->createCommand(sprintf('SELECT `sort`.* FROM `sort` LEFT JOIN `member` ON `sort`.`uid`=`member`.`id`  WHERE `sort`.`term_id`=%u AND `sort`.`sorted_at`=0 AND `sort`.`status`<>1 ORDER BY `updated_at` ASC,`member`.`prestige` DESC',$term['term_id']));
                    $res2 = $command->queryAll();
                    if($res2){
                        foreach ($res2 as $key => $pro) {
                            $command = $connection->createCommand(sprintf('UPDATE `sort` SET `sorted_at`=`updated_at`+1,`updated_at`=%u,`sort`=%u WHERE `pid`=%u',$term['now_zhouqi'],$key+1,$pro['pid']));
                            $command->execute();
                        }
                    }

                }
            }elseif($term['has_pro']==0){
                $command = $connection->createCommand(sprintf('SELECT `sort`.`pid` FROM `sort` LEFT JOIN `member` ON `sort`.`uid`=`member`.`id`  WHERE `sort`.`term_id`=%u AND `sort`.`sorted_at`=0 ORDER BY `member`.`prestige` DESC LIMIT 0,1',$term['term_id']));
                $res1 = $command->queryOne();
                if($res1){
                    $command = $connection->createCommand(sprintf('UPDATE `sort` SET `status`=1,`sorted_at`=0,`updated_at`=%u WHERE `pid`=%u',$term['now_zhouqi'],$res1['pid']));
                    $command->execute();
                }
            }

        }
        
        
    }
}
