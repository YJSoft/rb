<?php
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 91 ? $recnum : 30;

$RCD = getDbArray($table['s_module'],'','*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_module'],'');
$TPG = getTotalPage($NUM,$recnum);

if (!$id)
{
	$id = 'site';
}
$R = getDbData($table['s_module'],"id='".$id."'",'*');
?>

<div class="row">
	<div class="col-md-4 col-lg-3" id="tab-content-list">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="icon">
					<i class="fa fa-list fa-2x"></i>
				</div>
				<h4 class="panel-title">
					모듈 정보
				</h4>
			</div>
			<div class="list-group hidden-xs hidden-sm">
				<?php $_TMP_RCD=array()?>
				<?php while($BR = db_fetch_array($RCD)):?>
				<a class="list-group-item<?php if($BR['id']==$id):?> active<?php endif?>" href="<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $p?>&amp;id=<?php echo $BR['id']?>">
					<?php if($BR['hidden']):?><span class="badge">
						<i class="fa fa-eye-slash fa-lg"></i>
					</span><?php endif?><?php echo $BR['name']?>
					<span class="text-muted">(<?php echo $BR['id']?>)</span>
				</a>
				<?php $_TMP_RCD[]=$BR;endwhile?>
			</div>
			<div class="list-group visible-xs visible-sm">
				<?php foreach($_TMP_RCD as $BR):?>
				<a class="list-group-item<?php if($BR['id']==$id):?> active<?php endif?>" data-toggle="modal" href="#module-info">
					<?php if($BR['hidden']):?><span class="badge">
						<i class="fa fa-eye-slash fa-lg"></i>
					</span><?php endif?><?php echo $BR['name']?>
					<span class="text-muted">(<?php echo $BR['id']?>)</span>
				</a>
				<?php endforeach?>
			</div>
			<div class="panel-footer text-center">
				<ul class="pagination">
					<li><a href="<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=1">&laquo;</a></li>
					<?php for($i = 1; $i <= $TPG; $i++):?>
					<li><a href="<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $i?>"><?php echo $i?></a></li>
					<?php endfor?>
					<li><a href="<?php echo $g['adm_href']?>&amp;recnum=<?php echo $recnum?>&amp;p=<?php echo $TPG?>">&raquo;</a></li>
				</ul>
			</div>
		</div>
		<hr class="visible-xs visible-sm">
	</div>
	<div class="col-md-8 col-lg-9 hidden-xs hidden-sm" id="tab-content-view">

		<div class="page-header">
			<h4>
			<i class="fa fa-cog fa-lg"></i>&nbsp; 모듈 등록정보
			</h4>
		</div>

		<div class="row">
			<div class="col-md-2 col-sm-2 text-center">
				<span class="fa-stack fa-3x">
					<i class="fa fa-square fa-stack-2x"></i>
					<i class="kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?> fa-stack-1x kf-inverse" id="_moduleIcon_"></i>
				</span>
			</div>
			<div class="col-md-10 col-sm-10">
				<h4 class="media-heading"><strong><?php echo $R['name']?></strong>
					<span class="text-muted">(<?php echo $R['id']?>)</span></h4>
				<p class="text-muted">선택된 모듈에 대한 등록정보입니다. 시스템 기본모듈은 삭제할 수
					없습니다.</p>

				<!-- Split button -->
				<div class="btn-group">
				  <button type="button" class="btn btn-default"><i class="fa fa-code fa-lg"></i> <a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=admin&amp;module=filemanager&amp;front=main&amp;pwd=<?php echo urlencode('./modules/'.$R['id'].'/')?>">파일관리</a></button>
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				  	<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&amp;module=<?php echo $R['id']?>">모듈 관리자페이지</a></li>
				    <li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $R['id']?>" target="_blank">모듈 사용자페이지</a></li>
				    <li class="divider"></li>
					<?php if(!$R['system']):?>
				    <li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=module_delete&amp;moduleid=<?php echo $R['id']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('관련파일/DB데이터가 모두 삭제됩니다.\n정말로 삭제하시겠습니까?     ')">모듈삭제</a></li>
					<?php else:?>
				    <li class="disabled"><a>모듈삭제</a></li>
					<?php endif?>
				  </ul>
				</div>

				<button class="btn btn-primary" type="button" onclick="document.procForm1.submit();"><i class="fa fa-check fa-lg"></i> 속성변경</button>

			</div>
		</div>
		<hr>

		<form class="form-horizontal" role="form" name="procForm1" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
		<input type="hidden" name="r" value="<?php echo $r?>" />
		<input type="hidden" name="m" value="<?php echo $module?>" />
		<input type="hidden" name="moduleid" value="<?php echo $R['id']?>" />
		<input type="hidden" name="a" value="moduleinfo_update" />
		<input type="hidden" name="iconaction" value="" />

			<div class="form-group">
				<label class="col-md-2 control-label">모듈 아이디</label>
				<div class="col-md-10">
					<p class="form-control-static"><?php echo $R['id']?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">모듈이름</label>
				<div class="col-md-10">
					<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $R['name']?>">
				</div>
			</div>
			<!-- 모듈 아이콘  -->
			<div class="form-group">
				<label class="col-md-2 control-label">모듈아이콘</label>
				<div class="col-md-10">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<a href="#icon-gallery" data-toggle="tab" class="btn btn-default active">
							<input id="option1" name="options" type="radio">
							<i class="fa fa-check-square-o"></i>&nbsp;아이콘 갤러리에서 선택
						</a>					
						<a href="#icon-self" data-toggle="tab"  class="btn btn-default">
							<input id="option1" name="options" type="radio">
							<i class="fa fa-font"></i>&nbsp;전용 아이콘 폰트 지정
						</a>
					</div>
				</div>
			</div>
			<div class="form-group tab-content" style="padding:0">
				<div class="col-md-offset-2 col-md-10 tab-pane active" id="icon-gallery">
					<button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#modal-icon-gallery"><i class="fa fa-flag fa-lg"></i> 아이콘 갤러리
					</button>
					<p class="help-block">아이콘 갤러리에서 선택해 주세요.</p>
				</div>
				<div class="col-md-offset-2 col-md-10 tab-pane" id="icon-self">
					<label class="sr-only" for="">폰트 지정</label>
					<input type="text" class="form-control" id="" placeholder="스타일 속성을 입력해 주세요" name="icon" value="<?php echo $R['icon']?>">
					<ul class="help-block list-unstyled">
						<li>전용 아이콘 폰트를 사용하려면 모듈내부에 아이폰 폰트 파일을 내장 하고 있어야 합니다.</li>
						<li>아이콘 폰트 제작 방법은 <a href="http://docs.kimsq.com/kr/" target="_blank">도움말</a>을 참고해 주세요</li>
						<li>입력된 코드는 <code>&lt;i class=""&gt;</code>에 속성으로 반영 됩니다.</li>
					</ul>
				</div>
			</div>
			<!-- /모듈 아이콘  -->
			<div class="form-group">
				<label class="col-md-2 control-label">모듈감추기</label>
				<div class="col-md-10">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-default<?php if($R['hidden']):?> active<?php endif?>">
							<input id="option1" type="radio" name="hidden" value="1"<?php if($R['hidden']):?> checked<?php endif?>>
							<span class="glyphicon glyphicon-eye-open"></span>&nbsp;출력함
						</label>
						<label class="btn btn-default<?php if(!$R['hidden']):?> active<?php endif?>">
							<input id="option2" type="radio" name="hidden" value="0"<?php if(!$R['hidden']):?> checked<?php endif?>>
							<i class="fa fa-eye-slash fa-lg"></i>&nbsp;감춤
						</label>
					</div>
					<span class="help-block">모듈 리스트에서 출력하거나 감춤</span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">테이블생성</label>
				<div class="col-md-10">
					<p class="form-control-static">
					<?php if($R['tblnum']):?>
					DB테이블 <?php echo $R['tblnum']?>개가 생성되었습니다.
					<?php else:?>
					이 모듈은 DB테이블을 생성하지 않습니다.
					<?php endif?>					
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">모듈등록일</label>
				<div class="col-md-10">
					<p class="form-control-static"><?php echo getDateFormat($R['d_regis'],'Y/m/d')?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">포함언어팩</label>
				<div class="col-md-10">
					<p class="form-control-static">
					<?php $i=0?>
					<?php $dirs = opendir($g['path_module'].$R['id'].'/')?>
					<?php while(false !== ($tpl = readdir($dirs))):?>
					<?php if(substr($tpl,0,5)!='lang.')continue?>
					<?php $reallang = str_replace('lang.','',$tpl)?>
					<span class="b"><?php echo getFolderName($g['path_var'].'language/'.$reallang)?></span>(<?php echo $reallang?>)<br />
					<?php $i++; endwhile?>
					<?php closedir($dirs)?>
					<?php if(!$i):?>
					<span class="b">언어팩이 없는 모듈입니다</span>
					<?php endif?>
					</p>
				</div>
			</div>
		</form>


	</div>
</div>



<!-- Modal -->
  <div class="modal fade" id="module-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-cog fa-lg"></i>&nbsp; 모듈 등록정보</h4>
        </div>
        <div class="modal-body">

			<div class="row">
				<div class="col-md-2 col-sm-2">
					<span class="fa-stack fa-3x">
						<i class="fa fa-square fa-stack-2x"></i>
						<i class="kf <?php echo $R['icon']?$R['icon']:'kf-'.$R['id']?> fa-stack-1x kf-inverse"></i>
					</span>
				</div>
				<div class="col-md-10 col-sm-10">
					<h4 class="media-heading"><?php echo $R['name']?>
						<span class="text-muted">(<?php echo $R['id']?>)</span></h4>
					<p class="text-muted">선택된 모듈에 대한 등록정보입니다. 시스템 기본모듈은 삭제할 수
						없습니다.</p>

					<!-- Split button -->
					<div class="btn-group">
					  <button type="button" class="btn btn-default">관리</button>
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					    <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $m?>&amp;module=<?php echo $R['id']?>">모듈 관리자페이지</a></li>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $R['id']?>" target="_blank">모듈 사용자페이지</a></li>
						<li class="divider"></li>
						<?php if(!$R['system']):?>
						<li><a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=module_delete&amp;moduleid=<?php echo $R['id']?>" target="_action_frame_<?php echo $m?>" onclick="return confirm('관련파일/DB데이터가 모두 삭제됩니다.\n정말로 삭제하시겠습니까?     ')">모듈삭제</a></li>
						<?php else:?>
						<li class="disabled"><a>모듈삭제</a></li>
						<?php endif?>
					  </ul>
					</div>

				</div>
			</div>
			<hr>
			<form class="form-horizontal" role="form" name="procForm2" action="<?php echo $g['s']?>/" method="post" target="_action_frame_<?php echo $m?>" enctype="multipart/form-data" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>" />
			<input type="hidden" name="m" value="<?php echo $module?>" />
			<input type="hidden" name="moduleid" value="<?php echo $R['id']?>" />
			<input type="hidden" name="a" value="moduleinfo_update" />
			<input type="hidden" name="iconaction" value="" />
			<div class="form-group">
				<label class="col-md-2 control-label">모듈 아이디</label>
				<div class="col-md-10">
					<p class="form-control-static"><?php echo $R['id']?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">모듈이름</label>
				<div class="col-md-10">
					<input class="form-control col-md-6" placeholder="" type="text" name="name" value="<?php echo $R['name']?>">
				</div>
			</div>
			<!-- 모듈 아이콘  -->
			<div class="form-group">
				<label class="col-md-2 control-label">모듈아이콘</label>
				<div class="col-md-10">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<a href="#icon-gallery-xs" data-toggle="tab" class="btn btn-default active">
							<input id="option1" name="options" type="radio">
							<i class="fa fa-check-square-o"></i>&nbsp;갤러리
						</a>					
						<a href="#icon-self-xs" data-toggle="tab"  class="btn btn-default">
							<input id="option1" name="options" type="radio">
							<i class="fa fa-font"></i>&nbsp;전용 폰트
						</a>
					</div>
				</div>
			</div>
			<div class="form-group tab-content" style="padding:0">
				<div class="col-md-offset-2 col-md-10 tab-pane active" id="icon-gallery-xs">
					<button class="btn btn-default btn-block" type="button" data-toggle="modal" data-target="#modal-icon-gallery"><i class="fa fa-flag fa-lg"></i> 아이콘 갤러리
					</button>
					<p class="help-block">아이콘 갤러리에서 선택해 주세요.</p>
				</div>
				<div class="col-md-offset-2 col-md-10 tab-pane" id="icon-self-xs">
					<label class="sr-only" for="">폰트 지정</label>
					<input type="text" class="form-control" id="" placeholder="스타일 속성을 입력해 주세요" name="icon" value="<?php echo $R['icon']?>">
					<ul class="help-block list-unstyled">
						<li>전용 아이콘 폰트를 사용하려면 모듈내부에 아이폰 폰트 파일을 내장 하고 있어야 합니다.</li>
						<li>아이콘 폰트 제작 방법은 <a href="http://docs.kimsq.com/kr/" target="_blank">도움말</a>을 참고해 주세요</li>
						<li>입력된 코드는 <code>&lt;i class=""&gt;</code>에 속성으로 반영 됩니다.</li>
					</ul>
				</div>
			</div>
			<!-- /모듈 아이콘  -->
			<div class="form-group">
				<label class="col-md-2 control-label">모듈감추기</label>
				<div class="col-md-10">
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-default<?php if($R['hidden']):?> active<?php endif?>">
							<input id="option1" type="radio" name="hidden" value="1"<?php if($R['hidden']):?> checked<?php endif?>>
							<span class="glyphicon glyphicon-eye-open"></span>&nbsp;출력함
						</label>
						<label class="btn btn-default<?php if(!$R['hidden']):?> active<?php endif?>">
							<input id="option2" type="radio" name="hidden" value="0"<?php if(!$R['hidden']):?> checked<?php endif?>>
							<i class="fa fa-eye-slash fa-lg"></i>&nbsp;감춤
						</label>
					</div>
					<span class="help-block">모듈 리스트에서 출력하거나 감춤</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">테이블생성</label>
				<div class="col-md-10">
					<p class="form-control-static">
					<?php if($R['tblnum']):?>
					DB테이블 <?php echo $R['tblnum']?>개가 생성되었습니다.
					<?php else:?>
					이 모듈은 DB테이블을 생성하지 않습니다.
					<?php endif?>						
					</p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">모듈등록일</label>
				<div class="col-md-10">
					<p class="form-control-static"><?php echo getDateFormat($R['d_regis'],'Y/m/d')?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">포함언어팩</label>
				<div class="col-md-10">
				<p class="form-control-static">
				<?php $i=0?>
				<?php $dirs = opendir($g['path_module'].$R['id'].'/')?>
				<?php while(false !== ($tpl = readdir($dirs))):?>
				<?php if(substr($tpl,0,5)!='lang.')continue?>
				<?php $reallang = str_replace('lang.','',$tpl)?>
				<span class="b"><?php echo getFolderName($g['path_var'].'language/'.$reallang)?></span>(<?php echo $reallang?>)<br />
				<?php $i++; endwhile?>
				<?php closedir($dirs)?>
				<?php if(!$i):?>
				<span class="b">언어팩이 없는 모듈입니다</span>
				<?php endif?>
				</p>
				</div>
			</div>

        </div>
        <div class="modal-footer">
		<button class="btn btn-primary btn-block btn-lg" type="submit"><i class="fa fa-check fa-lg"></i> 속성 변경</button>
		<button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">닫기</button>
        </div>
	  </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->



<script type="text/javascript">
//<![CDATA[
function iconDrop(val)
{
	var f = document.procForm1;
	f.icon.value = val;
	getId('_moduleIcon_').className = val + ' kf fa-stack-1x kf-inverse';
	iconDropAply();
}
function iconDropAply()
{
	var f = document.procForm1;
	f.iconaction.value = '1';
	f.submit();
}
function saveCheck(f)
{
	if (f.name.value == '')
	{
		alert('모듈이름을 입력해 주세요.     ');
		f.name.focus();
		return false;
	}
	return confirm('정말로 실행하시겠습니까?         ');
}
function showCheck(id,hidden)
{
	frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=moduleshow_update&moduleid=' + id + '&hidden=' + hidden;
}
function mobileCheck(id,mobile)
{
	frames._action_frame_<?php echo $m?>.location.href = '<?php echo $g['s']?>/?r=<?php echo $r?>&m=<?php echo $module?>&a=modulemobile_update&moduleid=' + id + '&mobile=' + mobile;
}
//]]>
</script>




