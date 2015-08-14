<?php if ($where && $value) $list = mysqli_fetch_array(mysqli_query($DB_CONNECT,"SELECT * FROM $Xtbl WHERE $where='$value'"))?>

<div id="dbmodify">


	<form action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $module?>" />
	<input type="hidden" name="a" value="action" />
	<input type="hidden" name="_a" value="record_update" />
	<input type="hidden" name="ggg_table" value="<?php echo $Xtbl?>" />
	<input type="hidden" name="ggg_where" value="<?php echo $where?>" />
	<input type="hidden" name="ggg_value" value="<?php echo $value?>" />

	<table>
		<colgroup> 
		<col width="80"> 
		<col width="80"> 
		<col width="140"> 
		<col> 
		</colgroup> 
		<thead>
		<tr>
		<th scope="col" class="split">필드</th>
		<th scope="col" class="split">종류</th>
		<th scope="col" class="split">함수</th>
		<th scope="col">값</th>
		</tr>
		</thead>

		<tbody>

	<?php 
	$i = 0; $result = mysqli_query($DB_CONNECT, "SHOW FIELDS FROM $Xtbl");
	while ($row = mysqli_fetch_array($result)) :

		$field_name = $row[0];
		$field_kind = explode(" ", $row[1]);
		$field_kind1 = explode("(", $row[1]);
		$field_length = explode(")", $field_kind1[1]);
		$field_null = $row[2];
		$field_default = $row[4];
		$field_atinc = trim($row[5]);
		$field_key = $row[3];
	?>	

			<tr class="<?php if(!($i%2)):?>x1<?php else:?>x2<?php endif?>">
				<td class="b"><?php echo $field_name?></td>
				<td class="b"><?php echo $field_kind[0]?></td>
				<td>
					<select name="ggg_f_<?php echo $field_name?>">
					<option value=""></option>
					<option value="ASCII">ASCII</option>
					<option value="CHAR">CHAR</option>
					<option value="SOUNDEX">SOUNDEX</option>
					<option value="LCASE">LCASE</option>
					<option value="UCASE">UCASE</option>
					<option value="NOW">NOW</option>
					<option value="PASSWORD">PASSWORD</option>
					<option value="MD5">MD5</option>
					<option value="ENCRYPT">ENCRYPT</option>
					<option value="RAND">RAND</option>
					<option value="LAST_INSERT_ID">LAST_INSERT_ID</option>
					<option value="COUNT">COUNT</option>
					<option value="AVG">AVG</option>
					<option value="SUM">SUM</option>
					<option value="CURDATE">CURDATE</option>
					<option value="CURTIME">CURTIME</option>
					<option value="FROM_DAYS">FROM_DAYS</option>
					<option value="FROM_UNIXTIME">FROM_UNIXTIME</option>
					<option value="PERIOD_ADD">PERIOD_ADD</option>
					<option value="PERIOD_DIFF">PERIOD_DIFF</option>
					<option value="TO_DAYS">TO_DAYS</option>
					<option value="UNIX_TIMESTAMP">UNIX_TIMESTAMP</option>
					<option value="USER">USER</option>
					<option value="WEEKDAY">WEEKDAY</option>
					<option value="CONCAT">CONCAT</option>
					</select>		
				</td>
				<td>
			
			<?php if(!strstr($field_kind[0], "text")):?>
				<input type="text" name="<?php echo $field_name?>" class="input" size="<?php echo $field_length[0]<20?$field_length[0]:65?>" value="<?php echo $list[$i]?>" />
			<?php else:?>
				<TEXTAREA name="<?php echo $field_name?>" rows="7" cols="64"><?php echo $list[$i]?></textarea>
			<?php endif?>

				</td>
			</tr>
	<?php $i++;endwhile?>
		</tbody>
	</table>



	<div class="bottom">

		<?php if($where):?>
		<input type="radio" name="ggg_save_type" value="update" checked /> 현재레코드를 수정
		<input type="radio" name="ggg_save_type" value="" />새레코드(열)에 삽입
		<input type="submit" value=" 실 행 " class="btnblue" />
		<input type="button" onclick="history.go(-1);" value="취소" class="btngray" />
		<?php else:?>
		<input type="submit" value="새레코드(열) 삽입" class="btnblue" />
		<input type="button" onclick="history.go(-1);" value="취소" class="btngray" />
		<?php endif?>

	</div>

	</form>

</div>
