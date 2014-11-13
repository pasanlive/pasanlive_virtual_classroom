<?php
/**
 * Definition of log events
 *
 * @package    mod_pasanlive_virtualclass
 */

defined('MOODLE_INTERNAL') || die();

global $DB;

$logs = array(
    array('module'=>'pasanlive_virtualclass', 'action'=>'add', 'mtable'=>'pasanlive_virtualclass', 'field'=>'id'),
    array('module'=>'pasanlive_virtualclass', 'action'=>'update', 'mtable'=>'pasanlive_virtualclass', 'field'=>'id'),
    array('module'=>'pasanlive_virtualclass', 'action'=>'view', 'mtable'=>'pasanlive_virtualclass', 'field'=>'id'),
    array('module'=>'pasanlive_virtualclass', 'action'=>'view all', 'mtable'=>'pasanlive_virtualclass', 'field'=>'id')
);
