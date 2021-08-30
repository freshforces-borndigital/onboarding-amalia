var sequence_question = $('#display-sequence-question').detach();
var sequence_type = $('#sequence-type').detach();
var episode = $('#episode');
var character = $('#character').detach();
var sequence_video = $('#display-sequence-video').detach();

/*display sequence type*/
$(document).on('click', '.relation-btn', function () {
	let sequence_id = $(this).prop('id');
	sequence_id = sequence_id.split('-')[2];

	let episode_id = $(this).data('id');

	episode.detach();
	sequence_type.appendTo('body');

	$('#sequence-question').prop('id','sequence-question-'+sequence_id);
	$('#sequence-video').prop('id','sequence-video-'+sequence_id);
	$('#sequence-page').prop('id','sequence-page-'+episode_id);
})

/*get sequence*/
$(document).on('click','.choose-sequence, .option-btn', function () {
	let sequence_id = $(this).prop('id');
	sequence_id = sequence_id.split('-')[2];
	let episode_id = $(this).data('id');
	// console.log('clicked')

	$('body').css('background','#3B3B3BDB')
	$('body').css('color','white')

	//check episode is displayed
	let episodeExist = document.getElementById('episode');
	if(episodeExist) episode.detach();

	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : handleAjax.ajaxUrl,
		data : {
			action : handleAjax.ajx.startEpisode.action,
			nonce : handleAjax.ajx.startEpisode.nonce,
			sequence_id : sequence_id,
			episode_id : episode_id
		}
	}).done(function (data) {
		// console.log(data.data)

		//check character is displayed
		let characterExist = document.getElementById('character');
		if(characterExist) character.detach();

		let sequence_data = data.data;

		if(sequence_data.type==='question') {
			sequence_question.appendTo('body');
			let countAnswer = sequence_data !== 'Post not found' ? sequence_data.answer.length : 0 ;

			if(countAnswer>0) {
				$('#sequence-sub-title').html(sequence_data.sub_title);
				$('#sequence-title').html(sequence_data.post_title);
				$('#sequence-question').html(sequence_data.body_question);

				//clear button answer
				let answerButton = document.getElementById('answers-div');
				while (answerButton.hasChildNodes()) {
					answerButton.removeChild(answerButton.firstChild);
				}

				//reappend answer button
				for (let i=0; i < countAnswer; i++ ) {
					let next_sequence = sequence_data.answer[i]['question_answer_sequence'] !== false ? sequence_data.answer[i]['question_answer_sequence'] : '';
					$('#answers-div').append(`<button class="btn btn-info border-0 option-btn" id="sequence-question-${next_sequence}" data-id="${next_sequence}">${sequence_data.answer[i]['question_answer_option']}</button>&nbsp;`)
				}
			} else {
				alert('This is the last question');
			}
		} else if(sequence_data.type==='video') {
			// console.log('video')
			sequence_video.appendTo('body');

			if(sequence_data !== 'Post not found') {
				$('#video-title').html(sequence_data.post_title);
				$('#video-file').append(`<source media="(min-width: 380px)" src=${sequence_data.video_file}>`);
				$('.next-sequence-video').prop('id','next-video-'+sequence_data.follow_up_sequence);
			} else {
				alert('This is the last video');
			}
		}  else if(sequence_data.type==='page') {
			character.appendTo('body');
			// console.log(data.data);

			let characters = data.data;
			for (let i=0;i<characters.length;i++) {
				$('#display-character').append(`
				<div class="col-md-2">
					<div class="card text-center">
						<div class="card-body">
							<small class="card-text">${characters[i]['character_relation_title']}</small>
							<h4 class="card-title">${characters[i]['post_title']}</h4>
							<h6 class="card-title">${characters[i]['character_line_up']}</h6>
							<button id="sequence-question-${characters[i]['character_follow_up_sequence']}" class="btn btn-primary btn-sm border-0 choose-sequence">Choose</button>
						</div>
					</div>
				</div>
			`)
			}
		}
	})
})

/*get character*/
/*$(document).on('click', '.character-btn', function () {
	let episode_id = $(this).prop('id');
	episode_id = episode_id.split('-')[2];

	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : handleAjax.ajaxUrl,
		data : {
			action : handleAjax.ajx.displayCharacter.action,
			nonce : handleAjax.ajx.displayCharacter.nonce,
			episode_id : episode_id
		}
	}).done(function (data){
		sequence_type.detach();
		character.appendTo('body');
		// console.log(data.data);

		let characters = data.data;
		for (let i=0;i<characters.length;i++) {
			$('#display-character').append(`
				<div class="col-md-2">
					<div class="card text-center">
						<div class="card-body">
							<small class="card-text">${characters[i]['character_relation_title']}</small>
							<h4 class="card-title">${characters[i]['post_title']}</h4>
							<h6 class="card-title">${characters[i]['character_line_up']}</h6>
							<button id="sequence-question-${characters[i]['character_follow_up_sequence']}" class="btn btn-primary btn-sm border-0 choose-sequence">Choose</button>
						</div>
					</div>
				</div>
			`)
		}
	})
})*/
