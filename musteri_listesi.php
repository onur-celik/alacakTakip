<?php include "header.php"; ?>
	
	<table class="table table-hover table-striped table-bordered">
		<thead>
			<th>İsim Soyisim</th>
			<th>Adres</th>
			<th>Telefon1</th>
			<th>Telefon2</th>
			<th>Telefon3</th>
			<th>Hesap Durumu</th>
		</thead>
		<tbody>
		<?php
			connect_db();
			$msquery = mysql_query("SELECT * FROM musteriler ORDER BY isimsoyisim ASC");
			while($row = mysql_fetch_object($msquery))
			{
				if ($row->hesap_durumu == 1)
				{
					echo "<tr class='success'>";
				}
				else
				{
					echo "<tr class='danger'>";
				}
				echo "<td> <a href='musteri.php?id=$row->id'>$row->isimsoyisim</a> </td>";
				echo "<td> $row->adres </td>";
				echo "<td> $row->telefon1 </td>";
				echo "<td> $row->telefon2 </td>";
				echo "<td> $row->telefon3 </td>";
				if ($row->hesap_durumu == 1)
				{
					echo "<td width=130> AÇIK </td>";	
				}
				else
				{
					echo "<td width=130> KAPALI </td>";	
				}
				
				echo "</tr>";
			}
		?>		
		</tbody>
	</table>
	