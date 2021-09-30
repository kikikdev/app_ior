<?php
header( "Content-type: application/vnd.ms-excel" );
header('Content-Disposition: attachment; filename="IOR_Biweekly_report.xls"');
header("Pragma: no-cache");
header("Expires: 0");      
?>

<div align="center" class="page" style="font-size: 12px ;">

  <h4>GMF INTERNAL OCCURRENCE SYSTEM</h4>
  <h5>PERIOD : <?=$start?> - <?=$end?> </h5>
  <table align="center" border="1" width="auto" style="font-size: 12px ;">
    <thead> 
        <tr bgcolor="grey">
            <th align ="center" width="auto">No.</th>
            <th align ="center" width="auto">IOR No.</th>
            <th align ="center" width="auto">Category</th>
            <th align ="center" width="auto">Sub Category</th>
            <th align ="center" width="auto">Subject</th>
            <th align ="center" width="auto">Current Risk Index</th>
            <th align ="center" width="auto">Final Risk Index</th>
            <th align ="center" width="auto">Occ Date</th>
            <th align ="center">Detail Occurrence</th>
            <th align ="center" width="auto">Next.Unit</th>
            <th align ="center" width="auto">Insert Date</th>
            <th align ="center">Report By</th>
            <th align ="center">Insert By</th>
            <th align ="center" width="auto">Status</th>
            <th align ="center">Follow On</th>
            <th align ="center" width="auto">Follow Date</th>
            <th align ="center">Follow By</th>
            <th align ="center" width="auto">Send To</th>
        </tr>
    </thead>
    <tbody>
        <?php   $no= 0 ;  foreach($occurrence as $occ){  
                $no++ ?>
            <tr>
                <td align="center" valign="top" width="auto"><?=$no;?></td>
                <td align="center" valign="top" width="auto"><?=$occ->occ_no?></td>
                <td align="center" valign="top" width="auto"><?=$occ->cat_name?></td>
                <td align="center" valign="top" width="auto"><?=$occ->cat_sub_desc?></td>
                <td align="center" valign="top" width="auto"><?=$occ->occ_sub?></td>
                <td align="center" valign="top" width="auto"><?=$occ->occ_risk_index?></td>
                <?php if ($occ->occ_status == 3 && $occ->occ_confirm_stats) {?>
                <td align="center" valign="top" width="auto"><?=$occ->occ_final_index?></td>
                <?php }else{?>
                    <td align="center" valign="top" width="auto">-</td>
                <?php }?>
                <td align="center" valign="top" width="auto"><?=$occ->occ_date?></td>
                <?php   $detail = preg_replace("/<br\W*?\/>/", "", $occ->occ_detail); 
                        $detail2 = preg_replace("/<br\W*?\>/", "",   $detail);
                ?>
                <td height="15" align="center" valign="top" width="700" style="max-height: 15px;"  height="15"><?=$detail2?></td>
                <!-- <td align="center" valign="top" width="auto"><?=$occ->occ_follow_last_by?></td> -->
                <td align="center" valign="top" width="auto">
                    <?php if ($occ->occ_follow_last_by == '-' || $occ->occ_follow_last_by == '' || $occ->occ_follow_last_by == null) { ?>
                        <?=$occ->occ_send_to?>
                    <?php } 
                    else { ?>
                        <?=$occ->occ_follow_last_by?>
                    <?php 
                    }
                    ?>    
                </td>
                <td align="center" valign="top" width="auto"><?=$occ->created_date?></td>
                <td align="center" valign="top" width="150"><?=$occ->created_by.'/'.$occ->created_by_name.'/('.$occ->created_by_unit.')'?></td>
                <td align="center" valign="top" width="150"><?=$occ->InsertBy?></td>
                <td align="center" valign="top" width="auto">
                                <?php 
                                        
                                        if ($occ->occ_status == 1 && $occ->occ_confirm_stats == 1 ) {
                                            if ($occ->OVERDUESTATS >= '0'){
                                            echo "OVERDUE" ; 
                                            }
                                            else{
                                            echo "OPEN" ; 
                                            }
                                        }
                                        else if ($occ->occ_status == 1 && $occ->occ_confirm_stats == 2 ) {
                                            if ($occ->OVERDUESTATS >= '0'){
                                            echo "OVERDUE" ; 
                                            }
                                            else{
                                            echo "On Progress" ; 
                                            }
                                        }
                                        else if ($occ->occ_status == 1 && $occ->occ_confirm_stats == 3 ) {
                                            echo "WAITING CLOSE CONFIRMATION" ; 
                                        }
                                        else if ($occ->occ_status == 3 && $occ->occ_confirm_stats == 3 ) {
                                            echo "CLOSE" ; 
                                        }
                                        else{
                                            echo "NCR" ; 
                                        }
                                ?>
                </td>
                <td align="center" valign="top" width="400"><?=$occ->follow_desc?></td>
                <td align="center" valign="top" width="auto"><?=$occ->follow_date?></td>
                <td align="center" valign="top" width="150">
                    <?php if ($occ->follow_by == null OR $occ->follow_by_name == null OR $occ->follow_by_unit == null) { ?>
                        -    
                    <?php }else{?>
                    <?=$occ->follow_by.'/'.$occ->follow_by_name.'/('.$occ->follow_by_unit.')'?>
                      <?php } ?>  
                </td>
                <td align="center" valign="top" width="auto"><?=$occ->occ_send_to?></td>
        <?php } ?>
            </tr>
        </tbody>
    </table>
</div>

