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
		
		$datefield = "";
		$custnofield = "trim(a.custno)";
		$salespsnfield = "";
		$itemfield ="trim(a.item)";
		$loccdfield = "";
		$vendornofield ="";
		$po_field ="";
		

		$periodmonthfield = "";
		$periodyearfield = "";
		include "reportcondition.php";
		
			$query = "SELECT a.*,b.category, (select otprice from icitem where trim(icitem.item) = trim(a.item)) otprice,".
				" (select itemdesc from icitem where trim(icitem.item) = trim(a.item)) itemdesc,".
				" (select company from arcust where trim(arcust.custno) = trim(a.custno)) company,".
				"(select bu from arcust where trim(arcust.custno) = trim(a.custno)) bu from custpric a, arcust b ".
				" WHERE TRIM(a.custno) = TRIM(b.custno)".
						$holdadditionalwhereclause . " ORDER BY b.category, a.custno ";
			
			//echo $query;
			$result = mysqli_query($_SESSION['db_connect'],$query);
			$numrows = mysqli_num_rows($result);
			
			

		?>		
		
	
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/tablehighlight.js"></script>
	<form name="form1" id="form1" method="post" action="">
		
		<a href="#" class="noprint" onclick="window.close();return false"><h3>Close Window</h3></a>
		 
		<div id="print_table">
		<h3><strong>Customer Price Master </strong></h3>
		<table >
		
			<tr>
				<td  align="center">
					
					
						<table  border="0" cellpadding="5" cellspacing="1" class="menu_backcolor" id="userlistTable">
							<thead>
								<tr class="right_backcolor">
									<th   class="Corner">&nbsp;</th>
									<th   class="Odd">S/N</th>
									<th   class="Odd">Customer:</th>
									<th   class="Odd">Category</th>
									<th   class="Odd">Product</th>
									<th   class="Odd">Base Price</th>
									<th   class="Odd">Dealer Margin</th>
									<th   class="Odd">NFR</th>
									<th   class="Odd">Misc</th>
									<th   class="Odd">Net Price</th>
									<th  >&nbsp;</th>
								</tr>
							</thead>
							<?php 
								
								$k = 0;
			  
						  
								while($k<  $numrows ) 
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
										<td  ><?php echo trim($row["custno"]) ."-" . trim($row["company"]);?></td>
										<td  ><?php echo trim($row["item"]) ."-" . trim($row["itemdesc"]);?></td>
										<td   align="right"><?php echo number_format($row['otprice'],2);?></td>
										<td   align="right"><?php echo number_format($row["dmargin"],2);?></td>
										<td   align="right"><?php echo number_format($row["srvchg"],2);?></td>
										<td   align="right"><?php echo  number_format($row["nfr"],2);?></td>
										<td   align="right"><?php echo  number_format($row["misc"],2);?></td>
										<td   align="right"><?php echo  number_format($row["otprice"]+$row["srvchg"]+$row["nfr"]-$row["dmargin"] + $row["misc"],2);?></td>
										<td  ></td>
									</tr>
							<?php 
									//} //End For Loop
								} //End If Result Test	
							?>
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