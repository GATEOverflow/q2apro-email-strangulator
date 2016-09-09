<?php

/*
	Plugin Name: Q2APRO Email Strangulator
	Plugin URI: http://www.q2apro.com/plugins/emailoff
	Plugin Description: Adds an option to each user profile to disable all email notifications for new forum posts
	Plugin Version: 0.1
	Plugin Date: 2016-09-09
	Plugin Author: q2apro.com
	Plugin Author URI: http://www.q2apro.com
	Plugin License: GPLv3
	Plugin Minimum Question2Answer Version: 1.6
	Plugin Update Check URI: 
*/

	// don't allow this page to be requested directly from browser
	if (!defined('QA_VERSION'))
	{ 
		header('Location: ../../');
		exit;
	}
	
	
	// core function overrides 
	qa_register_plugin_overrides('q2apro-email-strangulator-overrides.php');
	
	// layer
	qa_register_plugin_layer('q2apro-email-strangulator-layer.php', 'Q2APRO Email Strangulator Layer');
	
	// to get the form post
	qa_register_plugin_module('event', 'q2apro-email-strangulator-event.php', 'q2apro_email_strangulator_event', 'Q2APRO Email Strangulator Event');
	
	// language file
	qa_register_plugin_phrases('q2apro-email-strangulator-lang-*.php', 'q2apro_email_strangulator');

	
/*
	Omit PHP closing tag to help avoid accidental output
*/