<?php 
      $bdata = get_article_new(array(20),'art_cat',0,false,true);
      foreach( $bdata as $key=>$value) { 
      
          echo "<a href='". $value['link'] ."' target='_blank' title='" . $value['title'] . "'><img src='" . $value['file_url'] . "' height='456' alt='" . $value['title'] . "'/></a>";
      }
      ?>