<?php 
	ob_start();
	include_once "session_track.php";
	
	include "printheader.php";
?>

<style>
	table {
		  border-collapse: collapse;
		}
	@media screen {
			td {padding:5px;}
			.tableb {border-radius: 15px 50px; border-collapse: separate;border : 5px solid olive;}
			
			#print_table {
				display:none;
			}
	}
	
	@media print{
			#print, #head-inner,#smoothmenu1, .tableb, .noprint, .PrintButton{
				display:none;
			}
			#print_table {
				display:block;
			}
		
			
		}
</style>

<div align ="center" id="data-form" > 
	<?php 
		
		include "basicparameters.php";	
		
		$datefield = "a.receivd_dt";
		$custnofield = "";
		$salespsnfield = "";
		$itemfield ="trim(a.item)";
		$loccdfield = "trim(a.loccd)";
		$vendornofield ="";
		$po_field ="";
		
		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
				
			$query = "SELECT a.*, b.loc_name FROM rec_invent a, lmf b WHERE trim(a.loccd) = trim(b.loccd) " .
							$holdadditionalwhereclause . " ORDER BY STR_TO_DATE( a.receivd_dt , '%d/%m/%Y') desc, a.item ";

		$query_summary = "SELECT sum(a.qtyreceived) qtyreceived FROM rec_invent a  WHERE 1 = 1 " .
							$holdadditionalwhereclause ;

		
		
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$result_summary = mysqli_query($_SESSION['db_connect'],$query_summary);
			$numrows = mysqli_num_rows($result);
			
			$summary_qtyreceived = 0;
			if($numrows>0){
				$row_summary = mysqli_fetch_array($result_summary);
				$summary_qtyreceived = $row_summary['qtyreceived'];
			}

			
		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Inventory Receipt </font></strong></h3>
		<h3><strong>Reporting from <?php echo $startdate;?> &nbsp; to  <?php echo $enddate;?> </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Receipt No</th>
									<th   class="Odd">Date</th>
									<th   class="Odd">LPO No</th>
									<th   class="Odd">Received From</th>
									<th   class="Odd">Receiving Point</th>
									<th   class="Odd">Sub Inventory</th>
									<th   class="Odd">Item</th>
									<th   class="Odd">Qty Received</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
						  
								while($k<$numrows) 
								{
									$k++;
									//for($i=0; $i<$numrows; $i++){
									$row = mysqli_fetch_array($result);
									//while($i < $skip) continue;
									//echo 'count '.$i.'   '.$skip;	
								//}
							?>
							
									<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ><?php echo $k;?></td>
										<td   ><?php echo $row['inv_recpt_no'];?></td>
										<td   align="right"><?php echo substr(trim($row['receivd_dt']),0,10);?></td>
										<td  ><?php echo trim($row['purchaseorderno']);?></td>
										<td  ><?php echo trim($row['vendorno'])."-" . trim($row['company']);?></td>
										<td  ><?php echo trim($row['loccd'])."-" . trim($row['loc_name']);?></td>
										<td  ><?php echo trim($row['subloc']);?></td>
										<td  ><?php echo trim($row['itemdesc'])."-" . trim($row['item']);?></td>
										<td   align="right"><?php echo number_format($row['qtyreceived'],2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
							
							<tr <?php echo ($k%2==0)?"class='treven'":"class='trodd'"; ?> >
										<td  >&nbsp;</td>
										<td  ></td>
										<td   ></td>
										<td   align="right"></td>
										<td  ></td>
										<td  ></td>
										<td  ><strong>Summary :</strong></td>
										<td  ></td>
										<td  ></td>
										<td   align="right"><strong><?php echo number_format($summary_qtyreceived,2);?></strong></td>
										<td  ></td>
									</tr>
							
						</table>
					
				</td>
			</tr>
			
			</table>
			</div>
			
	</form>
</div>

<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.addEventListener("DOMContentLoaded",function(){PrintPage();});
		
</script>