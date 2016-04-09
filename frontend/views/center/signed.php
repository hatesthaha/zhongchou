<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta name="data-spm" content="a215s">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta content="fullscreen=yes,preventMove=no" name="ML-Config">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta content="转让变现快,提现实时到,多重保障,本息保护,账户托管至新浪支付" name="Keywords">
    <meta name="description" content="仌仌众梦" />  
    <title>每日签到</title>
    <?= Html::cssFile('@web/style/css/font-awesome.min.css') ?>
    <?= Html::cssFile('@web/style/css/reset.css') ?>
    <?= Html::cssFile('@web/style/css/style.css') ?>
</head>
<body>
    <section class="bodyA"><img src="<?= Yii::getAlias('@web') . '/' ?>style/images/u0.gif" alt=""></section>
    <div id="body_h">
        <section class="pagetop">
            <a class="pagetopleft" href="/center/personalcenter"><i class='icon-angle-left'></i></a>
            <h2>每日签到</h2>
            <a class="pagetopright" href="/"></a>
        </section>
        <section class="headerh"></section>
        <section>
            <img width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/signed.jpg" alt="每日签到">
            <div class="modular18">
                <p class="signbtn"><span id="signedbtn">签到</span></p>
                <div>
                    <p><img class="block" width="100%" src="<?= Yii::getAlias('@web') . '/' ?>style/images/signed2.png" alt="每日签到"></p>
                    <div class="signdatabox">
                        <?php 
                        class Calendar{
                            var $YEAR,$MONTH,$DAY;
                            var $COLOR_TODAY = "lightgray";
                            var $COLOR_THIS_MONTH = "lightgray";
                            var $COLOR_THIS_YEAR = "lightgray";
                            var $NUMS_YEAR = 1;
                            var $WEEK=array("日","一","二","三","四","五","六"); 
                            var $_MONTH=array( 
                                "01"=>"一月", 
                                "02"=>"二月", 
                                "03"=>"三月", 
                                "04"=>"四月", 
                                "05"=>"五月", 
                                "06"=>"六月", 
                                "07"=>"七月", 
                                "08"=>"八月", 
                                "09"=>"九月", 
                                "10"=>"十月", 
                                "11"=>"十一月",
                                "12"=>"十二月"
                            );
                            function setYear($year){ 
                                $this->YEAR=$year; 
                            } 
                            function getYear(){ 
                                return $this->YEAR; 
                            } 
                            function setMonth($month){ 
                                $this->MONTH=$month; 
                            } 
                            function getMonth(){ 
                                return $this->MONTH; 
                            } 
                            function setDay($day){ 
                                $this->DAY=$day; 
                            } 
                            function getDay(){ 
                                return $this->DAY; 
                            } 
                            function getWeek($year,$month,$day){
                                $week=date("w",mktime(0,0,0,$month,$day,$year));
                                return $week;
                            } 
                            function _env(){ 
                                if(isset($_POST['month'])){
                                    $month=$_POST['month']; 
                                }else{ 
                                    $month=date("m");
                                } 
                                if(isset($_POST['year'])){
                                    $year=$_POST['year']; 
                                }else{ 
                                    $year=date("Y");
                                } 
                                $this->setYear($year); 
                                $this->setMonth($month); 
                                $this->setDay(date("d")); 
                            }
                            function out(){ 
                                $this->_env(); 
                                $week=$this->getWeek($this->YEAR,$this->MONTH,$this->DAY);
                                $fweek=$this->getWeek($this->YEAR,$this->MONTH,1);
                                echo "<table class='signdata' border=1 solid align=center>"; 
                                echo "<tr>"; 
                                for($Tmpa=0;$Tmpa<count($this->WEEK);$Tmpa++){
                                    echo "<td align=center style=' vertical-align:middle' >".$this->WEEK[$Tmpa]."</td>"; 
                                } 
                                echo "</tr><tr>";
                                for($Tmpc=0;$Tmpc<$fweek;$Tmpc++){ 
                                    echo "<td></td>"; 
                                }
                                for($Tmpb=1;$Tmpb<=date("t",mktime(0,0,0,$this->MONTH,$this->DAY,$this->YEAR));$Tmpb++){
                                    $Tmpb=sprintf("%02d",$Tmpb); 
                                    if((strcmp($Tmpb,$this->DAY)==0) && ($this->MONTH == date("m")) && ($this->YEAR == date("Y")) ){
                                        $flag="class='newDAY'";
                                    }else{ 
                                        $flag="";
                                    }
                                    if((strcmp($this->getWeek($this->YEAR,$this->MONTH,$Tmpb),0)==0) && (1==$Tmpb)){
                                        echo "<tr><td $flag>$Tmpb</td>";
                                    }else if(strcmp($this->getWeek($this->YEAR,$this->MONTH,$Tmpb),0)==0){ 
                                        echo "<tr><td $flag>$Tmpb</td>";
                                    }else if(strcmp($this->getWeek($this->YEAR,$this->MONTH,$Tmpb),6)==0){
                                        echo "<td $flag>$Tmpb</td></tr>";
                                    }else{ 
                                        echo "<td $flag>$Tmpb</td>"; 
                                    }
                                }
                                if(strcmp($this->getWeek($this->YEAR,$this->MONTH,date("t",mktime(0,0,0,$this->MONTH,$this->DAY,$this->YEAR))),6)==0)
                                    echo "</table>";
                                else
                                    echo "</tr></table>";
                            }
                        }
                        $d = new Calendar();
                        $d->out();
                        ?>
                    </div>
                </div>
                <div class="modular6">
                    <p class="yellowco2 font14">签到规则说明：</p>
                    <p>每签到一次可获得1声望值。</p>
                </div>
            </div>
        </section>
    </div>
    </div>
    <p id="tip-error"><span>表单验证错误信息</span></p>
<?= Html::jsFile('@web/style/js/jquery-2.1.1.min.js') ?>
<?= Html::jsFile('@web/style/js/reset.js') ?>
<script>
            $(document).ready(function(){
                        var d = <?php echo date("d",time()); ?>;
                        var databased = <?= $pd; ?>;
                        if(d == databased){
                            $("#signedbtn").html("已签到");
                        }
                        var myDate = new Date();
                        day = myDate.getDate();
                        $("#signedbtn").click(function(){
                                    var d = <?php echo date("d",time()); ?>;
                                    var databased = <?= $pd; ?>;
                                    if(d == databased){
                                        $('#tip-error span').html('今天已经签到过了哦');
                                        $('#tip-error').show();
                                        setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
                                        return false;
                                    }
                                    var id = <?= $id; ?>;
                                    $.post("/center/check_ins",{id:id},function(result){
                                        if(result == "2"){
                                            $('#tip-error span').html('签到成功');
                                            $('#tip-error').show();
                                            setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
                                            $(".signdata td").each(function(){
                                                        var Th = $(this);
                                                        if(Th.hasClass("newDAY")){
                                                                    Th.addClass("signedok");
                                                                    Th.append("<i class='icon-ok'></i>"); 
                                                                    $("#signedbtn").html("已签到");
                                                                    $("#signedbtn").attr("id","signedok");
                                                        }
                                            });
                                        }else if(result == "4"){
                                            $('#tip-error span').html('今天已经签到过了哦');
                                            $('#tip-error').show();
                                            setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
                                        }else if(result == "1" || result == "3"){
                                            $('#tip-error span').html('服务器繁忙，请稍后再试');
                                            $('#tip-error').show();
                                            setTimeout(function(){$('#tip-error').fadeOut(500);},1000);
                                        }
                                    });
                        });
                        $(".signdata td").each(function(){
                                    var Th = $(this);
                                    var Thval = $(this).text();
                                    var a = new Array(<?= $day; ?>);
                                    for(var i =0; i<a.length; i++){
                                                if(a[i] == Thval ){
                                                            Th.addClass("signedok");
                                                            Th.append("<i class='icon-ok'></i>"); 
                                                }
                                    }
                        });
                        $(".bodyA").hide();
            })
</script>
</body>
</html>