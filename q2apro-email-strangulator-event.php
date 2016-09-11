<?php
/*
	Question2Answer by Gideon Greenspan and contributors
	http://www.question2answer.org/

	File: qa-plugin/event-logger/qa-event-logger.php
	Description: Event module class for event logger plugin


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

class q2apro_email_strangulator_event
{

	public function process_event($event, $userid, $handle, $cookieid, $params)
	{
		if($event == 'u_save')
		{
			$userid = qa_get_logged_in_userid();
			$emailoff = qa_post_text('emailoff');
			
			require_once QA_INCLUDE_DIR.'qa-db-metas.php';
			if($emailoff=='1')
			{
				qa_db_usermeta_set($userid, 'emailoff', 1);
			}
			else 
			{
				qa_db_usermeta_set($userid, 'emailoff', 0);
			}
		}
	} // process_event

	public function admin_form(&$qa_content)
	{
		// process form input
		$saved = false;
		$users_muted = '';
		
		if(qa_clicked('email_strangulator_save_button'))
		{
			require_once QA_INCLUDE_DIR.'qa-db-metas.php';
			$users_in_post = qa_post_text('email_strangulator_userstomute');
			// usernames can hold spaces, so we only remove the spaces around the commas by trim after explode
			// $users_in = str_replace(' ', '', $users_in_post);
			$users_array = explode(',', $users_in_post);
			foreach($users_array as $useridhan)
			{
				$useridhan = trim($useridhan);
				$userid = null;
				if(is_numeric($useridhan))
				{
					$userid = $useridhan;
					$users_muted .= qa_userid_to_handle($userid).'<br>';
				}
				else
				{
					$userid = qa_handle_to_userid($useridhan);
					$users_muted .= $useridhan;
				}
				if(isset($userid))
				{
					qa_db_usermeta_set($userid, 'emailoff', 1).'<br>';
				}
			}
			$saved = true;
		}

		// admin form for display
		return array(
			'ok' => $saved ? 'Users got muted: '.$users_muted : null,

			'fields' => array(
				array(
					'id' => 'email_strangulator_userstomute',
					'label' => 'Enter the userids or handles of the users you want to mute:',
					'value' => '',
					'tags' => 'name="email_strangulator_userstomute"',
					'note' => 'Comma separated, e.g. "bigtroll, youarereading, 334"',
				),
			),

			'buttons' => array(
				array(
					'label' => 'Submit',
					'tags' => 'name="email_strangulator_save_button"',
				),
			),
		);
	} // function admin_form
	
} // q2apro_email_strangulator_event