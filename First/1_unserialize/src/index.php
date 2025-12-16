<?php
highlight_file(__FILE__);
error_reporting(0);

//欢迎参加第一次纳新
//玩的开心:)

class W {
    public $bomb;
    public $wisadel;
    public function __set($name,$arguments) {
        //Password?
        if (md5($this->bomb) === "50e25b7745cd1d9bd32a758d53a1f768") {
            eval($this->wisadel);
        }else{
            echo "东风不与周郎便，铜雀春深锁二乔";
        }
    }
}

class Amiya{
    public $emotion;
    public $ring;
    public function __destruct(){
        echo "<br>Welcome ".$this -> name;
    }

    public function __wakeup(){
        $this -> name = "Hacker";
    }
}

class Sakiko{
    public $mutsumi;
    public $uika;
    public $umiri;
    public $nyamu;
    public function __toString(){
        $this -> mutsumi -> uika;
        return "";
    }
}

class Texas{
    public $pocky;
    public $partner;
    public function __toString(){
        $this -> partner -> dirve();
        return "";
    }
}

class Lappland{
    public $weapon;
    public $target;
    public function __call($name,$arguments){
        if ($name === "dirve"){
            $func = $this -> target;
            $func();
        }
    }
}

class Kaltsit{
    public $mon3tr;

    public function __invoke(){
        if($this -> mon3tr == "Mon3tr is A Cute Cat!"){
            echo "给你密码还不行嘛: ";
            echo file_get_contents("/password");
        }
    }
}

class Doctor{
    public $sanity;
    public $assistant;

    public function __get($name){
        if($name === "mutsumi"){
            //睦头想执行命令
            eval($this -> assistant);
        }else{
            $this -> sanity -> mutsumi = "saki,移动";
        }
    }
}

if (isset($_POST['arknights'])){
    unserialize($_POST['arknights']);
}

?>