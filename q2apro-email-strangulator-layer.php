<?php

/*
	Plugin Name: Q2APRO Email Strangulator
*/

class qa_html_theme_layer extends qa_html_theme_base
{
	public function initialize() 
	{
		if($this->template=='account')
		{
			$userid = qa_get_logged_in_userid();
			require_once QA_INCLUDE_DIR.'qa-db-metas.php';
			$emailoff = qa_db_usermeta_get($userid, 'emailoff');
			
			// var_dump($this->content);
			$this->content['form_profile']['fields']['emailoff'] = array(
					'type' => 'checkbox',
					'label' => qa_lang('q2apro_email_strangulator/mute_all_label'),
					'note' => qa_lang('q2apro_email_strangulator/mute_all_note'),
					'value' => ($emailoff=='1' ? 'checked' : ''),
					'id' => 'emailoff',
					'tags' => 'name="emailoff"',
			);
		}
		
		// default
		qa_html_theme_base::initialize();
	}
}


/*
	Omit PHP closing tag to help avoid accidental output
*/