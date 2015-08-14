<?php 
$recnum = 20;
if ($recn) $recnum = $recn;

if ($keyword && $where) {
	$keyword = str_replace(" ", ",", $keyword);
	$keyword_split = explode("," , $keyword);
	if ($keyword_split[1]) {
		for($j = 0; $j < sizeof($keyword_split); $j++) {
			$WHEREIS = "$WHEREIS $where LIKE '%".trim($keyword_split[$j])."%'";
			if($j < sizeof($keyword_split)-1) {
				$WHEREIS = "$WHEREIS $search_type ";
			}
		}
		$WHEREIS = "WHERE $WHEREIS";
	}
	else {
		$WHEREIS = "WHERE $where LIKE '%$keyword%'";
	}
}
if ($sort) {
	$st = "ORDER BY $sort $orderby";
}


$data_row = db_fetch_array(db_query("SELECT count(*) FROM $Xtbl $WHEREIS", $DB_CONNECT));
$data_num = $data_row[0];
$TPG = intval($data_num/$recnum);
if(intval($data_num/$recnum) > 0) { $TPG++; }
else {$TPG = 1;}
$start_num = ($p-1)*$recnum;

$table_data = db_query("SELECT * FROM $Xtbl $WHEREIS $st LIMIT $start_num,$recnum",$DB_CONNECT);
$field_num = mysqli_num_fields($table_data);
?>


<div id="dbview">


	<form action="<?php echo $g['s']?>/" method="post">
	<input type="hidden" name="r" value="<?php echo $r?>" />
	<input type="hidden" name="m" value="<?php echo $m?>" />
	<input type="hidden" name="module" value="<?php echo $module?>" />
	<input type="hidden" name="type" value="view" />
	<input type="hidden" name="Xtbl" value="<?php echo $Xtbl?>" />
	<input type="hidden" name="p" value="<?php echo $p?>" />
	<input type="hidden" name="cutlen" value="<?php echo $cutlen?>" />



	<table>
		<colgroup> 
		<col width="70"> 
		<col width="70"> 
	<?php for($j = 0; $j < $field_num; $j++):?>
		<col> 
	<?php endfor?>
		</colgroup> 
		<thead>
		<tr>
		<th scope="col" class="split">
			<select name="recn" onchange="this.form.submit();">
				<option value=10<?php if($recnum=="10"):?> selected<?php endif?>>d.10</option>
				<option value=20<?php if($recnum=="20"):?> selected<?php endif?>>d.20</option>
				<option value=30<?php if($recnum=="30"):?> selected<?php endif?>>d.30</option>
				<option value=50<?php if($recnum=="50"):?> selected<?php endif?>>d.50</option>
				<option value=100<?php if($recnum=="100"):?> selected<?php endif?>>d.100</option>
				<option value=200<?php if($recnum=="200"):?> selected<?php endif?>>d.200</option>
				<option value=500<?php if($recnum=="500"):?> selected<?php endif?>>d.500</option>
			</select>		
		</th>
		<th scope="col" class="split">
			<?php if(!$cutlen):?>
			<a href="<?php echo $g['adm_href']?>&amp;type=view&Xtbl=<?php echo $Xtbl?>&amp;sort=<?php echo $val?>&amp;p=<?php echo $p?>&amp;where=<?php echo $where?>&amp;sort=<?php echo $sort?>&amp;orderby=<?php echo $orderby?>&amp;search_type=<?php echo $search_type?>&amp;recn=<?php echo $recnum?>&amp;keyword=<?php echo $_keyword?>&amp;cutlen=1"><img src="<?php echo $g['img_module_admin']?>/fulltext.gif" alt="모두보이기" /></a>
			<?php else:?>
			<a href="<?php echo $g['adm_href']?>&amp;type=view&amp;Xtbl=<?php echo $Xtbl?>&amp;sort=<?php echo $val?>&amp;p=<?php echo $p?>&amp;where=<?php echo $where?>&amp;sort=<?php echo $sort?>&amp;orderby=<?php echo $orderby?>&amp;search_type=<?php echo $search_type?>&amp;recn=<?php echo $recnum?>&amp;keyword=<?php echo $_keyword?>"><img src="<?php echo $g['img_module_admin']?>/cuttext.gif" alt="일부보이기" /></a>
			<?php endif?>	
		</th>
	<?php for($j = 0; $j < $field_num; $j++):$val=mysqli_fetch_field_direct($table_data, $j)->name?>
		<th scope="col"<?php if($j < $field_num-1):?> class="split"<?php endif?>>
			<a href="<?php echo $g['adm_href']?>&amp;type=view&amp;Xtbl=<?php echo $Xtbl?>&amp;sort=<?php echo $val?>&amp;p=<?php echo $p?>&amp;where=<?php echo $where?>&amp;sort=<?php echo $val?>&amp;orderby=<?php echo $orderby?>&amp;search_type=<?php echo $search_type?>&amp;recn=<?php echo $recnum?>&amp;keyword=<?php echo $_keyword?>">
			<b><?php echo $val?></b>
			</a>
		</th>
	<?php endfor?>
		</tr>
		</thead>
		
		<tbody>

	<?php $gque = mysqli_fetch_field_direct($table_data,0)->name?>
	<?php $i = 0; while($list = db_fetch_array($table_data)):?>
		<tr class="<?php if(!($i%2)):?>x1<?php else:?>x2<?php endif?>">
			<td class="c"><a href="<?php echo $g['adm_href']?>&amp;type=modify&amp;Xtbl=<?php echo $Xtbl?>&amp;where=<?php echo $gque?>&amp;value=<?php echo $list[0]?>&amp;p=<?php echo $p?>" class="u">수정</a></td>
			<td class="c"><a class="hand u" onclick="return RecordDelCheck('<?php echo $module?>','<?php echo $Xtbl?>','<?php echo $gque?>','<?php echo $list[0]?>','<?php echo $p?>');">삭제</a></td>

		<?php for($j = 0; $j < $field_num; $j++):?>
			<?php if(!$cutlen):?>
			<td><?php echo  getStrCut(htmlspecialchars($list[$j]),20,'..')?></td>
			<?php else:?>
			<td><?php echo  htmlspecialchars($list[$j])?></td>
			<?php endif?>
		<?php endfor?>
		</tr>
	<?php $i++; endwhile?>
		</tbody>
	</table>


	<div class="bottom">
		<div class="pagebox02">
		<?php //echo getPageLink(10,$p,$TPG,$g['img_core'].'/page/default')?>
		<script type="text/javascript">getPageLink(10,<?php echo $p?>,<?php echo $TPG?>,'<?php echo $g['img_core']?>/page/default');</script>
		</div>

		<div>

			<select name="where">
			<option value="">검색필드 선택</option>
			<?php for($j = 0; $j < $field_num; $j++): $val = mysql_field_name($table_data,$j)?>
				<option value="<?php echo $val?>"<?php if($val == $where):?> selected<?php endif?>><?php echo $val?></option>
			<?php endfor?>
			</select>

			<input type="text" name="keyword" value="<?php echo $_keyword?>" />

			<select name="search_type">
			<option value="OR"<?php if($search_type=="OR"):?> selected<?php endif?>>OR</option>
			<option value="AND"<?php if($search_type=="AND"):?> selected<?php endif?>>AND</option>
			</select>

			<input type="submit" class="btnblue" value=" SEARCH " />
			<input type="button" class="btngray" value=" 초기화 " onclick="goHref('<?php echo $g['adm_href']?>&amp;type=view&Xtbl=<?php echo $Xtbl?>');" />
			* 복수검색시 공백이나 콤마(,)로 구분
		
		</div>
	</div>

	</form>


</div>

