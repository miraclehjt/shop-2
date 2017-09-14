<?php
global $_LANG;

$_LANG['pups']          = '门店自提';
$_LANG['pups_desc']     = '您可以选择离您最近的自提点上门提货：';
$_LANG['item_fee']              = '单件商品费用：';
$_LANG['base_fee']              = '1000克以内费用';
$_LANG['step_fee']               = '续重每1000克或其零数的费用';
$_LANG['shipping_print']         = '<table style="width:18.8cm; height:3cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table style="width:18.8cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:9.4cm" valign="top">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td valign="middle" style="width:1.5cm; height:0.8cm;">&nbsp;</td>
      <td width="85%">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
    <td valign="middle" style="width:5cm; height:0.8cm;">{$shop_name}</td>
      <td valign="middle">&nbsp;</td>
    <td valign="middle" style="width:1.8cm; height:0.8cm;">{$order.order_sn}</td>
    </tr>
   </table>
   </td>
 </tr>
 <tr valign="middle">
 <td>&nbsp;</td>
 <td class="h">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:1.3cm; height:0.8cm;">{$province}</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">{$city}</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$shop_address}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">&nbsp;</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td style="width:1.5cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:3.5cm; height:0.8cm;">{$service_phone}</td>
  </tr>
</table>
</td>
</tr>
</table>
  </td>
    <td style="width:9.4cm;" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<td valign="middle" style="width:1.5cm; height:0.8cm;">&nbsp;</td>
<td width="85%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="middle" style="width:5cm; height:0.8cm;">{$order.consignee}</td>
  <td valign="middle">&nbsp;</td>
  <td valign="middle" style="width:1.8cm; height:0.8cm;">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$order.region}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$order.address}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">&nbsp;</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:1.7cm;">&nbsp;</td>
    <td style="width:1.5cm; height:0.8cm;">&nbsp;</td>
    <td style="width:1.7cm;">&nbsp;</td>
    <td style="width:3.5cm; height:0.8cm;">{$order.tel}</td>
  </tr>
</table>
</td>
</tr>
</table>
</td>
  </tr>
</table>
<table style="width:18.8cm; height:6.5cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="width:7.4cm;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td colspan="2" style="height:0.5cm;"></td>
  </tr>
<tr>
<td rowspan="2" style="width:4.9cm;">&nbsp;</td>
<td style="height:0.8cm;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:0.8cm;">
  <tr>
    <td style="width:1cm;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr>
<td style="height:1.3cm;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td style="height:0.7cm;">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:1.5cm">
<tr>
<td>&nbsp;</td>
</tr>
</table>
</td>
<td valign="top" style="width:11.4cm;">&nbsp;</td>
  </tr>
</table>';

?>