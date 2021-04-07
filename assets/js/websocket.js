jQuery(function($){

			// Websocket
			var websocket_server = new WebSocket("ws://localhost/");

				websocket_server.onopen = function(e) {
				websocket_server.send(
					JSON.stringify({
						'type':'socket',
						'user_id':$('#pseudoUser').val()
					})
				);
				var pseudo = $('#sessionId').val();
				var pseudo = $('#pseudoUser').val();
				var welcome = ' vient de rejoindre le lobby';

				websocket_server.send(
						JSON.stringify({
							'type':'welcome',
							'user_id':$('#pseudoUser').val(),
							'sessionId':$('#sessionId').val(),
							'chat_msg':welcome
						})
					);
			};

			websocket_server.onerror = function(e) {
				// Errorhandling
			}

			websocket_server.onmessage = function(e)
			{
				var json = JSON.parse(e.data);
				switch(json.type) {
					case 'chat':
						$('#chat_output').append(json.msg);
						break;
					case 'welcome':
						$('#chat_output').append(json.msg);
						break;
				}
			}
			
			// Events
			$('#chat_input').on('keyup',function(e){
				if(e.keyCode==13 && !e.shiftKey)
				{
					var chat_msg = $(this).val();
					websocket_server.send(
						JSON.stringify({
							'type':'chat',
							'user_id':$('#pseudoUser').val(),
							'chat_msg':chat_msg
						})
					);
					$(this).val('');
				}
			});
		});