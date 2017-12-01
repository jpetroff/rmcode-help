
(function() {
	tinymce.create('tinymce.plugins.rm_tinymce_plugin', {

		init : function(editor, url) {
			var t = this;

			t.url = url;

			//add new button
			editor.addButton("hint", {
				title : "Hint",
				cmd : "insert_hint",
				text : "hint"
			});

			editor.addButton("mdash", {
				title : "Insert —",
				cmd : "insert_mdash",
				text : "—"
			});

			//button functionality.
			editor.addCommand("insert_hint", function() {
				var selected_text = editor.selection.getContent();
				var return_text = "[hint title=Hint]" + selected_text + "[/hint]";
				editor.execCommand("mceInsertContent", 0, return_text);
			});

			editor.addCommand("insert_mdash", function() {
				var selected_text = editor.selection.getContent();
				// var return_text = " — ";
				var return_text = "&#8239;&mdash;&#8198;"
				editor.execCommand("mceInsertContent", 0, return_text);
			});


			//replace shortcode before editor content set
			editor.on('BeforeSetContent', function(editor) {
				editor.content = t.renderShortcodes(editor.content);
			});

			//replace shortcode as its inserted into editor (which uses the exec command)
			editor.on('ExecCommand', function(editor, cmd) {
				if (cmd ==='mceInsertContent'){
					tinyMCE.activeEditor.setContent( t.renderShortcodes(tinyMCE.activeEditor.getContent()) );
				}
			});

			//replace the image back to shortcode on save
			editor.on('PostProcess', function(editor) {
				if (editor.get)
					editor.content = t.restoreShortcodes(editor.content);
			});
		},

		renderShortcodes : function(content) {
			var t = this;

			// [rmvideo]
			// content = content.replace(/\[rmvideo(.*?)\]/g, function(str, _params){
			// 	var params = t._parseParams(_params);
			// 	params.tag = 'rmvideo';
			//
			// 	var videoCode = '<video src="'+params.src+'"></video>';
			// 	return '<media-wrapper class="rm-shortcode" data-rm-params="'+tinyMCE.DOM.encode(JSON.stringify(params))+'"  contenteditable="false">' +
			// 		'<iframe src="javascript:alert(\''+videoCode+'\');" allowtransparency="true" seamless><a href="'+params.src+'"></a></iframe>' +
			// 		'</media-wrapper>';
			// });

			// [rmimg]
			content = content.replace(/\[img(.*?)\]/g, function(str, _params){
				var params = t._parseParams(_params);
				params.tag = 'img';
				return '<media-wrapper class="rm-shortcode" data-rm-params="'+tinyMCE.DOM.encode(JSON.stringify(params))+'"  contenteditable="false">' +
					'<img src="'+params.f+'" srcset="'+params.rf+' 2x" width="'+params.w+'" height="'+params.h+'"></img>' +
					'</media-wrapper>';
			});

			// [hint]
			content = content.replace(/\[hint([\s\S]*)\]([\s\S]*)\[\/hint\]/g, function(str, _params, _content){
				var params = t._parseParams(_params);
				params.tag = 'hint';
				return '' +
				'<hint class="rm-shortcode def-hint-box" data-rm-shortcode="hint"  contenteditable="false">' +
					'<div class="def-hint-box__toggle" contenteditable="true">' + params.title + '</div>' +
					'<div class="def-hint-box__content" contenteditable="true"><p>' + _content + '</p></div>' +
				'</hint>';
			});

			return content;
		},

		restoreShortcodes : function(content) {

			// [rmvideo] [rmimg]
			content = content.replace(/<media-wrapper[^>]*data-rm-params="([^">]*)"[^>]*>(.*?)<\/media-wrapper>/g, function(str,_params,content) {
				var params = JSON.parse(tinyMCE.DOM.decode(_params));
				var output = ["\n["+params.tag];
				for(var key in params) {
					if(key=='tag') continue;
					output.push(key+'="'+params[key]+'"');
				}
				output.push(']');
				return output.join(' ');
			});

			// [hint][/hint]
			content = content.replace(/<hint[^>]*data-rm-shortcode="hint"[^>]*>([\s\S]*?)<\/hint>/gi, function(str,_innerHtml){
				var titlePattern = /<div[^>]*class="def-hint-box__toggle"[^>]*>([\s\S]*?)<\/div>/gi;
				var contentPattern = /<div[^>]*class="def-hint-box__content"[^>]*>([\s\S]*?)<\/div>/gi;

				var title = titlePattern.exec(_innerHtml)[1];
				var content = contentPattern.exec(_innerHtml)[1];

				return "\n"+'[hint title="'+title.trim()+'"]'+content.trim()+'[/hint]';
			});

			// <a v-rlink>
			content = content.replace(/<a([^>]*?)>([\s\S]*?)<\/a>/gi, function(_str, _params, _content) {
				if(_params.indexOf('v-rlink') != -1) return _str;

				return "<a v-rlink "+_params.trim()+">"+_content+"</a>";
			});

			return content;
		},

		_parseParams: function(paramStr) {
			// var ops = paramStr.split(' ');
			var result = {};
			var pattern = /([^\s=]*)=("[^"]*"|[^\s]*)/gi;
			var ops = paramStr.match(pattern);
			// console.log(ops);
			ops.forEach(function(val) {
				if (val.length == 0) return;
				var _p = /([^\s=]*)=("[^"]*"|[^\s]*)/.exec(val);
				// console.log(val, _p);
				if(_p.length <= 1 || !_p[1] || !_p[2]) return;
				result[ _p[1] ] = _p[2].replace(/"/g, '');
			});

			return result;
		},

		getInfo : function() {
			return {
				longname : 'RM shortcode replace',
				author : 'John Petrov',
				authorurl : 'https://readymag.com',
				infourl : '',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('rm_tinymce_plugin', tinymce.plugins.rm_tinymce_plugin);
})();
