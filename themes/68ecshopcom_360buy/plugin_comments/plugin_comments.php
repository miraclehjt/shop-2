<?php 


function get_comment_score($goods_id) 
{ 
$sql="SELECT comment_rank,count(*) AS score_count FROM ".$GLOBALS['ecs']->table('comment') ." WHERE comment_type='0' and id_value='$goods_id' and status='1' and parent_id='0' group by comment_rank";
 $res_score=$GLOBALS['db']->query($sql); 
$comment_score=array(); 
while($row_score=$GLOBALS['db']->fetchRow($res_score)) 
{ 
$comment_score[$row_score['comment_rank']]  = $row_score['score_count']; 
} 
$comment_score['all'] =$comment_score[5] +$comment_score[4] +$comment_score[3] +$comment_score[2] +$comment_score[1];
 $comment_score['hao'] =$comment_score[5] +$comment_score[4]; 
$comment_score['zhong'] =$comment_score[3] +$comment_score[2]; 
$comment_score['cha'] = intval($comment_score[1]); 
$comment_score['hao-du'] = $comment_score['all'] ?round(($comment_score['hao'] / $comment_score['all']),2) *100 : 0;
 $comment_score['zhong-du'] = $comment_score['all'] ?round(($comment_score['zhong'] / $comment_score['all']),2) *100 : 0;
 $comment_score['cha-du'] = $comment_score['all'] ?round(($comment_score['cha'] / $comment_score['all']),2) *100 : 0;
 $comment_score['hao-img'] = $comment_score['hao-du'] * 2.11; 
$comment_score['zhong-img'] = $comment_score['zhong-du'] * 2.11; 
$comment_score['cha-img'] = $comment_score['cha-du'] * 2.11; 
return $comment_score; 
} 
function http() 
{ 
return (isset($_SERVER['HTTPS']) &&(strtolower($_SERVER['HTTPS']) != 'off')) ?'https://': 'http://';
 } 
function get_domain() 
{ 
$protocol = http(); 
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) 
{ 
$host = $_SERVER['HTTP_X_FORWARDED_HOST']; 
} 
elseif (isset($_SERVER['HTTP_HOST'])) 
{ 
$host = $_SERVER['HTTP_HOST']; 
} 
else 
{ 
if (isset($_SERVER['SERVER_PORT'])) 
{ 
$port = ':'.$_SERVER['SERVER_PORT']; 
if ((':80'== $port &&'http://'== $protocol) ||(':443'== $port &&'https://'== $protocol))
 { 
$port = ''; 
} 
} 
else 
{ 
$port = ''; 
} 
if (isset($_SERVER['SERVER_NAME'])) 
{ 
$host = $_SERVER['SERVER_NAME'] .$port; 
} 
elseif (isset($_SERVER['SERVER_ADDR'])) 
{ 
$host = $_SERVER['SERVER_ADDR'] .$port; 
} 
} 
return $protocol .$host; 
} 

?> 