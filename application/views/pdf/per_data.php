<style>
     .detail_tabel{
          border-bottom:1;
          border-left:1;
          border-right:1;
          border-top:1;
          border:1px solid black;
          border-collapse:collapse;
          border:#000;
          font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
          font-size: 10pt;
          margin-top: 0;
     }
     .marg{
          margin-top: 0;    
     }
     .putih{
          display: none;
     }
     .inp-check{
          width: 15px; 
          max-width: 15px;
          min-width: 15px;
     }

     .detail-break{
          font-size: 11px;
          white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
          white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
          white-space: -pre-wrap;      /* Opera 4-6 */
          white-space: -o-pre-wrap;    /* Opera 7 */
          white-space: pre-wrap;       /* css-3 */
          word-wrap: break-word;       /* Internet Explorer 5.5+ */
          word-break: break-all;
          white-space: normal;

     }
     @media print {
         .element-that-contains-table {
             overflow: visible !important;
         }
     }
</style>
<?php foreach($occurrence as $occ){  ?>
<table width="100%" height="100%" border="1" align="center" class="detail_tabel" style="font-size: 12px;">
     <tbody>
          <tr>
               <td colspan="9" align="center">
                    <span style="text-align: center; font-weight: bold;">OCCURRENCE REPORT</span> 
               </td>
          </tr>
          <tr>
               <td colspan="5" rowspan="3">Subject : <?=$occ->occ_sub?></td>
               <?php $ra =$occ->occ_risk_index ;
                if ($ra == '5A' || $ra == '5B' || $ra == '5C' || $ra == '4A' || $ra == '4B'|| $ra == '3A') { 
               $bgcolor =  '#ff0000' ;
               }else if ($ra == '5D' || $ra == '5E' || $ra == '4C' || $ra == '3B' || $ra == '3C' || $ra == '2A' || $ra == '2B') {
               $bgcolor =  '#d8ff00' ;
               }else if ($ra == '4D' || $ra == '4E' || $ra == '3D' || $ra == '4D' || $ra == '2C' || $ra == '1A' || $ra == '1B') {
               $bgcolor =  '#d8ff00' ;
               }else if ($ra == '3E' || $ra == '2D' || $ra == '2E' || $ra == '1C' || $ra == '1D' || $ra == '1E') {
               $bgcolor =  '#048a04' ;
               }
               else {
               $bgcolor =  '' ;    
               }?>
               <td rowspan="2" align="center" bgcolor="<?=$bgcolor?>" ><i style="font-size: 12px;">Current Risk Index</i><br><?=$occ->occ_risk_index?></td>
               <td colspan="3">No of Occurrence : <?=$occ->occ_no?></td>
          </tr>
          <tr>
               <?php 
               $ocdate = substr($occ->occ_date, 8 ,2);  
               $ocmonth = substr($occ->occ_date, 5 ,2);  
               $ocyear = substr($occ->occ_date, 0 ,4);
               ?>
            <td colspan="3">Date of Occurrence : <?=$ocdate .'-'. $ocmonth .'-'. $ocyear?></td>
          </tr>
          <tr>
          	 <?php $ra =$occ->occ_final_index ;
                if ($ra == '5A' || $ra == '5B' || $ra == '5C' || $ra == '4A' || $ra == '4B'|| $ra == '3A') { 
               $bgcolor =  '#ff0000' ;
               }else if ($ra == '5D' || $ra == '5E' || $ra == '4C' || $ra == '3B' || $ra == '3C' || $ra == '2A' || $ra == '2B') {
               $bgcolor =  '#d8ff00' ;
               }else if ($ra == '4D' || $ra == '4E' || $ra == '3D' || $ra == '4D' || $ra == '2C' || $ra == '1A' || $ra == '1B') {
               $bgcolor =  '#d8ff00' ;
               }else if ($ra == '3E' || $ra == '2D' || $ra == '2E' || $ra == '1C' || $ra == '1D' || $ra == '1E') {
               $bgcolor =  '#048a04' ;
               }
               else {
               $bgcolor =  '' ;    
               }?>
               <td align="center" bgcolor="<?=$bgcolor?>" ><i style="font-size: 12px;">Final Risk Index</i><br><?php if (!empty($occ->occ_final_index)) {echo $occ->occ_final_index;}else{echo '-';}?></td>
               <td colspan="4" valign="top" >Reference : <?=$occ->occ_reff?></td>
          </tr>
          <tr>
               <td colspan="6">Ambiguity : <?php if ($occ->occ_ambiguity == '1') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked"/> YES' ; 
                    echo '<input class="inp-check" type="checkbox"/> NO' ; 
                     }
                    else {
                    echo '<input class="inp-check" type="checkbox"/> YES' ; 
                    echo '<input class="inp-check" type="checkbox" checked="checked"/> NO' ; 
                    } ?> 
                </td>                    
               <td colspan="3" rowspan="2">To : <?=$occ->occ_send_to?></td>
               
          </tr>
          <tr>
               <td colspan="6">TYPE or P/N : 
                    <?php if ($occ->occ_level_sub == null || $occ->occ_level_sub == '-') { 
                         echo "-" ;
                         }else{ 
                         echo "$occ->occ_level_sub" ;
                         } ?>
                         /
                         <?php if ($occ->occ_level_sub_child == null || $occ->occ_level_sub_child == '-') { 
                         echo "-" ;
                         }else{ 
                         echo "$occ->occ_level_sub_child" ;
                         } ?>
               </td>
          </tr>
          <tr>
               <td colspan="6" align="center"><strong>Category</strong></td>
               <td colspan="3" rowspan="6">Copy : TQY</td>
          </tr>
          <tr>
            <td colspan="2"><?php if ($occ->occ_category == '3') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
              Personnel </td>
            <td colspan="4"><?php if ($occ->occ_category == '4') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
              Maintenance Instruction </td>
          </tr>
           <tr>
             <td colspan="2"><?php if ($occ->occ_category == '2') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Maintenance Data </td>
             <td colspan="4"><?php if ($occ->occ_category == '5') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Tool equipment</td>
          </tr>
          <tr>
               <td colspan="2">
               <?php if ($occ->occ_category == '8') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Others</td>
               <td colspan="4"><?php if ($occ->occ_category == '6') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Company Procedure</td>
          </tr>
          <tr>
               <td colspan="2"><?php if ($occ->occ_category == '1') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Facility</td>
               <td colspan="4"><?php if ($occ->occ_category == '7') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Personal Protective Equipment</td>
               <!-- <td colspan="3" rowspan="2">Copy : TQY</td> -->
          </tr>
          <tr>
               <td colspan="2"><?php if ($occ->occ_category == '9') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Health, Safety, and Environment</td>
          </tr>
          <tr>
               <td><strong>Level Type </strong></td>
               <td colspan="2">
               <?php if ($occ->occ_level_type == 'Aircraft') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Aircraft
               </td>
               <td colspan="3">
               <?php if ($occ->occ_level_type == 'Engine') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Engine</td>
               <td>
               <?php if ($occ->occ_level_type == 'APU') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               APU
               </td>
               <td>
               <?php if ($occ->occ_level_type == 'Component') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Component
               </td>
               <td>
               <?php if ($occ->occ_level_type == 'Others') { 
                    echo '<input class="inp-check" type="checkbox" checked="checked" />' ;
                    }
                    else {
                    echo '<input class="inp-check" type="checkbox"/>' ; 
                    } ?>
               Others
               </td>
          </tr>
          </tbody>
          </table>
<table width="100%" height="80%" border="1" align="center" class="detail_tabel" style="font-size: 10px;">
     <tbody>
          <tr>
               <td colspan="9" class=""><strong>Detail of Occurrence</strong> <strong>:</strong><br>
               <?php 
                         $iamlong    = $occ->occ_detail ;

                         $iamwrapped = wordwrap($iamlong , 120, " ", true); 
                         
                         ?>

               <?=$iamwrapped?></td>
          </tr>
          <tr>
               <?php 
               $ocdatec = substr($occ->created_date, 8 ,2);  
               $ocmonthc = substr($occ->created_date, 5 ,2);  
               $ocyearc = substr($occ->created_date, 0 ,4);
               $occtimec = substr($occ->created_date, 11 ,10);
               ?>
               <td colspan="5" valign="top">
               <?php if ($occ->created_hide == 0 ) { ?>
                                  Name/ID No : <?=$occ->created_by_name.'/'.$occ->created_by?>
                              <br>Unit : <?=$occ->created_by_unit?>
                              <br>Date : <?=$ocdatec .'-'. $ocmonthc .'-'. $ocyearc .' '.$occtimec ?>
               <?php } else {?>
               
                              Name/ID No : -
                              <br>Unit : -
                              <br>Date : <?=$ocdatec .'-'. $ocmonthc .'-'. $ocyearc .' '.$occtimec ?>
                              <?php } ?>
               </td>
               <td colspan="4">Reporter identity : 
                              <?php if ($occ->created_hide == '0') {
                              echo '<input class="inp-check" type="checkbox" checked="checked"/> Shown' ; 
                              echo '<input class="inp-check" type="checkbox"/> Hidden' ;
                              }
                              else{
                              echo '<input class="inp-check" type="checkbox"/> Shown' ; 
                              echo '<input class="inp-check" type="checkbox" checked="checked"/> Hidden' ;
                                   }?>
                           <br>
                           <br>Data reference : 
                           <?php echo '<input class="inp-check" type="checkbox"/> Yes' ; 
                                 echo '<input class="inp-check" type="checkbox"/> No' ; ?>
               </td>
          </tr>
          <tr>
               <td colspan="9"><strong>Next Process </strong>
               <input class="inp-check" type="checkbox" />Hiram
               <input class="inp-check" type="checkbox" />Investigation
               <input class="inp-check" type="checkbox" />NCR
               </td>
          </tr>
          </tbody>
          </table>
<table width="100%" height="100%" border="1"  autosize="1" align="center" class="detail_tabel" style="font-size: 12px;">
     <tbody>
          <?php
          $no = 0 ;
          foreach($occurrence_follow as $follow){  
          $no++ ; 
          ?>
          <tr>
               <td colspan="9"><strong><?=$no?>) Follow On : </strong>
               <br><?=$follow->follow_desc?>
               </td>
          </tr>
          <tr>
               <td colspan="4">Name/ID No : <?=$follow->follow_by_name.'/'.$follow->follow_by?>
                           <br>Unit : <?=$follow->follow_by_unit?>
               <?php 
               $ocdatecf = substr($follow->follow_date, 8 ,2);  
               $ocmonthcf = substr($follow->follow_date, 5 ,2);  
               $ocyearcf = substr($follow->follow_date, 0 ,4);
               $occtimecf = substr($follow->follow_date, 11 ,10);
               ?>
                           <br>Date : <?=$ocdatecf .'-'. $ocmonthcf .'-'. $ocyearcf .' '.$occtimecf ?>
               </td>
               <td colspan="5">Data reference Yes No

                    <?php $hehe = (count($occurrence_follow ))  ; ?>
                            <br>Status : <?php  if ($no == $hehe && $follow->occ_status == 3 && $follow->occ_confirm_stats == 3 ) { 
                              echo '<input class="inp-check" type="checkbox"/> Open' ; 
                              echo '<input class="inp-check" type="checkbox" checked="checked"/> Close' ; 
                              } else {
                              echo '<input class="inp-check" type="checkbox" checked="checked"/> Open' ; 
                              echo '<input class="inp-check" type="checkbox"/> Close' ;
                              } ?>
                            <br>Next Unit :  <?=$follow->follow_next?>
               </td>
          </tr>
          
          <?php } ?>
     </tbody>
</table>
<?php } ?>