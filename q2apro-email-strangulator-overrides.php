<?php
/*
	Plugin Name: Q2APRO Email Strangulator
*/

	// don't allow this page to be requested directly from browser
	if (!defined('QA_VERSION')) 
	{ 
		header('Location: ../../');
		exit;
	}


	// override, see http://docs.question2answer.org/plugins/overrides/ if you are interested
	/*
		The solution is quite simple: We catch the userid, look up the settings in table qa_usermetas, 
		and can decide if an email should be sent or not. If not, we null the userid and the email.
	*/
	function qa_send_notification($userid, $email, $handle, $subject, $body, $subs, $html = false)
	{
		// ignore user-account related emails
		$ignoresubjects = array(qa_lang('emails/confirm_subject'), qa_lang('emails/reset_subject'), qa_lang('emails/new_password_subject'), qa_lang('emails/welcome_subject'), qa_lang('emails/private_message_subject'));
		
		// we care for all emails triggered by forum posts, see qa-event-notify.php
		
		// do the email magic
		if(isset($userid) && !in_array($subject, $ignoresubjects))
		{
			// check settings
			require_once QA_INCLUDE_DIR.'qa-db-metas.php';
			$emailoff = qa_db_usermeta_get($userid, 'emailoff');
			if($emailoff=='1')
			{
				// prevent email to be sent
				$userid = null;
				$email = null;
			}
		}
		
		// call default function
		return qa_send_notification_base($userid, $email, $handle, $subject, $body, $subs, $html);
	} // qa_send_notification



/*
	Omit PHP closing tag to help avoid accidental output
*/