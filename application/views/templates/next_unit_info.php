<div class="democontent">
            <div class="info">
            <h4>Follow Description</h4>
                <table class="table table-hover tbfontssz">
                        <thead style="background-color: #0d0251; font-size: 10px;" >
                            <tr>
                                <th>Follow.Desc</th>
                                <th>Follow.By</th>
                                <th>Next.Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                                          <?php $no = 1 ; foreach($followinfo as $data) { ?>
                                            <?php // if ($data->follow_by_name == null || ''){ ?>
                                            <!-- <tr>
                                            	<td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                            </tr> -->
                                        <?php// }  else { ?>
                                        	<tr>
                                            	<td><?=$data->follow_desc?></td>
                                                <td><?=$data->follow_by_name?></td>
                                                <td><?=$data->follow_next?></td>
                                            </tr>
                                        <?php } //}?>
                                          </tbody>
                </table>
            </div>
      <div class="clear"></div>
</div>