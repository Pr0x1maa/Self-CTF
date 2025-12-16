<?php
#礼物是一份shell哦, 快来执行命令吧:)
if(';' === preg_replace('/[^\W]+\((?R)?\)/','',$_POST['m1xian'])){    
    eval($_POST['m1xian']);
}
?>