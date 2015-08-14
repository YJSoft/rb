
<div id="dbproperty">

	<table>
		<colgroup> 
		<col width="60"> 
		<col width="60"> 
		<col width="40"> 
		<col width="120"> 
		<col width="60"> 
		<col width="50"> 
		<col width="80"> 
		<col> 
		</colgroup> 
		<thead>
		<tr>
		<th scope="col" class="split">필드</th>
		<th scope="col" class="split">종류</th>
		<th scope="col" class="split">길이</th>
		<th scope="col" class="split">보기</th>
		<th scope="col" class="split">NULL</th>
		<th scope="col" class="split">기본값</th>
		<th scope="col" class="split">추가</th>
		<th scope="col">실행</th>
		</tr>
		</thead>
		<tbody>
	<?php 
	$i = 0; $result = mysqli_query($DB_CONNECT, "SHOW FIELDS FROM $Xtbl");
	while ($row = mysqli_fetch_array($result)) :$i++;

		$field_name = $row[0];
		$field_kind = explode("(", $row[1]);
		$field_length = explode(")", $field_kind[1]);
		$field_view = trim($field_length[1]);
		$field_null = $row[2];
		$field_default = $row[4];
		$field_atinc = trim($row[5]);
		$field_key = $row[3];
	?>	


		<tr>
		<td>
		
		<form name="property_<?php echo $i?>" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="a" value="action" />
		<input type="hidden" name="_a" value="" />
		<input type="hidden" name="Xtbl" value="<?php echo $Xtbl?>" />
		<input type="hidden" name="field" value="<?php echo $field_name?>" />

		<input type="text" name="field_name" class="input" size="10" value="<?php echo $field_name?>" />
		</td>
		<td><input type="text" name="field_type" class="input" size="15" value="<?php echo  strtoupper($field_kind[0])?>" /></td>
		<td><input type="text" name="field_length" class="input" size="3" value="<?php echo $field_length[0]?>" /></td>
		<td>
		<select name="field_view">
		<option value=""></option>
		<option value="BINARY"<?php if($field_view=='binary'):?> selected<?php endif?>>BINARY</option>
		<option value="UNSIGNED"<?php if($field_view=='unsigned'):?> selected<?php endif?>>UNSIGNED</option>
		<option value="UNSIGNED ZEROFILL"<?php if($field_view=='unsigned zerofill'):?> selected<?php endif?>>UNSIGNED ZEROFILL</option>
		</select>	
		</td>
		<td>
		<select name="field_null">
		<option value=""<?php if($field_null):?> selected<?php endif?>>YES</option>
		<option value="1"<?php if(!$field_null):?> selected<?php endif?>>NO</option>
		</select>
		</td>
		<td><input type="text" name="field_default" class="input" size="5" value="<?php echo $field_default?>" /></td>
		<td>
		<select name="field_atinc">
		<option value="auto_increment"<?php if($field_atinc):?> selected<?php endif?>>auto_increment</option>
		<option value=""<?php if(!$field_atinc):?> selected<?php endif?>></option>
		</select>	
		</td>
		<td>
		<input type="button" value="변경" onclick="TablePropertyChk('property_<?php echo $i?>','alter');" />
		<input type="button" value="삭제" onclick="TablePropertyChk('property_<?php echo $i?>','delete');" />

		<?php if($field_key != 'PRI'):?>
		<input type="button" value="기본" onclick="TablePropertyChk('property_<?php echo $i?>','primary');"<?php if(strstr($field_kind[0],"text")):?> disabled<?php endif?> />
		<?php else:?>
		<input type="button" value="기본" onclick="TablePropertyChk1('property_<?php echo $i?>','primary');" style="background:gold;" />
		<?php endif?>

		<?php if($field_key != 'MUL'):?>
		<input type="button" value="IDX" onclick="TablePropertyChk('property_<?php echo $i?>','index');"<?php if(strstr($field_kind[0],"text")):?> disabled<?php endif?> />
		<?php else:?>
		<input type="button" value="IDX" onclick="TablePropertyChk1('property_<?php echo $i?>','index');" style="background:#E17AE2" />
		<?php endif?>

		<?php if($field_key != 'UNI'):?>
		<input type="button" value="고유" onclick="TablePropertyChk('property_<?php echo $i?>','unique');"<?php if(strstr($field_kind[0],"text")):?> disabled<?php endif?> />
		<?php else:?>
		<input type="button" value="고유" onclick="TablePropertyChk1('property_<?php echo $i?>','unique');" style="background:#56D9FA;" />
		<?php endif?>

		<input type="button" value="Fulltext" onclick="TablePropertyChk('property_<?php echo $i?>','fulltext');"<?php if(!strstr($field_kind[0],"text") && !strstr($field_kind[0],"varchar")):?> disabled<?php endif?> />
		
		</form>
		</td>
		</tr>
		

	<?php endwhile?>

		<form name="property" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $module?>" />
			<input type="hidden" name="a" value="action" />
			<input type="hidden" name="_a" value="field_alter" />
			<input type="hidden" name="new" value="yes" />
			<input type="hidden" name="Xtbl" value="<?php echo $Xtbl?>" />
			
				<tr>
				<td><input type="text" name="field" size="10" class="input" value="" /></td>
				<td>
					<select name="field_type">
					<option value=""></option>
					<option value="TINYINT">TINYINT</option>
					<option value="SMALLINT">SMALLINT</option>
					<option value="MEDIUMINT">MEDIUMINT</option>
					<option value="INT">INT</option>
					<option value="BIGINT">BIGINT</option>
					<option value="FLOAT">FLOAT</option>
					<option value="DOUBLE">DOUBLE</option>
					<option value="DECIMAL">DECIMAL</option>
					<option value="DATE">DATE</option>
					<option value="DATETIME">DATETIME</option>
					<option value="TIMESTAMP">TIMESTAMP</option>
					<option value="TIME">TIME</option>
					<option value="YEAR">YEAR</option>
					<option value="CHAR">CHAR</option>
					<option value="VARCHAR">VARCHAR</option>
					<option value="TINYBLOB">TINYBLOB</option>
					<option value="TINYTEXT">TINYTEXT</option>
					<option value="TEXT">TEXT</option>
					<option value="BLOB">BLOB</option>
					<option value="MEDIUMBLOB">MEDIUMBLOB</option>
					<option value="MEDIUMTEXT">MEDIUMTEXT</option>
					<option value="LONGBLOB">LONGBLOB</option>
					<option value="LONGTEXT">LONGTEXT</option>
					<option value="ENUM">ENUM</option>
					<option value="SET">SET</option>
					</select>
				</td>
				<td><input type="text" name="field_length" class="input" size="3" value="" /></td>
				<td>
					<select name="field_view">
					<option value=""></option>
					<option value="BINARY">BINARY</option>
					<option value="UNSIGNED">UNSIGNED</option>
					<option value="UNSIGNED ZEROFILL">UNSIGNED ZEROFILL</option>
					</select>	
				</td>
				<td>
					<select name="field_null">
					<option value="">YES</option>
					<option value="1" selected>NO</option>
					</select>
				</td>
				<td><input type="text" name="field_default" class="input" size="5" value="" /></td>
				<td>
					<select name="field_atinc">
					<option value="auto_increment">auto_increment</option>
					<option value="" selected></option>
					</select>	
				</td>

				<td align="center">
					<select name="field_nav" STYLE="width:180px;">
					<option value="->">테이블의 마지막</option>
					<option value="<-">테이블의 처음</option>
					<?php $result1 = mysqli_query($DB_CONNECT, "SHOW FIELDS FROM $Xtbl");while ($row1 = mysqli_fetch_array($result1)) :?>
					<option value="<?php echo $row1[0]?>"><?php echo $row1[0]?> 다음에</option>
					<?php endwhile?>
					</select>
					<input type="button" value="필드추가" class="btnblue" onclick="TablePropertyChk('property','add');" />
				</td>
			</tr>
		</form>
		</tbody>
	</table>


</div>
