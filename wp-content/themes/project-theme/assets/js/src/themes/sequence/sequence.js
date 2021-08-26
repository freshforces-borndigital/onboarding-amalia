(function ($) {

});

var sequence = $('#display-sequence-question').detach();
var sequence_type = $('#sequence-type').detach();
var episode = $('#episode');
var character = $('#character').detach();

/*display sequence type*/
$(document).on('click', '.relation-btn', function () {
	let sequence_id = $(this).prop('id');
	sequence_id = sequence_id.split('-')[2];

	let episode_id = $(this).prop('data-id');

	episode.detach();
	sequence_type.appendTo('body');
	$('.sequence-question').prop('id','sequence-question-'+sequence_id);
	$('.character-btn').prop('id','character-btn'+episode_id);
})

/*get sequence*/
$(document).on('click','.sequence-question, .option-btn', function () {
	let sequence_id = $(this).prop('id');
	sequence_id = sequence_id.split('-')[2];

	$.ajax({
		type : 'POST',
		dataType : 'json',
		url : handleAjax.ajaxUrl,
		data : {
			action : handleAjax.ajx.startEpisode.action,
			nonce : handleAjax.ajx.startEpisode.nonce,
			sequence_id : sequence_id
		}
	}).done(function (data) {
		// console.log(data.data)

		let sequenceTypeExist = document.getElementById('sequence-type');
		if(sequenceTypeExist) sequence_type.detach();
		sequence.appendTo('body');

		let sequence_data = data.data;
		if(!sequence_data.is_first_sequence) {
			$('#sequence-sub-title').html(sequence_data.sub_title);
			$('#sequence-title').html(sequence_data.post_title);
			$('#sequence-question').html(sequence_data.body_question);

			//clear button answer
			let answerButton = document.getElementById('answers-div');
			while (answerButton.hasChildNodes()) {
				answerButton.removeChild(answerButton.firstChild);
			}

			//reappend answer button
			let countAnswer = sequence_data.answer.length;
			for (let i=0; i < countAnswer; i++ ) {
				let next_sequence = sequence_data.answer[i]['question_answer_sequence'] !== false ? sequence_data.answer[i]['question_answer_sequence'] : '';
				$('#answers-div').append(`<button class="btn btn-info border-0 option-btn" id="option-btn-${next_sequence}" data-id="${next_sequence}">${sequence_data.answer[i]['question_answer_option']}</button>&nbsp;`)
			}
		}
	})
})

/*get character*/
$(document).on('click', '.character-btn', function () {
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
	})
})
