$(function(){
	var press	= {
		init: function(){
			$('textarea.field').click(function(){
				if( typeof($(this).attr('stop')) === "undefined" )
				{
					$(this).removeAttr('readonly');
				}
			});
			$('textarea.field').blur(function(){
				$(this).attr('readonly','readonly');
			});

			// 提交留言
			$('#add_talk').click(function(){
				var val	= $('#add-talk-text').val();
				alert('我提交的内容 --> '+val);
			});

			// 上传插件
			if( $('#input-kejian').length > 0 )
			{
				$("#input-kejian").fileinput();
			}
			if( $("#input-video").length > 0 )
			{
				$("#input-video").fileinput();
			}

			// 添加课时信息的动态窗口
			$('#add-lesson').click(function(){
				press.dialog.lesson_edit('add-lesson');
			});

			$('#sub_tixi').click(function(){
				alert('你提交了一个“知识体系”录制申请');
				window.location.href="/jkxy_press/apply_course.html";
			});

			$('#sub_course').click(function(){
				alert('你提交了一个“课程”录制申请');
				window.location.href="/jkxy_press/course_list.html";
			});
		},
		dialog: {
			dia_header: '<div class="modal fade |id|" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"><div class="modal-dialog modal-|size|"><div class="modal-content">',
			dia_footer: '</div></div></div>',
			dia_body: '',
			gener: function(options){
				var id			= '';
				var settings	= {
					id: 'temp_modal',
					size:'lg'
				};
				if (options)
				{
					$.extend(settings, options);
				}

				var dia_header	= press.dialog.dia_header.replace("|size|", settings.size);
					dia_header	= press.dialog.dia_header.replace("|id|", settings.id);
				var dia_body	= press.dialog.dia_body;
				var dia_footer	= press.dialog.dia_footer;

				var html	= dia_header+dia_body+dia_footer;
				$(html).modal();
			},
			lesson_edit: function(id){
				var dia_body	= '<form role="form">';
						dia_body	+= '<div class="form-group">';
							dia_body	+= '<label for="">课时标题</label>';
							dia_body	+= '<input type="text" class="form-control" id="exampleInputEmail1" placeholder="填写课时标题">';
						dia_body	+= '</div>';
						dia_body	+= '<div class="form-group">';
							dia_body	+= '<label for="">填写课时知识点</label>';
							dia_body	+= '<textarea class="form-control" row="4"></textarea>';
						dia_body	+= '</div>';
						dia_body	+= '<div class="form-group">';
							dia_body	+= '<label>填写课时概要</label>';
							dia_body	+= '<textarea class="form-control" row="4"></textarea>';
							dia_body	+= '<p class="help-block">Example block-level help text here.</p>';
						dia_body	+= '</div>';
						dia_body	+= '<div class="form-group">';
							dia_body	+= '<label>预估课时时长</label>';
							dia_body	+= '<input type="text" id="">';
							dia_body	+= '<p class="help-block">eg：10 ~ 15</p>';
						dia_body	+= '</div>';
						dia_body	+= '<a href="javascript:void(0);" class="btn btn-default">Submit</a>';
					dia_body	+= '</form>';
				press.dialog.dia_body	= dia_body;
				press.dialog.gener( {id:id} );
			}
		}
	};
	press.init();
});

