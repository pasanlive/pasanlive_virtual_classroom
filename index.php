<?php

/**
 * This is a one-line short description of the file
 *
 *
 * @package    mod_pasanlive_virtualclass
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT);   // course

$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);

require_course_login($course);

add_to_log($course->id, 'pasanlive_virtualclass', 'view all', 'index.php?id='.$course->id, '');

$coursecontext = context_course::instance($course->id);

$PAGE->set_url('/mod/virtualclass/index.php', array('id' => $id));
$PAGE->set_title(format_string($course->fullname));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($coursecontext);

echo $OUTPUT->header();

if (! $virtualclasss = get_all_instances_in_course('pasanlive_virtualclass', $course)) {
    notice(get_string('novirtualclasss', 'virtualclass'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

$table = new html_table();
if ($course->format == 'weeks') {
    $table->head  = array(get_string('week'), get_string('name'));
    $table->align = array('center', 'left');
} else if ($course->format == 'topics') {
    $table->head  = array(get_string('topic'), get_string('name'));
    $table->align = array('center', 'left', 'left', 'left');
} else {
    $table->head  = array(get_string('name'));
    $table->align = array('left', 'left', 'left');
}

foreach ($virtualclasss as $virtualclass) {
    if (!$virtualclass->visible) {
        $link = html_writer::link(
            new moodle_url('/mod/virtualclass.php', array('id' => $virtualclass->coursemodule)),
            format_string($virtualclass->name, true),
            array('class' => 'dimmed'));
    } else {
        $link = html_writer::link(
            new moodle_url('/mod/virtualclass.php', array('id' => $virtualclass->coursemodule)),
            format_string($virtualclass->name, true));
    }

    if ($course->format == 'weeks' or $course->format == 'topics') {
        $table->data[] = array($virtualclass->section, $link);
    } else {
        $table->data[] = array($link);
    }
}

echo $OUTPUT->heading(get_string('modulenameplural', 'virtualclass'), 2);
echo html_writer::table($table);
?>
<p>Hangout Button</p>
<script src="https://apis.google.com/js/platform.js" async defer></script>
    <g:hangout render="createhangout"
        initial_apps="[{ app_id : '184219133185', start_data : 'dQw4w9WgXcQ', 'app_type': 'ROOM_APP' }]">
    </g:hangout>
<?php
echo $OUTPUT->footer();
