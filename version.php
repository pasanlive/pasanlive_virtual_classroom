<?php

/**
 * Defines the version of pasanlive_virtualclass
 *
 * This code fragment is called by moodle_needs_upgrading() and
 * /admin/index.php
 *
 * @package    mod_pasanlive_virtualclass
 */

defined('MOODLE_INTERNAL') || die();

//$module->version   = 0.0.1;               // If version == 0 then module will not be installed
$module->version   = 2014101704;      // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2013051405;      // Requires this Moodle version
$module->cron      = 0;               // Period for cron to check this module (secs)
$module->component = 'mod_virtualclass'; // To check on upgrade, that module sits in correct place
